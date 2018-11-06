<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2017
 * @author Grupo Grow - www.grupogrow.com.br
 * PollResponses Controller
 *
 * @property Poll $Poll
 * @property PaginatorComponent $Paginator
 */
class PollResponsesController extends AppController {
        
    public function add(){

        if ($this->request->is('post')) {
            $this->PollResponse->create();
            if ($this->PollResponse->saveAll($this->request->data)) {
                $this->Session->setFlash('Obrigado pela sua avaliação!','site/popup-success');
                return $this->redirect($this->referer());
            } else {
                $this->Session->setFlash('Erro ao gravar sua avaliação!','site/popup-error');
                return $this->redirect($this->referer());
            }
        }
    }
}
