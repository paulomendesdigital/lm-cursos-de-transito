<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserQuestionOptions Controller
 *
 * @property UserQuestionOption $UserQuestionOption
 * @property PaginatorComponent $Paginator
 */
class UserQuestionOptionsController extends AppController {

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
                    'UserQuestionOption.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'UserQuestionOption.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'UserQuestionOption.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->UserQuestionOption->recursive = 0;
        $this->set('userQuestionOptions', $this->Paginator->paginate());
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
        if (!$this->UserQuestionOption->exists($id)) {
            throw new NotFoundException(__('Invalid user question option'));
        }
        $options = array('conditions' => array('UserQuestionOption.' . $this->UserQuestionOption->primaryKey => $id));
        $this->set('userQuestionOption', $this->UserQuestionOption->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->UserQuestionOption->create();
            if ($this->UserQuestionOption->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$userQuestions = $this->UserQuestionOption->UserQuestion->find('list');
		$questionAlternativeOptionUsers = $this->UserQuestionOption->QuestionAlternativeOptionUser->find('list');
		$this->set(compact('userQuestions', 'questionAlternativeOptionUsers'));
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
        if (!$this->UserQuestionOption->exists($id)) {
            throw new NotFoundException(__('Invalid user question option'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->UserQuestionOption->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('UserQuestionOption.' . $this->UserQuestionOption->primaryKey => $id));
            $this->request->data = $this->UserQuestionOption->find('first', $options);
        }
        
        		$userQuestions = $this->UserQuestionOption->UserQuestion->find('list');
		$questionAlternativeOptionUsers = $this->UserQuestionOption->QuestionAlternativeOptionUser->find('list');
		$this->set(compact('userQuestions', 'questionAlternativeOptionUsers'));
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
        $this->UserQuestionOption->id = $id;
        if (!$this->UserQuestionOption->exists()) {
            throw new NotFoundException(__('Invalid user question option'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->UserQuestionOption->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
