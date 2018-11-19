<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * QuestionAlternativeOptions Controller
 *
 * @property QuestionAlternativeOption $QuestionAlternativeOption
 * @property PaginatorComponent $Paginator
 */
class QuestionAlternativeOptionsController extends AppController {

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
                    'QuestionAlternativeOption.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'QuestionAlternativeOption.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'QuestionAlternativeOption.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->QuestionAlternativeOption->recursive = 0;
        $this->set('questionAlternativeOptions', $this->Paginator->paginate());
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
        if (!$this->QuestionAlternativeOption->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative option'));
        }
        $options = array('conditions' => array('QuestionAlternativeOption.' . $this->QuestionAlternativeOption->primaryKey => $id));
        $this->set('questionAlternativeOption', $this->QuestionAlternativeOption->find('first', $options));
    }

        
    /**
    * add method
    *
    * @return void
    */
    
    public function add() 
    {
        if ($this->request->is('post')) {
        
            $this->QuestionAlternativeOption->create();
            if ($this->QuestionAlternativeOption->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$questionAlternatives = $this->QuestionAlternativeOption->QuestionAlternative->find('list');
		$this->set(compact('questionAlternatives'));
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
        if (!$this->QuestionAlternativeOption->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative option'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->QuestionAlternativeOption->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => false));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('QuestionAlternativeOption.' . $this->QuestionAlternativeOption->primaryKey => $id));
            $this->request->data = $this->QuestionAlternativeOption->find('first', $options);
        }
        
        		$questionAlternatives = $this->QuestionAlternativeOption->QuestionAlternative->find('list');
		$this->set(compact('questionAlternatives'));
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
        $this->QuestionAlternativeOption->id = $id;
        if (!$this->QuestionAlternativeOption->exists()) {
            throw new NotFoundException(__('Invalid question alternative option'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->QuestionAlternativeOption->delete()) {
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
                    'QuestionAlternativeOption.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'QuestionAlternativeOption.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'QuestionAlternativeOption.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->QuestionAlternativeOption->recursive = 0;
        $this->set('questionAlternativeOptions', $this->Paginator->paginate());
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
        if (!$this->QuestionAlternativeOption->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative option'));
        }
        $options = array('conditions' => array('QuestionAlternativeOption.' . $this->QuestionAlternativeOption->primaryKey => $id));
        $this->set('questionAlternativeOption', $this->QuestionAlternativeOption->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add($question_alternative_id=false) {
        if ($this->request->is('post')) {
            $this->QuestionAlternativeOption->create();
            if ($this->QuestionAlternativeOption->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                if( $this->Session->read('manualRedirect') ){
                    return $this->redirect( $this->Session->read('manualRedirect') );
                }else{
                    return $this->redirect(array('action' => 'index', 'manager' => true));
                }
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }
        if( $question_alternative_id ){
            $this->request->data['QuestionAlternativeOption']['question_alternative_id'] = $question_alternative_id;
            $this->Session->write('manualRedirect', $this->referer());
        }
		$questionAlternatives = $this->QuestionAlternativeOption->QuestionAlternative->find('list', array('fields'=>array('id','text')));
		$this->set(compact('questionAlternatives'));
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
        if (!$this->QuestionAlternativeOption->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative option'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->QuestionAlternativeOption->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action' => 'index', 'manager' => true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('QuestionAlternativeOption.' . $this->QuestionAlternativeOption->primaryKey => $id));
            $this->request->data = $this->QuestionAlternativeOption->find('first', $options);
        }
        
		$questionAlternatives = $this->QuestionAlternativeOption->QuestionAlternative->find('list', array('fields'=>array('id','text')));
		$this->set(compact('questionAlternatives'));
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
        $this->QuestionAlternativeOption->id = $id;
        if (!$this->QuestionAlternativeOption->exists()) {
            throw new NotFoundException(__('Invalid question alternative option'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->QuestionAlternativeOption->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
