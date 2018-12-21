<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Invoices');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Orders Controller
 *
 * @property Order $Order
 * @property PaginatorComponent $Paginator
 */
class OrdersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','PagarMe.PagarMe');

/**
    * index method
    *
    * @return void
    */

    public function payment($sender = null){
        $this->disableCache();

        $session_id = $this->__getSessionId();
        $carts = $this->__getCartsInSession($session_id);

        if (empty($carts)) {
            return $this->redirect(['controller' => 'pages', 'action' => 'index']);
        }

        if ($this->Auth->user('id')) {
            $user = $this->__getStudent($this->Auth->user('id'));
            $userValid = $this->checkStudent($user);
            if (!$userValid) {
                $user['Student'][0] = $user['Student'];
                $user['Student'][0]['birth'] = isset($user['Student'][0]['birth']) ? implode('/', array_reverse(explode('-', $user['Student'][0]['birth']))) : '';
                $this->request->data = array_merge($user, $this->request->data);
            }
            $this->set('user', $user);
            $this->set('userValid', $userValid);
        }

        $subtotal = $discount = 0;
        foreach ($carts as $cart) {
            $subtotal += $cart['Cart']['unitary_value'];
            $discount += $cart['Cart']['unitary_discount'];
        }

        if (!empty($sender)) {
            $this->set('sender', $sender);
        }
        
        $this->set('carts', $carts);
        $this->set('subtotal', $subtotal);
        $this->set('discount', $discount);
        $this->set('total', $subtotal - $discount);

        if ($this->request->query('refresh_resume') !== null) {
            $this->autorender = false;
            $this->layout     = false;
            $this->set('refresh', true);
            return $this->render('/Elements/site/payment/resumo');
        }

        if($this->request->is('post')){
            $this->loadModel('Group');
            $this->__verifySecurity($this->Group->getAluno());

            $cart_informations = $this->__getCartForPagarme($carts, $this->request->data['Order']);

            $transaction = $this->PagarMe->createTransaction($cart_informations);

            if($this->PagarMe->transactionSuccess($transaction)){
                $this->Order->create();
                $order = $this->__convertPagarMeTransactionToOrder($transaction, $cart_informations, $this->request->data['Order']['sender']);

                if($this->Order->saveAll($order,['validate'=>'first', 'deep' => true])){
                    $this->Session->delete('user_bag');
                    $this->Session->delete('Ticket');
                    return $this->redirect(['action'=>'success','prefixes'=>false,$this->Order->id]);
                }else{
                    $errors = $this->__showErrors($this->Order->validateErrors);
                    //No momento da criação da transação, o valor já é debitado. Por isso, quando ocorre algum erro na criação do pedido, o sistema precisa realizar o estorno
                    $this->PagarMe->refundTransaction($order['Order']['transactionid']);
                    $purchaseValidation = $this->Order->havePurchaseForThisUserValidation();
                    if($purchaseValidation === false || is_string($purchaseValidation) && $purchaseValidation != ''){
                        $this->Session->setFlash('Erro ao enviar o pedido! Verifique os dados de seu cadastro e tente novamente. - ' . $errors, 'site/popup-error');
                    }else{
                        $this->Session->setFlash('Erro ao enviar o pedido! Por favor, tente novamente. - ' . $errors, 'site/popup-error');
                    }
                }
            }else{
                if(!empty($transaction['status']) && $this->Order->Payment->getStatusByPagarmeStatus($transaction['status']) == $this->Order->Payment->getStatusCancelado()){
                    $this->loadModel('Method');                    
                    if($transaction['payment_method'] == $this->Method->getMetodoPagamentoPagarmeCartaoCode()){
                        $this->Session->setFlash('Transação não autorizada. Confira o limite e os dados do cartão e tente novamente.', 'site/popup-error');                        
                    }else{
                        $this->Session->setFlash('Transação não autorizada. Confira os dados do seu cadastro e tente novamente.', 'site/popup-error');
                    }                                        
                }else{ 
                    $errors = $this->__showErrorsPayment($transaction);                   
                    $this->Session->setFlash('Erro ao enviar o pedido! ' . $errors, 'site/popup-error');
                }                
            }
        } else {
            if ($this->Session->read('consulta_cpf')) {
                $this->request->data['User']['username'] = $this->request->data['User']['cpf'] = $this->Session->read('consulta_cpf');
            }
            if ($this->Session->read('consulta_birth')) {
                $this->request->data['Student'][0]['birth'] = $this->Session->read('consulta_birth');
            }
        }
    }

    public function success($order_id){
        $this->loadModel('Group');
        $this->__verifySecurity($this->Group->getAluno());

        $user = $this->Auth->user();

        $order = $this->Order->find('first',[
            //'fields'=>['Order.id','Order.payment_link_boleto','Order.method_id'],
            'conditions' => ['Order.id' => $order_id, 'Order.user_id' => $user['id']]
        ]);

        if (empty($order)) {
            return $this->redirect(['controller' => 'pages', 'action'=>'index']);
        }
        $this->set('order',$order);
    }

    public function sendEmailLogPostback(){
        $data['template'] = 'default'; 
        $data['subject'] = 'postback pargar.me';
        $data['to'] = 'dayvisonsilva@gmail.com';
        $data['content'] = array(
          'postback' => json_encode($this->request->data)
        );
        $this->__SendMail($data);
    }

    public function postback_pagarme(){
        $this->autoRender = false;
        $this->layout = false;

        if($this->request->is(array('post','put'))){
            
            //$this->sendEmailLogPostback();
            
            if( $this->__IsPostbackBoleto() ){
                
                $this->__UpdateStatusBoleto();

            }else{

                $this->log('INÍCIO de cartão de crédito-----------------------------------------------', 'nfse');

                if( $this->PagarMe->validatePostback(file_get_contents("php://input"),$this->request->header('X-Hub-Signature')) ){

                    $this->log('PagarMe validado', 'nfse');
                    
                    $this->loadModel('Order');
                    $postback = $this->request->data;

                    if( !empty($postback) ){

                        $this->log('Existe postback', 'nfse');

                        $this->request->header('X-Hub-Signature');

                        $this->Order->Behaviors->load('Containable');
                        $order = $this->Order->find('first',[
                            'contain'=>[
                                'User' => [
                                    'Student' => [
                                        'City',
                                        'State'
                                    ]
                                ],
                                'Method',
                                'OrderCourse' => [
                                    'Course' => [
                                        'fields' => ['Course.name']
                                    ]
                                ]
                            ],
                            'conditions'=>['Order.transactionid'=>$postback['transaction']['id']]
                        ]);

                        if( !empty($order) ){

                            $this->log('Existe order', 'nfse');

                            $this->log('FIM de cartão de crédito-----------------------------------------------', 'nfse');

                            $this->loadModel('Payment');

                            $this->createNfse($order, $postback['current_status']);

                            $success = false;

                            if( $order['Method']['code'] == $this->Order->Method->getMetodoPagamentoPagarmeCartaoCode() ){

                                //se status chegar como aprovado, a compra foi via cartão e precisamos capturar
                                if( $postback['current_status'] == $this->Order->Payment->getPagarmeStatusByStatus($this->Order->Payment->getStatusAprovado())){
                                    $capture = $this->PagarMe->captureTransaction($postback['transaction']['id'],$order['Order']['value'] - $order['Order']['value_discount']);
                                    if($this->PagarMe->transactionSuccess($capture)){
                                        $success = true;
                                    }
                                }else{
                                    $success = true;
                                }
                            }
                            elseif( $order['Method']['code'] == $this->Order->Method->getMetodoPagamentoPagarmeBoletoCode() ){ 

                                //boleto
                                //set como true pq só preciso atualizar o status no banco
                                $success = true;
                            }
                            else{

                                $success = false;
                            }

                            if( $success ){

                                $postbackStatus = $this->Order->Payment->getStatusByPagarmeStatus($postback['current_status']);
                                
                                $order['Order']['order_type_id'] = $postbackStatus;

                                if( $this->Order->save($order) ){
                                    $payment['Payment']['order_id']         = $order['Order']['id'];
                                    $payment['Payment']['TransacaoID']      = $postback['transaction']['id'];
                                    $payment['Payment']['DataTransacao']    = strftime("%Y-%m-%d %H:%M:%S",strtotime($postback['transaction']['date_updated']));
                                    $payment['Payment']['StatusTransacao']  = $this->Payment->getStatusByCode($this->Payment->getStatusByPagarmeStatus($postback['current_status']));
                                    $payment['Payment']['Parcelas']         = isset($postback['transaction']['installments']) ? $postback['transaction']['installments'] : 1;
                                    $payment['Payment']['TipoPagamento']    = $order['Method']['name'];
                                    $payment['Payment']['NumItens']         = count($order['OrderCourse']);
                                    $this->Payment->create();
                                    $this->Payment->save( $payment );
                                    return true;
                                }
                            }
                        }
                    }                            
                }
            
            }
        }
        return false;
    } 

    private function __IsPostbackBoleto(){
        if ( isset($this->request->data['transaction']['payment_method']) and $this->request->data['transaction']['payment_method'] == 'boleto' ){
            return true;
        }else{
            return false;
        }
    }

    private function __UpdateStatusBoleto(){
        $this->loadModel('Order');

        $postback = $this->request->data;
        $this->Order->Behaviors->load('Containable');
        $order = $this->Order->find('first',[
            'contain'=>[
                'User' => [
                    'Student' => [
                        'City',
                        'State'
                    ]
                ],
                'Method',
                'OrderCourse' => [
                    'Course' => [
                        'fields' => ['Course.name']
                    ]
                ]
            ],
            'conditions'=>['Order.transactionid'=>$postback['transaction']['id']]
        ]);

        if( !empty($order) ){
            $this->loadModel('Payment');
            
            $this->createNfse($order, $postback['current_status']);

            $order['Order']['order_type_id'] = $postbackStatus;
            $this->Order->save($order);
            $payment['Payment']['order_id']         = $order['Order']['id'];
            $payment['Payment']['TransacaoID']      = $postback['transaction']['id'];
            $payment['Payment']['DataTransacao']    = strftime("%Y-%m-%d %H:%M:%S",strtotime($postback['transaction']['date_updated']));
            $payment['Payment']['StatusTransacao']  = $this->Payment->getStatusByCode($this->Payment->getStatusByPagarmeStatus($postback['current_status']));
            $payment['Payment']['Parcelas']         = isset($postback['transaction']['installments']) ? $postback['transaction']['installments'] : 1;
            $payment['Payment']['TipoPagamento']    = $order['Method']['name'];
            $payment['Payment']['NumItens']         = count($order['OrderCourse']);
            $this->Payment->create();
            $this->Payment->save( $payment );       
        }
        return true;
    }

    private function createNfse($order, $postBackCurrentStatus) {

        $postbackStatus = $this->Order->Payment->getStatusByPagarmeStatus($postBackCurrentStatus);
                
        $statusPaid = $this->Order->Payment->getStatusByText('Aprovado');

        if ($order['Order']['order_type_id'] != $postbackStatus && $postbackStatus == $statusPaid) {

            $services = $order['OrderCourse'];

            $nfse = new InvoicesController;

            $xml = $nfse->buildXmlRps($order, $services);

            $notasPendentes = $nfse->sendRps($xml);

            if (!empty($notasPendentes)) {
                
                $notasEmitidas = $nfse->sendFiscalDocument($notasPendentes);

                $this->log('NFSe notasEmitidas: ' . $notasEmitidas, 'nfse');

                if (!empty($notasEmitidas)) {

                    $dataToEmail = $nfse->createNfse($notasEmitidas);

                    $courseName = $order['OrderCourse'][0]['Course']['name'];

                    $this->sendMailNfse($dataToEmail, $courseName);
                } else {
                    $this->log('NFSe NÃO EMITIDA: nota emitida não criada ' . $notasEmitidas, 'nfse');
                }

            } else {
                $this->log('NFSe NÃO EMITIDA: nota pendente não criada ' . $notasPendentes, 'nfse');
            }
        } else {
            $this->log('NFSe NÃO EMITIDA: o código do pedido ($order["Order"]["order_type_id"]) é igual ao status do postback ($postbackStatus) ou o status do postback ($postbackStatus) é diferente de pago ($statusPaid) || $order["Order"]["order_type_id"] = ' . $order['Order']['order_type_id'] . ' || $postbackStatus = ' . $postbackStatus . ' || $statusPaid = ' . $statusPaid, 'nfse');
        }
    }

    private function sendMailNfse($dataToEmail, $courseName) {

        $data['template'] = 'invoice'; 
        $data['subject'] = '[LM Cursos de Trânsito] Nota Fiscal de Serviço';
        $data['to'] = $dataToEmail['email'];
        $data['content'] = array(
            'messenger' => 'Olá ' . $dataToEmail['name'] . ', <br />Segue abaixo link para a nota de serviço para a compra do produto ' . $courseName,
            'email' => $dataToEmail['email'],
            'link' => $dataToEmail['invoice_link']
        );
                                        
        $this->__SendMail($data);
    }

    private function __InsertPayment(){

    }

    public function index(){

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'Order.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Order.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Order.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Order->recursive = 0;
        $this->set('orders', $this->Paginator->paginate());
    }

    /**
    * view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */

    public function view($id = null){
        if (!$this->Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }
        $options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
        $this->set('order', $this->Order->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add(){
        if ($this->request->is('post')) {
        
            $this->Order->create();
            if ($this->Order->save($this->request->data)) {
            
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$orderTypes = $this->Order->OrderType->find('list');
		$users = $this->Order->User->find('list');
		$this->set(compact('orderTypes', 'users'));
    }

    
    /**
    * edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function edit($id = null){
        if (!$this->Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Order->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
            $this->request->data = $this->Order->find('first', $options);
        }
        
        		$orderTypes = $this->Order->OrderType->find('list');
		$users = $this->Order->User->find('list');
		$this->set(compact('orderTypes', 'users'));
    }

    /**
    * delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function delete($id = null){
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Order->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', 'manager' => false));
    }
        

    /**
    * manager_index method
    *
    * @return void
    */

    public function manager_index(){

        $this->Filter->addFilters(array(
            'filter_id' => array(
                'Order.id' => array(
                    'operator' => '=',
                )
            ),
            'filter_nome' => array(
                'User.name' => array(
                    'operator' => 'LIKE',
                    'value' => array(
                        'before' => '%',
                        'after'  => '%'
                    )
                )
            ),
            'filter_cpf' => array(
                'User.cpf' => array(
                    'operator' => 'LIKE',
                    'value' => array(
                        'before' => '%',
                        'after'  => '%'
                    )
                )
            ),
            'filter_status_pagamento' => array(
                'Order.order_type_id' => array(
                    'select' => $this->Order->OrderType->find('list')

                )
            ),
            'filter_status_detran' => array(
                'OrderCourse.status_detran_id' => array(
                    'select' => $this->Order->OrderCourse->StatusDetran->find('list', ['fields' => ['StatusDetran.id', 'StatusDetran.nome']]),
                )
            ),
            'filter_curso' => array(
                'OrderCourse.course_id' => array(
                    'select' => $this->Order->OrderCourse->Course->find('list')
                )
            ),
            'filter_estado' => [
                'OrderCourse.state_id'
            ],
            'filter_cidade' => [
                'OrderCourse.citie_id'
            ],
            'filter_data_de' => [
                'Order.created' => ['operator' => '>='],
            ],
            'filter_data_ate' => [
                'Order.created' => ['operator' => '<='],
            ]
        ));

        $course_id = $status_detran_id = $state_id = $citie_id = $conditionFilters = false;
        if( $this->Filter->getConditions() ){
            $conditionFilters = $this->Filter->getConditions();

            if(isset($conditionFilters['OrderCourse.course_id ='])){
                $course_id = $conditionFilters['OrderCourse.course_id ='];
                unset($conditionFilters['OrderCourse.course_id =']);
            }

            if(isset($conditionFilters['OrderCourse.status_detran_id ='])){
                $status_detran_id = $conditionFilters['OrderCourse.status_detran_id ='];
                unset($conditionFilters['OrderCourse.status_detran_id =']);
            }

            if(isset($conditionFilters['OrderCourse.state_id ='])){
                $state_id = $conditionFilters['OrderCourse.state_id ='];
                unset($conditionFilters['OrderCourse.state_id =']);
            }

            if(isset($conditionFilters['OrderCourse.citie_id ='])){
                $citie_id = $conditionFilters['OrderCourse.citie_id ='];
                unset($conditionFilters['OrderCourse.citie_id =']);
            }

            if(isset($conditionFilters['Order.order_type_id ='])){
                if( $conditionFilters['Order.order_type_id ='] == Payment::APROVADO ){
                    $conditionFilters['Order.order_type_id IN'] = [Payment::APROVADO,Payment::DISPONIVEL];
                }
            }

            if (isset($conditionFilters['Order.created >='])) {
                $conditionFilters['Order.created >='] = implode('-', array_reverse(explode('/', $conditionFilters['Order.created >='])));
            }
            if (isset($conditionFilters['Order.created <='])) {
                $conditionFilters['Order.created <='] = implode('-', array_reverse(explode('/', $conditionFilters['Order.created <='])));
            }
        }

        $states = $cities = [];
        if (!empty($course_id)) {
            $states = $this->Order->OrderCourse->Course->getStatesOfCourse($course_id);

            if (!empty($state_id)) {
                $course = $this->Order->OrderCourse->Course->find('first', ['fields' => ['id', 'course_type_id'], 'conditions' => ['Course.id' => $course_id]]);
                if (!empty($course)) {
                    $this->loadModel('CourseState');
                    $cities = $this->CourseState->__getCitiesByCourseState($state_id, $course['Course']['course_type_id']);
                }
            }
        }

        $contain = [
            'OrderType',
            'User',
            'OrderCourse' => [
                'Course' => ['fields'=>['id','name', 'course_type_id']],
                'State',
                'Citie',
                'StatusDetran'
            ]
        ];

        if( $course_id || $status_detran_id || $state_id || $citie_id){
            $conditions = [];
            if (!empty($course_id)) {
                $conditions[] = ['OrderCourse.course_id' =>$course_id];
            }
            if (!empty($status_detran_id)) {
                $conditions[] = ['OrderCourse.status_detran_id' =>$status_detran_id];
            }
            if (!empty($state_id)) {
                $conditions[] = ['OrderCourse.state_id' =>$state_id];
            }
            if (!empty($citie_id)) {
                $conditions[] = ['OrderCourse.citie_id' =>$citie_id];
            }
            $orders = $this->Order->OrderCourse->find('list',[
                'fields'=>['OrderCourse.order_id'],
                'conditions'=> $conditions
            ]);
            $contain = [
                'OrderType',
                'User',
                'OrderCourse' => [
                    'conditions'=> $conditions,
                    'Course' => ['fields'=>['id','name', 'course_type_id']],
                    'State',
                    'Citie',
                    'StatusDetran'
                ],
            ];
            $conditionFilters = \Hash::merge($conditionFilters, ['Order.id'=>$orders]);
        }

        $this->Filter->setPaginate('order', 'Order.id DESC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        if( !empty($conditionFilters) )
            $this->Filter->setPaginate('conditions', $conditionFilters);

        $this->Order->recursive = 0;
        $this->Order->Behaviors->attach('Containable');
        $this->Filter->setPaginate('contain', $contain);
        $orders = $this->Paginator->paginate();

        $pageTitle = 'Matrícula';
        $this->set(compact('orders','pageTitle', 'states', 'cities'));
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */

    public function manager_view($id = null){
        if (!$this->Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }
        $options = array('conditions' => array('Order.id' => $id));
        $this->Order->Behaviors->load('Containable');

        $order_course = $this->Order->OrderCourse->findByOrderId($id);
        $state_id = $order_course['OrderCourse']['state_id'];
        $city_id  = $order_course['OrderCourse']['citie_id'];

        $conditionsModuleCourse = ['ModuleCourse.course_id IS NOT NULL'];

        if( !empty($state_id) ){
            $conditionsModuleCourse['ModuleCourse.state_id'] = $state_id;
        }
        if( !empty($city_id) ){
            $conditionsModuleCourse['ModuleCourse.citie_id'] = $city_id;
        }

        $this->Order->contain([
            'UserModuleSummary',
            'User',
            'OrderType',
            'OrderCourse' => [
                'Citie' => [
                    'fields' => ['name']
                ], 
                'State' => [
                    'fields' => ['name']
                ],
                'StatusDetran',
                'Course' => [
                    'fields' => ['name', 'course_type_id'],
                    'ModuleCourse'=>[
                        'conditions'=>$conditionsModuleCourse,
                        'Module'=>[
                            'fields' => ['id', 'name'],
                            'UserModuleSummary'=>[
                                'conditions'=>['UserModuleSummary.order_id'=>$id]
                            ],
                            'ModuleDiscipline'=>[
                                'fields' => ['id', 'name'],
                                'ModuleDisciplinePlayer' => [
                                    'conditions' => ['ModuleDisciplinePlayer.status' => 1],
                                    'order' => ['ModuleDisciplinePlayer.position' => 'ASC'],
                                    'UserModuleLog' => [
                                        'fields' => ['id','time'],
                                        'conditions' => [
                                            'UserModuleLog.model' => 'ModuleDisciplinePlayer',
                                            'UserModuleLog.order_id' => $id,
                                        ]
                                    ]
                                ],
                                'ModuleDisciplineSlider' => [
                                    'fields' => ['id', 'name'],
                                    'conditions' => ['ModuleDisciplineSlider.status' => 1],
                                    'order' => ['ModuleDisciplineSlider.position' => 'ASC'],
                                    'UserModuleLog' => [
                                        'fields' => ['order_id'],
                                        'conditions' => [
                                            'UserModuleLog.model' => 'ModuleDisciplineSlider',
                                            'UserModuleLog.order_id' => $id,
                                        ]
                                    ]
                                ],
                            ],
                            'UserQuestion'=>[
                                'conditions'=>['UserQuestion.order_id'=>$id]
                            ]
                        ]
                    ]
                ]
            ],
        ]);

        $order =  $this->Order->find('first', $options);

        $pageTitle = 'Matrícula';
        $this->set(compact('order','pageTitle'));
    }

    public function manager_insertUserModuleSummary($order_id){
        
        $this->Order->Behaviors->load('Containable');
        $this->Order->contain(['OrderCourse']);
        $order = $this->Order->findById($order_id);
        
        //Verifica se os módulos já foram disponibilizados para esta compra
        $UserModuleSummary = $this->Order->UserModuleSummary->find('count', ['conditions' => ['UserModuleSummary.order_id' => $order_id]]);
        if ( $UserModuleSummary == false) {

            if (!empty( $order )) {
                $this->Order->insertUserModuleSummary( $order, $order_id );
            }
        } else {
            if (!empty( $order )) {
                $this->Order->updateUserModuleSummary( $order, $order_id );
            }
        }
        $this->Session->setFlash(__('Grade de Estudo Atualizada!.'), 'manager/success');
        $this->redirect( $this->referer() );
    }

    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add($user_id = null)
    {


        if ($this->request->is('post')) {
            $this->Order->create();

            //recupera o total do pedido
            if (isset($this->request->data['OrderCourse'][0])) {

                $cart   = ['Cart' => $this->request->data['OrderCourse'][0]];
                $course = $this->__getCourseForCart($cart['Cart']['course_id'], $cart);

                if (!empty($course['Course']['promotional_price']) && empty($this->request->data['Order']['value'])) {
                    $this->request->data['Order']['value'] = $course['Course']['promotional_price'];
                } elseif (!empty($course['Course']['price']) && empty($this->request->data['Order']['value'])) {
                    $this->request->data['Order']['value'] = $course['Course']['price'];
                }
            }

            if ($this->Order->saveAll($this->request->data, ['deep' => true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if (isset($this->request->data['aplicar'])) {
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }

        $pageTitle     = 'Matrículas';
        $orderTypes    = $this->Order->OrderType->find('list');
        $paymentStatus = $this->Order->Payment->getStatusAprovado();
        $user          = null;

        $user_id = !empty($this->request->data['Order']['user_id']) ? $this->request->data['Order']['user_id'] : $user_id;

        if ($user_id) {
            $this->Order->User->Student->Behaviors->load('Containable');
            $user = $this->Order->User->Student->find('first', [
                'recursive'  => false,
                'fields'     => ['id', 'user_id', 'name', 'state_id', 'city_id', 'cnh', 'cnh_category', 'renach', 'birth'],
                'conditions' => ['Student.user_id' => $user_id],
                'contain'    => [
                    'User' => ['fields' => ['id', 'cpf'], 'School' => ['fields' => 'id', 'name', 'cod_cfc']]
                ]
            ]);

            $this->request->data['Order']['user_id']            = $user['User']['id'];
            $this->request->data['User']['id']                  = $user['User']['id'];
            $this->request->data['User']['Student'][0]['cpf']   = $user['User']['cpf'];
            $this->request->data['User']['Student'][0]['id']    = $user['Student']['id'];
            $this->request->data['User']['Student'][0]['birth'] = $user['Student']['birth'];

            if (!isset($this->request->data['User']['Student'][0])) { //se não veio no request, pega do banco
                $this->request->data['User']['Student'][0]['renach']       = $user['Student']['renach'];
                $this->request->data['User']['Student'][0]['cnh']          = $user['Student']['cnh'];
                $this->request->data['User']['Student'][0]['cnh_category'] = $user['Student']['cnh_category'];
            }

            if (!isset($this->request->data['OrderCourse'][0])) {  //se não veio no request, pega do banco
                $this->request->data['OrderCourse'][0]['renach']       = $user['Student']['renach'];
                $this->request->data['OrderCourse'][0]['cnh']          = $user['Student']['cnh'];
                $this->request->data['OrderCourse'][0]['cnh_category'] = $user['Student']['cnh_category'];
                $this->request->data['OrderCourse'][0]['state_id']     = $stateId = $user['Student']['state_id'];
                $this->request->data['OrderCourse'][0]['citie_id']     = $user['Student']['city_id'];
            }
        }

        //se já tem o curso selecionado
        $this->loadModel('State');
        if (isset($this->request->data['OrderCourse'][0]['course_id'])) {

            //recupera os estados do curso
            $states = $this->Order->OrderCourse->Course->getStatesOfCourse($this->request->data['OrderCourse'][0]['course_id']);

            $this->Order->OrderCourse->Course->Behaviors->load('Containable');
            $courseScope = $this->Order->OrderCourse->Course->find('first', [
                'conditions' => array('Course.id' => $this->request->data['OrderCourse'][0]['course_id']),
                'fields' => ['course_type_id'],
                'contain'=>[
                    'CourseType' => ['fields' => ['scope']]
                ]
            ]);

            $scope = $this->Order->OrderCourse->Course->CourseType->__listScopesForOrder($courseScope['CourseType']['scope']);

        } else {
            $states = $this->Order->OrderCourse->State->find('list');
            $scope  = '';
        }

        //recupera as cidades do estado
        $this->loadModel('City');
        $stateId = isset($this->request->data['OrderCourse'][0]['state_id']) ? $this->request->data['OrderCourse'][0]['state_id'] : State::RIO_DE_JANEIRO;

        $cities = $this->City->find('list', ['conditions' => ['state_id' => $stateId]]);

        //recupera os tipos de cada curso para regras de validação
        $coursesList = $this->Order->OrderCourse->Course->find('list', ['fields' => ['id', 'name', 'course_type_id']]);
        $courses     = [];
        $coursesType = [];
        foreach ($coursesList as $courseTypeId => $coursesOfType) {
            foreach ($coursesOfType as $key => $val) {
                $coursesType[$key] = $courseTypeId;
                $courses[$key]     = $val;
            }
        }

        //recupera a categoria de cnh
        $cnhCategories = $this->getCnhCategoriesList();

        $this->set(compact('orderTypes', 'courses', 'coursesType', 'user', 'cnhCategories', 'pageTitle', 'paymentStatus', 'states', 'cities', 'scope'));
    }

    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_edit($id = null){
        if (!$this->Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Order->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $this->Order->Behaviors->load('Containable');
            $this->Order->contain([
                    'OrderType',
                    'User',
                    'OrderCourse' => ['Citie'],
            ]);
            $options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
            $this->request->data = $this->Order->find('first', $options);
        }
        
        $orderTypes = $this->Order->OrderType->find('list');
        $users = $this->Order->User->find('list');
		$courses = $this->Order->OrderCourse->Course->find('list');
        $cnhCategories = $this->getCnhCategoriesList();
		$this->set(compact('orderTypes', 'users', 'courses', 'cnhCategories'));
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_delete($id = null){
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Order->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', 'manager' => true));
    }

    private function __getCartForPagarme($carts, $order){
        $cart_informations = [];
        $total_value = 0;
        $i = 0;

        $cart_informations['capture'] = 'true';
        $cart_informations['postback_url'] = Configure::read('Pagarme.postback_url');
        $cart_informations['async'] = 'false';
        //$cart_informations['installments'] = 6;
        //$cart_informations['encryption_key'] = Configure::read('Pagarme.encryption_key');
        //$cart_informations['api_key'] = Configure::read('Pagarme.api_key');

        $cart_informations = array_merge($order, $cart_informations);

        //credit card
        if (isset($cart_informations['card_number'])) {
            $cart_informations['card_number'] = preg_replace('/[^0-9]/', '', $cart_informations['card_number']);
        }

        if (isset($cart_informations['card_holder_name'])) {
            $cart_informations['card_holder_name'] = strtoupper($cart_informations['card_holder_name']);
        }

        if (isset($cart_informations['card_expiration_date'])) {
            $cart_informations['card_expiration_date'] = preg_replace('/[^0-9]/', '', $cart_informations['card_expiration_date']);
        }

        if (isset($cart_informations['card_cvv'])) {
            $cart_informations['card_cvv'] = preg_replace('/[^0-9]/', '', $cart_informations['card_cvv']);
        }

        //Items

        foreach($carts as $cart){                        
            $price = !empty($cart['Cart']['unitary_discount']) ? floatval($cart['Cart']['unitary_value']) - floatval($cart['Cart']['unitary_discount']) : floatval($cart['Cart']['unitary_value']);                                    

            $cart_informations['items'][$i]['id'] = $cart['Cart']['id'];
            $cart_informations['items'][$i]['title'] = $cart['Course']['name'];
            $cart_informations['items'][$i]['unit_price'] = number_format($price,2,'','');
            $cart_informations['items'][$i]['quantity'] = 1;
            $cart_informations['items'][$i]['tangible'] = false;
            $i++;
            $total_value += $price;
        }

        $cart_informations['amount'] = number_format($total_value,2,'','');
        
        if( $this->Auth->user() ){

            //Customer        
            $cart_informations['customer']['external_id'] = $this->Auth->user('id');
            $cart_informations['customer']['type'] = 'individual';
            $cart_informations['customer']['name'] = $this->Auth->user('Student.0.name') ? $this->Auth->user('Student.0.name') : $this->Auth->user('name');
            $cart_informations['customer']['country'] = 'br';
            $cart_informations['customer']['email'] = $this->Auth->user('email');

            if ( $this->Auth->user('Student.0.cellphone') ) {
                $cart_informations['customer']['phone_numbers'] = ['+55' . str_replace(['.', '(', ')', ' ', '-'], '', $this->Auth->user('Student.0.cellphone'))];
            }else{
                $cart_informations['customer']['phone_numbers'] = ['+55' . str_replace(['.', '(', ')', ' ', '-'], '', '(21) 98321-0467')];
            }

            //Documents        
            $cart_informations['customer']['documents'][0]['type'] = 'cpf';
            $cart_informations['customer']['documents'][0]['number'] = str_replace(['.','-'],'',$this->Auth->user('cpf'));        
            
            //Address
//            $cart_informations['billing']['name']                       =  $cart_informations['customer']['name'];
//            $cart_informations['billing']['address']['country']         = 'br';
//            $cart_informations['billing']['address']['state']           = $this->Auth->user('Student.0.State.abbreviation');
//            $cart_informations['billing']['address']['city']            = $this->Auth->user('Student.0.City.name');
//            $cart_informations['billing']['address']['neighborhood']    = $this->Auth->user('Student.0.neighborhood');
//            $cart_informations['billing']['address']['street']          = $this->Auth->user('Student.0.address');
//            $cart_informations['billing']['address']['street_number']   = $this->Auth->user('Student.0.number');
//            $cart_informations['billing']['address']['complementary']   = !empty($this->Auth->user('Student.0.complement')) ? $this->Auth->user('Student.0.complement') : 'Casa';
//            $cart_informations['billing']['address']['zipcode']         = str_replace(['.','-'],'',$this->Auth->user('Student.0.zipcode'));
        }

        return $cart_informations;

//        return $this->__checkDataClientInCart($cart_informations);
    }


    private function __convertPagarMeTransactionToOrder($pagarme_transaction,$cart_informations,$sender){
        $order = [];
        $order['Order']['user_id'] = $this->Auth->user('id');
        
        $order['Order']['transactionid'] = $pagarme_transaction['id'];
        $order['Order']['ticket_id'] = !empty($this->Session->read('Ticket')) ? $this->Session->read('Ticket')['id'] : null;
        $this->loadModel('Method');
        $this->Method->recursive = -1;
        $method = $this->Method->find('first',['fields'=>['Method.id','Method.name'],'conditions'=>['Method.code'=>$cart_informations['payment_method']]]);
        $order['Order']['method_id'] = $method['Method']['id'];  

        $this->loadModel('Payment');
        
        $order['Order']['order_type_id'] = $this->Payment->getStatusByPagarmeStatus($pagarme_transaction['status']);

        $carts = $this->__getCartsInSession($this->__getSessionId());
        $order['Order']['value'] = 0;
        $order['Order']['value_discount'] = 0;
        $order['Order']['sender'] = $sender;
        foreach($carts as $cart){
            $order['Order']['value'] += floatval($cart['Cart']['unitary_value']);
            $order['Order']['value_discount'] += floatval($cart['Cart']['unitary_discount']);
        }

        $order['OrderCourse'] = [];
        foreach($carts as $cart){            
            unset($cart['Cart']['id']);            
            $order['OrderCourse'][] = $cart['Cart'];
        }        
        
        $order['Payment'][0]['TransacaoID'] = $pagarme_transaction['id'];
        $order['Payment'][0]['DataTransacao'] = date('Y-m-d H:i:s'); 
        $order['Payment'][0]['StatusTransacao'] = $this->Order->Payment->getStatusByCode($this->Order->Payment->getStatusByPagarmeStatus($pagarme_transaction['status']));            
        $order['Payment'][0]['Parcelas'] = 1;
        $order['Payment'][0]['TipoPagamento'] = $method['Method']['name'];
        $order['Payment'][0]['NumItens'] = count($order['OrderCourse']);


        

        $order['Order']['payment_link_boleto'] = !empty($pagarme_transaction['boleto_url']) ? $pagarme_transaction['boleto_url'] : null;                

        return $order;
    }

    /**
     * Refaz a comunicação com os Detrans
     * @param int $id Order Id
     */
    public function manager_recomunicar($id =null)
    {
        if (!$this->Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }

        $this->Order->Behaviors->load('Containable');
        $order =  $this->Order->find('first', [
            'conditions' => ['Order.' . $this->Order->primaryKey => $id],
            'contain' => ['OrderCourse']
        ]);

        App::uses('IntegracaoDetransService', 'IntegracaoDetrans');

        $objIntegracaoService = new IntegracaoDetransService();
        $objIntegracaoService->setOrigem('manager_recomunicar');

        try {
            foreach ($order['OrderCourse'] as $orderCourse) {
                $objIntegracaoService->reprocessar($orderCourse['order_id'], $orderCourse['course_id']);
            }
            $this->Session->setFlash(__('Processamento efetuado com sucesso. Verifique o status'), 'manager/success');
        } catch (Exception $exception) {
            $this->Session->setFlash(__('Não foi possível reprocessar. ' . $exception->getMessage()), 'manager/error');
        }

        $this->redirect($this->referer());
    }

    /**
     * Exibe a tabela de Carga Horária e os Respectivos Créditos de Aula
     * @param null $id
     */
    public function manager_credito_aulas($id = null)
    {
        App::uses('IntegracaoDetransService', 'IntegracaoDetrans');
        $objIntegracaoService = new IntegracaoDetransService();

        $arrData = $objIntegracaoService->getDadosCreditoHoras($id);
        $this->set('arrData', $arrData);
    }

    public function payment_resume()
    {
        $this->autorender = false;
        $this->layout     = false;
        $this->render('/Elements/site/payment/resumo');
    }
}
