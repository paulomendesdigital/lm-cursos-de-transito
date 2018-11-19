<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018/2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseStates Controller
 *
 * @property CourseState $CourseState
 * @property PaginatorComponent $Paginator
 */
class CourseStatesController extends AppController {

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
    public function manager_index($course_type_id=null){

        if( !$course_type_id ){
            $this->Session->setFlash(__('Tipo de curso não localizado!'), 'manager/error');
            return $this->redirect( array('controller'=>'course_types','action'=>'index') );
        }

        $this->Filter->addFilters(
            array(
                'filterId' => array(
                    'CourseState.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterCourseType' => array(
                    'CourseState.status' => array(
                        'select' => ['' => 'Tipo de Curso'] + $this->CourseState->CourseType->find('list')
                    )
                ),
                'filterState' => array(
                    'CourseState.state_id' => array(
                        'select' => ['' => 'Estado'] + $this->CourseState->State->find('list')
                    )
                ),
                'filterStatus' => array(
                    'CourseState.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'CourseState.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        $conditions['CourseState.course_type_id'] = $course_type_id;

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());
        }

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        //$this->CourseState->recursive = -1;
        $this->CourseState->Behaviors->load('Containable');
        $this->CourseState->contain('CourseType','State');
        $courseStates = $this->Paginator->paginate();
        $this->set(compact('courseStates','course_type_id'));
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_view($id = null){
        if (!$this->CourseState->exists($id)) {
            throw new NotFoundException(__('Invalid course type'));
        }
        $options = array('conditions' => array('CourseState.' . $this->CourseState->primaryKey => $id));
        $this->CourseState->Behaviors->load('Containable');
        $this->CourseState->contain([
            'State',
            'CourseCity'=>['City'],
            'CourseType'
        ]);
        $courseState = $this->CourseState->find('first', $options);
        $schools = [];
        if( $courseState['CourseState']['order_in_school'] == 1 ){
            $this->loadModel('School');
            $schools = $this->School->find('all',['conditions'=>['School.state_id'=>$courseState['State']['id']]]);
        }

        $this->set(compact('courseState','schools'));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    public function manager_add($course_type_id=null){

        if( !$course_type_id ){
            $this->Session->setFlash(__('Tipo de curso não localizado!'), 'manager/error');
            return $this->redirect( array('controller'=>'course_types','action'=>'index') );
        }

        if ($this->request->is('post')) {

            $this->request->data = $this->CourseState->dataProcessing($this->request->data);
            $this->CourseState->create();
            if ($this->CourseState->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action'=>'index', $course_type_id,'manager'=>true));
            } else {
                $this->Session->setFlash($this->__showErrors( $this->CourseState->validationErrors ), 'manager/error');
            }
        }

        $states = $this->CourseState->State->find('list', [
            'fields'=>['id','name'],
            'conditions'=>[
                'NOT'=>[
                    'State.id'=>$this->CourseState->find('list',[
                        'fields'=>['state_id'],
                        'conditions'=>['CourseState.course_type_id'=>$course_type_id]
                    ])
                ]
            ],
            'order'=>['State.name']
        ]);

        $this->set(compact('states','course_type_id'));
    }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_edit($id = null) {
        if (!$this->CourseState->exists($id)) {
            throw new NotFoundException(__('Invalid course type'));
        }
        
        if ($this->request->is(array('post', 'put'))) {

            $this->request->data = $this->CourseState->dataProcessing($this->request->data);

            if ( $this->CourseState->saveAll($this->request->data,['deep'=>true]) ) {

                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action'=>'index', $this->request->data['CourseState']['course_type_id'], 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $this->CourseState->Behaviors->load('Containable');
            $options = array('conditions' => array('CourseState.' . $this->CourseState->primaryKey => $id));
            $this->CourseState->contain(['CourseType', 'CourseCity'=>['City']]);
            $this->request->data = $this->CourseState->find('first', $options);
        }

        $course_type_id = $this->request->data['CourseState']['course_type_id'];
        $states = $this->CourseState->State->find('list');

        $cities = $this->CourseState->State->City->find('all', [
            'recursive'=>-1,
            'conditions'=>[
                'City.state_id'=>$this->request->data['CourseState']['state_id'], 
                'City.name <>'=>'Todas as Cidades',
                'NOT'=>[
                    'City.id'=>$this->CourseState->CourseCity->find('list',['fields'=>['city_id']],['conditions'=>['CourseCity.course_state_id'=>$id]])
                ]
            ],
            'order'=>['City.name']
        ]);

        $state_id = $this->request->data['CourseState']['state_id'];
        $newCities = array_chunk($cities,200);
        $this->set(compact('states','course_type_id','newCities', 'state_id'));
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_delete($id = null) {
        $this->CourseState->id = $id;
        if (!$this->CourseState->exists()) {
            throw new NotFoundException(__('Invalid course type'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->CourseState->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', 'manager' => true));
    }

    public function ajax_getCitiesForCompose($state_id, $course_id, $module_id){
        $this->autorender = false;
        $this->layout = false;
        $this->CourseState->Behaviors->load('Containable');
        $courseState = $this->CourseState->find('first', [
            'contain'=>['CourseCity'=>['City']],
            'conditions'=>['CourseState.state_id'=>$state_id]
        ]);
        $this->loadModel('ModuleCourse');
        $module_courses = $this->ModuleCourse->find('list',[
            'fields'=>['citie_id'],
            'conditions'=>[
                'ModuleCourse.course_id'=>$course_id,
                'ModuleCourse.state_id'=>$state_id,
                'ModuleCourse.module_id'=>$module_id
            ]]);

        $this->set(compact('courseState','module_courses', 'state_id', 'course_id', 'module_id'));
        $this->render('/Elements/manager/cities_for_compose');
    }

    public function ajax_getCitiesForReport($course_id, $state_id){
        $this->autorender = false;
        $this->layout = false;

        $this->loadModel('Course');
        $course = $this->Course->find('first', ['fields' => ['id', 'course_type_id'], 'conditions' => ['Course.id' => $course_id]]);

        $this->CourseState->Behaviors->load('Containable');
        $courseState = $this->CourseState->find('first', [
            'contain'=>['CourseCity'=>['City']],
            'conditions'=>['CourseState.state_id'=>$state_id, 'CourseState.course_type_id' => $course['Course']['course_type_id']]
        ]);

        $this->set(compact('courseState'));
        $this->render('/Elements/manager/cities_for_report');
    }
}
