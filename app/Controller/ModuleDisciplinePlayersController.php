<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleDisciplinePlayers Controller
 *
 * @property ModuleDisciplinePlayer $ModuleDisciplinePlayer
 * @property PaginatorComponent $Paginator
 */
class ModuleDisciplinePlayersController extends AppController {

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
                    'ModuleDisciplinePlayer.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ModuleDisciplinePlayer.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'ModuleDisciplinePlayer.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->ModuleDisciplinePlayer->recursive = 0;
        $this->set('moduleDisciplinePlayers', $this->Paginator->paginate());
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
        if (!$this->ModuleDisciplinePlayer->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline player'));
        }
        $options = array('conditions' => array('ModuleDisciplinePlayer.' . $this->ModuleDisciplinePlayer->primaryKey => $id));
        $this->set('moduleDisciplinePlayer', $this->ModuleDisciplinePlayer->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->ModuleDisciplinePlayer->create();
            if ($this->ModuleDisciplinePlayer->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$moduleDisciplines = $this->ModuleDisciplinePlayer->ModuleDiscipline->find('list');
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
        if (!$this->ModuleDisciplinePlayer->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline player'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->ModuleDisciplinePlayer->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('ModuleDisciplinePlayer.' . $this->ModuleDisciplinePlayer->primaryKey => $id));
            $this->request->data = $this->ModuleDisciplinePlayer->find('first', $options);
        }
        
        		$moduleDisciplines = $this->ModuleDisciplinePlayer->ModuleDiscipline->find('list');
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
        $this->ModuleDisciplinePlayer->id = $id;
        if (!$this->ModuleDisciplinePlayer->exists()) {
            throw new NotFoundException(__('Invalid module discipline player'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ModuleDisciplinePlayer->delete()) {
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
                    'ModuleDisciplinePlayer.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ModuleDisciplinePlayer.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'ModuleDisciplinePlayer.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->ModuleDisciplinePlayer->recursive = 0;
        $this->set('moduleDisciplinePlayers', $this->Paginator->paginate());
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
        if (!$this->ModuleDisciplinePlayer->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline player'));
        }
        $options = array('conditions' => array('ModuleDisciplinePlayer.' . $this->ModuleDisciplinePlayer->primaryKey => $id));
        $this->set('moduleDisciplinePlayer', $this->ModuleDisciplinePlayer->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add($module_discipline_id=false) {
        if ($this->request->is('post')) {
            $this->ModuleDisciplinePlayer->create();
            if ($this->ModuleDisciplinePlayer->save($this->request->data)) {
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
            $this->request->data['ModuleDisciplinePlayer']['module_discipline_id'] = $module_discipline_id;
            $this->Session->write('manualRedirect', $this->referer());
        }
        $moduleDisciplines = $this->ModuleDisciplinePlayer->ModuleDiscipline->find('list');
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
        if (!$this->ModuleDisciplinePlayer->exists($id)) {
            throw new NotFoundException(__('Invalid module discipline player'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->ModuleDisciplinePlayer->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('ModuleDisciplinePlayer.' . $this->ModuleDisciplinePlayer->primaryKey => $id));
            $this->request->data = $this->ModuleDisciplinePlayer->find('first', $options);
        }
        
        		$moduleDisciplines = $this->ModuleDisciplinePlayer->ModuleDiscipline->find('list');
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
        $this->ModuleDisciplinePlayer->id = $id;
        if (!$this->ModuleDisciplinePlayer->exists()) {
            throw new NotFoundException(__('Invalid module discipline player'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ModuleDisciplinePlayer->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
