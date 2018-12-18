<?php
App::uses('AppController', 'Controller');

class VirtualRoomsController extends AppController {

	public function contact_us(){
		$this->__verifySecurity( $this->Group->getAluno() );
	}

	public function school_contact_us(){
		$this->__verifySecurity( $this->Group->getAluno() );
	}

	/* Lista de compras realizadas */
	public function index(){

	    $this->loadModel('OrderCourse');
	    $this->loadModel('Payment');

		$this->__verifySecurity( $this->OrderCourse->Order->User->Group->getAluno() );
		$this->OrderCourse->Behaviors->load('Containable');
		$order_courses = $this->OrderCourse->find('all', [
			'contain' => [
				'Order' => ['fields' => ['Order.id', 'Order.user_id', 'Order.created'],'OrderType' => ['fields' => ['OrderType.name', 'OrderType.class']]],
				'Course' => ['fields' => ['Course.id','Course.name','Course.image','Course.image_dir','Course.text']],
			],
			'conditions' => [
				'OrderCourse.order_id' => $this->OrderCourse->Order->find('list',[
					'fields'=>[
						'Order.id'
					], 
					'conditions' => [
						'Order.user_id' => $this->Auth->user('id'),
						'Order.order_type_id' =>[
							$this->Payment->getStatusAprovado(),
							$this->Payment->getStatusDisponivel()
						]
					]
				]),	
				'Order.user_id' => $this->Auth->user('id')			
			]
		]);		
		$this->set(compact('order_courses'));
	}

    /* Acesso ao curso */
    public function course($id = null){
    	$token = $id;
    	$this->__verifySecurity( $this->Group->getAluno() );

    	/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Curso Inválido'));
		}

