<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserModuleSummaries Controller
 *
 * @property UserModuleSummary $UserModuleSummary
 * @property PaginatorComponent $Paginator
 */
class UserModuleSummariesController extends AppController {

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
                    'UserModuleSummary.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'UserModuleSummary.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'UserModuleSummary.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->UserModuleSummary->recursive = 0;
        $this->set('userModuleSummaries', $this->Paginator->paginate());
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
        if (!$this->UserModuleSummary->exists($id)) {
            throw new NotFoundException(__('Invalid user module summary'));
        }
        $options = array('conditions' => array('UserModuleSummary.' . $this->UserModuleSummary->primaryKey => $id));
        $this->set('userModuleSummary', $this->UserModuleSummary->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->UserModuleSummary->create();
            if ($this->UserModuleSummary->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$users = $this->UserModuleSummary->User->find('list');
		$modules = $this->UserModuleSummary->Module->find('list');
		$moduleDisciplines = $this->UserModuleSummary->ModuleDiscipline->find('list');
		$this->set(compact('users', 'modules', 'moduleDisciplines'));
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
        if (!$this->UserModuleSummary->exists($id)) {
            throw new NotFoundException(__('Invalid user module summary'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->UserModuleSummary->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('UserModuleSummary.' . $this->UserModuleSummary->primaryKey => $id));
            $this->request->data = $this->UserModuleSummary->find('first', $options);
        }
        
        		$users = $this->UserModuleSummary->User->find('list');
		$modules = $this->UserModuleSummary->Module->find('list');
		$moduleDisciplines = $this->UserModuleSummary->ModuleDiscipline->find('list');
		$this->set(compact('users', 'modules', 'moduleDisciplines'));
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
        $this->UserModuleSummary->id = $id;
        if (!$this->UserModuleSummary->exists()) {
            throw new NotFoundException(__('Invalid user module summary'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->UserModuleSummary->delete()) {
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
                    'UserModuleSummary.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'UserModuleSummary.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'UserModuleSummary.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->UserModuleSummary->recursive = 0;
        $this->set('userModuleSummaries', $this->Paginator->paginate());
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
        if (!$this->UserModuleSummary->exists($id)) {
            throw new NotFoundException(__('Invalid user module summary'));
        }
        $options = array('conditions' => array('UserModuleSummary.' . $this->UserModuleSummary->primaryKey => $id));
        $this->set('userModuleSummary', $this->UserModuleSummary->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->UserModuleSummary->create();
            if ($this->UserModuleSummary->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$users = $this->UserModuleSummary->User->find('list');
		$modules = $this->UserModuleSummary->Module->find('list');
		$moduleDisciplines = $this->UserModuleSummary->ModuleDiscipline->find('list');
		$this->set(compact('users', 'modules', 'moduleDisciplines'));
    }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_edit($id = null){
        if (!$this->UserModuleSummary->exists($id)) {
            throw new NotFoundException(__('Invalid user module summary'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->UserModuleSummary->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('controller'=>'users','action'=>'view', $this->request->data['UserModuleSummary']['user_id'], 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('UserModuleSummary.' . $this->UserModuleSummary->primaryKey => $id));
            $this->request->data = $this->UserModuleSummary->find('first', $options);
        }
        
		$users = $this->UserModuleSummary->User->find('list');
		$modules = $this->UserModuleSummary->Module->find('list');
		$moduleDisciplines = $this->UserModuleSummary->ModuleDiscipline->find('list');
		$this->set(compact('users', 'modules', 'moduleDisciplines'));
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
        $this->UserModuleSummary->id = $id;
        if (!$this->UserModuleSummary->exists()) {
            throw new NotFoundException(__('Invalid user module summary'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->UserModuleSummary->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
