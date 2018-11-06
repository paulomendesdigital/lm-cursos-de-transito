<?php
App::uses('AppController', 'Controller');


class VirtualRoomForumsController extends AppController {

	public $components = array('Paginator');

	/* Listagem de fóruns do curso */
	public function index($id = null){

		$this->__verifySecurity( Group::ALUNO );

    	/* Validação de Token de acesso */
	    	$OrderCourse = $this->_accessCourseSecurity($id);
	    	if(!$OrderCourse){
	    		throw new NotFoundException(__('Invalid course'));
	    	}
	    	$course_id = $OrderCourse['OrderCourse']['course_id'];
	    	$citie_id = $OrderCourse['OrderCourse']['citie_id'];
	    	$state_id = $OrderCourse['OrderCourse']['state_id'];

    	/* Consulta a configuação do curso */
    		$course = $this->_findCourse($course_id);
			if(!$course){
	    		throw new NotFoundException(__('Invalid course'));
	    	}

	    	$this->loadModel('Forum');
	    	$this->Forum->Behaviors->load('Containable');
	    	$this->Paginator->settings = [
	    		'fields' => ['name', 'forum_post_count', 'created'],
	    		'contain' => [
	    			'Course' => [
	    				'fields' => ['id', 'name', 'firstname']
	    			],
	    			'User' => [
	    				'fields' => ['id','name', 'avatar']
	    			],
	    			'ForumPost' => [
	    				'User' => ['fields' => ['id', 'name','created', 'avatar'], 'Group' => ['fields' => 'name']],
	    				'conditions' => ['ForumPost.status' => 1],
						'fields' => ['user_id', 'created'],
						'order' => ['ForumPost.created' => 'DESC'],
	    				'limit' => 1
	    			]
	    		],
		        'conditions' => [
		        	'Course.id' => $course_id, 
		        	//'Forum.citie_id' => $citie_id,
		        	//'Forum.state_id' => $state_id,
		        	'Forum.status' => 1, 
		        	'Course.status' => 1, 
	        	],
		        'limit' => Configure::read('ResultPage')
		    ];
	    	$forums = $this->Paginator->paginate('Forum');
		    $this->set(compact('course', 'forums'));
	}

		
	//criar topico
	public function add($id = null) {

		$this->__verifySecurity( Group::ALUNO );
		$idToken   = $id;

		if( $id and empty($this->request->data) ){
        	/* Validação de Token de acesso */
        	$OrderCourse = $this->_accessCourseSecurity($id);
	    	if(!$OrderCourse){
	    		throw new NotFoundException(__('Invalid course'));
	    	}
	    	$course_id = $OrderCourse['OrderCourse']['course_id'];
	    	$citie_id  = $OrderCourse['OrderCourse']['citie_id'];
	    	$state_id  = $OrderCourse['OrderCourse']['state_id'];
			$idToken   = $id;

    		/* Consulta a configuação do curso */
    		$course = $this->_findCourse($course_id);
			if(!$course){
	    		throw new NotFoundException(__('Invalid course'));
	    	}
	    	$this->set(compact('course'));
		}

        if ($this->request->is('post')) {
        	$this->loadModel('Forum');
        	$this->request->data['Forum']['user_id'] = $this->Auth->user('id');
            $this->Forum->create();
            if ($this->Forum->save($this->request->data)) {
            	$this->Session->setFlash(__('The has been saved.'), 'manager/success');
                return $this->redirect( ['action'=>'index', $this->request->data['Forum']['idToken']] );
            } else {
                $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
            }
	    	$course_id = $this->request->data['Forum']['course_id'];
	    	$citie_id  = $this->request->data['Forum']['citie_id'];
	    	$state_id  = $this->request->data['Forum']['state_id'];
	    	$idToken   = $this->request->data['Forum']['idToken'];
        }
		$this->set(compact('order_id','course_id','citie_id','state_id','idToken'));
    }

