<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ForumPostComments Controller
 *
 * @property ForumPostComment $ForumPostComment
 * @property PaginatorComponent $Paginator
 */
class ForumPostCommentsController extends AppController {

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
                    'ForumPostComment.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ForumPostComment.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'ForumPostComment.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->ForumPostComment->recursive = 0;
        $this->set('forumPostComments', $this->Paginator->paginate());
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
        if (!$this->ForumPostComment->exists($id)) {
            throw new NotFoundException(__('Invalid forum post comment'));
        }
        $options = array('conditions' => array('ForumPostComment.' . $this->ForumPostComment->primaryKey => $id));
        $this->set('forumPostComment', $this->ForumPostComment->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->ForumPostComment->create();
            if ($this->ForumPostComment->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$forumPosts = $this->ForumPostComment->ForumPost->find('list');
		$users = $this->ForumPostComment->User->find('list');
		$this->set(compact('forumPosts', 'users'));
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
        if (!$this->ForumPostComment->exists($id)) {
            throw new NotFoundException(__('Invalid forum post comment'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->ForumPostComment->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('ForumPostComment.' . $this->ForumPostComment->primaryKey => $id));
            $this->request->data = $this->ForumPostComment->find('first', $options);
        }
        
        		$forumPosts = $this->ForumPostComment->ForumPost->find('list');
		$users = $this->ForumPostComment->User->find('list');
		$this->set(compact('forumPosts', 'users'));
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
        $this->ForumPostComment->id = $id;
        if (!$this->ForumPostComment->exists()) {
            throw new NotFoundException(__('Invalid forum post comment'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ForumPostComment->delete()) {
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

    public function manager_index($forum_post_id=false) 
    {

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'ForumPostComment.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'ForumPostComment.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $conditions['ForumPostComment.status'] = array('0','1');

        if( $forum_post_id ){
            $conditions['ForumPostComment.forum_post_id'] = $forum_post_id;
        }

        if( $this->Filter->getConditions() ){
            $conditions = \Hash::merge($conditions, $this->Filter->getConditions());
        }

        $this->Filter->setPaginate('order', 'ForumPostComment.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->ForumPostComment->recursive = 0;
        $forumPostComments = $this->Paginator->paginate();
        $this->set(compact('forumPostComments','forum_post_id'));
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
        if (!$this->ForumPostComment->exists($id)) {
            throw new NotFoundException(__('Invalid forum post comment'));
        }
        $options = array('conditions' => array('ForumPostComment.' . $this->ForumPostComment->primaryKey => $id));
        $this->set('forumPostComment', $this->ForumPostComment->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->ForumPostComment->create();
            if ($this->ForumPostComment->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$forumPosts = $this->ForumPostComment->ForumPost->find('list');
		$users = $this->ForumPostComment->User->find('list');
		$this->set(compact('forumPosts', 'users'));
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
        if (!$this->ForumPostComment->exists($id)) {
            throw new NotFoundException(__('Invalid forum post comment'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->ForumPostComment->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('ForumPostComment.' . $this->ForumPostComment->primaryKey => $id));
            $this->request->data = $this->ForumPostComment->find('first', $options);
        }
        
        		$forumPosts = $this->ForumPostComment->ForumPost->find('list');
		$users = $this->ForumPostComment->User->find('list');
		$this->set(compact('forumPosts', 'users'));
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
        $this->ForumPostComment->id = $id;
        if (!$this->ForumPostComment->exists()) {
            throw new NotFoundException(__('Invalid forum post comment'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->ForumPostComment->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
