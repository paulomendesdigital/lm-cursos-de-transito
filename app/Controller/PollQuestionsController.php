<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * PollQuestions Controller
 *
 * @property PollQuestion $PollQuestion
 * @property PaginatorComponent $Paginator
 */
class PollQuestionsController extends AppController {

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

    public function manager_index( $poll_id = false ){

        if( !$poll_id ){
            return $this->redirect( $this->referer() ) ;
        }

        $this->Filter->setPaginate('order', 'PollQuestion.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->PollQuestion->Behaviors->load('Containable');
        $this->PollQuestion->contain(['PollQuestionAlternative']);
        $this->set('pollQuestions', $this->Paginator->paginate());

        $poll = $this->PollQuestion->Poll->findById($poll_id);
        $this->set(compact('poll'));
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_view($id = null){
        if (!$this->PollQuestion->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative'));
        }
        $options = array('conditions' => array('PollQuestion.' . $this->PollQuestion->primaryKey => $id));
        $this->set('pollQuestion', $this->PollQuestion->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    public function manager_add( $poll_id = false ) {

        if( !$poll_id ){
            $this->Session->setFlash(__('Enquete não localizada!'), 'manager/error');
            return $this->redirect(array('controller'=>'polls','action'=>'index','manager'=>true));
        }
        if ($this->request->is('post')) {

            $poll_id = $this->request->data['PollQuestion']['poll_id'];

            if( Configure::read('Sistems.DataDefaultPollQuestionAlternatives') ){
                $this->request->data['PollQuestionAlternative'] = Configure::read('Sistems.DataDefaultPollQuestionAlternatives');
            }

            $this->PollQuestion->create();
            if ($this->PollQuestion->saveAll($this->request->data,['deep'=>true])) {
            
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                return $this->redirect( array('action'=>'index', $poll_id,'manager'=>true) );
                return $this->redirect(array('action'=>'edit', $this->PollQuestion->id,'manager'=>true));

            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }

        if( !$poll_id ){
            return $this->redirect( $this->referer() );
        }

        $poll = $this->PollQuestion->Poll->findById($poll_id);
		$this->set(compact('poll'));
    }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function manager_edit($id = null) {

        if (!$this->PollQuestion->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative'));
        }

        $poll_id = false;
        
        if ($this->request->is(array('post', 'put'))) {
            $poll_id = $this->request->data['PollQuestion']['poll_id'];
            if ($this->PollQuestion->saveAll($this->request->data,['deep'=>true])) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('action'=>'index', $poll_id,'manager'=>true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('PollQuestion.' . $this->PollQuestion->primaryKey => $id));
            $this->request->data = $this->PollQuestion->find('first', $options);
            $poll_id = $this->request->data['Poll']['id'];
        }
        
		$poll = $this->PollQuestion->Poll->findById($poll_id);
        $this->set(compact('poll'));
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_delete($id = null) {
        $this->PollQuestion->id = $id;
        if (!$this->PollQuestion->exists()) {
            throw new NotFoundException(__('Invalid question'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->PollQuestion->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect( $this->referer() );
    }
}