	public function posts($course_id = null, $forum_id = null){
		$this->__verifySecurity( Group::ALUNO );

		/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($course_id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Invalid course'));
    	}
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id  = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id  = $OrderCourse['OrderCourse']['state_id'];

    	/* Validação de Token de acesso */
    	$forum_id = $this->_accessForumPostSecurity($forum_id);
    	if(!$forum_id){
    		throw new NotFoundException(__('Invalid forum'));
    	}

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id);
		if(!$course){
    		throw new NotFoundException(__('Invalid course'));
    	}
	    	
    	$this->loadModel('ForumPost');
    	$this->ForumPost->Behaviors->load('Containable');
    	$this->Paginator->settings = [
    		'contain' => [
				'User' => ['fields' => ['id', 'name', 'forum_post_count', 'avatar'], 'Group' => ['fields' => 'name']],
				'ForumPostComment' => [
					'conditions' => [
						'ForumPostComment.status' => 1
					],
					'fields' => ['text', 'created'], 
					'User' => ['conditions' => ['User.status' => 1],'fields' => ['id', 'name','forum_post_count', 'avatar'], 'Group' => ['fields' => 'name']]
				]
    		],
    		'conditions' => [
    			'ForumPost.forum_id' => $forum_id,
    			'ForumPost.status' => 1,
    			'User.status' => 1,
    		],
    		'order' => ['ForumPost.id' => 'ASC'],
    		'limit' => Configure::read('ResultPage')
    	];
    	$forum_posts = $this->Paginator->paginate('ForumPost');

		$this->loadModel('Forum');
    	$this->Forum->Behaviors->load('Containable');
    	$this->Forum->contain('User');
    	$forum = $this->Forum->read(null, $forum_id);

		$this->set(compact('forum_posts', 'forum', 'course'));
	}

	public function forum_post($course_id = null, $forum_id = null){
		$this->__verifySecurity( Group::ALUNO );

		/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($course_id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Invalid course'));
    	}
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id  = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id  = $OrderCourse['OrderCourse']['state_id'];

    	/* Validação de Token de acesso */
    	$forum_id = $this->_accessForumPostSecurity($forum_id);
    	if(!$forum_id){
    		throw new NotFoundException(__('Invalid forum'));
    	}

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id);
		if(!$course){
    		throw new NotFoundException(__('Invalid course'));
    	}

    	if(isset($this->request->data)):
    		$this->loadModel('ForumPost');

    		$this->request->data['ForumPost']['forum_id'] = $forum_id;
    		$this->request->data['ForumPost']['user_id'] = $this->Auth->user('id');
    		$this->request->data['ForumPost']['status'] = Configure::read('ForumPostStatus');

    		$this->ForumPost->create();
    		if($this->ForumPost->save($this->request->data)):
    			$this->Session->setFlash(__('Parabéns! Resposta enviada com sucesso!'), 'site/success');
    			return $this->redirect($this->referer());
			else:
				$this->Session->setFlash(__('Ops! Algo ocorreu de errado, envie novamente sua resposta.'), 'site/error');
    			return $this->redirect($this->referer());
			endif;
		endif;
	}

	public function forum_post_comment($course_id = null, $forum_id = null){
		$this->__verifySecurity( Group::ALUNO );

		/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($course_id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Invalid course'));
    	}
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id  = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id  = $OrderCourse['OrderCourse']['state_id'];

    	/* Validação de Token de acesso */
    	$forum_id = $this->_accessForumPostSecurity($forum_id);
    	if(!$forum_id){
    		throw new NotFoundException(__('Invalid forum'));
    	}

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id);
		if(!$course){
    		throw new NotFoundException(__('Invalid course'));
    	}

    	if(isset($this->request->data)):
    		$this->loadModel('ForumPostComment');
    		$this->request->data['ForumPostComment']['user_id'] = $this->Auth->user('id');
    		$this->request->data['ForumPostComment']['status'] = Configure::read('ForumPostCommentStatus');
    		$this->ForumPostComment->create();
    		if($this->ForumPostComment->save($this->request->data)):
    			$this->Session->setFlash(__('Parabéns! Comentário enviado com sucesso!'), 'site/success');
    			return $this->redirect($this->referer());
			else:
				$this->Session->setFlash(__('Ops! Algo ocorreu de errado, envie novamente sua resposta.'), 'site/error');
    			return $this->redirect($this->referer());
			endif;
		endif;
	}

}