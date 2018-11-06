<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleDisciplineSliders Controller
 *
 * @property ModuleDisciplineSlider $ModuleDisciplineSlider
 * @property PaginatorComponent $Paginator
 */
class ModuleDisciplineSlidersController extends AppController {

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
                    'ModuleDisciplineSlider.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ModuleDisciplineSlider.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'ModuleDisciplineSlider.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->ModuleDisciplineSlider->recursive = 0;
        $this->set('moduleDisciplineSliders', $this->Paginator->paginate());
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
        if (!$this->ModuleDisciplineSlider->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline slider'));
        }
        $options = array('conditions' => array('ModuleDisciplineSlider.' . $this->ModuleDisciplineSlider->primaryKey => $id));
        $this->set('moduleDisciplineSlider', $this->ModuleDisciplineSlider->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->ModuleDisciplineSlider->create();
            if ($this->ModuleDisciplineSlider->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$moduleDisciplines = $this->ModuleDisciplineSlider->ModuleDiscipline->find('list');
		$this->set(compact('moduleDisciplines'));
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
        if (!$this->ModuleDisciplineSlider->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline slider'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->ModuleDisciplineSlider->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('ModuleDisciplineSlider.' . $this->ModuleDisciplineSlider->primaryKey => $id));
            $this->request->data = $this->ModuleDisciplineSlider->find('first', $options);
        }
        
        		$moduleDisciplines = $this->ModuleDisciplineSlider->ModuleDiscipline->find('list');
		$this->set(compact('moduleDisciplines'));
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
        $this->ModuleDisciplineSlider->id = $id;
        if (!$this->ModuleDisciplineSlider->exists()) {
            throw new NotFoundException(__('Invalid module discipline slider'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ModuleDisciplineSlider->delete()) {
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
                    'ModuleDisciplineSlider.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ModuleDisciplineSlider.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'ModuleDisciplineSlider.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->ModuleDisciplineSlider->recursive = 0;
        $this->set('moduleDisciplineSliders', $this->Paginator->paginate());
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
        if (!$this->ModuleDisciplineSlider->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline slider'));
        }
        $options = array('conditions' => array('ModuleDisciplineSlider.' . $this->ModuleDisciplineSlider->primaryKey => $id));
        $this->set('moduleDisciplineSlider', $this->ModuleDisciplineSlider->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */

    public function manager_add($module_discipline_id=false) 
    {
        if ($this->request->is('post')) {
        
            $this->ModuleDisciplineSlider->create();
            if ($this->ModuleDisciplineSlider->save($this->request->data)) {
            
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                if( $this->Session->read('manualRedirect') ){
                    return $this->redirect( $this->Session->read('manualRedirect') );
                }else{
                    return $this->redirect(array('action' => 'index', 'manager' => true));
                }
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        if( $module_discipline_id ){
            $this->request->data['ModuleDisciplineSlider']['module_discipline_id'] = $module_discipline_id;
            $this->Session->write('manualRedirect', $this->referer());
        }
		$moduleDisciplines = $this->ModuleDisciplineSlider->ModuleDiscipline->find('list');
		$this->set(compact('moduleDisciplines'));
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
        if (!$this->ModuleDisciplineSlider->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline slider'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->ModuleDisciplineSlider->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('ModuleDisciplineSlider.' . $this->ModuleDisciplineSlider->primaryKey => $id));
            $this->request->data = $this->ModuleDisciplineSlider->find('first', $options);
        }
        
        		$moduleDisciplines = $this->ModuleDisciplineSlider->ModuleDiscipline->find('list');
		$this->set(compact('moduleDisciplines'));
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
        $this->ModuleDisciplineSlider->id = $id;
        if (!$this->ModuleDisciplineSlider->exists()) {
            throw new NotFoundException(__('Invalid module discipline slider'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ModuleDisciplineSlider->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
