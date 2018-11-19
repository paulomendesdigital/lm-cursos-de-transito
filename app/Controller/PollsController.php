<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2017
 * @author Grupo Grow - www.grupogrow.com.br
 * Polls Controller
 *
 * @property Poll $Poll
 * @property PaginatorComponent $Paginator
 */
class PollsController extends AppController {

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
    public function manager_index() {

        $this->Filter->setPaginate('order', 'Poll.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Poll->recursive = 0;
        $this->set('polls', $this->Paginator->paginate());
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_view($id = null){

        if (!$this->Poll->exists($id)) {
            throw new NotFoundException(__('Invalid poll'));
        }
        $options = array('conditions' => array('Poll.' . $this->Poll->primaryKey => $id));
        $this->set('poll', $this->Poll->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    public function manager_add(){

        if ($this->request->is('post')) {
        
            $this->Poll->create();
            if ($this->Poll->saveAll($this->request->data,['Deep'=>true])) {
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
    public function manager_edit($id = null) {

        if (!$this->Poll->exists($id)) {
            throw new NotFoundException(__('Invalid Poll'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Poll->saveAll($this->request->data,['Deep'=>true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('Poll.' . $this->Poll->primaryKey => $id));
            $this->request->data = $this->Poll->find('first', $options);
        }
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_delete($id = null) {

        $this->Poll->id = $id;
        if (!$this->Poll->exists()) {
            throw new NotFoundException(__('Invalid Poll'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Poll->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', 'manager' => true));
    }
}