    	$order_id = $OrderCourse['OrderCourse']['order_id'];
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id = $OrderCourse['OrderCourse']['state_id'];

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id, $order_id);
		if(!$course){
    		throw new NotFoundException(__('Curso Inválido'));
		}
		
		/* texto do padrão do botão para pesquisa de satisfação do curso */
		$btnAnswer = 'Responder Agora';

		/* Modifica o texto do padrão do botão para pesquisa de satisfação do curso */
		if($course['Course']['id'] == 1) {
			$btnAnswer = 'Responda Agora para Imprimir Certificado';
		}

		$this->__SetModulesCourse($token, $OrderCourse, $course);

		$this->__SetPoll();
		$this->set('scheduling_link_detran', $this->__GetSchedulingLinkDetran($course, $state_id, $btnAnswer));
	}

	/*
	* seta a avalicao do curso para a view
	*/
	private function __SetPoll(){
		$this->loadModel('Poll');
		$this->Poll->Behaviors->load('Containable');
		$poll = $this->Poll->find('first',[
			'contain'=>[
				'PollQuestion'=>['PollQuestionAlternative']
			],
			'conditions'=>[
				'Poll.status'=>1,
				'NOT'=>[
					'Poll.id'=>$this->Poll->PollResponse->find('list',[
						'fields'=>['PollResponse.poll_id'],
						'conditions'=>['PollResponse.user_id'=>$this->Auth->user('id')]
					])
				]
			]
		]);
		$this->set(compact('poll'));
	}

	/*
	* seta os modulos do curso para a view 
	*/
	private function __SetModulesCourse($token, $OrderCourse, $course){

		$order_id = $OrderCourse['OrderCourse']['order_id'];
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id = $OrderCourse['OrderCourse']['state_id'];

		$conditionsModuleCourse = $this->__getConditionsForScope($course_id, $course['CourseType']['scope'], $state_id, $citie_id);

    	/* Consulta da lista de módulos */
    	$this->loadModel('ModuleCourse');
    	$this->ModuleCourse->Behaviors->load('Containable');
    	$module_courses = $this->__getCourseModules($conditionsModuleCourse, $order_id);
		$modules = $this->_DtoModuleCourse($module_courses);
		$course['Course']['avaliation'] = $this->__getConfigAvaliationCourse($course, $modules);

		$this->set(compact('course', 'modules', 'token', 'state_id'));
	}

	/* Acesso as disciplinas do curso */
	public function discipline($course = null, $id = null, $page = 0){
		$token = $id;
		$this->__verifySecurity( $this->Group->getAluno() );

	   	/* Validação de Token de acesso da disciplina */
	   	$id = $this->_accessDisciplineSecurity($id);
	   	if(!$id){
	   		throw new NotFoundException(__('Disciplina Inválida'));
	   	}

	  	/* Validação de Token de acesso do curso */
	   	$OrderCourse = $this->_accessCourseSecurity($course);
	   	if(!$OrderCourse){
	   		throw new NotFoundException(__('Curso Inválido'));
	   	}

	   	$order_id = $OrderCourse['OrderCourse']['order_id'];
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id = $OrderCourse['OrderCourse']['state_id'];

	   	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id);
		if(!$course){
	   		throw new NotFoundException(__('Curso Inválido'));
	   	}

	    /* Limita a quantidade de minutos ao estudo de acordo com o curso */
	    // COMENTADO AQUI PARA PERMITIR ACESSAR SLIDE JÁ ESTUDADO MESMO COM O LIMITE ULTRAPASSADO
	   	//$limitMaxTimeCourse = $this->_limitMaxTimeCourse($course);
	   	//if($limitMaxTimeCourse){
	   	//	throw new NotFoundException(__('Limite de acesso diário atingido!'));
	   	//}

	   	/* Controle de acesso apenas ao conteúdo sequencial */
		$this->loadModel('UserModuleLog');
		$t_log = $this->UserModuleLog->find('count', ['conditions' => [
	 				'UserModuleLog.user_id' => $this->Auth->user('id'),
	   				'UserModuleLog.module_discipline_id' => $id,
	   				'UserModuleLog.order_id' => $order_id
				]]);

		if($page > $t_log):
			throw new UnauthorizedException(__('Por Favor, siga a sequência correta dos slides!'));
		endif;

	   	/* Listagem do conteúdo da disciplina */
	   	$this->loadModel('ModuleDiscipline');
	   	$this->ModuleDiscipline->Behaviors->load('Containable');
	   	$module_discipline = $this->ModuleDiscipline->find('first', [
    		'contain' => [
    			'Module' => [
    				'fields' => ['name','is_introduction']
    			],
    			'ModuleDisciplinePlayer' => [
    				'conditions' => ['ModuleDisciplinePlayer.status' => 1],
    				'order' => ['ModuleDisciplinePlayer.position' => 'ASC'],
    				'UserModuleLog' => [
	    				'fields' => ['id','time'],
	    				'conditions' => [
    						'UserModuleLog.model' => 'ModuleDisciplinePlayer',
	    					'UserModuleLog.user_id' => $this->Auth->user('id'),
	    					'UserModuleLog.order_id' => $order_id,
    					]
	    			]
    			],
    		 	'ModuleDisciplineSlider' => [
    		 		'fields' => ['id', 'name', 'text', 'audio'],
    				'conditions' => ['ModuleDisciplineSlider.status' => 1],
    				'order' => ['ModuleDisciplineSlider.position' => 'ASC'],
	    			'UserModuleLog' => [
	    				'fields' => ['id','time'],
	    				'conditions' => [
	    					'UserModuleLog.model' => 'ModuleDisciplineSlider',
	    					'UserModuleLog.user_id' => $this->Auth->user('id'),
	    					'UserModuleLog.order_id' => $order_id,
    					]
	    			]
    			],
		 	],
    		'fields' => ['name','value_time'],
    		'conditions' => ['ModuleDiscipline.id' => $id, 'ModuleDiscipline.status' => 1]
		]);

		if( isset($module_discipline['ModuleDisciplineSlider'][$page]['UserModuleLog']) and !empty($module_discipline['ModuleDisciplineSlider'][$page]['UserModuleLog']) ){
			$this->set(compact('course', 'module_discipline', 'token'));
		}else{
			/* Limita a quantidade de minutos ao estudo de acordo com o curso */
		   	$limitMaxTimeCourse = $this->_limitMaxTimeCourse($course);

		   	if($limitMaxTimeCourse){
		   		throw new NotFoundException(__('Limite de acesso diário atingido!'));
		   	}else{
		   		$this->set(compact('course', 'module_discipline', 'token'));
		   	}
		}

		//para exibir a lista de modulos na coluna da direira
		$this->__SetModulesCourse($token, $OrderCourse, $course);
		$this->__SetPoll();
	} 

	/*Progresso do curso*/
	public function course_progress($id = null){
		$token = $id;
    	$this->__verifySecurity( $this->Group->getAluno() );

    	/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

    	$order_id = $OrderCourse['OrderCourse']['order_id'];
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id = $OrderCourse['OrderCourse']['state_id'];

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id, $order_id);
		if(!$course){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

    	$conditionsModuleCourse = $this->__getConditionsForScope($course_id, $course['CourseType']['scope'], $state_id, $citie_id);

    	/* Consulta da lista de módulos */
    	$this->loadModel('ModuleCourse');
    	$this->ModuleCourse->Behaviors->load('Containable');
    	$module_courses = $this->__getCourseModules($conditionsModuleCourse, $order_id);
		$modules = $this->_DtoModuleCourse($module_courses);

		$course['Course']['avaliation'] = $this->__getConfigAvaliationCourse($course, $modules);

		$course_workbooks = $this->Course->CourseWorkbook->__getCourseWorkbooks($course_id);

    	$this->set(compact('course', 'modules', 'course_workbooks', 'token'));
	}

	/* Acesso ao simulado do módulo */
	public function simulate_modules($course = null, $id = null){

		$this->__verifySecurity( $this->Group->getAluno() );

    	/* Validação de Token de acesso ao Modulo */
    	$id = $this->_accessSimulateModuleSecurity($id);
    	if(!$id){
    		throw new NotFoundException(__('Simulado Inválido'));
    	}

    	/* Validação de Token de acesso do curso */
    	$OrderCourse = $this->_accessCourseSecurity($course);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Curso Inválido'));
    	}
    	$course_id = $OrderCourse['OrderCourse']['course_id'];

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id);
		if(!$course){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

    	/* Consulta as questões para simulado */
		$this->loadModel('Module');
		$this->Module->Behaviors->load('Containable');
		$questions = $this->Module->find('first', [
			'contain' => [
				'QuestionAlternative' => [
					'fields' => ['QuestionAlternative.text'],
					'conditions' => ['QuestionAlternative.status' => 1],
					'order' => 'rand()',
					'limit' => $course['Course']['qt_question_module_avaliation'],
					
					'QuestionAlternativeOption' => [
						'fields' => ['id', 'name'],
						'conditions' => ['QuestionAlternativeOption.status' => 1]
					]
				]
			],
			'conditions' => [
				'Module.id' => $id
			]
		]);

		$this->set(compact('course', 'questions'));
    }

    /* Acesso ao simulado do curso - Prova Final */
	public function simulate_courses($course = null, $id = null){
		
		$this->__verifySecurity($this->Group->getAluno());

    	/* Validação de Token de acesso ao Modulo */
    	$id = $this->_accessSimulateCourseSecurity($id);
    	if(!$id){
    		throw new NotFoundException(__('Simulado Inválido'));
    	}

    	/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($course);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Curso Inválido'));
    	}
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id = $OrderCourse['OrderCourse']['state_id'];

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id);
		if(!$course){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

    	$conditionsModuleCourse = $this->__getConditionsForScope($course_id, $course['CourseType']['scope'], $state_id, $citie_id);

    	/* Consulta da lista de módulos */
    	$this->loadModel('ModuleCourse');
    	$this->ModuleCourse->Behaviors->load('Containable');
    	$module_courses = $this->ModuleCourse->find('all', [
    		'contain' => [
    			'Module' => [
    				'QuestionAlternative' => [
    					'fields' => ['QuestionAlternative.text'],
    					'conditions' => ['QuestionAlternative.status' => 1],
    					'order' => 'rand()',
    					
    					'QuestionAlternativeOption' => [
    						'fields' => ['id', 'name'],
    						'conditions' => ['QuestionAlternativeOption.status' => 1]
						],
					],
					'fields' => ['id', 'name', 'value_time'],
					'conditions' => ['Module.status' => 1],
					'order' => 'rand()'
				]
			],
			'fields' => ['id', 'module_id', 'course_id', 'citie_id', 'state_id'],
    		'conditions' => [
    			$conditionsModuleCourse
    			//'ModuleCourse.course_id' => $course_id,
    			//'ModuleCourse.citie_id' => $citie_id,
    			//'ModuleCourse.state_id' => $state_id
    		],
    		'order' => 'rand()'
		]);

		$questions = $this->_simulateCourseQuestions($module_courses, $course['Course']['qt_question_course_avaliation']);

		$this->set(compact('course','questions'));
    }

	/* Grava o log de acesso a cada conteúdo de cada disciplina, via ajax */
	public function user_module_logs($course_id = null, $discipline_id = null){
		$this->__verifySecurity( $this->Group->getAluno() );
		//echo $course_id . " - " . $discipline_id;
		
		$this->autoRender = false;
		
		/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($course_id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

    	$order_id 	= $OrderCourse['OrderCourse']['order_id'];
    	$course_id 	= $OrderCourse['OrderCourse']['course_id'];
    	$citie_id 	= $OrderCourse['OrderCourse']['citie_id'];
    	$state_id 	= $OrderCourse['OrderCourse']['state_id'];

		$discipline_id = $this->_accessDisciplineSecurity($discipline_id);
    	if(!$discipline_id){
    		throw new NotFoundException(__('Disciplina Inválida'));
    	}

    	/* Identifica qual módulo pertence a disciplina */
    	$this->loadModel('ModuleDiscipline');
    	$this->ModuleDiscipline->Behaviors->load('Containable');
    	$this->ModuleDiscipline->contain('Module');
    	$module_discipline = $this->ModuleDiscipline->read(null, $discipline_id);
    	
    	$this->request->data['UserModuleLog']['time'] = $this->_qtTimeDiscipline($module_discipline['Module']['id'], $module_discipline);

    	/* Monta os dados para salvar */
		$this->request->data['UserModuleLog']['order_id'] = $order_id;
		$this->request->data['UserModuleLog']['user_id'] = $this->Auth->user('id');
		$this->request->data['UserModuleLog']['module_id'] = $module_discipline['Module']['id'];
		$this->request->data['UserModuleLog']['module_discipline_id'] = $discipline_id;

		if($_POST['is_slider_id']):
			$this->request->data['UserModuleLog']['model'] = 'ModuleDisciplineSlider';
			$this->request->data['UserModuleLog']['modelid'] = $_POST['is_slider_id'];
		elseif($_POST['is_player_id']):
			$this->request->data['UserModuleLog']['model'] = 'ModuleDisciplinePlayer';
			$this->request->data['UserModuleLog']['modelid'] = $_POST['is_player_id'];
		endif;

		$this->loadModel('UserModuleLog');
		if( $this->UserModuleLog->save( $this->request->data ) ){

			$countSliders = $module_discipline['ModuleDiscipline']['module_discipline_slider_count'] + $module_discipline['ModuleDiscipline']['module_discipline_player_count'];
			$countSlidersAssistidos = $this->UserModuleLog->__getCountUserModuleLog($order_id, $this->Auth->user('id'), $discipline_id);

			if( $countSlidersAssistidos >= $countSliders ):
				/* Libera próximo módulo quando chegar ao final dos estudos do módulo atual */
				$this->loadModel('UserModuleSummary');
				$this->UserModuleSummary->__desblockNextModule($order_id, $this->Auth->user('id'), $course_id, $module_discipline['Module']['id']);

			endif;
			return true;
		}
	}

	/* Grava a resposta dos questionários */
	public function question_alternative_option_users($token_course = null, $modelid = null){

		//$token_course = $course_id;
		/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($token_course);

    	if(!$OrderCourse){
    		throw new NotFoundException(__('Curso Inválido'));
    	}
    	$order_id = $OrderCourse['OrderCourse']['order_id'];
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id = $OrderCourse['OrderCourse']['state_id'];

		/* Validação de Token de acesso ao Modulo */
    	$id = $this->_accessSimulateModuleSecurity($modelid);
    	if(!$id){
    		/* Validação de Token de acesso ao Modulo */
	    	$id = $this->_accessSimulateCourseSecurity($modelid);
	    	if(!$id){
	    		throw new NotFoundException(__('Simulado Inválido'));
	    	}
    	}

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id);
		if(!$course){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

		if ($this->request->is('post')) {
            session_regenerate_id();
            $this->loadModel('QuestionAlternativeOptionUser');
            $this->QuestionAlternativeOptionUser->create();
            if ($this->QuestionAlternativeOptionUser->saveAll($this->request->data)) {
            	$question_alternative_option_users = $this->QuestionAlternativeOptionUser->find('all', [
        			'conditions' => ['QuestionAlternativeOptionUser.sessionid' => session_id()]
        		]);
                $this->_UserQuestion($id, $course, $question_alternative_option_users, $token_course, $order_id);
            }else{
            	return $this->redirect(array('action'=>'course', $token_course, 'manager' => false));
            	//die(debug($this->QuestionAlternativeOptionUser->validationErrors));
            }
        }
	}

	public function simulate_result($course_id = null, $id){
		
		$this->__verifySecurity($this->Group->getAluno());

		/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($course_id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Curso Inválido'));
    	}
    	$course_id = $OrderCourse['OrderCourse']['course_id'];
    	$citie_id = $OrderCourse['OrderCourse']['citie_id'];
    	$state_id = $OrderCourse['OrderCourse']['state_id'];
			
		/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id);
		if(!$course){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

    	$this->loadModel('UserQuestion');
    	$this->UserQuestion->Behaviors->load('Containable');
        $contain = [
            'UserQuestionOption' => ['QuestionAlternativeOptionUser' => ['QuestionAlternative' => ['QuestionAlternativeOption'], 'QuestionAlternativeOption']],
        ];
    	$userQuestion = $this->UserQuestion->find('first', ['contain' => $contain, 'conditions' =>[
    		'UserQuestion.user_id' => $this->Auth->user('id'),
    		'UserQuestion.id' => $id
		]]);
		$this->set(compact('course', 'userQuestion'));
	}

	/* Impressão de certificado em PDF (Não Concluído) */
	public function certificate($id) {

		$this->__verifySecurity( $this->Group->getAluno() );

    	/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

    	$user_id = $this->Auth->user('id');

    	$order_id 	= $OrderCourse['OrderCourse']['order_id'];
    	$course_id 	= $OrderCourse['OrderCourse']['course_id'];
    	$citie_id 	= $OrderCourse['OrderCourse']['citie_id'];
    	$state_id 	= $OrderCourse['OrderCourse']['state_id'];
		
		/* Identificar o início do curso */
	    $this->loadModel('Order');
	    $this->Order->recursive = -1;
	    $order = $this->Order->findById($order_id);

	    /* Consulta a configuação do curso e os dados da conclusão */
		$course = $this->_findCourse($course_id, $order_id);

		if(!$course){
			throw new NotFoundException(__('Curso Inválido'));
    	}

    	$this->loadModel('UserCertificate');
    	$UserCertificate = $this->UserCertificate->__getCertificate($order_id, $user_id, $course_id);

    	$conditionsModuleCourse = $this->__getConditionsForScope($course_id, $course['CourseType']['scope'], $state_id, $citie_id);
		
		/* Consulta da lista de módulos */
    	$this->loadModel('ModuleCourse');
    	$module_courses = $this->ModuleCourse->__getModuleCourseInOrder($order_id, $user_id, $conditionsModuleCourse, $course);

	    if( empty($UserCertificate) ){

	    	//criando o certificado
	    	if( !$this->UserCertificate->__createCertificate($order, $user_id, $course, $module_courses) ){
	    		throw new NotFoundException(__('Não foi possível gerar o certificado!'));
	    	}
	    }
	    else{

	    	//atualizando dados do certificado
	    	if( !$this->UserCertificate->__updateCertificate($order, $user_id, $course, $module_courses, $UserCertificate) ){
	    		throw new NotFoundException(__('Não foi possível gerar o certificado!'));
	    	}
		}

	    //recarrega UserCertificate
		$UserCertificate = $this->UserCertificate->__getCertificate($order_id, $user_id, $course_id);

	    $this->__printCertificate( $order_id,  $UserCertificate);
	}

	private function __printCertificate($order_id, $UserCertificate){
		$params = array(
	        'download' => false,
	        'name' => "certificado-{$order_id}.pdf",
	        'paperOrientation' => 'landscape',
	        'paperSize' => 'A4'
	    );
	    $data = array(
	    	'certificateNumber' => $this->__MaskOrderId( $UserCertificate['UserCertificate']['id'] ),
	    	'username' 			=> $UserCertificate['User']['name'],
	    	'cpf' 				=> $UserCertificate['User']['cpf'],
	    	'courseTitle' 		=> $UserCertificate['UserCertificate']['course_name'],
	    	'startDate' 		=> $UserCertificate['UserCertificate']['start'],
	    	'finishDate' 		=> $UserCertificate['UserCertificate']['finish'],
	    	'score' 			=> $UserCertificate['UserCertificate']['score'],
	    	'workload' 			=> $this->UserCertificate->__getTotalWorkload($UserCertificate['UserCertificateModule']),
	    	'city' 				=> 'Rio de Janeiro',
	    	'description' 		=> $this->__getDescriptionForCertificate($UserCertificate),
	    	'Modules' 			=> $UserCertificate['UserCertificateModule'],
	    	'Instructor'		=> [
	    		'name'	=>	'ANDRE LUIS FERREIRA DOS SANTOS',
	    		'cpf'	=>	'112.875.967-54'
	    	],
	    	'imgVersoBase64' 		=> base64_encode(file_get_contents('img/certificate/background3.png')),
			'imgAssinaturasBase64' 	=> base64_encode(file_get_contents('img/certificate/assinatura-dupla-v2.png')),
			'qrCode' => base64_encode(file_get_contents('https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=https://lmcursosdetransito.com.br/pages/certificate/' . $UserCertificate['UserCertificate']['user_id']))
    	);

	    $this->set('data',$data);
		$this->set($params);

	    $this->render('reciclagem');
	}

	/* Lista de apostilas cadastrados */
	public function workbooks($id = null, $course_id=null){
		$token = $id;
    	$this->__verifySecurity( $this->Group->getAluno() );

    	if(!$course_id){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

	    $this->loadModel('CourseWorkbook');
		$this->CourseWorkbook->Behaviors->load('Containable');
		$workbooks = $this->CourseWorkbook->find('all', [
			'contain' => [
				'Course' => ['fields' => ['Course.id','Course.name','Course.image','Course.image_dir','Course.text']],
			],
			'conditions' => [	
				'CourseWorkbook.status' => 1,
				'CourseWorkbook.course_id'=>$course_id		
			],
			'order'=>['CourseWorkbook.id'=>'DESC']
		]);

		$this->set(compact('workbooks', 'token'));
	}

	/* Lista de livros cadastrados */
	public function libraries($id = null, $course_id=null){
		$token = $id;
    	$this->__verifySecurity( $this->Group->getAluno() );

    	if(!$course_id){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

	    $this->loadModel('CourseLibrary');
		$this->CourseLibrary->Behaviors->load('Containable');
		$libraries = $this->CourseLibrary->find('all', [
			'contain' => [
				'Course' => ['fields' => ['Course.id','Course.name','Course.image','Course.image_dir','Course.text']],
			],
			'conditions' => [	
				'CourseLibrary.status' => 1			
			],
			'order'=>['CourseLibrary.id'=>'DESC']
		]);		
		$this->set(compact('libraries','token'));
	}

	/* Lista da sala multimidia */
	public function multimidias($id = null, $course_id=null){
		$token = $id;
    	$this->__verifySecurity( $this->Group->getAluno() );

    	if(!$course_id){
    		throw new NotFoundException(__('Curso Inválido'));
    	}

	    $this->loadModel('CourseMultimidia');
		$this->CourseMultimidia->Behaviors->load('Containable');
		$midias = $this->CourseMultimidia->find('all', [
			'contain' => [
				'Course' => ['fields' => ['Course.id','Course.name','Course.image','Course.image_dir','Course.text']],
			],
			'conditions' => [	
				'CourseMultimidia.status' => 1			
			],
			'order'=>['CourseMultimidia.id'=>'DESC']
		]);	

		$this->set(compact('midias','token','course_id'));
	}

	/* view da sala multimidia */
	public function multimidia($midia_id, $id = null, $course_id){
		$token = $id;
    	$this->__verifySecurity( $this->Group->getAluno() );
    	
	    $this->loadModel('CourseMultimidia');
		$this->CourseMultimidia->Behaviors->load('Containable');
		$midia = $this->CourseMultimidia->find('first', [
			'contain' => [
				'Course' => ['fields' => ['Course.id','Course.name','Course.image','Course.image_dir','Course.text']],
			],
			'conditions' => [	
				'CourseMultimidia.id' => $midia_id			
			]
		]);	

		$this->set(compact('midia','token', 'course_id'));
	}

	public function contact_team($id = null){
		$token = $id;
    	$this->__verifySecurity( $this->Group->getAluno() );

		if ( $this->request->is('post') ) {
			$token = $id = $this->request->data['Contact']['token'];
			$template = 'pages_contact';

            $Sistems = Configure::read('Sistems');
            
            $data = array(
                'template' => $template, // Template do email
                'to' => $Sistems['EmailTo'], // Destino do email
                'subject' => '[Contato do Site] '.$this->request->data['Contact']['subject'], // Assunto do email
                'content' => array(
                    'name' => $this->request->data['Contact']['name'],
                    'email' => $this->request->data['Contact']['email'],
                    'phone' => $this->request->data['Contact']['phone'],
                    'subject' =>  $this->request->data['Contact']['subject'],
                    'messenger' => $this->request->data['Contact']['message']
                )
            );            

            try {
                $this->__SendMail($data);
                $this->Session->setFlash('Sua mensagem foi enviada com sucesso!','site/popup-success');
                return $this->redirect($this->referer());
            } catch (Exception $ex) {
                $this->Session->setFlash('Erro ao enviar o email. Tente novamente mais tarde.','site/popup-error');
                return $this->redirect($this->referer());                
            }
		}else{
			$this->request->data['Contact']['name'] = $this->Auth->user('name');
			$this->request->data['Contact']['email'] = $this->Auth->user('email');
		}

    	/* Validação de Token de acesso */
    	$OrderCourse = $this->_accessCourseSecurity($id);
    	if(!$OrderCourse){
    		throw new NotFoundException(__('Curso Inválido'));
    	}
    	$order_id 	= $OrderCourse['OrderCourse']['order_id'];
    	$course_id 	= $OrderCourse['OrderCourse']['course_id'];
    	$citie_id 	= $OrderCourse['OrderCourse']['citie_id'];
    	$state_id 	= $OrderCourse['OrderCourse']['state_id'];

    	/* Consulta a configuação do curso */
		$course = $this->_findCourse($course_id, $order_id);
		if(!$course){
    		throw new NotFoundException(__('Curso Inválido'));
    	}
    	//
    	$this->set(compact('token','course'));
	}

	public function biometria_facial($id = null){
		$this->layout = 'webcam';
		$token = $id;
    	$this->__verifySecurity( $this->Group->getAluno() );

		$this->Session->write('StartBiometria', true);
		if( !$this->Session->read('StartBiometriaUrlReturn') ){
			$this->Session->write('StartBiometriaUrlReturn', $this->referer());
		}
	}

	public function send_biometria_facial($id = null){
		$this->autoRender = false;
		$this->layout = 'webcam';

		$this->loadModel('Webcam');
		$snapshot = $this->Webcam->sendImage();

		if( $snapshot ){
			$avatar = "files/user/avatar/".$this->Auth->user('id')."/vga_".$this->Auth->user('avatar');

			if( $this->Webcam->compare( $avatar, $snapshot ) ){
				$referer = $this->Session->read('StartBiometriaUrlReturn');
				$this->Session->delete('StartBiometria');
				$this->Session->delete('StartBiometriaUrlReturn');

				$this->Session->setFlash('Biometria Facial validada com sucesso!','site/popup-success');
				echo $referer;
			}else{
				$this->Session->setFlash('Biometria Facial inválida!','site/popup-error');
				echo $this->referer();
			}
		}
	}

	//temporário: para teste do Detran
	public function send_biometria_facial_temp($type='avatar'){
		$this->autoRender = false;
		$this->layout = 'webcam';

		$this->loadModel('Webcam');
		$snapshot = $this->Webcam->sendImage($type);

		if( $snapshot and $type == 'avatar' ){

			copy( "{$snapshot}", 'facereco/refimg.jpg' );
			
			if( $this->Webcam->saveImage($snapshot, $this->Auth->user('id')) ){
				$dataAuth = $this->Session->read('Auth');
				$dataAuth['User']['avatar'] = $snapshot;
				$this->Session->write('Auth', $dataAuth);
				echo $this->Webcam->showImage($type);
			}
		}
		elseif( $snapshot and $type == 'unknown' ){
			copy( "{$snapshot}", 'facereco/unknown.jpg' );
			echo $this->Webcam->showImage($type);
		}
	}

	public function compare($url='http://192.168.2.1:5000') {
		$this->autoRender = false;
		$this->layout = 'webcam';

		@header("Access-Control-Allow-Origin: *");
		$curl = curl_init($url);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		
		$ret= curl_exec($curl);

		curl_close($curl);
		
		return $ret;
	}
}
