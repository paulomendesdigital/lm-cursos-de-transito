<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserQuestions Controller
 *
 * @property UserQuestion $UserQuestion
 * @property PaginatorComponent $Paginator
 */
class UserQuestionsController extends AppController {

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
                    'UserQuestion.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'UserQuestion.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'UserQuestion.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->UserQuestion->recursive = 0;
        $this->set('userQuestions', $this->Paginator->paginate());
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
        if (!$this->UserQuestion->exists($id)) {
            throw new NotFoundException(__('Invalid user question'));
        }
        $options = array('conditions' => array('UserQuestion.' . $this->UserQuestion->primaryKey => $id));
        $this->UserQuestion->Behaviors->load('Containable');
        $this->UserQuestion->contain([
            'User',
            'Module',
            'Course',
            'UserQuestionOption' => ['QuestionAlternativeOptionUser' => ['QuestionAlternative' => ['QuestionAlternativeOption'], 'QuestionAlternativeOption']],
        ]);
        // die(debug($this->UserQuestion->find('first', $options)));
        $this->set('userQuestion', $this->UserQuestion->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->UserQuestion->create();
            if ($this->UserQuestion->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
        		$users = $this->UserQuestion->User->find('list');
		$modules = $this->UserQuestion->Module->find('list');
		$courses = $this->UserQuestion->Course->find('list');
		$this->set(compact('users', 'modules', 'courses'));
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
        if (!$this->UserQuestion->exists($id)) {
            throw new NotFoundException(__('Invalid user question'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->UserQuestion->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('UserQuestion.' . $this->UserQuestion->primaryKey => $id));
            $this->request->data = $this->UserQuestion->find('first', $options);
        }
        
        		$users = $this->UserQuestion->User->find('list');
		$modules = $this->UserQuestion->Module->find('list');
		$courses = $this->UserQuestion->Course->find('list');
		$this->set(compact('users', 'modules', 'courses'));
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
        $this->UserQuestion->id = $id;
        if (!$this->UserQuestion->exists()) {
            throw new NotFoundException(__('Invalid user question'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->UserQuestion->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
    }

    public function manager_dashboard($user_id=null){
        
        if( !$user_id ){
            return $this->redirect( $this->referer() );
        }

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'UserQuestion.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'UserQuestion.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->UserQuestion->Behaviors->load('Containable');
        $userQuestions = $this->UserQuestion->find('all',[
            'contain'=>[
                'Module',
                'User'
            ],
            'conditions'=>['UserQuestion.user_id'=>$user_id,'UserQuestion.result'=>1]
        ]);

        $categories = $data = $dataFinal = [];
        foreach($userQuestions as $userQuestion){
            if( !empty($userQuestion['Module']['id']) ){
                $categories[] = $userQuestion['Module']['name'];
                $data[] = (float) $userQuestion['UserQuestion']['value_result'];
            }else{
                $categories[] = 'Prova Final';
                $data[] = (float) $userQuestion['UserQuestion']['value_result'];
            }
        }
        //die(debug($categories));
        $categories = json_encode($categories);
        $data = json_encode($data);
//die(debug($data));
        $this->set(compact('userQuestions', 'categories', 'data'));
        //die(debug($userQuestions));
    }
}
