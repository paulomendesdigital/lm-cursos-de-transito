<?php
App::uses('AppController', 'Controller');


class VirtualRoomDirectMessagesController extends AppController {

	public $components = array('Paginator');

	/* Visualização das mensagens com instrutor */
	public function view($course_id = null, $course_instructor_id = null){
		$this->__verifySecurity(4);

    	/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($course_id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Invalid course'));
		}
    	$course_id = $OrderCourse['OrderCourse']['course_id'];

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id);
		if(!$course){
    		throw new NotFoundException(__('Invalid course'));
    	}

    	/* Consulta a configuação do instrutor */
		$CourseInstructor = $this->_accessDirectMessageSecurity($course_instructor_id);
		if(!$CourseInstructor){
    		throw new NotFoundException(__('Invalid course'));
    	}

    	$this->loadModel('DirectMessage');
    	$this->DirectMessage->Behaviors->load('Containable');
    	$direct_messages = $this->DirectMessage->find('all', [
    		'contain' => [
	    		'User' => [
	    			'fields' => ['id', 'name', 'avatar']
	    		],
    			'Instructor' => [
    				'fields' => ['id', 'name'],
    				'User' => ['fields' => ['id', 'avatar']]
    			]
    		],
    		'conditions' => [
    			'DirectMessage.instructor_id' => $CourseInstructor['CourseInstructor']['instructor_id'],
    			'DirectMessage.user_id' => $this->Auth->user('id'),
    			'DirectMessage.status' => 1,
    		],
    		'order' => ['DirectMessage.created' => 'DESC']
		]);
    	
		$instructor_id = $CourseInstructor['CourseInstructor']['instructor_id'];

	    $this->set(compact('course', 'direct_messages', 'instructor_id'));
	}

	/* Atualiza a leitura da mensagem ao acessar */
	public function update_view_user($course_id = null, $course_instructor_id = null){
		$this->autoRender = false;
		$this->__verifySecurity(4);

    	/* Validação de Token de acesso */
	    	$OrderCourse = $this->_accessCourseSecurity($course_id);
	    	if(!$OrderCourse){
	    		throw new NotFoundException(__('Invalid course'));
    		}

		/* Consulta a configuação do instrutor */
    		$CourseInstructor = $this->_accessDirectMessageSecurity($course_instructor_id);
			if(!$CourseInstructor){
	    		throw new NotFoundException(__('Invalid course'));
	    	}

    	$instructor_id = $CourseInstructor['CourseInstructor']['instructor_id'];

    	$this->loadModel('DirectMessage');
		$this->DirectMessage->updateAll(['view_user'=>1], ['DirectMessage.instructor_id'=>$instructor_id,'DirectMessage.user_id' => $this->Auth->user('id')]);
	}

	public function add($course_id = null, $course_instructor_id = null){

		$this->__verifySecurity(4);

    	/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($course_id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Invalid course'));
		}

		/* Consulta a configuação do instrutor */
		$CourseInstructor = $this->_accessDirectMessageSecurity($course_instructor_id);
		if(!$CourseInstructor){
    		throw new NotFoundException(__('Invalid course'));
    	}

    	$instructor_id = $CourseInstructor['CourseInstructor']['instructor_id'];

    	if( isset($this->request->data) ):
    		$this->loadModel('DirectMessage');

    		$this->request->data['DirectMessage']['instructor_id'] = $instructor_id;
    		$this->request->data['DirectMessage']['user_id'] = $this->Auth->user('id');
    		$this->request->data['DirectMessage']['author'] = 'Student';
    		$this->request->data['DirectMessage']['view_user'] = 1;
    		$this->request->data['DirectMessage']['view_instructor'] = 0;
    		$this->request->data['DirectMessage']['status'] = Configure::read('DirectMessageStatus');
    		//die(debug($this->request->data));
    		$this->DirectMessage->create();
    		if($this->DirectMessage->save($this->request->data)):
    			// $this->Session->setFlash(__('Parabéns! Resposta enviada com sucesso!'), 'site/success');
    			return $this->redirect($this->referer());
			else:
				// $this->Session->setFlash(__('Ops! Algo ocorreu de errado, envie novamente sua resposta.'), 'site/error');
    			return $this->redirect($this->referer());
			endif;
		endif;
	}
}