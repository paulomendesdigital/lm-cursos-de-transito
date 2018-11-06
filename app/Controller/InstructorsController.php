<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Instructors Controller
 *
 * @property Instructor $Instructor
 * @property PaginatorComponent $Paginator
 */
class InstructorsController extends AppController {

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

    public function index(){
        $this->loadModel('Instructor');
        $instructors = $this->Instructor->find('all',[
            'recursive'=>0,
            'conditions'=>['Instructor.status'=>1]
        ]);
        $count = count($instructors);
        $this->set(compact('instructors','count'));    }

    /**
    * view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */

    public function view($id = null)
    {
        if (!$this->Instructor->exists($id)) {
            throw new NotFoundException(__('Invalid instructor'));
        }
        $options = array('conditions' => array('Instructor.' . $this->Instructor->primaryKey => $id));
        $this->set('instructor', $this->Instructor->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() {
        if ($this->request->is('post')) {
            $this->Instructor->create();
            if ($this->Instructor->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => false));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        $users = $this->Instructor->User->find('list');
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
        if (!$this->Instructor->exists($id)) {
            throw new NotFoundException(__('Invalid instructor'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Instructor->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('Instructor.' . $this->Instructor->primaryKey => $id));
            $this->request->data = $this->Instructor->find('first', $options);
        }
        
        		$users = $this->Instructor->User->find('list');
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
        $this->Instructor->id = $id;
        if (!$this->Instructor->exists()) {
            throw new NotFoundException(__('Invalid instructor'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Instructor->delete()) {
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

    public function manager_index() {

        $this->Filter->addFilters(
             array(
                'filterId' => array(
                    'Instructor.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterName' => array(
                    'Instructor.name' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterStatus' => array(
                    'Instructor.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Instructor.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Instructor->recursive = 0;
        $this->set('instructors', $this->Paginator->paginate());
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
        if (!$this->Instructor->exists($id)) {
            throw new NotFoundException(__('Invalid instructor'));
        }
        $options = array('conditions' => array('Instructor.' . $this->Instructor->primaryKey => $id));
        $this->Instructor->Behaviors->load('Containable');
        $this->Instructor->contain([
                'User',
                'DirectMessage' => ['User' => ['fields' => ['name']]],
        ]);
        $this->set('instructor', $this->Instructor->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() {
        if ($this->request->is('post')) {
            $this->Instructor->create();
            if ($this->Instructor->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        $users = $this->Instructor->User->find('list');
		$this->set(compact('users'));
    }

    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_edit($id = null) {
        if (!$this->Instructor->exists($id)) {
            throw new NotFoundException(__('Invalid instructor'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['User']['name'] = $this->request->data['Instructor']['name'];
            //die(debug($this->request->data));
            if ($this->Instructor->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                //debug($this->Instructor->User->validateErrors);
                //die(debug($this->Instructor->validateErrors));
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('Instructor.' . $this->Instructor->primaryKey => $id));
            $this->request->data = $this->Instructor->find('first', $options);
        }
        $users = $this->Instructor->User->find('list');
		$this->set(compact('users'));
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
        $this->Instructor->id = $id;
        if (!$this->Instructor->exists()) {
            throw new NotFoundException(__('Invalid instructor'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Instructor->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
