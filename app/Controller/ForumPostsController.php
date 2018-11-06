<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ForumPosts Controller
 *
 * @property ForumPost $ForumPost
 * @property PaginatorComponent $Paginator
 */
class ForumPostsController extends AppController {

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
                    'ForumPost.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ForumPost.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'ForumPost.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->ForumPost->recursive = 0;
        $this->set('forumPosts', $this->Paginator->paginate());
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
        if (!$this->ForumPost->exists($id)) {
            throw new NotFoundException(__('Invalid forum post'));
        }
        $options = array('conditions' => array('ForumPost.' . $this->ForumPost->primaryKey => $id));
        $this->set('forumPost', $this->ForumPost->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->ForumPost->create();
            if ($this->ForumPost->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$forums = $this->ForumPost->Forum->find('list');
		$users = $this->ForumPost->User->find('list');
		$this->set(compact('forums', 'users'));
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
        if (!$this->ForumPost->exists($id)) {
            throw new NotFoundException(__('Invalid forum post'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->ForumPost->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('ForumPost.' . $this->ForumPost->primaryKey => $id));
            $this->request->data = $this->ForumPost->find('first', $options);
        }
        
        		$forums = $this->ForumPost->Forum->find('list');
		$users = $this->ForumPost->User->find('list');
		$this->set(compact('forums', 'users'));
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
        $this->ForumPost->id = $id;
        if (!$this->ForumPost->exists()) {
            throw new NotFoundException(__('Invalid forum post'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ForumPost->delete()) {
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

    public function manager_index($forum_id=false) 
    {

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'ForumPost.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ForumPost.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $conditions['ForumPost.status'] = array('0','1');

        if( $forum_id ){
            $conditions['ForumPost.forum_id'] = $forum_id;
        }

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());
        }

        $this->Filter->setPaginate('order', 'ForumPost.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $conditions);

        $this->ForumPost->recursive = 0;
        $forumPosts = $this->Paginator->paginate();
        $this->set(compact('forumPosts','forum_id'));
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
        if (!$this->ForumPost->exists($id)) {
            throw new NotFoundException(__('Invalid forum post'));
        }
        $options = array('conditions' => array('ForumPost.' . $this->ForumPost->primaryKey => $id));
        $this->ForumPost->Behaviors->load('Containable');
        $this->ForumPost->contain([
                'Forum',
                'User',
                'ForumPostComment' => ['User' => ['fields' => ['name']]],
        ]);
        $this->set('forumPost', $this->ForumPost->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->ForumPost->create();
            if ($this->ForumPost->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$forums = $this->ForumPost->Forum->find('list');
		$users = $this->ForumPost->User->find('list');
		$this->set(compact('forums', 'users'));
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
        if (!$this->ForumPost->exists($id)) {
            throw new NotFoundException(__('Invalid forum post'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->ForumPost->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('ForumPost.' . $this->ForumPost->primaryKey => $id));
            $this->request->data = $this->ForumPost->find('first', $options);
        }
        
        		$forums = $this->ForumPost->Forum->find('list');
		$users = $this->ForumPost->User->find('list');
		$this->set(compact('forums', 'users'));
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
        $this->ForumPost->id = $id;
        if (!$this->ForumPost->exists()) {
            throw new NotFoundException(__('Invalid forum post'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ForumPost->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
