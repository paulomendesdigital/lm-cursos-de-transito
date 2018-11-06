<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * QuestionAlternatives Controller
 *
 * @property QuestionAlternative $QuestionAlternative
 * @property PaginatorComponent $Paginator
 */
class QuestionAlternativesController extends AppController {

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

    public function manager_index($module_id=null){

        $conditions = $course_type_id = $module = null; 

        if( isset($this->request->data['filter']['filterModule']) and !empty($this->request->data['filter']['filterModule']) ){
            $module_id = $this->request->data['filter']['filterModule'];
        }

        if( $module_id ){
            $module = $this->QuestionAlternative->Module->__getModule($module_id);
            $course_type_id = $module['CourseType']['id'];
        }

        $this->Filter->addFilters(
            array(
                'filterId' => array(
                    'QuestionAlternative.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterText' => array(
                    'QuestionAlternative.text' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterModule' => array(
                    'QuestionAlternative.module_id' => array(
                        'select' => ['' => 'Módulos'] + $this->QuestionAlternative->Module->__getListWithTypeCourse( $course_type_id )
                    )
                ),
                'filterStatus' => array(
                    'QuestionAlternative.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $conditions['QuestionAlternative.id >'] = 0;

        if( $module_id ){
            $conditions['QuestionAlternative.module_id'] = $module_id;
        }

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());
        }

        $this->Filter->setPaginate('order', 'QuestionAlternative.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        $this->QuestionAlternative->recursive = 0;
        $this->QuestionAlternative->Behaviors->load('Containable');
        $this->Filter->setPaginate('contain', ['Module'=>'CourseType']);
        $questionAlternatives = $this->Paginator->paginate();

        $this->set(compact('questionAlternatives', 'module_id', 'module'));

        $this->request->data['filter']['filterModule'] = $module_id;
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
        if (!$this->QuestionAlternative->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative'));
        }
        $options = array('conditions' => array('QuestionAlternative.' . $this->QuestionAlternative->primaryKey => $id));
        $this->QuestionAlternative->Behaviors->load('Containable');
        $this->QuestionAlternative->contain([
                'Module',
                'QuestionAlternativeOption'
        ]);
        $this->set('questionAlternative', $this->QuestionAlternative->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add($module_id=null) {
        $module = $course_type_id = null;

        if ( $this->request->is('post') ) {

            if( isset($this->request->data['QuestionAlternativeOption']) ){

                if( is_array($this->request->data['QuestionAlternative']['module_id']) ) {
                    $modules = $this->request->data['QuestionAlternative']['module_id'];
                    foreach ( $modules as $module) {
                        $this->request->data['QuestionAlternative']['module_id'] = $module;
                        $this->QuestionAlternative->create();
                        $this->QuestionAlternative->saveAll($this->request->data);
                    }
                    return $this->redirect(array('action'=>'index', $module_id,'manager'=>true));
                }else{
                    $module_id = $this->request->data['QuestionAlternative']['module_id'];
                    $this->QuestionAlternative->create();
                    if ($this->QuestionAlternative->saveAll($this->request->data)) {
                        
                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if( isset($this->request->data['aplicar']) ){
                            return $this->redirect(array('action'=>'add', $module_id));
                        }
                        if( !empty($this->request->data['QuestionAlternative']['urlReturn']) ){
                            return $this->redirect($this->request->data['QuestionAlternative']['urlReturn']);
                        }
                        return $this->redirect(array('action'=>'index', $module_id,'manager'=>true));
                    } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                    }
                }
            }else{
                $this->Session->setFlash(__('Não é permitido criar uma questão sem opções de resposta.'), 'manager/error');
            }
        }

        $this->request->data['QuestionAlternative']['status'] = 1;
        $this->request->data['QuestionAlternative']['module_id'] = $module_id;

        if( $module_id ){
            $module = $this->QuestionAlternative->Module->__getModule($module_id);
            $course_type_id = $module['CourseType']['id'];
        }

        $modules = $this->QuestionAlternative->Module->__getListWithTypeCourse($course_type_id);
        $urlReturn = $this->referer();
        $this->set(compact('modules', 'urlReturn', 'module', 'module_id'));
    }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_edit($id = null) {

        $course_type_id = $module = $module_id = null;

        if (!$this->QuestionAlternative->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative'));
        }
        
        if ($this->request->is(array('post', 'put'))) {

            $module_id = $this->request->data['QuestionAlternative']['module_id'];

            if ($this->QuestionAlternative->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', $module_id, 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('QuestionAlternative.' . $this->QuestionAlternative->primaryKey => $id));
            $this->request->data = $this->QuestionAlternative->find('first', $options);
        }

        if( $this->request->data['QuestionAlternative']['module_id'] ){
            $module_id = $this->request->data['QuestionAlternative']['module_id'];

            $module = $this->QuestionAlternative->Module->__getModule($module_id);
            $course_type_id = $module['CourseType']['id'];
        }

        $modules = $this->QuestionAlternative->Module->__getListWithTypeCourse( $course_type_id );
        $this->set(compact('modules', 'module', 'module_id'));
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_delete($id = null){
        $this->QuestionAlternative->id = $id;
        if (!$this->QuestionAlternative->exists()) {
            throw new NotFoundException(__('Invalid question alternative'));
        }

        $this->QuestionAlternative->recursive = -1;
        $questionAlternative = $this->QuestionAlternative->findById($id);
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->QuestionAlternative->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', $questionAlternative['QuestionAlternative']['module_id'], 'manager' => true));
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
                    'QuestionAlternative.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'QuestionAlternative.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'QuestionAlternative.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->QuestionAlternative->recursive = 0;
        $this->set('questionAlternatives', $this->Paginator->paginate());
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
        if (!$this->QuestionAlternative->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative'));
        }
        $options = array('conditions' => array('QuestionAlternative.' . $this->QuestionAlternative->primaryKey => $id));
        $this->set('questionAlternative', $this->QuestionAlternative->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->QuestionAlternative->create();
            if ($this->QuestionAlternative->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$modules = $this->QuestionAlternative->Module->find('list');
		$this->set(compact('modules'));
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
        if (!$this->QuestionAlternative->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->QuestionAlternative->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('QuestionAlternative.' . $this->QuestionAlternative->primaryKey => $id));
            $this->request->data = $this->QuestionAlternative->find('first', $options);
        }
        
        		$modules = $this->QuestionAlternative->Module->find('list');
		$this->set(compact('modules'));
    }
        
}
