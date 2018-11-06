<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Grupo Grow - www.grupogrow.com.br
 * Carts Controller
 *
 * @property Cart $Cart
 * @property PaginatorComponent $Paginator
 */
class CartsController extends AppController {

    /**
     * Components
     *
     * @var array
    */
	public $components = array('Paginator');

    /**
    * add method
    * @return void
    */
    public function add(){
        $this->autoRender = false;
        $this->layout = false;

        if ($this->request->is('post')) {            
            $course_id = $this->request->data['Cart']['course_id'];
            if( !empty($this->request->data['Cart']['course_id']) ){                
                $this->Cart->Course->Behaviors->load('Containable');
                $course = $this->__getCourseForCart($this->request->data['Cart']['course_id'],$this->request->data);
                $session_id = $this->__getSessionId();
                if( !empty($course) ){
                    if( !$this->Cart->__containCourseInCart($this->request->data['Cart']['course_id'], $session_id) ){

                        //INTEGRAÇÕES ========================================================
                        $camposConsulta = $this->request->data('Cart');
                        $stateId = isset($course['Cart']['state_id']) ? $course['Cart']['state_id'] : null;
                        $cityId  = isset($course['Cart']['citie_id']) ? $course['Cart']['citie_id'] : null;

                        if (isset($camposConsulta['cpf']) && !empty($camposConsulta['cpf'])) {
                            $this->Session->write('consulta_cpf', $camposConsulta['cpf']);
                        }
                        if (isset($camposConsulta['birth']) && !empty($camposConsulta['birth'])) {
                            $this->Session->write('consulta_birth', $camposConsulta['birth']);
                        }

                        App::uses('IntegracaoDetransService', 'IntegracaoDetrans');
                        try {
                            $objIntegracao = new IntegracaoDetransService();
                            if (!$objIntegracao->validar($course['Course']['id'], $stateId, $cityId, $camposConsulta)) {
                                $this->Session->setFlash('Não foi possível continuar com a matrícula<br><span style="font-size:16px">' . $objIntegracao->getRetorno() . '</span>', 'site/popup-error');
                                $this->redirect($this->referer());
                            }
                        } catch (IntegracaoException $ex) { //exception que pode ser exibida ao usuário
                            $this->Session->setFlash('Não foi possível continuar com a matrícula<br><span style="font-size:16px">' . $ex->getMessage() . '</span>', 'site/popup-error');
                            $this->redirect($this->referer());
                        } catch (Exception $e) {//erro de comunicação/sistema não será exibida ao usuário
                        }
                        //FIM DAS INTEGRAÇÕES ========================================================

                        $this->Cart->create();

                        $this->request->data = $this->Cart->__setValuesInRequestData($course, $session_id);

                        if ($this->Cart->save($this->request->data)) {
                            //$this->Session->setFlash(__('Curso adicionado com sucesso ao carrinho!'), 'site/popup-success');
                            return $this->redirect(['controller' => 'orders', 'action' => 'payment', 'manager' => false]);
                        } else {
                            $this->Session->setFlash('Não foi possível adicionar ao carrinho!', 'site/popup-error');
                        }
                    }else{                        
                        $this->Session->setFlash('Este curso já está no carrinho!<br><a href="' . Router::url(['controller' => 'carts', 'action' => 'index']) . '">Ir para o Carrinho</a>', 'site/popup-error');
                        return $this->redirect( $this->referer() );
                    }
                }else{                                        
                    $this->Session->setFlash('Não foi possível localizar o curso desejado!', 'site/popup-error');
                    return $this->redirect( $this->referer() );
                }
            }else{                          
                $this->Session->setFlash('Não foi possível adicionar o curso ao carrinho!', 'site/popup-error');
                return $this->redirect( $this->referer() );
            }
        }
        return $this->redirect(array('action' => 'index', 'manager' => false));
    }

    public function add_ticket(){
        $this->autoRender = false;
        $this->layout = false;

        $bolSuccess = false;
        $message = 'O código do cupom não foi informado!';

        if ($this->request->is('post')) {
            if( !empty($this->request->data['Cart']['code']) ){
                $code = $this->request->data['Cart']['code'];

                $this->Cart->Course->Ticket->Behaviors->load('Containable');
                $ticket = $this->Cart->Course->Ticket->__getTicketByCode($code);

                if( !empty($ticket) ){
                    if( !$this->Session->read('Ticket') ){

                        //adicionando o cupom de desconto
                        if( $this->Cart->Course->Ticket->__isValid($ticket) ){
                            $this->Cart->Behaviors->load('Containable');
                            $carts = $this->Cart->__getCartsInSession($this->__getSessionId());
                            $countDiscount = 0;                            
                            foreach ($carts as $cart) {                                
                                if( $this->Cart->__addDiscount($cart, $ticket) ){
                                    $countDiscount++;
                                }
                            }
                            if( $countDiscount > 0 ){
                                $ticket['Ticket']['amount'] = $ticket['Ticket']['amount'] - $countDiscount;
                                $this->Session->write('Ticket', $ticket['Ticket']);
                                $message = 'Desconto adicionado com sucesso!';
                                $bolSuccess = true;
                            }else{
                                $message = 'Não foi possível inserir o desconto!';
                            }
                        }else{
                            $message = 'Este cupom não está mais válido!';
                        }
                    }else{
                        //ja foi adicionado um cupom antes, verificar se está removendo ou querendo adicionar outro
                        $message = 'Você já está usando um cupom de desconto para esta compra!';
                    }
                }else{
                    $message = 'O código do cupom não foi localizado!';
                }
            }
        }

        if (strstr($this->referer(), 'orders/payment')) {
            $this->set('message', $message);
            return $this->render('/Elements/site/payment/form-cupom');
        } else {
            $this->Session->setFlash($message, $bolSuccess ? 'site/popup-success' : 'site/popup-error');
            return $this->redirect(array('action' => 'index', 'manager' => false));
        }
    }

