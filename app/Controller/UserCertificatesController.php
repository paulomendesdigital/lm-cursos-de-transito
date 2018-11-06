<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserCertificates Controller
 *
 * @property UserCertificate $UserCertificate
 * @property PaginatorComponent $Paginator
 */
class UserCertificatesController extends AppController {

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

    public function manager_index() 
    {

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'UserCertificate.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'UserCertificate.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'UserCertificate.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->UserCertificate->recursive = 0;
        $this->set('userCetificates', $this->Paginator->paginate());
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
        if (!$this->UserCertificate->exists($id)) {
            throw new NotFoundException(__('Invalid user cetificate'));
        }
        $options = array('conditions' => array('UserCertificate.' . $this->UserCertificate->primaryKey => $id));
        $this->set('userCetificate', $this->UserCertificate->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->UserCertificate->create();
            if ($this->UserCertificate->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$users = $this->UserCertificate->User->find('list');
		$this->set(compact('users'));
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
        if (!$this->UserCertificate->exists($id)) {
            throw new NotFoundException(__('Invalid user cetificate'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->UserCertificate->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('UserCertificate.' . $this->UserCertificate->primaryKey => $id));
            $this->request->data = $this->UserCertificate->find('first', $options);
        }
        
        		$users = $this->UserCertificate->User->find('list');
		$this->set(compact('users'));
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
        $this->UserCertificate->id = $id;
        if (!$this->UserCertificate->exists()) {
            throw new NotFoundException(__('Invalid user cetificate'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->UserCertificate->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
