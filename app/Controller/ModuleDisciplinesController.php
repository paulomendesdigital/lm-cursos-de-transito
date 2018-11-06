<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleDisciplines Controller
 *
 * @property ModuleDiscipline $ModuleDiscipline
 * @property PaginatorComponent $Paginator
 */
class ModuleDisciplinesController extends AppController {

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
    public function manager_index($module_id=null) {

        $conditions = $course_type_id = $module = null; 

        if( isset($this->request->data['filter']['filterModule']) and !empty($this->request->data['filter']['filterModule']) ){
            $module_id = $this->request->data['filter']['filterModule'];

            if( isset($this->request->params['pass'][0]) and !empty($this->request->params['pass'][0]) ){
                $this->request->params['pass'][0] = $module_id;
            }
        }

        if( $module_id ){
            $module = $this->ModuleDiscipline->Module->__getModule($module_id);
            $course_type_id = $module['CourseType']['id'];
        }

        $this->Filter->addFilters(
            array(
                'filterId' => array(
                    'ModuleDiscipline.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterModule' => array(
                    'ModuleDiscipline.module_id' => array(
                        'select' => ['' => 'Módulos'] + $this->ModuleDiscipline->Module->__getListWithTypeCourse( $course_type_id )
                    )
                ),
                'filterStatus' => array(
                    'ModuleDiscipline.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $conditions = $this->Filter->getConditions();

        $this->Filter->setPaginate('order', ['ModuleDiscipline.position'=>'ASC','ModuleDiscipline.id'=>'ASC']); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        if( $module_id ){
            if (empty($conditions)) {
                $conditions = [];
            }
            $conditions = \Hash::merge($conditions, ['ModuleDiscipline.module_id'=>$module_id]);
        }

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        $this->ModuleDiscipline->recursive = 0;
        $this->ModuleDiscipline->Behaviors->load('Containable');
        $this->Filter->setPaginate('contain', ['Module'=>'CourseType', 'DisciplineCode']);

        $moduleDisciplines = $this->Paginator->paginate();
        $this->set(compact('moduleDisciplines','module_id'));

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
        if (!$this->ModuleDiscipline->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline'));
        }
        $options = array('conditions' => array('ModuleDiscipline.' . $this->ModuleDiscipline->primaryKey => $id));
        $this->ModuleDiscipline->Behaviors->load('Containable');
        $this->ModuleDiscipline->contain([
                'Module',
                'ModuleDisciplinePlayer',
                'ModuleDisciplineSlider',
        ]);
        $this->set('moduleDiscipline', $this->ModuleDiscipline->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add($module_id=false) {

        $course_type_id = $module = null;

        if ($this->request->is('post')) {
            $module_id = $this->request->data['ModuleDiscipline']['module_id'];

            $this->ModuleDiscipline->create();
            if ($this->ModuleDiscipline->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect(array('action'=>'add', $module_id,'manager'=>true));
                }
                return $this->redirect(array('action' => 'index', $module_id, 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        if( $module_id ){
            $this->request->data['ModuleDiscipline']['module_id'] = $module_id;

            $module = $this->ModuleDiscipline->Module->__getModule($module_id);
            $course_type_id = $module['CourseType']['id'];
        }

		$modules = $this->ModuleDiscipline->Module->__getListWithTypeCourse( $course_type_id );

       $disciplineCodes = $this->ModuleDiscipline->DisciplineCode->getDisciplineCodesListByCourseTypeId($course_type_id);

		$this->set(compact('modules', 'module', 'module_id', 'disciplineCodes'));
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

        if (!$this->ModuleDiscipline->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline'));
        }
        
        if ($this->request->is(array('post', 'put'))) {

            if ($this->ModuleDiscipline->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', $this->request->data['ModuleDiscipline']['module_id'], 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {

            $this->ModuleDiscipline->Behaviors->load('Containable');
            $options = array(
                'contain'=>array(
                    'Module'=>array('CourseType'),
                    'ModuleDisciplinePlayer',
                    'ModuleDisciplineSlider'
                ),
                'conditions' => array('ModuleDiscipline.' . $this->ModuleDiscipline->primaryKey => $id)
            );

            $this->request->data = $this->ModuleDiscipline->find('first', $options);
        }

        //

        if( $this->request->data['ModuleDiscipline']['module_id'] ){
            $module_id = $this->request->data['ModuleDiscipline']['module_id'];

            $module['Module'] = $this->request->data['Module'];
            $course_type_id = $module['Module']['CourseType']['id'];
        }

        $modules = $this->ModuleDiscipline->Module->__getListWithTypeCourse( $course_type_id );
        $disciplineCodes = $this->ModuleDiscipline->DisciplineCode->getDisciplineCodesListByCourseTypeId($course_type_id);
        $this->set(compact('modules', 'module', 'module_id', 'disciplineCodes'));
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
        $this->ModuleDiscipline->id = $id;
        if (!$this->ModuleDiscipline->exists()) {
            throw new NotFoundException(__('Invalid module discipline'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ModuleDiscipline->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
