<?php
App::uses('AppController', 'Controller');
App::uses('Download', 'Model');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Reports Controller
 */
class ReportsController extends AppController {

    public function manager_approvals($export = false) {

        $this->loadModel('UserCertificate');
        $reports = [];

        if ($this->request->is('post')) {

            if (empty($this->request->data['Report']['course_id'])) {
                $this->Session->setFlash(__('Favor selecionar o curso!'), 'manager/error');
                return $this->redirect($this->referer());
            }

            $conditionsOrderCourse['OrderCourse.course_id'] = $this->request->data['Report']['course_id'];

            if ($this->request->data['Report']['scope'] == 'municipal') {
                if (empty($this->request->data['Report']['state_id']) OR empty($this->request->data['Report']['citie_id'])) {
                    $this->Session->setFlash(__('O Estado e o Município devem ser selecionados!'), 'manager/error');
                    return $this->redirect($this->referer());
                }
                $conditionsOrderCourse['OrderCourse.state_id'] = $this->request->data['Report']['state_id'];
                $conditionsOrderCourse['OrderCourse.citie_id'] = $this->request->data['Report']['citie_id'];

                //para o filtro
                $this->loadModel('CourseState');
                $this->CourseState->Behaviors->load('Containable');
                $this->set('cities', $this->CourseState->__getCitiesByCourseState($this->request->data['Report']['state_id']));
            }
            elseif($this->request->data['Report']['scope'] == 'estadual'){
                $conditionsOrderCourse['OrderCourse.state_id'] = $this->request->data['Report']['state_id'];
            }

            $finishBD = date('Y-m-d');
            $startBD  = $this->__calculateDate($finishBD, -30);

            if (!empty($this->request->data['Report']['start'])) {
                $startBD = $this->Report->dateFormatBeforeSave($this->request->data['Report']['start']);
            }

            if (!empty($this->request->data['Report']['finish'])) {
                $finishBD = $this->Report->dateFormatBeforeSave($this->request->data['Report']['finish']);
            }

            //debug($this->request->data);
            $this->UserCertificate->Behaviors->load('Containable');
            $reports = $this->UserCertificate->find('all', [
                'contain'    => [
                    'User',
                    'Order' => [
                        'OrderCourse' => [
                            'State',
                            'Citie',
                            'conditions' => [
                                $conditionsOrderCourse
                            ]
                        ],
                    ],
                    'Course'
                ],
                'conditions' => [
                    'UserCertificate.course_id' => $this->request->data['Report']['course_id'],
                    'UserCertificate.start >='  => $startBD,
                    'UserCertificate.finish <=' => $finishBD,
                    'UserCertificate.order_id'  => $this->UserCertificate->Order->OrderCourse->find('list', ['fields' => ['order_id'], 'conditions' => [$conditionsOrderCourse]]),
                ],
                'order'      => ['UserCertificate.finish']
            ]);

            $states = $this->UserCertificate->Course->getStatesOfCourse($this->request->data['Report']['course_id']);

            if (!$states) { //corrige o warning quando não tem estados
                $states = [];
            }

            $this->request->data['Report']['start']  = $this->Report->dateFormatAfterFind($startBD);
            $this->request->data['Report']['finish'] = $this->Report->dateFormatAfterFind($finishBD);

            $this->set('states', $states);

            if ($export) {

                if (!empty($this->request->data['Report']['extension'])) {

                    ob_start();

                    if ($this->request->data['Report']['extension'] == 'AVL') {
                        App::uses('Folder', 'Utility');
                        App::uses('File', 'Utility');
                        $folder = new Folder("files/reports", true, 0755);

                        // Define o tempo máximo de execução em 0 para as conexões lentas
                        set_time_limit(0);
                        $avl       = $this->Report->__FormatAVL($reports);
                        $file_path = $this->Report->__GenerateAVL($avl);

                        if ($file_path) {

                            $this->Report->download($file_path);
                            //return $this->redirect( ['controller'=>'downloads', 'action'=>'send', base64_encode($file_path),'manager'=>false] );
                            //return $this->redirect( Router::url('/', true) . $file_path );
                        } else {
                            $this->Session->setFlash(__('Não foi possível gerar o arquivo!'), 'manager/error');
                        }
                    }
                    else{

                        $this->layout = 'export_xls';
                        //$results = $this->Report->__FormatXLS( $reports );
                        $this->set('filename', 'aprovados');
                        $this->set(compact('reports'));
                        $this->render('manager_export');
                    }
                }
                else{
                    $this->Session->setFlash(__('Selecione em qual formato deseja baixar!'), 'manager/error');
                }
            }
        }
        else{

            $states = [];
        }

        //filtros
        $courses = $this->UserCertificate->Course->find('list');
        $this->set(compact('courses', 'states', 'reports'));
    }

