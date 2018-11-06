<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleCourses Controller
 *
 * @property ModuleCourse $ModuleCourse
 * @property PaginatorComponent $Paginator
 */
class ModuleCoursesController extends AppController {

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
                    'ModuleCourse.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ModuleCourse.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'ModuleCourse.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->ModuleCourse->recursive = 0;
        $this->set('moduleCourses', $this->Paginator->paginate());
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
        if (!$this->ModuleCourse->exists($id)) {
            throw new NotFoundException(__('Invalid module course'));
        }
        $options = array('conditions' => array('ModuleCourse.' . $this->ModuleCourse->primaryKey => $id));
        $this->set('moduleCourse', $this->ModuleCourse->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->ModuleCourse->create();
            if ($this->ModuleCourse->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$modules = $this->ModuleCourse->Module->find('list');
		$courses = $this->ModuleCourse->Course->find('list');
		$cities = $this->ModuleCourse->Citie->find('list');
		$states = $this->ModuleCourse->State->find('list');
		$this->set(compact('modules', 'courses', 'cities', 'states'));
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
        if (!$this->ModuleCourse->exists($id)) {
            throw new NotFoundException(__('Invalid module course'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->ModuleCourse->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('ModuleCourse.' . $this->ModuleCourse->primaryKey => $id));
            $this->request->data = $this->ModuleCourse->find('first', $options);
        }
        
        		$modules = $this->ModuleCourse->Module->find('list');
		$courses = $this->ModuleCourse->Course->find('list');
		$cities = $this->ModuleCourse->Citie->find('list');
		$states = $this->ModuleCourse->State->find('list');
		$this->set(compact('modules', 'courses', 'cities', 'states'));
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
        $this->ModuleCourse->id = $id;
        if (!$this->ModuleCourse->exists()) {
            throw new NotFoundException(__('Invalid module course'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ModuleCourse->delete()) {
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
                    'ModuleCourse.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ModuleCourse.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'ModuleCourse.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->ModuleCourse->recursive = 0;
        $this->set('moduleCourses', $this->Paginator->paginate());
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
        if (!$this->ModuleCourse->exists($id)) {
            throw new NotFoundException(__('Invalid module course'));
        }
        $options = array('conditions' => array('ModuleCourse.' . $this->ModuleCourse->primaryKey => $id));
        $this->set('moduleCourse', $this->ModuleCourse->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add($course_id=null) {
        
        $isAjax = $this->request->is('ajax');

        if( !$course_id ){
            $this->Session->setFlash(__('Id do curso não identificado! Entre na página do curso, clique em editar e inclua o modulo por lá.'), 'manager/error');
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
        
            $this->ModuleCourse->create();
            if ( $this->ModuleCourse->save($this->request->data) ) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                return $this->redirect(array('controller'=>'courses','action'=>'edit', $course_id, 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }

        $this->ModuleCourse->Course->Behaviors->load('Containable');
        $this->ModuleCourse->Course->contain([
                'CourseType'=>['CourseState'=>['State']],
                'ModuleCourse' => ['State', 'Citie'],
        ]);
        $options = array('conditions' => array('Course.id' => $course_id));
        $course = $this->ModuleCourse->Course->find('first', $options);

        $modules = $this->ModuleCourse->Module->__getListWithTypeCourse($course['Course']['course_type_id']);

        //ordena o array de CourseState
        $arrSortState = [];
        foreach ($course['CourseType']['CourseState'] as $courseState) {
            $arrSortState[] = $courseState['State']['name'];
        }
        array_multisort($arrSortState, SORT_ASC, $course['CourseType']['CourseState']);


        $states = $this->CourseType->CourseState->__extractStatesList($course['CourseType']['CourseState']);

		//$modules = $this->ModuleCourse->Module->find('list');
		//$courses = $this->ModuleCourse->Course->find('list');
		$cities = [];//$this->ModuleCourse->Citie->find('list');
		//$states = $this->ModuleCourse->State->find('list');
		$this->set(compact('modules', 'course', 'cities', 'states', 'isAjax'));
    }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_edit($id = null) {
        if (!$this->ModuleCourse->exists($id)) {
            throw new NotFoundException(__('Invalid module course'));
        }

        $course_id = 0;
        
        if ($this->request->is(array('post', 'put'))) {
            $course_id = $this->request->data['ModuleCourse']['course_id'];
            if ($this->ModuleCourse->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                return $this->redirect(array('controller'=>'courses','action'=>'edit', $course_id, 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('ModuleCourse.' . $this->ModuleCourse->primaryKey => $id));
            $this->request->data = $this->ModuleCourse->find('first', $options);
            $course_id = $this->request->data['ModuleCourse']['course_id'];
        }

        $this->ModuleCourse->Course->Behaviors->load('Containable');
        $this->ModuleCourse->Course->contain([
                'CourseType'=>['CourseState'=>['State']],
                'ModuleCourse' => ['State', 'Citie'],
        ]);
        $options = array('conditions' => array('Course.id' => $course_id));
        $course = $this->ModuleCourse->Course->find('first', $options);

        $modules = $this->ModuleCourse->Module->__getListWithTypeCourse($course['Course']['course_type_id']);
        $states = $this->CourseType->CourseState->__extractStatesList($course['CourseType']['CourseState']);

        //$modules = $this->ModuleCourse->Module->find('list');
        //$courses = $this->ModuleCourse->Course->find('list');
        $cities = $this->ModuleCourse->Citie->find('list',['conditions'=>['Citie.state_id'=>$this->request->data['ModuleCourse']['state_id']]]);
        //$states = $this->ModuleCourse->State->find('list');
        $this->set(compact('modules', 'course', 'cities', 'states'));
        
		//$modules = $this->ModuleCourse->Module->find('list');
		//$courses = $this->ModuleCourse->Course->find('list');
		//$cities = $this->ModuleCourse->Citie->find('list');
		//$states = $this->ModuleCourse->State->find('list');
		//$this->set(compact('modules', 'courses', 'cities', 'states'));
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
        $this->ModuleCourse->id = $id;
        if (!$this->ModuleCourse->exists()) {
            throw new NotFoundException(__('Invalid module course'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ModuleCourse->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
