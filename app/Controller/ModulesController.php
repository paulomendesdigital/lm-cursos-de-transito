<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Modules Controller
 *
 * @property Module $Module
 * @property PaginatorComponent $Paginator
 */
class ModulesController extends AppController {

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
                    'Module.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterCourseType' => array(
                    'Module.course_type_id' => array(
                        'select' => ['' => 'Tipos de Curso'] + $this->Module->CourseType->find('list')
                    )
                ),
                'filterStatus' => array(
                    'Module.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Module.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Module->recursive = 0;
        $this->set('modules', $this->Paginator->paginate());
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_view($id = null){
        if (!$this->Module->exists($id)) {
            throw new NotFoundException(__('Invalid module'));
        }
        $options = array('conditions' => array('Module.' . $this->Module->primaryKey => $id));
        $this->Module->Behaviors->load('Containable');
        $this->Module->contain([
                'CourseType',
                'ModuleCourse' => [
                    'Course' => ['fields' => ['name']], 
                    'Citie' => ['fields' => ['name']], 
                    'State' => ['fields' => ['name']]
                ],
                'ExamDisciplineCode',
                'ModuleDiscipline' => ['DisciplineCode'],
                'QuestionAlternative',
        ]);
        $this->set('module', $this->Module->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->Module->create();
            if ($this->Module->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }

        $courseTypes = $this->Module->CourseType->find('list');
        $examDisciplineCodes = $this->Module->ExamDisciplineCode->getDisciplineCodesListByCourseTypeId(null, true);

        $this->set(compact('courseTypes', 'moduleCodes', 'examDisciplineCodes'));
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
        if (!$this->Module->exists($id)) {
            throw new NotFoundException(__('Invalid module'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Module->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('recursive' => 0, 'conditions' => array('Module.' . $this->Module->primaryKey => $id));
            $this->request->data = $this->Module->find('first', $options);
        }

        $courseTypes = $this->Module->CourseType->find('list');
        $examDisciplineCodes = $this->Module->ExamDisciplineCode->getDisciplineCodesListByCourseTypeId(null, true);

        $this->set(compact('courseTypes', 'moduleCodes', 'examDisciplineCodes'));
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
        $this->Module->id = $id;
        if (!$this->Module->exists()) {
            throw new NotFoundException(__('Invalid module'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Module->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
    }

    public function manager_compose($id=null){
        if (!$this->Module->exists($id)) {
            throw new NotFoundException(__('Invalid module'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $module_name = $this->request->data['ModuleCourse']['modulo'];
            $module_id = $this->request->data['ModuleCourse']['module_id'];
            $course_id = $this->request->data['ModuleCourse']['course_id'];
            $state_id = $this->request->data['ModuleCourse']['state_id'];
            unset($this->request->data['ModuleCourse']['modulo']);
            unset($this->request->data['ModuleCourse']['module_id']);
            unset($this->request->data['ModuleCourse']['course_id']);
            unset($this->request->data['ModuleCourse']['state_id']);
            //die(debug($this->request->data));
            $this->Module->ModuleCourse->deleteAll([
                'ModuleCourse.module_id'=>$module_id,
                'ModuleCourse.course_id'=>$course_id,
                'ModuleCourse.state_id'=>$state_id
            ]);

            foreach ($this->request->data['ModuleCourse'] as $key => $ModuleCourse) {
                $this->Module->ModuleCourse->create();
                $ModuleCourse['position'] = $key;
                $this->Module->ModuleCourse->save($ModuleCourse);
            }
            $this->Session->setFlash(__($module_name . ' gravado com sucesso.'), 'manager/success');
            return $this->redirect( ['action'=>'index'] );
        }

        $this->Module->Behaviors->load('Containable');
        $module = $this->Module->find('first', [
            'contain'=>[
                'CourseType'=>[
                    'CourseState'=>['State']
                ],
                'ModuleCourse'=>['State','Citie']
            ],
            'conditions'=>['Module.id' => $id]
        ]);

        $courses = $this->Module->ModuleCourse->Course->__getList( $module['CourseType']['id'] );
        $states = $this->CourseType->CourseState->__extractStatesList($module['CourseType']['CourseState']);
        
        $this->set(compact('module', 'courses', 'states'));
    }

    //usado na tela de listagem de tipos de curso para replicar itens
    public function manager_get_modules($course_type_id=false, $scope=false){

        if ($this->request->is(array('post', 'put'))) {
            
            $this->Module->Behaviors->load('Containable');

            foreach ($this->request->data['Modules'] as $module_id ) {
                $module = $this->Module->find('all', [
                    'contain'=>[
                        'QuestionAlternative'=>[
                            'QuestionAlternativeOption'
                        ],
                        'ModuleDiscipline'=>['ModuleDisciplineSlider']
                    ],
                    'conditions'=>[
                        'Module.id' => $module_id
                    ]
                ]);
                //die(debug($module));
                $this->Module->__replicate_all($course_type_id, $module);
            }
            $this->Session->setFlash(__('Replicação finalizada.'), 'manager/success');
            return $this->redirect(['action'=>'index','manager'=>true]);
        }

        //obter a lista dos estados cadastrados para este tipo de curso
        $this->loadModel('CourseState');
        $states = $this->CourseState->State->find('list', [
            'fields'=>['id','name'],
            'conditions'=>[
                'State.id'=>$this->CourseState->find('list',[
                    'fields'=>['state_id'],
                    'conditions'=>['CourseState.course_type_id'=>$course_type_id]
                ])
            ],
            'order'=>['State.name']
        ]);

        //obter a lista de tipos de cursos para escolher de onde será replicado
        $this->loadModel('CourseType');
        $course_types = $this->CourseType->find('list',[
            'fields'=>['id','name'],
            'conditions'=>['id <>'=>$course_type_id, 'scope'=>$scope]
        ]);
        
        $this->set(compact('course_types', 'states'));
    }

    public function ajax_getModules($course_type_id){
        $this->autorender = false;
        $this->layout = false;
        
        $modules = $this->Module->find('list',[
            'fields'=>['id','name'],
            'conditions'=>[
                'Module.course_type_id'=>$course_type_id
            ],
            'order'=>['Module.id'=>'ASC']
        ]);

        $this->set(compact('modules'));
        $this->render('/Elements/manager/modules');
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
                    'Module.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Module.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Module.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Module->recursive = 0;
        $this->set('modules', $this->Paginator->paginate());
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
        if (!$this->Module->exists($id)) {
            throw new NotFoundException(__('Invalid module'));
        }
        $options = array('conditions' => array('Module.' . $this->Module->primaryKey => $id));
        $this->set('module', $this->Module->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->Module->create();
            if ($this->Module->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$courseTypes = $this->Module->CourseType->find('list');
		$this->set(compact('courseTypes'));
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
        if (!$this->Module->exists($id)) {
            throw new NotFoundException(__('Invalid module'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Module->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('Module.' . $this->Module->primaryKey => $id));
            $this->request->data = $this->Module->find('first', $options);
        }
        
        		$courseTypes = $this->Module->CourseType->find('list');
		$this->set(compact('courseTypes'));
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
        $this->Module->id = $id;
        if (!$this->Module->exists()) {
            throw new NotFoundException(__('Invalid module'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Module->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => false));
                            }
        

}