    public function manager_sales()
    {
        $this->loadModel('Order');
        $this->loadModel('Payment');

        $states  = $this->Order->OrderCourse->State->find('list');
        $courses = $this->Order->OrderCourse->Course->find('list');
        $status  = $this->Order->OrderType->find('list');
        $schools  = $this->Order->User->School->find('list', ['order' => 'name']);
        $this->set(compact('courses', 'states', 'status', 'schools'));

        if (!$this->request->is('post')) {

            $this->request->data['Report']['start']         = date_create()->modify('-1 month')->format('Y-m-01');
            $this->request->data['Report']['finish']        = date('Y-m-d');
            $this->request->data['Report']['order_type_id'] = Payment::APROVADO;


            $sqlNaoCancelado = "orders.order_type_id != '" . Payment::CANCELADO . "'";
            $sqlAprovado     = "orders.order_type_id = '" . Payment::APROVADO . "'";
            $sqlAguardando   = "orders.order_type_id = '" . Payment::AGUARDANDO_PAGTO . "'";
            $sqlSumTotal     = "SUM(orders.value - orders.value_discount) as total";

            //vendas hoje
            $sqlHoje = "DATE(orders.created) = '" . date('Y-m-d') . "'";
            $arrDashboard['hoje']['total']      = $this->Order->query("SELECT $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlHoje")[0][0]['total'];
            $arrDashboard['hoje']['aguardando'] = $this->Order->query("SELECT $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlHoje AND $sqlAguardando")[0][0]['total'];
            $arrDashboard['hoje']['aprovado']   = $this->Order->query("SELECT $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlHoje AND $sqlAprovado")[0][0]['total'];

            //vendas mês atual
            $sqlMesAtual = "DATE(orders.created) BETWEEN '" . date('Y-m-01') . "' AND '" .  date('Y-m-d') . "'";
            $arrDashboard['mes_atual']['total']      = $this->Order->query("SELECT $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlMesAtual")[0][0]['total'];
            $arrDashboard['mes_atual']['aguardando'] = $this->Order->query("SELECT $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlMesAtual AND $sqlAguardando")[0][0]['total'];
            $arrDashboard['mes_atual']['aprovado']   = $this->Order->query("SELECT $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlMesAtual AND $sqlAprovado")[0][0]['total'];

            $arrDashboard['mes_atual']['por_dia'] = [];
            $resultPorDia = $this->Order->query("SELECT DATE(created) as dia, $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlMesAtual GROUP BY DATE(created) ORDER BY 1");
            foreach ($resultPorDia as $row) {
                $arrDashboard['mes_atual']['por_dia'][] = [strtotime($row[0]['dia']) * 1000, round($row[0]['total'])];
            }

            //vendas mês anterior
            $sqlMesAnterior = "DATE(orders.created) BETWEEN '" . date_create()->modify('-1 month')->format('Y-m-01') . "' AND '" .  date_create()->modify('-1 month')->format('Y-m-t') . "'";
            $arrDashboard['mes_anterior']['total']      = $this->Order->query("SELECT $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlMesAnterior")[0][0]['total'];
            $arrDashboard['mes_anterior']['aguardando'] = $this->Order->query("SELECT $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlMesAnterior AND $sqlAguardando")[0][0]['total'];
            $arrDashboard['mes_anterior']['aprovado']   = $this->Order->query("SELECT $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlMesAnterior AND $sqlAprovado")[0][0]['total'];

            $arrDashboard['mes_anterior']['por_dia'] = [];
            $resultPorDia = $this->Order->query("SELECT DATE(created) as dia, $sqlSumTotal FROM orders WHERE $sqlNaoCancelado AND $sqlMesAnterior GROUP BY DATE(created) ORDER BY 1");
            foreach ($resultPorDia as $row) {
                $arrDashboard['mes_anterior']['por_dia'][] = [strtotime($row[0]['dia']) * 1000, round($row[0]['total'])];
            }

            $this->set('arrDashboard', $arrDashboard);

        } else {

            $arrConditions = [
                'DATE(Order.created) >=' => $this->request->data['Report']['start'],
                'DATE(Order.created) <=' => $this->request->data['Report']['finish'],
            ];

            if (!empty($this->request->data['Report']['order_type_id'])) {
                $arrConditions['Order.order_type_id'] = $this->request->data['Report']['order_type_id'];
            }
            if (!empty($this->request->data['Report']['course_id'])) {
                $arrConditions['OrderCourse.course_id'] = $this->request->data['Report']['course_id'];
            }
            if (!empty($this->request->data['Report']['state_id'])) {
                $arrConditions['OrderCourse.state_id'] = $this->request->data['Report']['state_id'];
            }
            if (!empty($this->request->data['Report']['citie_id'])) {
                $arrConditions['OrderCourse.citie_id'] = $this->request->data['Report']['citie_id'];
            }

            set_time_limit(300);
            $this->Order->OrderCourse->Behaviors->load('Containable');
            $dados = $this->Order->OrderCourse->find('all', [
                'fields'     => ['order_id', 'course_id', 'citie_id', 'state_id'],
                'contain'    => [
                    'Course' => ['name', 'price', 'promotional_price'],
                    'Citie'  => ['name'],
                    'State'  => ['abbreviation'],
                    'Order'  => [
                        'id', 'order_type_id', 'user_id', 'method_id', 'created', 'value',
                        'OrderType' => ['name'],
                        'Method'    => ['name'],
                        'User'      => [
                            'name',
                            'cpf',
                            'email',
                            'School' => ['name']
                        ],
                        'Payment'   => [
                            'fields'     => ['created'],
                            'conditions' => [
                                'Payment.StatusTransacao' => $this->Payment->getStatusByCode(Payment::APROVADO)
                            ],
                            'limit'      => 1,
                            'order'      => 'Payment.id',
                        ]
                    ],
                ],
                'conditions' => $arrConditions
            ]);

            $this->set(compact('dados'));

            $this->autoRender = false;
            $this->layout     = false;

            header("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=vendas_" . date('Ymdhis') . ".xls");
            header("Content-Description: Generated Report");
            $this->render('manager_sales_export');
        }
    }
}
