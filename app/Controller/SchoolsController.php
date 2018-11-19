<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Schools Controller
 *
 * @property School $School
 * @property PaginatorComponent $Paginator
 */
class SchoolsController extends AppController {

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

        $this->Filter->addFilters(
             array(
                'filterId' => array(
                    'School.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filterName' => array(
                    'School.name' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%', 
                            'after'  => '%'  
                        )
                    )
                ),
                'filterStatus' => array(
                    'School.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                ),
                'filterEstado' => array(
                    'School.state_id' => [
                        'select' => $this->School->State->find('list')
                    ]
                )
            )
        );

        $this->Filter->setPaginate('order', 'School.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->School->recursive = 0;
        $this->set('schools', $this->Paginator->paginate());
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_view($id = null){
        if (!$this->School->exists($id)) {
            throw new NotFoundException(__('Invalid instructor'));
        }
        $options = array('conditions' => array('School.' . $this->School->primaryKey => $id));
        $this->School->Behaviors->load('Containable');
        $this->School->contain([
                'State',
                'City'
        ]);
        $this->set('school', $this->School->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    public function manager_add() {
        if ($this->request->is('post')) {
            $this->School->create();
            if ($this->School->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        $states = $this->School->State->find('list');
		$this->set(compact('states'));
    }

    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_edit($id = null) {
        if (!$this->School->exists($id)) {
            throw new NotFoundException(__('Invalid instructor'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->request->data['User']['name'] = $this->request->data['School']['name'];

            if ($this->School->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('School.' . $this->School->primaryKey => $id));
            $this->request->data = $this->School->find('first', $options);

            $this->set('cities', $this->School->City->find('list',['conditions'=>['City.state_id'=>$this->request->data['School']['state_id']]]));
        }
        $states = $this->School->State->find('list');
        $this->set(compact('states'));
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_delete($id = null) {
        $this->School->id = $id;
        if (!$this->School->exists()) {
            throw new NotFoundException(__('Invalid instructor'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->School->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect(array('action' => 'index', 'manager' => true));
    }
}
