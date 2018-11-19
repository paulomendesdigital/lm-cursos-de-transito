<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Webdoors Controller
 *
 * @property Webdoor $Webdoor
 * @property PaginatorComponent $Paginator
 */
class WebdoorsController extends AppController {

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
    public function manager_index(){

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'Webdoor.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Webdoor.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Webdoor.id DESC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Webdoor->recursive = 0;
        $this->set('webdoors', $this->Paginator->paginate());
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */

    public function manager_view($id = null){
        if (!$this->Webdoor->exists($id)) {
            throw new NotFoundException(__('Invalid webdoor'));
        }
        $options = array('conditions' => array('Webdoor.' . $this->Webdoor->primaryKey => $id));
        $this->set('webdoor', $this->Webdoor->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    public function manager_add(){
        if ($this->request->is('post')) {
            $this->Webdoor->create();
            if ($this->Webdoor->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
    }

    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_edit($id = null){
        if (!$this->Webdoor->exists($id)) {
            throw new NotFoundException(__('Invalid webdoor'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Webdoor->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('Webdoor.' . $this->Webdoor->primaryKey => $id));
            $this->request->data = $this->Webdoor->find('first', $options);
        }
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_delete($id = null){
        $this->Webdoor->id = $id;
        if (!$this->Webdoor->exists()) {
            throw new NotFoundException(__('Invalid webdoor'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Webdoor->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', 'manager' => true));
    }
}