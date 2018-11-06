<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Courses Controller
 *
 * @property Course $Course
 * @property CourseState $CourseState
 * @property PaginatorComponent $Paginator
 */
class CoursesController extends AppController {

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
                    'Course.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Course.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Course.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Course->recursive = 0;
        $this->set('courses', $this->Paginator->paginate());
    }

    /**
    * view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */

    public function view($id = null, $slug = null, $uf = null)
    {
        if (!$this->Course->exists($id)) {
            throw new NotFoundException(__('Invalid course'));
        }

        $this->Course->Behaviors->load('Containable');
        $this->Course->recursive = -1;

        $course_scopes = $this->Course->CourseType->__listScopesByText();

        $course_test = $this->Course->find('first',[
            'fields'=>['Course.course_type_id'],
            'conditions'=>['Course.id' => $id],
            'contain' => [
                'CourseType'=>['fields'=>['CourseType.scope']]
            ]
        ]);

        $this->loadModel('CourseState');
        $this->CourseState->Behaviors->load('Containable');


        $ModuleCourseConditions = [
            'ModuleCourse.module_id' => $this->Course->ModuleCourse->Module->find('list',['fields'=>['Module.id'],'conditions'=>['Module.is_introduction'=>0]]),
        ];

        $currentCourseState = null;
        $orderInSchool      = false;
        $stateActive        = true;
        if ($course_test['CourseType']['scope'] == $course_scopes['Estadual']) {

            if (empty($uf)) {
                $ModuleCourseConditions['ModuleCourse.state_id'] = null;
            } else {
                $arrCourseState = $this->CourseState->find('first', [
                    'contain'    => ['State'],
                    'conditions' => [
                        'CourseState.course_type_id' => $course_test['Course']['course_type_id'],
                        'State.abbreviation'         => strtoupper($uf)
                    ]
                ]);
                if (isset($arrCourseState['State']['name'])) {
                    $currentCourseState = $arrCourseState;
                    $ModuleCourseConditions['ModuleCourse.state_id'] = $currentCourseState['State']['id'];
                }
            }
        } elseif ($course_test['CourseType']['scope'] == $course_scopes['Municipal']) {
            $ModuleCourseConditions['ModuleCourse.state_id'] = null;
            $ModuleCourseConditions['ModuleCourse.citie_id'] = null;
        }

        $course = $this->Course->find('first', [
            'conditions' => ['Course.' . $this->Course->primaryKey => $id,'Course.status'=>1],
            'contain'=>[
                'CourseType',
                'ModuleCourse' => [
                    'conditions' => $ModuleCourseConditions,
                    'order'=>['ModuleCourse.position ASC'],
                    'Module' => [
                        'conditions'=>['Module.is_introduction'=>0]
                    ]
                ]
            ]
        ]);

        if ($currentCourseState) {
            $course['Course']['name'] .= ' ' . $this->getPreposicaoUF($currentCourseState['State']['abbreviation']) . ' ' . $currentCourseState['State']['name'];
            $course['Course']['promotional_price'] = $currentCourseState['CourseState']['price'];

            $orderInSchool = $currentCourseState['CourseState']['order_in_school'];
            $stateActive   = $currentCourseState['CourseState']['status'];
        }

        $recycle = $course['CourseType']['id'] == $this->Course->CourseType->__getReciclagemId() ? true : false;
        $especializado = $course['CourseType']['id'] == $this->Course->CourseType->__getEspecializadosId() ? true : false;

        //estados
        $arrStatesEnabled = $this->CourseState->find('list', [
            'fields' => ['State.id', 'State.id'],
            'contain'    => ['State'],
            'conditions' => [
                'CourseState.course_type_id' => $course['Course']['course_type_id'],
                'CourseState.status'         => 1
            ]
        ]);

        $arrStatesModuleEnabled = $this->Course->ModuleCourse->find('list',[
            'fields'=>['ModuleCourse.state_id'],
            'conditions'=> ['ModuleCourse.course_id'=>$course['Course']['id']]
        ]);
        $arrStatesEnabled = array_intersect($arrStatesEnabled, $arrStatesModuleEnabled);

        $this->loadModel('State');
        $statesResult = $this->State->find('all',[
            'conditions'=>[
                'State.id' => $arrStatesEnabled,
            ]
        ]);

        $states             = [];
        $statesAbbreviation = [];
        $statesOrder        = [];
        foreach ($statesResult as $val) {
            $states[$val['State']['id']]                       = $val['State']['name'];
            $statesOrder[$val['State']['id']]                  = $val['State']['id'] == 19 ? '     ' : $val['State']['name']; //rio de janeiro primeiro
            $statesAbbreviation[$val['State']['abbreviation']] = $val['State']['name'];
        }

        $keysStates = array_keys($states);
        array_multisort($statesOrder, SORT_ASC, $states, $keysStates, $statesAbbreviation);
        $states = array_combine($keysStates, $states);

        //view
        $this->set('course', $course);
        $this->set('recycle',$recycle);
        $this->set('especializado', $especializado);
        $this->set('cnh_categories', $this->getCnhCategoriesList());
        $this->set('currentCourseState', $currentCourseState);
        $this->set('stateActive', $stateActive);
        $this->set('states',$states);
        $this->set('statesAbbreviation',$statesAbbreviation);
        $this->set('course_scopes',$course_scopes);
        $this->set('state_id', $currentCourseState ? $currentCourseState['State']['id'] : null);
        $this->set('city_id', null);
        $this->set('user', $this->Auth->user());
        $this->set('order_in_school', $orderInSchool);
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->Course->create();
            if ($this->Course->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$courseTypes = $this->Course->CourseType->find('list');
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
        if (!$this->Course->exists($id)) {
            throw new NotFoundException(__('Invalid course'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Course->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('Course.' . $this->Course->primaryKey => $id));
            $this->request->data = $this->Course->find('first', $options);
        }
        
        		$courseTypes = $this->Course->CourseType->find('list');
		$this->set(compact('courseTypes'));
    }

    /**
    * delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function delete($id = null){
        $this->Course->id = $id;
        if (!$this->Course->exists()) {
            throw new NotFoundException(__('Invalid course'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Course->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => false));
                            }
        
    public function ajax_getModuleCourseOptions($course_id,$state_id){
        $this->layout = 'ajax'; 
        $this->autoRender = false;       
        $this->loadModel('City');
        $cities = $this->City->find('list',[
            'conditions'=>[
                'City.id' => $this->Course->ModuleCourse->find('list',[
                    'fields'=>['ModuleCourse.citie_id'],
                    'conditions'=>[
                        'ModuleCourse.course_id' => $course_id,
                        'ModuleCourse.state_id' => $state_id
                    ]
                ])
            ]
        ]);        
        
        $options = '<option value="">Selecione o município</option>';
        foreach($cities as $city_id => $city_name){
            $options .= '<option value="'.$city_id.'">'.$city_name.'</option>';
        }        
        return $options;
    
    }

    public function ajax_getModuleCourseTable($course_id,$state_id,$city_id = null){
        $this->layout = 'ajax'; 
        $this->autoRender = false;  
        $this->Course->Behaviors->load('Containable');
        $this->Course->recursive = -1;

        $course_scopes = $this->Course->CourseType->__listScopesByText();
        $course_test = $this->Course->find('first',[
            'fields'=>['Course.course_type_id'],
            'conditions'=>['Course.id'=>$course_id],  
            'contain' => [
                'CourseType'=>['fields'=>['CourseType.scope']]
            ]
        ]);        
        
        $ModuleCourseConditions = [
            'ModuleCourse.module_id' => $this->Course->ModuleCourse->Module->find('list',['fields'=>['Module.id'],'conditions'=>['Module.is_introduction'=>0]]),            
            
        ];

        switch ($course_test['CourseType']['scope']){
            case $course_scopes['Municipal']:
                $ModuleCourseConditions['ModuleCourse.citie_id'] = $city_id;
                break;
            case $course_scopes['Estadual']:
                $ModuleCourseConditions['ModuleCourse.state_id'] = $state_id;
                break;
        }

        $options = array(
            'fields'=>['Course.id','Course.course_type_id'],
            'conditions' => array('Course.' . $this->Course->primaryKey => $course_id,'Course.status'=>1),
            'contain'=>[
                'ModuleCourse' => [
                    //'order' => ['ModuleCourse.position ASC'],
                    'conditions' => $ModuleCourseConditions,
                    'order'=>['ModuleCourse.position ASC'],
                    'Module' => [
                        'conditions'=>['Module.is_introduction'=>0]
                    ]
                ],
                'CourseType' => [
                    'fields' => ['scope']
                ]
            ]
        );        
        $course = $this->Course->find('first', $options);
        $this->set('course', $course);

        $this->set('stateActive', 1);
        $this->set('order_in_school', 0);

        switch ($course['CourseType']['scope']){
            case $course_scopes['Municipal']:
                $this->loadModel('CourseState');
                $course_state = $this->CourseState->CourseCity->find('first',[
                    'conditions'=>[
                        'CourseCity.city_id' => $city_id,
                        'CourseCity.course_state_id' => $this->CourseState->find('list',[
                            'fields'=>['CourseState.id'],
                            'conditions' => [
                                'CourseState.course_type_id' => $course['Course']['course_type_id']
                            ]
                        ])
                    ]
                ]);
                if( !empty($course_state) ){
                    $this->set('promotional_price',number_format($course_state['CourseCity']['price'],2,',','.'));
                    $this->set('installment_price',number_format($course_state['CourseCity']['price'] / 10,2,',','.'));
                }
                break;
            case $course_scopes['Estadual']:
                $this->loadModel('CourseState');
                $course_state = $this->CourseState->find('first',[
                    'conditions'=>[
                        'CourseState.state_id' => $state_id,
                        'CourseState.course_type_id' => $course['Course']['course_type_id'],
                    ]
                ]);                                
                if( !empty($course_state) ){
                    $this->set('promotional_price',number_format($course_state['CourseState']['price'],2,',','.'));
                    $this->set('installment_price',number_format($course_state['CourseState']['price'] / 10,2,',','.'));
                    $this->set('order_in_school', $course_state['CourseState']['order_in_school']);
                    $this->set('stateActive', $course_state['CourseState']['status']);
                }
                break;
        }

        $recycle       = $course['CourseType']['id'] == $this->Course->CourseType->__getReciclagemId() ? true : false;
        $especializado = $course['CourseType']['id'] == $this->Course->CourseType->__getEspecializadosId() ? true : false;

        $this->set('cnh_categories', $this->getCnhCategoriesList());
        $this->set('recycle', $recycle);
        $this->set('especializado', $especializado);
        $this->set('state_id', $state_id);
        $this->set('city_id', $city_id);
        $this->set('user', $this->Auth->user());

        $this->render('/Elements/site/course-modules-table');
    }

    public function ajax_getModuleCourseTableDefault($course_id){
        $this->layout = 'ajax'; 
        $this->autoRender = false;  
        /*$this->Course->Behaviors->load('Containable');
        $this->Course->recursive = -1;
        $options = array(
            'conditions' => array('Course.' . $this->Course->primaryKey => $course_id,'Course.status'=>1),
            'contain'=>[
                'ModuleCourse' => [
                    'conditions' => [
                        'ModuleCourse.module_id' => $this->Course->ModuleCourse->Module->find('list',['fields'=>['Module.id'],'conditions'=>['Module.is_default'=>1,'Module.is_introduction'=>0]])
                    ],
                    'Module' => [
                        'conditions'=>['Module.is_default'=>1,'Module.is_introduction'=>0]
                    ]
                ]
            ]
        );*/
        $course = false;//$this->Course->find('first', $options);
        $this->set('course', $course);
        $this->render('/Elements/site/course-modules-table');
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
                    'Course.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Course.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Course.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Course->recursive = 0;
        $this->set('courses', $this->Paginator->paginate());
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
        if (!$this->Course->exists($id)) {
            throw new NotFoundException(__('Invalid course'));
        }
        $options = array('conditions' => array('Course.' . $this->Course->primaryKey => $id));
        $this->Course->Behaviors->load('Containable');
        $this->Course->contain([
                'CourseType',
                'CourseInstructor' => ['Instructor' => ['fields' => ['name']]],
                'Forum' => ['Citie' => ['fields' => ['name']], 'State' => ['fields' => ['name']], 'User' => ['fields' => ['name']]],
                'ModuleCourse' => ['Module' => ['fields' => ['name']], 'Citie' => ['fields' => ['name']], 'State' => ['fields' => ['name']]],
                'CourseCode'
        ]);
        $this->set('course', $this->Course->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->Course->create();
            if ($this->Course->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        $instructors = $this->Course->Instructor->find('list', ['order' => ['Instructor.name' => 'ASC']]);
        $courseTypes = $this->Course->CourseType->find('list', ['order' => ['CourseType.name' => 'ASC']]);
        $modules = $this->Course->ModuleCourse->Module->find('list', ['order' => ['Module.name' => 'ASC']]);
        $courseCodes = $this->Course->CourseCode->find('list', ['fields' => ['CourseCode.code_name']]);
        $this->set(compact('courseTypes', 'instructors', 'modules', 'courseCodes'));
    }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_edit($id = null) {
        if (!$this->Course->exists($id)) {
            throw new NotFoundException(__('Invalid course'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Course->saveAll($this->request->data, ['deep' => true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $this->Course->Behaviors->load('Containable');
            $this->Course->contain([
                    'CourseType' => ['CourseState' => ['State']],
                    'CourseInstructor',
                    'CourseLibrary',
                    'CourseWorkbook',
                    'CourseMultimidia',
                    'Instructor',
                    'ModuleCourse' => ['State', 'Citie'],
            ]);
            $options = array('conditions' => array('Course.' . $this->Course->primaryKey => $id));
            $this->request->data = $this->Course->find('first', $options);
        }
        
        $instructors = $this->Course->Instructor->find('list', ['order' => ['Instructor.name' => 'ASC']]);
        $courseTypes = $this->Course->CourseType->find('list', ['order' => ['CourseType.name' => 'ASC']]);

        $modules = $this->Course->ModuleCourse->Module->__getListWithTypeCourse($this->request->data['Course']['course_type_id']);

        $courseType   = $this->request->data['CourseType'];
        $courseStates = $courseType['CourseState'];

        //ordena o array de CourseState
        $arrSortState = [];
        foreach ($courseStates as $courseState) {
            $arrSortState[] = $courseState['State']['name'];
        }
        array_multisort($arrSortState, SORT_ASC, $courseStates);
        $this->request->data['CourseType']['CourseState'] = $courseStates;


        $courseCodes = $this->Course->CourseCode->find('list', ['fields' => ['CourseCode.code_name']]);

        $this->set(compact('courseTypes', 'instructors', 'modules', 'courseCodes', 'courseType', 'courseStates'));
    }

    public function manager_ajaxGetStatesOfCourse($course_id){
        $this->layout = 'ajax'; 
        $this->autoRender = false;  

        $states = $this->Course->getStatesOfCourse($course_id);

        if (!$states) { //corrige o warning quando não tem estados
            $states = [];
        }

        $this->set('states', $states);
        $this->render('/Elements/manager/order_states');
    }

    public function manager_ajaxGetScopeOfCourse($course_id){
        $this->layout = 'ajax'; 
        $this->autoRender = false;  
        $this->Course->Behaviors->load('Containable');
        $this->Course->recursive = -1;
        $options = array(
            'conditions' => array('Course.id' => $course_id),
            'contain'=>[
                'CourseType'
            ]
        );
        $course = $this->Course->find('first', $options);
        echo $this->Course->CourseType->__listScopesForOrder( $course['CourseType']['scope'] );
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
        $this->Course->id = $id;
        if (!$this->Course->exists()) {
            throw new NotFoundException(__('Invalid course'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Course->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
    }

    private function getPreposicaoUF($strUF)
    {
        if (in_array($strUF, ['AL', 'GO', 'MG', 'PE', 'RO', 'RR', 'SC', 'SP', 'SE'])) {
            return 'de';
        } elseif (in_array($strUF, ['BA', 'PB'])) {
            return 'da';
        } else {
            return 'do';
        }
    }

}
