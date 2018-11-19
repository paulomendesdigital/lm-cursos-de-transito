<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Grupo Grow - www.grupogrow.com.br
 * Tickets Controller
 *
 * @property Ticket $Ticket
 * @property PaginatorComponent $Paginator
 */
class TicketsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Paginator');

    /**
    * manager_index method
    *
    * @return void
    */
    public function manager_index(){

        $this->Filter->addFilters(
            array(
                'filterId' => array(
                    'Ticket.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterCode' => array(
                    'Ticket.code' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterStatus' => array(
                    'Ticket.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Ticket.id DESC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional
        $this->Filter->setPaginate('contain','User');

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Ticket->recursive = 1;        
        $this->set('tickets', $this->Paginator->paginate());
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
        if (!$this->Ticket->exists($id)) {
            throw new NotFoundException(__('Invalid ticket'));
        }
        $options = array('conditions' => array('Ticket.' . $this->Ticket->primaryKey => $id));
        $this->set('ticket', $this->Ticket->find('first', $options));
    }

    /**
    * manager_add method
    *
    * @return void
    */
    public function manager_add(){
        if ($this->request->is('post')) {
            $this->Ticket->create();
            if ($this->Ticket->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            }else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        $courses = $this->Ticket->Course->__getList();
        $this->set(compact('courses'));
    }

    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_edit($id = null){
        if (!$this->Ticket->exists($id)) {
            throw new NotFoundException(__('Invalid ticket'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Ticket->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('Ticket.' . $this->Ticket->primaryKey => $id));
            $this->request->data = $this->Ticket->find('first', $options);
        }

        $courses = $this->Ticket->Course->__getListForHABTM();
        $this->set(compact('courses'));
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_delete($id = null){
        $this->Ticket->id = $id;
        if (!$this->Ticket->exists()) {
            throw new NotFoundException(__('Invalid ticket'));
        }

        $this->request->onlyAllow('post', 'delete');
        if ($this->Ticket->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', 'manager' => true));
    }

    /**
    * index method
    *
    * @return void
    */
    public function index() 
    {

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'Ticket.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Ticket.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Ticket.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Ticket->recursive = 0;
        $this->set('tickets', $this->Paginator->paginate());
    }

    /**
    * view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */

    public function view($id = null)
    {
        if (!$this->Ticket->exists($id)) {
            throw new NotFoundException(__('Invalid ticket'));
        }
        $options = array('conditions' => array('Ticket.' . $this->Ticket->primaryKey => $id));
        $this->set('ticket', $this->Ticket->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->Ticket->create();
            if ($this->Ticket->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$users = $this->Ticket->User->find('list');
		$this->set(compact('users'));
    }

    
    /**
    * edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function edit($id = null) 
    {
        if (!$this->Ticket->exists($id)) {
            throw new NotFoundException(__('Invalid ticket'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Ticket->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('Ticket.' . $this->Ticket->primaryKey => $id));
            $this->request->data = $this->Ticket->find('first', $options);
                    }
        
        		$users = $this->Ticket->User->find('list');
		$this->set(compact('users'));
    }

    /**
    * delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function delete($id = null) 
    {
        $this->Ticket->id = $id;
        if (!$this->Ticket->exists()) {
            throw new NotFoundException(__('Invalid ticket'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Ticket->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => false));
                            }
        

}
