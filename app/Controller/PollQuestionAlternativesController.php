<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * PollQuestionAlternatives Controller
 *
 * @property PollQuestionAlternative $PollQuestionAlternative
 * @property PaginatorComponent $Paginator
 */
class PollQuestionAlternativesController extends AppController {

    /**
    * Components
    *
    * @var array
    */
	public $components = array('Paginator');
        
    /**
    * manager_add method
    *
    * @return void
    */
    public function manager_add( $poll_question_id = false ) {

        if ($this->request->is('post')) {

            $poll_question_id = $this->request->data['PollQuestionAlternative']['poll_question_id'];
            $this->PollQuestionAlternative->create();
            //die(debug($this->request->data));
            if ($this->PollQuestionAlternative->saveAll($this->request->data)) {
            
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                return $this->redirect(array('controller'=>'poll_questions','action'=>'edit', $poll_question_id,'manager'=>true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        }

        if( !$poll_question_id ){
            return $this->redirect( $this->referer() );
        }

        $poll_question = $this->PollQuestionAlternative->PollQuestion->findById($poll_question_id);
		$this->set(compact('poll_question'));
    }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_edit($id = null) {

        if (!$this->PollQuestionAlternative->exists($id)) {
            throw new NotFoundException(__('Invalid question alternative'));
        }

        $poll_question_id = false;
        
        if ($this->request->is(array('post', 'put'))) {
            $poll_question_id = $this->request->data['PollQuestionAlternative']['poll_question_id'];
            if ($this->PollQuestionAlternative->save($this->request->data)) {
                $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                if(isset($this->request->data['aplicar'])){
                    return $this->redirect($this->referer());
                }
                return $this->redirect(array('controller'=>'poll_questions','action'=>'edit', $poll_question_id,'manager'=>true));
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
        } else {
            $options = array('conditions' => array('PollQuestionAlternative.' . $this->PollQuestionAlternative->primaryKey => $id));

            $this->PollQuestionAlternative->Behaviors->load('Containable');
            $this->PollQuestionAlternative->contain(['PollQuestion']);
            $this->request->data = $this->PollQuestionAlternative->find('first', $options);
            $poll_question_id = $this->request->data['PollQuestion']['id'];
        }
        
		$poll_questions = $this->PollQuestionAlternative->PollQuestion->findById($poll_question_id);
        $this->set(compact('poll_questions'));
    }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_delete($id = null) {
        $this->PollQuestionAlternative->id = $id;
        if (!$this->PollQuestionAlternative->exists()) {
            throw new NotFoundException(__('Invalid question'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->PollQuestionAlternative->delete()) {
            $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
        } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
        }
        return $this->redirect( $this->referer() );
    }
}
