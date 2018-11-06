<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Notepads Controller
 *
 */
class NotepadsController extends AppController {

    public function save(){

        if ($this->request->is('post')) {
            if( $this->Auth->user('id') ){
                $notepad = $this->Notepad->findByUserId($this->Auth->user('id'));
                if( !empty($notepad) ){
                    $this->Notepad->id = $notepad['Notepad']['id'];
                    $this->Notepad->saveField('description', $this->request->data['Notepad']['description']);
                    $this->Session->setFlash(__('Anotação gravada com sucesso!'), '/site/popup-success'); 
                }else{

                    $this->Notepad->create();
                    $this->request->data['Notepad']['user_id'] = $this->Auth->user('id');
                    if ( $this->Notepad->save($this->request->data) ) {
                        $this->Session->setFlash(__('notação gravada com sucesso!'), 'site/popup-success');
                    } else {
                        $this->Session->setFlash(__('Erro ao gravar a anotação, tente novamente!'), 'manager/error');
                    }
                }
            }
        }
        return $this->redirect( $this->referer() );
    }
}