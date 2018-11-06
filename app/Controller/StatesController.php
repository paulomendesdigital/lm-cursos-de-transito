<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * States Controller
 *
 * @property State $State
 * @property PaginatorComponent $Paginator
 */
class StatesController extends AppController {

    public function ajax_getStateIdByUf($uf){
        $this->autoRender = false;
        $this->layout = 'ajax';

        $state = $this->State->find('first',['fields'=>['State.id'],'conditions'=>['State.abbreviation'=>$uf]]);
        return isset($state['State']['id']) && !empty($state['State']['id']) ? $state['State']['id'] : false;
    }

    public function cities($id){
        $this->autorender = false;
        $this->layout = false;
        $this->State->Behaviors->load('Containable');
        $state = $this->State->find('first', ['contain' => ['City'],'conditions' => ['State.id' => $id]]);
        $this->set(compact('state'));
        $this->render('/Elements/manager/cities');
    }  
}