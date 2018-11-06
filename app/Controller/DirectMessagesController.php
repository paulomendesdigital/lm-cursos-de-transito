<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * DirectMessages Controller
 *
 * @property DirectMessage $DirectMessage
 * @property PaginatorComponent $Paginator
 */
class DirectMessagesController extends AppController {

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
                    'DirectMessage.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'DirectMessage.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'DirectMessage.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->DirectMessage->recursive = 0;
        $this->set('directMessages', $this->Paginator->paginate());
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
        if (!$this->DirectMessage->exists($id)) {
            throw new NotFoundException(__('Invalid direct message'));
        }
        $options = array('conditions' => array('DirectMessage.' . $this->DirectMessage->primaryKey => $id));
        $this->set('directMessage', $this->DirectMessage->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->DirectMessage->create();
            if ($this->DirectMessage->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$users = $this->DirectMessage->User->find('list');
		$instructors = $this->DirectMessage->Instructor->find('list');
		$this->set(compact('users', 'instructors'));
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
        if (!$this->DirectMessage->exists($id)) {
            throw new NotFoundException(__('Invalid direct message'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->DirectMessage->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('DirectMessage.' . $this->DirectMessage->primaryKey => $id));
            $this->request->data = $this->DirectMessage->find('first', $options);
        }
        
        		$users = $this->DirectMessage->User->find('list');
		$instructors = $this->DirectMessage->Instructor->find('list');
		$this->set(compact('users', 'instructors'));
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
        $this->DirectMessage->id = $id;
        if (!$this->DirectMessage->exists()) {
            throw new NotFoundException(__('Invalid direct message'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->DirectMessage->delete()) {
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

    public function manager_index($user_id=false) {

        $this->Filter->addFilters(
            array(
                'status' => [
                    'DirectMessage.status' => [
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    ]
                ],
                'student' => [
                    'DirectMessage.user_id'
                ],
                'instructor' => [
                    'DirectMessage.instructor_id'
                ],
                'view_user' => [
                    'DirectMessage.view_user' => [
                        'select' => ['' => 'Vista pelo Aluno', 0 => 'Não', 1 => 'Sim']
                    ]
                ],
                'view_instructor' => [
                    'DirectMessage.view_instructor' => [
                        'select' => ['' => 'Vista pelo Instrutor', 0 => 'Não', 1 => 'Sim']
                    ]
                ],
                'data_de' => [
                    'DirectMessage.created' => ['operator' => '>='],
                ],
                'data_ate' => [
                    'DirectMessage.created' => ['operator' => '<='],
                ]
            )
        );

        $conditions = [];

        if( $user_id ){
            $conditions['DirectMessage.user_id'] = $user_id;
        }

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());

            if (isset($conditions['DirectMessage.created >='])) {
                $conditions['DirectMessage.created >='] = implode('-', array_reverse(explode('/', $conditions['DirectMessage.created >='])));
            }
            if (isset($conditions['DirectMessage.created <='])) {
                $conditions['DirectMessage.created <='] = implode('-', array_reverse(explode('/', $conditions['DirectMessage.created <='])));
            }
        }

        //named params
        if (empty($conditions) && isset($this->params['named']['opt'])) {
            if ($this->params['named']['opt'] == 'minhas') {
                $conditions['DirectMessage.instructor_id'] = $this->request->data['filter']['instructor'] = $this->Auth->user('id');
            } elseif (!isset($this->request->data['filter']['view_instructor']) && $this->params['named']['opt'] == 'nao_vistas') {
                $conditions['DirectMessage.view_instructor'] = $this->request->data['filter']['view_instructor'] = 0;
            }
        }

        $this->Filter->setPaginate('order', 'DirectMessage.id DESC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        $this->DirectMessage->recursive = 0;
        $this->set('directMessages', $this->Paginator->paginate());

        $instructors = $this->DirectMessage->Instructor->find('list');
        $this->set('instructors', $instructors);

        $students = $this->DirectMessage->User->find('list', ['conditions' => ['User.group_id' => Group::ALUNO], 'order' => 'User.name']);
        $this->set('students', $students);
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
        if (!$this->DirectMessage->exists($id)) {
            throw new NotFoundException(__('Invalid direct message'));
        }
        $options = array('conditions' => array('DirectMessage.' . $this->DirectMessage->primaryKey => $id));
        $this->set('directMessage', $this->DirectMessage->find('first', $options));
    }

        
    /**
    * manager_answer method
    * responder mensagem para aluno
    * @return void
    */
    
    public function manager_answer($student_id=false, $instructor_id=false) {

        if ($this->request->is('post')) {
        
            $this->DirectMessage->create();
            $this->request->data['DirectMessage']['author'] = 'Instructor';
            if ($this->DirectMessage->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                //if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                //}
                //return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }

        $this->DirectMessage->Behaviors->load('Containable');
        $directMessages = $this->DirectMessage->find('all',[
            'contain' => [
                'User' => [
                    'fields' => ['id', 'name', 'avatar']
                ],
                'Instructor' => [
                    'fields' => ['id', 'name'],
                    'User' => ['fields' => ['id', 'avatar']]
                ]
            ],
            'conditions'=>[
                'DirectMessage.user_id'=>$student_id,
                'DirectMessage.instructor_id'=>$instructor_id
            ],
            'order'=>['DirectMessage.id'=>'ASC']
        ]);
        $user_id = $student_id;
        $instructors[$directMessages[0]['DirectMessage']['instructor_id']] = $directMessages[0]['Instructor']['name'];
        $this->set(compact('directMessages','user_id','instructors'));
    }

    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->DirectMessage->create();
            if ($this->DirectMessage->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$users = $this->DirectMessage->User->find('list');
		$instructors = $this->DirectMessage->Instructor->find('list');
		$this->set(compact('users', 'instructors'));
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
        if (!$this->DirectMessage->exists($id)) {
            throw new NotFoundException(__('Invalid direct message'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->DirectMessage->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('DirectMessage.' . $this->DirectMessage->primaryKey => $id));
            $this->request->data = $this->DirectMessage->find('first', $options);
        }
        
        		$users = $this->DirectMessage->User->find('list');
		$instructors = $this->DirectMessage->Instructor->find('list');
		$this->set(compact('users', 'instructors'));
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
        $this->DirectMessage->id = $id;
        if (!$this->DirectMessage->exists()) {
            throw new NotFoundException(__('Invalid direct message'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->DirectMessage->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
