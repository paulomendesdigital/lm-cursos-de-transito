<?php
App::uses('AppController', 'Controller');

class PartnersController extends AppController {

        /* Lista de compras realizadas */
        public function index(){

                $this->loadModel('Order');
                $this->Order->Behaviors->load('Containable');
                
                $orders = $this->Order->find('all', 
                        [
                                'contain' => [
                                        'OrderCourse' => [
                                                'Course' => [
                                                        'fields' => ['id', 'name', 'course_type_id']
                                                ],
                                        ],
                                        'OrderType',
                                        'User',
                                ],
                                'conditions' => array('Order.sender !=' => 'LM')
                        ]
                );

                $pageTitle = 'Matrícula';
                $this->set(compact('orders', 'pageTitle'));
        }
}
