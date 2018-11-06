<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserCertificateModules Controller
 *
 * @property UserCertificateModule $UserCertificateModule
 * @property PaginatorComponent $Paginator
 */
class UserCertificateModulesController extends AppController {

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
                    'UserCertificateModule.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'UserCertificateModule.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'UserCertificateModule.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->UserCertificateModule->recursive = 0;
        $this->set('userCertificateModules', $this->Paginator->paginate());
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
        if (!$this->UserCertificateModule->exists($id)) {
            throw new NotFoundException(__('Invalid user certificate module'));
        }
        $options = array('conditions' => array('UserCertificateModule.' . $this->UserCertificateModule->primaryKey => $id));
        $this->set('userCertificateModule', $this->UserCertificateModule->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->UserCertificateModule->create();
            if ($this->UserCertificateModule->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$userCertificates = $this->UserCertificateModule->UserCertificate->find('list');
		$this->set(compact('userCertificates'));
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
        if (!$this->UserCertificateModule->exists($id)) {
            throw new NotFoundException(__('Invalid user certificate module'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->UserCertificateModule->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('UserCertificateModule.' . $this->UserCertificateModule->primaryKey => $id));
            $this->request->data = $this->UserCertificateModule->find('first', $options);
        }
        
        		$userCertificates = $this->UserCertificateModule->UserCertificate->find('list');
		$this->set(compact('userCertificates'));
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
        $this->UserCertificateModule->id = $id;
        if (!$this->UserCertificateModule->exists()) {
            throw new NotFoundException(__('Invalid user certificate module'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->UserCertificateModule->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
