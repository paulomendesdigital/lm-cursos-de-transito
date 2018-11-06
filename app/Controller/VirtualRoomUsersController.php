<?php
App::uses('AppController', 'Controller');
class VirtualRoomUsersController extends AppController {

	public function edit(){
		$this->__verifySecurity(Group::ALUNO);
		$this->loadModel('User');

		if ( $this->request->is(array('post', 'put')) ) {

			//Salvando os dados
			$this->request->data['User']['id'] = $this->Auth->user('id');
			$this->request->data['User']['group_id'] = $this->Auth->user('group_id');

			if( $this->Auth->user('cpf') ){
				$this->request->data['User']['cpf'] = $this->Auth->user('cpf');
			}else{
				unset($this->request->data['User']['cpf']);
			}

			if ( $this->User->saveAll($this->request->data, ['deep'=>true]) ) {
                $this->Session->setFlash(__('Dados atualizados com sucesso!'), 'site/popup-success');

                //verifico se tem produtos no carrinho e direciono para so checkout
	            $session_id = $this->__getSessionId();        
	        	$carts = $this->__getCartsInSession($session_id);
	            if( !empty($carts) ){
	            	return $this->redirect( "/orders/payment" );
	            }
            } else {
                $this->Session->setFlash(__('Erro ao tentar atualizar seu cadastro!'), 'site/popup-error');
            }
		}

		$this->User->Behaviors->load('Containable');
		$this->User->contain([
			'Student',
			'Order' => [
				'OrderType' => ['fields' => ['name']]
			]
		]);
		$this->request->data = $this->User->read(null, $this->Auth->user('id'));

		unset($this->request->data['User']['password']);

		if( !empty($this->request->data['Student'][0]['state_id']) ){
            $this->set('cities', $this->User->Student->City->find('list',['conditions'=>['City.state_id'=>$this->request->data['Student'][0]['state_id']]]));
        }

		$states = $this->User->Student->State->find('list', array('fields' => array('id', 'name'), 'order' => 'State.name ASC'));
        $this->set(compact('states'));
	}
}