    public function remove_ticket(){
        $this->autoRender = false;
        $this->layout = false;

        $bolSuccess = false;
        $message    = 'Não foi possível remover o desconto!';

        if ($this->request->is('post')) {
            if( !empty($this->request->data['Cart']['code']) ){
                $code = $this->request->data['Cart']['code'];

                $this->Cart->Course->Ticket->Behaviors->load('Containable');
                $ticket = $this->Cart->Course->Ticket->__getTicketByCode($code);                
                if( !empty($ticket) ){
                    if( $this->Session->read('Ticket') ){
                        //if( $this->Cart->Product->Ticket->__isValid($ticket) ){
                        $this->Cart->Behaviors->load('Containable');
                        $carts = $this->Cart->__getCartsInSession($this->__getSessionId());                        
                        $countDiscount = 0;
                        foreach ($carts as $cart) {
                            if( $this->Cart->__removeDiscount($cart, $ticket) ){
                                $countDiscount++;
                            }
                        }
                        if( $countDiscount > 0 ){
                            $ticket['Ticket']['amount'] = $ticket['Ticket']['amount'] + $countDiscount;
                            $this->Session->delete('Ticket');
                            $message    = 'Desconto removido com sucesso!';
                            $bolSuccess = true;
                            unset($this->request->data['Cart']['code']);
                        }else{
                            $message = 'Não foi possível remover o desconto!';
                        }
                        //}else{
                        //    $this->Session->setFlash('O cupom informado não está mais válido!','site/popup-error');
                        //    return $this->redirect(array('action' => 'index', 'manager' => false));
                        //}
                    }else{
                        $message = 'Não foi localizado o cupom!';
                    }
                }else{
                    $message = 'O código do cupom não foi localizado!';
                }
            }else{
                $message = 'O código do cupom não foi informado!';
            }
        }

        if (strstr($this->referer(), 'orders/payment')) {
            if ($bolSuccess) {
                $message = '';
            }
            $this->set('message', $message);
            return $this->render('/Elements/site/payment/form-cupom');
        } else {
            $this->Session->setFlash($message, $bolSuccess ? 'site/popup-success' : 'site/popup-error');
            return $this->redirect(array('action' => 'index', 'manager' => false));
        }
    }

    /**
    * index method
    *
    * @return void
    */

    public function index(){                
        $this->loadModel('Group');
        //$this->__verifySecurity($this->Group->getAluno());
        $session_id = $this->__getSessionId();        
        $carts = $this->__getCartsInSession($session_id);
        $this->set(compact('carts'));                
    }    

    /**
    * delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function delete($id = null){
        $this->Cart->id = $id;
        if (!$this->Cart->exists()) {
            throw new NotFoundException(__('Invalid cart'));
        }
        $session_id = $this->__getSessionId();
        $this->Cart->id = $this->request->data['id'];
        $cart = $this->Cart->find('first',[
            'conditions' => [
                'Cart.id' => $this->request->data['id'],
                'Cart.sessionid' => $session_id
            ]
        ]);
        $this->request->onlyAllow('post', 'delete');
        if(!empty($cart)){
            if ($this->Cart->delete()) {
                $this->Session->setFlash('Item excluído do carrinho com sucesso!', 'site/popup-success');
            } else {
                $this->Session->setFlash('Não foi possível excluir o ítem do carrinho!', 'site/popup-error');
            }
        }else{
            $this->Session->setFlash('Não foi possível excluir o ítem do carrinho!', 'site/popup-error');
        }
        
        return $this->redirect(array('action'=>'index', 'manager' => false));
    }

    public function ajax_delete(){
        $this->layout = 'ajax';
        $this->autoRender = false;        
        $session_id = $this->__getSessionId();
        $this->Cart->id = $this->request->data['id'];
        $cart = $this->Cart->find('first',[
            'conditions' => [
                'Cart.id' => $this->request->data['id'],
                'Cart.sessionid' => $session_id
            ]
        ]);
        if (!$this->Cart->exists() || empty($cart)) {
            throw new NotFoundException(__('Invalid cart'));
        }
        $this->request->onlyAllow('post', 'delete');

        if ($this->Cart->delete()) {
            $this->Session->setFlash('Item excluído do carrinho com sucesso!', 'site/popup-success');
            return true;
        }
        $this->Session->setFlash('Não foi possível excluir o ítem do carrinho!', 'site/popup-error');                    

        return false;
    }

    /**
    * manager_index method
    *
    * @return void
    */

    public function manager_index() 
    {

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'Cart.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Cart.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Cart.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Cart->recursive = 0;
        $this->set('carts', $this->Paginator->paginate());
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */

    public function manager_view($id = null)
    {
        if (!$this->Cart->exists($id)) {
            throw new NotFoundException(__('Invalid cart'));
        }
        $options = array('conditions' => array('Cart.' . $this->Cart->primaryKey => $id));
        $this->set('cart', $this->Cart->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->Cart->create();
            if ($this->Cart->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$products = $this->Cart->Product->find('list');
		$this->set(compact('products'));
    }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_edit($id = null) 
    {
        if (!$this->Cart->exists($id)) {
            throw new NotFoundException(__('Invalid cart'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Cart->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('Cart.' . $this->Cart->primaryKey => $id));
            $this->request->data = $this->Cart->find('first', $options);
                    }
        
        		$products = $this->Cart->Product->find('list');
		$this->set(compact('products'));
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_delete($id = null) 
    {
        $this->Cart->id = $id;
        if (!$this->Cart->exists()) {
            throw new NotFoundException(__('Invalid cart'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Cart->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }
   
}
