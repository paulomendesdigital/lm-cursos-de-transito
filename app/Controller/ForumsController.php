<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Forums Controller
 *
 * @property Forum $Forum
 * @property PaginatorComponent $Paginator
 */
class ForumsController extends AppController {

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
                    'Forum.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Forum.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Forum.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Forum->recursive = 0;
        $this->set('forums', $this->Paginator->paginate());
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
        if (!$this->Forum->exists($id)) {
            throw new NotFoundException(__('Invalid forum'));
        }
        $options = array('conditions' => array('Forum.' . $this->Forum->primaryKey => $id));
        $this->set('forum', $this->Forum->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->Forum->create();
            if ($this->Forum->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$courses = $this->Forum->Course->find('list');
		$cities = $this->Forum->Citie->find('list');
		$states = $this->Forum->State->find('list');
		$users = $this->Forum->User->find('list');
		$this->set(compact('courses', 'cities', 'states', 'users'));
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
        if (!$this->Forum->exists($id)) {
            throw new NotFoundException(__('Invalid forum'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Forum->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('Forum.' . $this->Forum->primaryKey => $id));
            $this->request->data = $this->Forum->find('first', $options);
        }
        
        		$courses = $this->Forum->Course->find('list');
		$cities = $this->Forum->Citie->find('list');
		$states = $this->Forum->State->find('list');
		$users = $this->Forum->User->find('list');
		$this->set(compact('courses', 'cities', 'states', 'users'));
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
        $this->Forum->id = $id;
        if (!$this->Forum->exists()) {
            throw new NotFoundException(__('Invalid forum'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Forum->delete()) {
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
                    'Forum.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Forum.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Forum.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Forum->recursive = 0;
        $this->set('forums', $this->Paginator->paginate());
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
        if (!$this->Forum->exists($id)) {
            throw new NotFoundException(__('Invalid forum'));
        }
        $options = array('conditions' => array('Forum.' . $this->Forum->primaryKey => $id));
        $this->Forum->Behaviors->load('Containable');
        $this->Forum->contain([
                'Course',
                'Citie',
                'State',
                'User',
                'ForumPost' => ['User' => ['fields' => ['name']]],
        ]);
        $this->set('forum', $this->Forum->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->Forum->create();
            if ($this->Forum->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$courses = $this->Forum->Course->find('list');
		$states = $this->Forum->State->find('list');
		$users = $this->Forum->User->find('list');
		$this->set(compact('courses', 'states', 'users'));
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
        if (!$this->Forum->exists($id)) {
            throw new NotFoundException(__('Invalid forum'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Forum->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('Forum.' . $this->Forum->primaryKey => $id));
            $this->request->data = $this->Forum->find('first', $options);
        }
        
        		$courses = $this->Forum->Course->find('list');
		$states = $this->Forum->State->find('list');
		$users = $this->Forum->User->find('list');
		$this->set(compact('courses', 'states', 'users'));
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
        $this->Forum->id = $id;
        if (!$this->Forum->exists()) {
            throw new NotFoundException(__('Invalid forum'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Forum->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
