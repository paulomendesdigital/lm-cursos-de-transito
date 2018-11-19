<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * OrderCourses Controller
 *
 * @property OrderCourse $OrderCourse
 * @property PaginatorComponent $Paginator
 */
class OrderCoursesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

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
                    'OrderCourse.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'OrderCourse.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'OrderCourse.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->OrderCourse->recursive = 0;
        $this->set('orderCourses', $this->Paginator->paginate());
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
        if (!$this->OrderCourse->exists($id)) {
            throw new NotFoundException(__('Invalid order course'));
        }
        $options = array('conditions' => array('OrderCourse.' . $this->OrderCourse->primaryKey => $id));
        $this->set('orderCourse', $this->OrderCourse->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->OrderCourse->create();
            if ($this->OrderCourse->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$orders = $this->OrderCourse->Order->find('list');
		$courses = $this->OrderCourse->Course->find('list');
		$cities = $this->OrderCourse->Citie->find('list');
		$states = $this->OrderCourse->State->find('list');
		$this->set(compact('orders', 'courses', 'cities', 'states'));
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
        if (!$this->OrderCourse->exists($id)) {
            throw new NotFoundException(__('Invalid order course'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->OrderCourse->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('OrderCourse.' . $this->OrderCourse->primaryKey => $id));
            $this->request->data = $this->OrderCourse->find('first', $options);
        }
        
        		$orders = $this->OrderCourse->Order->find('list');
		$courses = $this->OrderCourse->Course->find('list');
		$cities = $this->OrderCourse->Citie->find('list');
		$states = $this->OrderCourse->State->find('list');
		$this->set(compact('orders', 'courses', 'cities', 'states'));
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
        $this->OrderCourse->id = $id;
        if (!$this->OrderCourse->exists()) {
            throw new NotFoundException(__('Invalid order course'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->OrderCourse->delete()) {
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

    public function manager_index() 
    {

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'OrderCourse.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'OrderCourse.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'OrderCourse.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->OrderCourse->recursive = 0;
        $this->set('orderCourses', $this->Paginator->paginate());
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
        if (!$this->OrderCourse->exists($id)) {
            throw new NotFoundException(__('Invalid order course'));
        }
        $options = array('conditions' => array('OrderCourse.' . $this->OrderCourse->primaryKey => $id));
        $this->set('orderCourse', $this->OrderCourse->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->OrderCourse->create();
            if ($this->OrderCourse->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$orders = $this->OrderCourse->Order->find('list');
		$courses = $this->OrderCourse->Course->find('list');
		$cities = $this->OrderCourse->Citie->find('list');
		$states = $this->OrderCourse->State->find('list');
		$this->set(compact('orders', 'courses', 'cities', 'states'));
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
        if (!$this->OrderCourse->exists($id)) {
            throw new NotFoundException(__('Invalid order course'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->OrderCourse->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('OrderCourse.' . $this->OrderCourse->primaryKey => $id));
            $this->request->data = $this->OrderCourse->find('first', $options);
        }
        
        		$orders = $this->OrderCourse->Order->find('list');
		$courses = $this->OrderCourse->Course->find('list');
		$cities = $this->OrderCourse->Citie->find('list');
		$states = $this->OrderCourse->State->find('list');
		$this->set(compact('orders', 'courses', 'cities', 'states'));
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
        $this->OrderCourse->id = $id;
        if (!$this->OrderCourse->exists()) {
            throw new NotFoundException(__('Invalid order course'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->OrderCourse->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
