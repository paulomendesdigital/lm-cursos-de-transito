<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Paginator');

    /**
    * manager_index method
    * @return void
    */
    public function manager_index() {

        $group_id = $this->User->Group->getAdministrador();
        $titlePage = $this->User->getTitlePage('index', $group_id);

        $action_add = 'add';
        $action_edit = 'edit';

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'User.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'User.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'User.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        $conditions = array('User.group_id'=>$group_id);

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());
        }

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        $this->User->recursive = 0;
        $users = $this->Paginator->paginate();

        $this->set(compact('users','titlePage','group_id','action_add','action_edit'));
    }

    /**
    * manager_add method
    * ADMINISTRADORES
    * @return void
    */
    public function manager_add($group_id=Group::ADMINISTRADOR){

        $action = $this->User->getActionReturn($group_id);
        $titlePage = $this->User->getTitlePage('add',$group_id);
        $action = $this->User->getActionReturn($group_id);

        if ($this->request->is('post')) {

            $this->request->data['Manager'][0]['name']   = $this->request->data['User']['name'];
            $this->request->data['Manager'][0]['status'] = $this->request->data['User']['status'];

            $this->User->create();
            if ($this->User->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action'=>$action,'manager'=>true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        $this->request->data['User']['status'] = $this->request->data['User']['newsletter'] = 1;
        $states = $this->User->Manager->State->find('list', array('fields' => array('id', 'name'), 'order' => 'State.name ASC'));

        $this->set(compact('group_id', 'titlePage', 'action', 'states'));
    }

    /**
    * manager_edit method
    * ADMINISTRADORES
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_edit($id = null) {

        $group_id = Group::ADMINISTRADOR;
        $groupName = $this->User->Group->getGroup($group_id);
        $titlePage = $this->User->getTitlePage('add',$group_id);
        $action = $this->User->getActionReturn($group_id);

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is(array('post', 'put'))) {
            
            $this->request->data['Manager'][0]['name']   = $this->request->data['User']['name'];
            $this->request->data['Manager'][0]['status'] = $this->request->data['User']['status'];

            $this->request->data['Manager'][0]['user_id'] = 53;
            if ( $this->User->saveAll($this->request->data) ) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action'=> $action,'manager'=>true));
            } else {
                //die(debug( $this->User->validationErrors ));
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);

            if( !empty($this->request->data['Manager'][0]['state_id']) ){
                $this->set('cities', $this->User->Manager->City->find('list',['conditions'=>['City.state_id'=>$this->request->data['Manager'][0]['state_id']]]));
            }
        }

        $states = $this->User->Manager->State->find('list', array('fields' => array('id', 'name'), 'order' => 'State.name ASC'));
        $this->set(compact('group_id','titlePage','action','groupName', 'states'));
    }

    /**
    * PROFESSORES
    * @return void
    */
    public function manager_instructors(){

        $group_id = $this->User->Group->getInstrutor();
        $titlePage = $this->User->getTitlePage('index', $group_id);
        $action_add = 'add_instructor';
        $action_edit = 'edit_instructor';

        $this->Filter->addFilters(
            array(
                'filterId' => array(
                    'User.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterName' => array(
                    'User.name' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterCpf' => array(
                    'User.cpf' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterStatus' => array(
                    'User.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $conditions = array('User.group_id'=>$group_id);

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());
        }

        $this->Filter->setPaginate('order', 'User.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        $this->User->recursive = 0;
        $users = $this->Paginator->paginate();
        
        $this->set(compact('users','titlePage','group_id','action_add','action_edit'));
        $this->render('manager_index');
    }

    /**
    * PROFESSORES
    * @return void
    */
    public function manager_add_instructor($group_id=Group::INSTRUTOR){

        $group_id = Group::INSTRUTOR;
        $action = $this->User->getActionReturn($group_id);
        $titlePage = $this->User->getTitlePage('add',$group_id);

        if ($this->request->is('post')) {
            
            $this->request->data['User']['username']        = $this->request->data['User']['email'];
            $this->request->data['Instructor'][0]['name']   = $this->request->data['User']['name'];
            $this->request->data['Instructor'][0]['status'] = $this->request->data['User']['status'];

            $this->User->create();
            if ($this->User->saveAll($this->request->data, ['deep'=>true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action'=>$action,'manager'=>true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }

        $this->request->data['User']['status'] = $this->request->data['User']['newsletter'] = 1;
        $states = $this->User->Instructor->State->find('list', array('fields' => array('id', 'name'), 'order' => 'State.name ASC'));

        $this->set(compact('group_id','titlePage','action','states'));
    }

    /**
    * PROFESSORES
    * @return void
    */
    public function manager_edit_instructor($id = null) {
        $group_id = Group::INSTRUTOR;
        $action = $this->User->getActionReturn($group_id);
        $titlePage = $this->User->getTitlePage('edit',$group_id);
        $groupName = $this->User->Group->getGroup($group_id);

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is(array('post', 'put'))) {
            
            $this->request->data['User']['username']        = $this->request->data['User']['email'];
            $this->request->data['Instructor'][0]['name']   = $this->request->data['User']['name'];
            $this->request->data['Instructor'][0]['status'] = $this->request->data['User']['status'];
            
            if ($this->User->saveAll($this->request->data, ['deep'=>true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action'=> $action,'manager'=>true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->User->Behaviors->load('Containable');
            $this->User->contain('Instructor');
            $this->request->data = $this->User->find('first', $options);

            if( !empty($this->request->data['Instructor'][0]['state_id']) ){
                $this->set('cities', $this->User->Instructor->City->find('list',[]));
            }
        }

        $states = $this->User->Instructor->State->find('list', array('fields' => array('id', 'name'), 'order' => 'State.name ASC'));

        $this->set(compact('group_id','titlePage','action','groupName','states'));
    }

    ############################ // ############################# // ##############################
    
    /**
    * ALUNOS
    * @return void
    */
    public function manager_students() {
        $group_id = $this->User->Group->getAluno();
        $titlePage = $this->User->getTitlePage('index', $group_id);
        $action_add = 'add_student';
        $action_edit = 'edit_student';

        $this->Filter->addFilters(
            array(
                'filterId' => array(
                    'User.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterName' => array(
                    'User.name' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterCpf' => array(
                    'User.cpf' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterStatus' => array(
                    'User.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $conditions = array('User.group_id'=>$group_id);

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());
        }

        $this->Filter->setPaginate('order', 'User.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        $this->User->recursive = 0;
        $users = $this->Paginator->paginate();
        
        $this->set(compact('users','titlePage','group_id','action_add','action_edit'));
        $this->render('manager_index');
    }

    /**
    * ALUNOS
    * @return void
    */
    public function manager_add_student($group_id=Group::ALUNO){

        $group_id = Group::ALUNO;
        $action = $this->User->getActionReturn($group_id);
        $titlePage = $this->User->getTitlePage('add',$group_id);

        if (strpos($this->referer(), 'orders/add') !== false) {
            $this->Session->write('redirect_order', $this->referer());
        }

        if ($this->request->is('post')) {
            
            $this->request->data['Student'][0]['name']   = $this->request->data['User']['name'];
            $this->request->data['Student'][0]['status'] = $this->request->data['User']['status'];

            $this->request->data['User']['school_id']= isset($this->request->data['Student'][0]['school_id']) ? $this->request->data['Student'][0]['school_id'] : NULL;
            $this->request->data['User']['username'] = $this->request->data['User']['cpf'];
            $this->request->data['User']['password'] = $this->User->__setPasswordStudent($this->request->data['User']['username']);

            $this->User->create();
            if ($this->User->saveAll($this->request->data, ['deep'=>true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if ($this->Session->read('redirect_order')) {
                    $this->Session->delete('redirect_order');
                    return $this->redirect(['controller' => 'orders', 'action' => 'add', 'manager' => true, $this->User->id]);
                } else {
                    if (isset($this->request->data['aplicar'])) {
                        return $this->redirect($this->referer());
                    }
                    return $this->redirect(array('action' => $action, 'manager' => true));
                }
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }

        $this->request->data['User']['status'] = $this->request->data['User']['newsletter'] = 1;
        $states = $this->User->Instructor->State->find('list', array('fields' => array('id', 'name'), 'order' => 'State.name ASC'));

        $schools = $this->User->Student->School->find('list');
        $this->set('cnh_categories', $this->getCnhCategoriesList());

        $this->set(compact('group_id','titlePage','action','states','schools'));
    }

    /**
    * ALUNOS
    * @return void
    */
    public function manager_edit_student($id = null) {
        
        $group_id = Group::ALUNO;
        $action = $this->User->getActionReturn($group_id);
        $titlePage = $this->User->getTitlePage('edit',$group_id);
        $groupName = $this->User->Group->getGroup($group_id);

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is(array('post', 'put'))) {
            
            $this->request->data['User']['school_id']    = isset($this->request->data['Student'][0]['school_id']) ? $this->request->data['Student'][0]['school_id'] : NULL;
            $this->request->data['User']['username']     = $this->request->data['User']['cpf'];
            $this->request->data['Student'][0]['name']   = $this->request->data['User']['name'];
            $this->request->data['Student'][0]['status'] = $this->request->data['User']['status'];
            
            if ($this->User->saveAll($this->request->data, ['deep'=>true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action'=> $action,'manager'=>true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = [
                'conditions' => ['User.id' => $id],
                'contain' => [
                    'Student' => [
                        'School'
                    ],
                ]
            ];
            $this->User->Behaviors->load('Containable');
            $this->request->data = $this->User->find('first', $options);

            if( !empty($this->request->data['Student'][0]['state_id']) ){
                $this->set('cities', $this->User->Student->City->find('list',['conditions'=>['City.state_id'=>$this->request->data['Student'][0]['state_id']]]));
            }
        }

        $states = $this->User->Student->State->find('list', array('fields' => array('id', 'name'), 'order' => 'State.name ASC'));

        $schools = $this->User->Student->School->find('list');
        $this->set('cnh_categories', $this->getCnhCategoriesList());

        $this->set(compact('group_id','titlePage','action','groupName','states','schools'));
    }

    ############################ // ############################# // ##############################
    
    /**
    * PARCEIROS
    * @return void
    */
    public function manager_partners() {
        
        $group_id = $this->User->Group->getParceiro();
        $titlePage = $this->User->getTitlePage('index', $group_id);
        $action_add = 'add_partner';
        $action_edit = 'edit_partner';

        $this->Filter->addFilters(
            array(
                'filterId' => array(
                    'User.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterName' => array(
                    'User.name' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterCpf' => array(
                    'User.cpf' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterStatus' => array(
                    'User.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $conditions = array('User.group_id'=>$group_id);

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());
        }

        $this->Filter->setPaginate('order', 'User.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        $this->User->recursive = 0;
        $users = $this->Paginator->paginate();
        
        $this->set(compact('users','titlePage','group_id','action_add','action_edit'));
        $this->render('manager_index');
    }

    /**
    * PARCEIROS
    * @return void
    */
    public function manager_add_partner($group_id=Group::PARCEIRO){

        $group_id = Group::PARCEIRO;
        $action = $this->User->getActionReturn($group_id);
        $titlePage = $this->User->getTitlePage('add',$group_id);

        if (strpos($this->referer(), 'partners/add') !== false) {
            $this->Session->write('redirect_partner', $this->referer());
        }

        if ($this->request->is('post')) {
            
            $this->request->data['Partner'][0]['name']   = $this->request->data['User']['name'];
            $this->request->data['Partner'][0]['status'] = $this->request->data['User']['status'];

            $this->request->data['User']['username'] = $this->request->data['User']['cpf'];
            $this->request->data['User']['password'] = $this->User->__setPasswordPartner($this->request->data['User']['username']);

            $this->User->create();

            if ($this->User->saveAll($this->request->data, ['deep'=>true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if ($this->Session->read('redirect_partner')) {
                    $this->Session->delete('redirect_partner');
                    return $this->redirect(['controller' => 'partners', 'action' => 'add', 'manager' => true, $this->User->id]);
                } else {
                    if (isset($this->request->data['aplicar'])) {
                        return $this->redirect($this->referer());
                    }
                    return $this->redirect(array('action' => $action, 'manager' => true));
                }
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }

        $this->request->data['User']['status'] = $this->request->data['User']['newsletter'] = 1;

        $this->set('cnh_categories', $this->getCnhCategoriesList());

        $this->set(compact('group_id','titlePage','action'));
    }

    /**
    * PARCEIROS
    * @return void
    */
    public function manager_edit_partner($id = null) {
        
        $group_id = Group::PARCEIRO;
        $action = $this->User->getActionReturn($group_id);
        $titlePage = $this->User->getTitlePage('edit',$group_id);
        $groupName = $this->User->Group->getGroup($group_id);

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is(array('post', 'put'))) {
            
            $this->request->data['User']['username']     = $this->request->data['User']['cpf'];
            $this->request->data['Partner'][0]['name']   = $this->request->data['User']['name'];
            $this->request->data['Partner'][0]['status'] = $this->request->data['User']['status'];
            
            if ($this->User->saveAll($this->request->data, ['deep'=>true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action'=> $action,'manager'=>true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = [
                'conditions' => ['User.id' => $id],
            ];
            $this->User->Behaviors->load('Containable');
            $this->request->data = $this->User->find('first', $options);

            if( !empty($this->request->data['Partner'][0]['state_id']) ){
                $this->set('cities', $this->User->Partner->City->find('list',['conditions'=>['City.state_id'=>$this->request->data['Partner'][0]['state_id']]]));
            }
        }

        $states = $this->User->Partner->State->find('list', array('fields' => array('id', 'name'), 'order' => 'State.name ASC'));

        $this->set('cnh_categories', $this->getCnhCategoriesList());

        $this->set(compact('group_id','titlePage','action','groupName','states'));
    }

    ############################ // ############################# // ##############################

    /**
    * operadores
    * @return void
    */
    public function manager_operators() {
        $group_id = $this->User->Group->getOperador();
        $titlePage = $this->User->getTitlePage('index', $group_id);

        $this->Filter->addFilters(
            array(
                'filterId' => array(
                    'User.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterName' => array(
                    'User.name' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterCpf' => array(
                    'User.cpf' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterStatus' => array(
                    'User.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $conditions = array('User.group_id'=>$group_id);

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());
        }

        $this->Filter->setPaginate('order', 'User.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        $this->User->recursive = 0;
        $users = $this->Paginator->paginate();
        
        $this->set(compact('users','titlePage','group_id'));
        $this->render('manager_index');
    }

    

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_view($id = null){

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }

        $dataUser = $this->User->find('first',array('recursive'=>-1,'conditions'=>array('User.id'=>$id)));

        $options = array('conditions' => array('User.id' => $id));
        $this->User->Behaviors->load('Containable');

        switch ($dataUser['User']['group_id']) {
            case $this->User->Group->getAdministrador():
                $this->User->contain(['Group','Manager']);
                break;
            case $this->User->Group->getOperador():
                $this->User->contain(['Group','Manager']);
                break;
            case $this->User->Group->getProfessor():
                $this->User->contain([
                    'Group',
                    'Complement',
                    'Instructor'=>[
                        'City',
                        'State',
                        'DirectMessage'=>[
                            //'fields'=>['DISTINCT DirectMessage.user_id'],
                            'User'=>['id','name','email'],
                        ],
                    ]
                ]);
                break;
            case $this->User->Group->getAluno():
                $this->User->getViewAluno();
                break;
            default:
                $this->User->contain(['Group','Manager']);
                break;
        }
        
        $user = $this->User->find('first', $options);
        $titlePage = $this->User->getTitlePage('view', $user['User']['group_id']);
        $action = $this->User->getActionReturn($user['User']['group_id']);
        $this->set( compact('user','titlePage','action') );
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
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        $options = array('recursive'=>-1,'conditions' => array('User.' . $this->User->primaryKey => $id));
        $user = $this->User->find('first', $options);

        $group_id = $user['User']['group_id'];
        $action = $this->User->getActionReturn($group_id);
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => $action, 'manager' => true));
    }

    public function manager_login() {

        if ($this->Auth->user()):
            return $this->redirect(array('controller' => 'pages', 'action' => 'index', 'manager' => false));
        endif;
                
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Your username or password was incorrect.'), 'site/error');
        }
    }
        
    public function manager_logout() {
        $this->Session->setFlash(__('Good-Bye.'), 'site/success');
        $this->redirect($this->Auth->logout());
    }

    public function manager_pass() {
        if($this->request->data){
            session_regenerate_id();

            $this->request->data = $this->User->find('first', [
                'recursive' => -1,
                'conditions' => [
                    'User.email' => $this->request->data['User']['email'],
                    'User.group_id' => 4
                ]
            ]);
            if($this->request->data['User']['id']){
                $this->request->data['User']['password'] = substr(session_id(), -4);
                $this->request->data['User']['new_password'] = substr(session_id(), -4);
                if($this->User->save($this->request->data)){
                    $this->Session->setFlash(__('Pronto! Sua nova senha foi enviada pra seu email.'),'site/success');
                    return $this->redirect($this->Auth->redirect());
                }else{
                    $this->Session->setFlash(__('Ops! Algo ocorreu de errado, tente novamente.'), 'site/error');
                    return $this->redirect($this->Auth->redirect());
                }
            }

            $this->Session->setFlash(__('Ops! Não conseguimos localizar seu email.'), 'site/error');
            return $this->redirect($this->Auth->redirect());
        }
    }


    /**
    * index method
    *
    * @return void
    */
    public function index(){

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'User.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'User.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'User.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
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
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    private function prepareUserForSave() {
        $this->request->data['User']['group_id'] = Group::ALUNO;
        $this->request->data['Student'][0]['status'] = 1;

        $this->request->data['Student'][0]['name'] = $this->request->data['User']['name'];
        $this->request->data['User']['username']   = $this->request->data['User']['cpf'];
        //$this->request->data['User']['password'] = $this->User->__setPasswordStudent($this->request->data['User']['username']);

        $this->request->data['User']['status'] = $this->request->data['User']['newsletter'] = 1;
    }

    /**
    * add method
    *
    * @return void
    */
    public function add(){
        $this->layout = 'site';
        if ($this->request->is('post')) {

            $this->User->create();
            $this->prepareUserForSave();
            $this->User->prepareValidationForCadastroAluno();

            if ($this->User->saveAll($this->request->data,['deep'=>true,'validate'=>'first'])) {
                if( $this->Auth->login(null, false) ){
                    $this->Session->setFlash(__('Seja bem vindo(a)!'), 'site/popup-success');
                    return $this->redirect(['controller' => 'pages', 'action' => 'index']);
                }
                return $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('Erro ao salvar. Por favor, tente novamente.'), 'site/popup-error');
            }
        }
		$states = $this->User->Instructor->State->find('list', array('fields' => array('id', 'name'), 'order' => 'State.name ASC'));
        $this->set('states',$states);

        $this->set('genders',$this->getGendersList());
        $this->set('cnh_categories', $this->getCnhCategoriesList());
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
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->User->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        
        		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', 'manager' => false));
    }
    public function login() {

        if ($this->Auth->user()):
            return $this->redirect(array('controller' => 'pages', 'action' => 'index', 'manager' => false));
        endif;
        
        if ($this->request->is('post')) {

            if ($this->Auth->login()) {
                if( (strstr($this->referer(), 'orders/payment')) or strstr($this->Auth->redirect(), 'orders/payment')){
                    $this->Auth->loginRedirect = array(
                        'controller' => 'orders',
                        'action' => 'payment',
                        'school' => false,
                    );
                }
                elseif( !strstr($this->Auth->redirect(), 'carts') ){
                    $this->Auth->loginRedirect = array(
                        'controller' => 'meus-cursos',
                        'action' => 'index',
                        'school' => false,
                    );
                }
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Your username or password was incorrect.'), 'site/error');
        }
    }

    public function login_partner() {

        if ($this->Auth->user()):
            return $this->redirect(array('controller' => 'pages', 'action' => 'index', 'manager' => false));
        endif;
        
        if ($this->request->is('post')) {

            if ($this->Auth->login()) {
                
                $this->Session->write('partner',true);

                $this->Auth->loginRedirect = array(
                    'controller' => 'minhas-vendas',
                    'action' => 'index',
                    'school' => false,
                );
                return $this->redirect($this->Auth->redirect());
            }
            die;
            $this->Session->setFlash(__('Your username or password was incorrect.'), 'site/error');
        }
    }
        
    public function logout() {

        if (strstr($this->referer(), 'orders/payment') || isset($this->request->query['home'])) {
            $this->Auth->logoutRedirect = array(
                'controller' => 'pages',
                'action'     => 'index'
            );
        } elseif( $this->Auth->user('Student.0.School') ){

            $this->Auth->logoutRedirect = array(
                'controller' => 'users',
                'action'     => 'login',
                'school'     => true,
            );
        }
        $this->Session->setFlash(__('Good-Bye.'), 'site/success');
        $this->Session->delete('user_bag');
        $this->Session->delete('Ticket');
        $this->redirect($this->Auth->logout());
    }

    public function pass() {
        if($this->request->data){
            session_regenerate_id();

            $this->request->data = $this->User->find('first', [
                'recursive' => -1,
                'conditions' => [
                    'User.cpf' => $this->request->data['User']['cpf'],
                    'User.group_id' => 4
                ]
            ]);
            if( isset($this->request->data['User']['id']) and !empty($this->request->data['User']['id']) ){
                
                //$this->User->id = $this->request->data['User']['id'];
                $this->request->data['User']['password'] = $this->request->data['User']['new_password'] = substr(session_id(), -4);
                //$this->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
                
                if( $this->User->save($this->request->data) ){
                    $email = $this->request->data['User']['email'];
                    $Sistems = Configure::read('Sistems');
                    
                    $data['template'] = 'change_password'; 
                    $data['subject'] = '[Recuperação de Senha]';
                    $data['to'] = $email;
                    $data['content'] = array(
                      'Login' => $this->request->data['User']['username'],
                      'Senha' => $this->request->data['User']['new_password'],
                      'messenger' => 'Olá '.$this->request->data['User']['name'].', <br />você acaba de alterar sua senha, acesse o nosso site e faça seu login.',
                      'email' => $email
                    );

                    try {
                        $this->__SendMail($data);
                        $this->Session->setFlash(__('Pronto! Sua nova senha foi enviada para seu email de cadastro.'), 'site/popup-success');
                        return $this->redirect(['action'=>'login']);
                    } catch (Exception $ex) {
                      $this->Session->setFlash('Erro ao enviar o email. Tente novamente mais tarde.','site/popup-error');
                    }
                    return $this->redirect($this->Auth->redirect());
                }else{
                    $this->Session->setFlash(__('Ops! Algo ocorreu de errado, tente novamente.'), 'site/error');
                    return $this->redirect($this->Auth->redirect());
                }
            }

            $this->Session->setFlash(__('Ops! Não conseguimos localizar seu CPF.'), 'site/error');
            return $this->redirect($this->Auth->redirect());
        }
    }

    /**
     * Retorna os Dados de Estudantes para uso no Select2
     * @return string
     */
    public function manager_ajaxSelect2Students()
    {
        $this->layout = 'ajax';
        $this->autoRender = false;

        $term = trim($this->request->query('term'));

        $termNumbers = preg_replace('/\D/', '', $term);
        if (empty($termNumbers)) {
            $termNumbers = $term; //pog para não procurar por vazio
        }

        $this->User->Student->Behaviors->load('Containable');
        $rows = $this->User->Student->find('all', [
            'recursive'  => false,
            'conditions' => [
                'User.status' => '1',
                'OR' => [
                    'User.name LIKE' => "%$term%",
                    'User.cpf LIKE' => "%$term%",
                    'User.cpf LIKE' => "%$termNumbers%",
                    'User.email LIKE' => "%$term%",
                    'Student.cnh LIKE' => "%$term%",
                    'Student.cnh LIKE' => "%$termNumbers%",
                    'Student.renach LIKE' => "%$term%",
                    'Student.renach LIKE' => "%$termNumbers%"
                ]
,            ],
            'fields' => ['id', 'name', 'state_id', 'city_id', 'cnh', 'cnh_category', 'renach', 'birth'],
            'contain' => ['User' => ['id', 'name', 'cpf'], 'School' => ['id', 'name', 'cod_cfc']],
            'order' => ['User.name']
        ]);

        $results = [];
        foreach ($rows as $row) {
            $results[] = [
                'id'    => $row['User']['id'],
                'text'  => $row['User']['name'] . ($row['User']['cpf'] ? ' - ' . $row['User']['cpf'] : ''),
                'extra' => $row
            ];
        }

        return json_encode(['more' => false, 'results' => $results]);
    }

    /* ############################ LOGIN PARA AUTO ESCOLAS ############################## */
    public function school_login() {

        if ( $this->Auth->user() ):
            return $this->redirect(array('controller' => 'meus-cursos', 'action' => 'index'));
        endif;
        
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Auth->loginRedirect = array(
                    'controller' => 'meus-cursos',
                    'action' => 'index',
                    'school' => false,
                );
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Your username or password was incorrect.'), 'site/error');
        }
    }
        
    public function school_logout() {
        $this->Session->setFlash(__('Good-Bye.'), 'site/success');
        $this->Session->delete('user_bag');
        $this->redirect($this->Auth->logout());
    }
    /* ############################ FIIM LOGIN PARA AUTO ESCOLA ########################## */

    /**
     * Retorna os Dados de Auto Escolas para uso no Select2
     * @return string
     */
    public function manager_ajaxSelect2Schools()
    {
        $this->layout = 'ajax';
        $this->autoRender = false;

        $term = trim($this->request->query('term'));

        $rows = $this->User->Student->School->find('all', [
            'recursive'  => false,
            'conditions' => [
                'School.status' => '1',
                'OR' => [
                    'School.name LIKE' => "%$term%",
                    'School.cod_cfc LIKE' => "%$term%",
                ]
            ],
            'fields' => ['id', 'name', 'cod_cfc'],
            'order'  => ['School.name']
        ]);

        $results = [];
        foreach ($rows as $row) {
            $strCodCfc = isset($row['School']['cod_cfc']) && $row['School']['cod_cfc'] != '' ? (' - ' . $row['School']['cod_cfc']) : '';
            $results[] = ['id'    => $row['School']['id'], 'text'  => $row['School']['name'] . $strCodCfc];
        }

        return json_encode(['more' => false, 'results' => $results]);
    }

    public function payment_identification($userAction = null)
    {
        $this->autorender = false;
        $this->layout     = false;

        $bolSuccess = false;

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($userAction == 'login') {
                $bolSuccess = $this->paymentLogin();
            } elseif ($userAction == 'cadastro') {
                $bolSuccess = $this->paymentCadastro();
            }
        }

        if ($this->Auth->user('id')) {
            $user      = $this->__getStudent($this->Auth->user('id'));
            $userValid = $this->checkStudent($user);
            if (!$userValid) {
                $user['Student'][0] = $user['Student'];
                $user['Student'][0]['birth'] = isset($user['Student'][0]['birth']) ? implode('/', array_reverse(explode('-', $user['Student'][0]['birth']))) : '';
                $this->request->data = array_merge($this->request->data, $user);
            }
            $this->set('user', $user);
            $this->set('userValid', $userValid);
        }

        $this->set('success', $bolSuccess);
        $this->set('userAction', $userAction);
        $this->render('/Elements/site/payment/identification');
    }

    private function paymentLogin()
    {
        //login facebook
        if (isset($this->request->data['User']['facebook_json']) && !empty($this->request->data['User']['facebook_json'])) {

            if ($this->facebookLogin(json_decode($this->request->data['User']['facebook_json'], true))) {
                return true;
            } else {
                $strMessage = 'Não foi possível Entrar com o Facebook';
            }

        //login normal
        } else{
            if ($this->Auth->login()) {
                return true;
            } else {
                $strMessage = __('Your username or password was incorrect.');
            }
        }

        $this->set('message', $strMessage);
        return false;
    }

    private function facebookLogin(array $facebookData)
    {
        $user = $this->User->find('first', [
            'recursive'  => false,
            'conditions' => [
                'group_id' => Group::ALUNO,
                'OR' => [
                    'facebook_id' => $facebookData['id'],
                    'email'       => $facebookData['email'],
                ]
            ]
        ]);

        //se não encontrou o usuário, cadastradas temporariamente
        if (!$user) {
            $this->User->create();
            $userData = [
                'User' => [
                    'facebook_id' => $facebookData['id'],
                    'username'    => $facebookData['id'],
                    'group_id'    => Group::ALUNO,
                    'name'        => $facebookData['name'],
                    'email'       => $facebookData['email'],
                    'status'      => 1,
                    'newsletter'  => 1

                ],
                'Student' => [
                    [
                        'status' => 1,
                        'name'   => $facebookData['name']
                    ]
                ]
            ];

            if ($this->User->saveAll($userData,['deep'=>true,'validate'=>'first'])) {
                $user = $this->User->read(null,$this->User->id);
            } else {
                return false;
            }
        }

        $user = array_merge($user, $user['User']);

        if ($this->Auth->login($user)) {
            $this->request->data = null;
            return true;
        } else {
            return false;
        }
    }

    private function paymentCadastro()
    {
        $this->prepareUserForSave();
        $this->User->prepareValidationForCadastroAluno();

        if ($this->User->saveAll($this->request->data,['deep'=>true,'validate'=>'first']) && $this->Auth->login()) {
            return true;
        } else {
            return false;
        }
    }
}
