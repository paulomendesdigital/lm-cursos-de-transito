<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseTypes Controller
 *
 * @property CourseType $CourseType
 * @property PaginatorComponent $Paginator
 */
class CourseTypesController extends AppController {

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
                'filter1' => array(
                    'CourseType.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'CourseType.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'CourseType.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->CourseType->recursive = 0;
        $this->CourseType->Behaviors->load('Containable');
        $this->CourseType->contain(['Module','CourseState'=>['CourseCity']]);
        
        $courseTypes = $this->Paginator->paginate();
        $listScopes = $this->CourseType->__listScopes();

        $this->set(compact('courseTypes','listScopes'));
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_view($id = null){
        if (!$this->CourseType->exists($id)) {
            throw new NotFoundException(__('Invalid course type'));
        }
        $options = array('conditions' => array('CourseType.' . $this->CourseType->primaryKey => $id));
        $this->set('courseType', $this->CourseType->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    public function manager_add(){
        if ($this->request->is('post')) {
            $this->CourseType->create();
            if ($this->CourseType->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        $scopes = $this->CourseType->__listScopes();
        $this->set(compact('scopes'));
    }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_edit($id = null) {
        if (!$this->CourseType->exists($id)) {
            throw new NotFoundException(__('Invalid course type'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->CourseType->saveAll($this->request->data,['deep'=>true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $this->CourseType->Behaviors->load('Containable');
            $options = array('conditions' => array('CourseType.' . $this->CourseType->primaryKey => $id));
            $this->CourseType->contain(['Module','CourseState'=>['CourseCity']]);
            $this->request->data = $this->CourseType->find('first', $options);
        }
        $scopes = $this->CourseType->__listScopes();
        $this->set(compact('scopes'));
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_delete($id = null) {
        $this->CourseType->id = $id;
        if (!$this->CourseType->exists()) {
            throw new NotFoundException(__('Invalid course type'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->CourseType->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', 'manager' => true));
    }
}
