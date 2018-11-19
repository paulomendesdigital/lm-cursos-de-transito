<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * QuestionAlternativeOptionUsers Controller
 *
 * @property QuestionAlternativeOptionUser $QuestionAlternativeOptionUser
 * @property PaginatorComponent $Paginator
 */
class QuestionAlternativeOptionUsersController extends AppController {

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
                    'QuestionAlternativeOptionUser.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'QuestionAlternativeOptionUser.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'QuestionAlternativeOptionUser.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->QuestionAlternativeOptionUser->recursive = 0;
        $this->set('questionAlternativeOptionUsers', $this->Paginator->paginate());
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
        if (!$this->QuestionAlternativeOptionUser->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative option user'));
        }
        $options = array('conditions' => array('QuestionAlternativeOptionUser.' . $this->QuestionAlternativeOptionUser->primaryKey => $id));
        $this->set('questionAlternativeOptionUser', $this->QuestionAlternativeOptionUser->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->QuestionAlternativeOptionUser->create();
            if ($this->QuestionAlternativeOptionUser->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$users = $this->QuestionAlternativeOptionUser->User->find('list');
		$questionAlternatives = $this->QuestionAlternativeOptionUser->QuestionAlternative->find('list');
		$questionAlternativeOptions = $this->QuestionAlternativeOptionUser->QuestionAlternativeOption->find('list');
		$this->set(compact('users', 'questionAlternatives', 'questionAlternativeOptions'));
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
        if (!$this->QuestionAlternativeOptionUser->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative option user'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->QuestionAlternativeOptionUser->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('QuestionAlternativeOptionUser.' . $this->QuestionAlternativeOptionUser->primaryKey => $id));
            $this->request->data = $this->QuestionAlternativeOptionUser->find('first', $options);
        }
        
        		$users = $this->QuestionAlternativeOptionUser->User->find('list');
		$questionAlternatives = $this->QuestionAlternativeOptionUser->QuestionAlternative->find('list');
		$questionAlternativeOptions = $this->QuestionAlternativeOptionUser->QuestionAlternativeOption->find('list');
		$this->set(compact('users', 'questionAlternatives', 'questionAlternativeOptions'));
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
        $this->QuestionAlternativeOptionUser->id = $id;
        if (!$this->QuestionAlternativeOptionUser->exists()) {
            throw new NotFoundException(__('Invalid question alternative option user'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->QuestionAlternativeOptionUser->delete()) {
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
                    'QuestionAlternativeOptionUser.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'QuestionAlternativeOptionUser.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'QuestionAlternativeOptionUser.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->QuestionAlternativeOptionUser->recursive = 0;
        $this->set('questionAlternativeOptionUsers', $this->Paginator->paginate());
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
        if (!$this->QuestionAlternativeOptionUser->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative option user'));
        }
        $options = array('conditions' => array('QuestionAlternativeOptionUser.' . $this->QuestionAlternativeOptionUser->primaryKey => $id));
        $this->set('questionAlternativeOptionUser', $this->QuestionAlternativeOptionUser->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->QuestionAlternativeOptionUser->create();
            if ($this->QuestionAlternativeOptionUser->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$users = $this->QuestionAlternativeOptionUser->User->find('list');
		$questionAlternatives = $this->QuestionAlternativeOptionUser->QuestionAlternative->find('list');
		$questionAlternativeOptions = $this->QuestionAlternativeOptionUser->QuestionAlternativeOption->find('list');
		$this->set(compact('users', 'questionAlternatives', 'questionAlternativeOptions'));
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
        if (!$this->QuestionAlternativeOptionUser->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative option user'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->QuestionAlternativeOptionUser->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('QuestionAlternativeOptionUser.' . $this->QuestionAlternativeOptionUser->primaryKey => $id));
            $this->request->data = $this->QuestionAlternativeOptionUser->find('first', $options);
        }
        
        		$users = $this->QuestionAlternativeOptionUser->User->find('list');
		$questionAlternatives = $this->QuestionAlternativeOptionUser->QuestionAlternative->find('list');
		$questionAlternativeOptions = $this->QuestionAlternativeOptionUser->QuestionAlternativeOption->find('list');
		$this->set(compact('users', 'questionAlternatives', 'questionAlternativeOptions'));
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
        $this->QuestionAlternativeOptionUser->id = $id;
        if (!$this->QuestionAlternativeOptionUser->exists()) {
            throw new NotFoundException(__('Invalid question alternative option user'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->QuestionAlternativeOptionUser->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
