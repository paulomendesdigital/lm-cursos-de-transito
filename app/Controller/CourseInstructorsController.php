<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseInstructors Controller
 *
 * @property CourseInstructor $CourseInstructor
 * @property PaginatorComponent $Paginator
 */
class CourseInstructorsController extends AppController {

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
                    'CourseInstructor.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'CourseInstructor.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'CourseInstructor.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->CourseInstructor->recursive = 0;
        $this->set('courseInstructors', $this->Paginator->paginate());
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
        if (!$this->CourseInstructor->exists($id)) {
            throw new NotFoundException(__('Invalid course instructor'));
        }
        $options = array('conditions' => array('CourseInstructor.' . $this->CourseInstructor->primaryKey => $id));
        $this->set('courseInstructor', $this->CourseInstructor->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->CourseInstructor->create();
            if ($this->CourseInstructor->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$courses = $this->CourseInstructor->Course->find('list');
		$instructors = $this->CourseInstructor->Instructor->find('list');
		$this->set(compact('courses', 'instructors'));
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
        if (!$this->CourseInstructor->exists($id)) {
            throw new NotFoundException(__('Invalid course instructor'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->CourseInstructor->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('CourseInstructor.' . $this->CourseInstructor->primaryKey => $id));
            $this->request->data = $this->CourseInstructor->find('first', $options);
        }
        
        		$courses = $this->CourseInstructor->Course->find('list');
		$instructors = $this->CourseInstructor->Instructor->find('list');
		$this->set(compact('courses', 'instructors'));
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
        $this->CourseInstructor->id = $id;
        if (!$this->CourseInstructor->exists()) {
            throw new NotFoundException(__('Invalid course instructor'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->CourseInstructor->delete()) {
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
                    'CourseInstructor.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'CourseInstructor.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'CourseInstructor.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->CourseInstructor->recursive = 0;
        $this->set('courseInstructors', $this->Paginator->paginate());
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
        if (!$this->CourseInstructor->exists($id)) {
            throw new NotFoundException(__('Invalid course instructor'));
        }
        $options = array('conditions' => array('CourseInstructor.' . $this->CourseInstructor->primaryKey => $id));
        $this->set('courseInstructor', $this->CourseInstructor->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->CourseInstructor->create();
            if ($this->CourseInstructor->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$courses = $this->CourseInstructor->Course->find('list');
		$instructors = $this->CourseInstructor->Instructor->find('list');
		$this->set(compact('courses', 'instructors'));
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
        if (!$this->CourseInstructor->exists($id)) {
            throw new NotFoundException(__('Invalid course instructor'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->CourseInstructor->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('CourseInstructor.' . $this->CourseInstructor->primaryKey => $id));
            $this->request->data = $this->CourseInstructor->find('first', $options);
        }
        
        		$courses = $this->CourseInstructor->Course->find('list');
		$instructors = $this->CourseInstructor->Instructor->find('list');
		$this->set(compact('courses', 'instructors'));
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
        $this->CourseInstructor->id = $id;
        if (!$this->CourseInstructor->exists()) {
            throw new NotFoundException(__('Invalid course instructor'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->CourseInstructor->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
