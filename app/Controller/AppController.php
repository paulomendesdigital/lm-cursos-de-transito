<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @
CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $helpers = array(
		'Html' => array('className' => 'BootstrapHtml'),
		'Form' => array('className' => 'BootstrapForm'),
		'Paginator' => array('className' => 'BootstrapPaginator'),
		'Session',
		/*'FilterResults.Search' => array(
			'operators' => array(
				'LIKE' => 'containing',
				'NOT LIKE' => 'not containing',
				'LIKE BEGIN' => 'starting with',
				'LIKE END' => 'ending with',
				'=' => 'equal to',
				'!=' => 'different',
				'>' => 'greater than',
				'>=' => 'greater or equal to',
				'<' => 'less than',
				'<=' => 'less or equal to',
			),
		),*/
	);
	public $components = array(
		'Acl',
		'Acl.AclManager',
		'Auth' => array(
			'authorize' => array(
				'Actions' => array('actionPath' => 'controllers'),
			),
		),
		'Session',
		'Cookie',
		'RequestHandler',
		'FilterResults.Filter' => array(
			'auto' => array(
				'paginate' => false,
				'explode' => true, // recommended
			),
			'explode' => array(
				'character' => ' ',
				'concatenate' => 'AND',
			),
		),
	); 

	private function __setManagerAmbient(){
		$this->helpers['FilterResults.Search'] = array(
            'operators' => array(
                'LIKE' => 'containing',
                'NOT LIKE' => 'not containing',
                'LIKE BEGIN' => 'starting with',
                'LIKE END' => 'ending with',
                '=' => 'equal to',
                '!=' => 'different',
                '>' => 'greater than',
                '>=' => 'greater or equal to',
                '<' => 'less than',
                '<=' => 'less or equal to'
            )
        );

		Configure::write('Config.language', 'pt_br');
		$locale = Configure::read('Config.language');
		if ($locale && file_exists($locale . DS . $this->viewPath)) {
			// e.g. use /app/View/fra/Pages/tos.ctp instead of /app/View/Pages/tos.ctp
			$this->viewPath = $locale . DS . $this->viewPath;
		}

		//Acesso ao manager
		$this->Auth->authError = __('Você não tem permissão para acessar.', true);
		$this->Auth->autoRedirect = true;

		$this->Auth->authenticate = array(
			'Form' => array(
				'scope' => array(
					'User.status' => 1, 
					'User.group_id' => [Group::ADMINISTRADOR,Group::OPERADOR]
				),
			),
		);

		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action' => 'login',
			'manager' => true,
		);
		$this->Auth->loginRedirect = array(
			'controller' => 'pages',
			'action' => 'index',
			'manager' => true,
		);
		$this->Auth->logoutRedirect = array(
			'controller' => 'users',
			'action' => 'login',
			'manager' => true,
		);

		//$this->Auth->allow();
		$this->layout = 'manager';
	}

	private function __setSchoolAmbient(){
		$this->_CookieLogin();
			
		//Locale
		if ($this->Session->read('locale')):
			Configure::write('Config.language', $this->Session->read('locale'));
		else:
			Configure::write('Config.language', 'pt_br');
		endif;

		$locale = Configure::read('Config.language');
		if ($locale && file_exists($locale . DS . $this->viewPath)) {
			// e.g. use /app/View/fra/Pages/tos.ctp instead of /app/View/Pages/tos.ctp
			$this->viewPath = $locale . DS . $this->viewPath;
		}

		//Acesso de usuário comum
		$this->Auth->autoRedirect = true;
		$this->Auth->authenticate = array(
			'Form' => array(
				'scope' => array(
					'User.status' => 1, 
					'User.group_id' => [Group::ALUNO,Group::PARCEIRO],
					'User.school_id IS NOT NULL'
				),
			),
		);

		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action' => 'login',
			'school' => true,
		);

		if ($this->Session->read('autoRedirect')):
			$this->Auth->loginRedirect = $this->Session->read('autoRedirect');
		else:
			$this->Auth->loginRedirect = array(
				'controller' => 'meus-cursos',
				'action' => 'index',
				'school' => false,
			);
		endif;

		$this->Auth->logoutRedirect = array(
			'controller' => 'users',
			'action' => 'login',
			'school' => true,
		);

		$this->layout = 'school';
		$this->Auth->allow();
	}

	public function beforeFilter() {		
		
		$this->request->addDetector('ssl', array(
            'env' => 'HTTP_X_FORWARDED_PROTO',
            'value' => 'https'
        ));
        if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] == "http") {  
            return $this->redirect('https://' . env('SERVER_NAME') . $this->here); 
        }

		$this->loadModel('Group');
		$Sistems = Configure::read('Sistems');
		$Developer = Configure::read('Developer');
		$Auth = $this->Auth->user();
		$this->set(compact('Sistems', 'Developer', 'Auth'));

		$this->loadModel('CourseType');
		$this->loadModel('Payment');
		
		if ( isset($this->params['manager']) ) {

			$this->__setManagerAmbient();
		
		}
		elseif ( isset($this->params['school']) ) {

			$this->__setSchoolAmbient();

		}
		else{

			
			$this->_CookieLogin();
			
			//Locale
			if ($this->Session->read('locale')):
				Configure::write('Config.language', $this->Session->read('locale'));
			else:
				Configure::write('Config.language', 'pt_br');
			endif;

			$locale = Configure::read('Config.language');
			if ($locale && file_exists($locale . DS . $this->viewPath)) {
				// e.g. use /app/View/fra/Pages/tos.ctp instead of /app/View/Pages/tos.ctp
				$this->viewPath = $locale . DS . $this->viewPath;
			}

			/* Chave da sessão em Session */
			if($this->Session->check('user_bag')):
				$this->set('user_bag',$this->Session->read('user_bag'));
			else:
				$this->Session->write('user_bag',date('YmdHis'), true, Configure::read('TimeBag'));
			endif;

			//Acesso de usuário comum
			$this->Auth->autoRedirect = true;

			$this->Auth->authenticate = array(
				'Form' => array(
					'scope' => array('User.status' => 1, 'User.group_id' => [Group::ALUNO,Group::PARCEIRO]),
				),
			);

			$this->Auth->loginAction = array(
				'controller' => 'users',
				'action' => 'login',
				'manager' => false,
			);

			if ($this->Session->read('autoRedirect')):
				$this->Auth->loginRedirect = $this->Session->read('autoRedirect');
			else:
				$this->Auth->loginRedirect = array(
					'controller' => 'meus-cursos',
					'action' => 'index',
					'manager' => false,
				);
			endif;

			$this->Auth->logoutRedirect = array(
				'controller' => 'users',
				'action' => 'login',
				'manager' => false,
			);

			if( $this->__isVirtualRoomAmbient() ){
				$this->layout = 'default';
			}
			else{
				$this->layout = 'site';
			}

			$this->loadModel('Course');

			$this->Course->recursive = -1;
			$footer_courses = $this->Course->find('list',[
				'conditions'=>[
					'Course.course_type_id' => [$this->Course->CourseType->__getTaxiId(), $this->Course->CourseType->__getReciclagemId()]
				],
				'limit' => 2
			]);									

			$this->set('footer_courses',$footer_courses);
			$this->set('cartInSession',$this->__getCartsInSession( $this->__getSessionId() ));

			$this->Auth->allow();

		}
		
		//States DB
		if ($this->request->params['action'] != 'manager_install'):
			$this->loadModel('State');
			$states = $this->State->find('list', array('fields' => array('id', 'abbreviation'), 'order' => 'State.name ASC'));
			$this->set(compact('states'));
		endif;
	}

	private function checkAmbient(){

        if( isset($this->params['manager']) ){
            if( !empty($this->Auth->user('group_id')) ){
                switch ($this->Auth->user('group_id')) {
                    case Group::ADMINISTRADOR:
                        $this->Auth->logoutRedirect = array(
                            'controller' => 'users',
                            'action' => 'login',
                            'manager' => true
                        );
                        $this->redirect($this->Auth->logout());
                    case Group::CLIENTE:
                        $this->Auth->logoutRedirect = array(
                            'controller' => 'users',
                            'action' => 'login',
                            'manager' => false
                        );
                        $this->redirect($this->Auth->logout());
                    default:
                        break;
                }
            }

        }elseif( isset($this->params['vendor']) ){

            if( !empty($this->Auth->user('group_id')) ){
                switch ($this->Auth->user('group_id')) {
                    case Group::OPERADOR:
                        $this->Auth->logoutRedirect = array(
                            'controller' => 'users',
                            'action' => 'login',
                            'manager' => true
                        );
                        $this->redirect($this->Auth->logout());
                    case Group::GERENTE:
                        $this->Auth->logoutRedirect = array(
                            'controller' => 'users',
                            'action' => 'login',
                            'manager' => true
                        );
                        $this->redirect($this->Auth->logout());
                    case Group::CLIENTE:
                        $this->Auth->logoutRedirect = array(
                            'controller' => 'users',
                            'action' => 'login',
                            'vendor' => false
                        );
                        $this->redirect($this->Auth->logout());
                    default:
                        break;
                }
            }

        }else{

            if( $this->Auth->user() and !in_array($this->Auth->user('group_id'), [Group::CLIENTE]) ){
                $this->Auth->logoutRedirect = array(
                    'controller' => 'users',
                    'action' => 'login',
                    'prefix' => false
                );
                $this->redirect($this->Auth->logout());
            }
        }
    }

	public function __isVirtualRoomAmbient(){
		return in_array($this->params['controller'], ['virtual_rooms','virtual_room_forums','virtual_room_users','virtual_room_direct_messages','users']);
	}

	public function beforeRender() {
		
		// $this->set('user', $this->Auth->user());
	}

	/*
	 * __setAutoRedirect
	 * Função interna para __verifySecurity
	 *
	 */
	private function __setAutoRedirect() {
		$this->Session->write('autoRedirect', "/{$this->params->url}");
	}

	/*
	 * __verifySecurity
	 * Verificar o tipo de grupo de usuário que está acessando o url.
	 *
	 * Informe o id do grupo a permitir, e opcional, informe a url
	 * de redirecionamento caso o usuário não seja permitido.
	 */
	public function __verifySecurity($authGroup = null, $loginPersona = null) {
		if (!$this->Auth->user()):
			$this->__setAutoRedirect();
			if (!$loginPersona):
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
			else:
				$this->redirect($loginPersona);
			endif;

		else:
			$group_id = $this->Auth->user('group_id');
			if ($authGroup):
				if ($group_id != $authGroup):
					$this->__setAutoRedirect();
					$this->Session->setFlash(__('You do not have permission to access this page. Make your log-in'), 'site/error');
					$this->redirect(array('controller' => 'users', 'action' => 'logout'));
				endif;
			endif;
			if( $group_id == Group::ALUNO ):
				$this->__updateSessionAuth();
			endif;
		endif;
	}

	/*
    * Atualiza a Sessão de usuario logado incluindo os dados editados
    */
    public function __updateSessionAuth(){
        $this->loadModel('User');
        $dataAuth = $this->Session->read('Auth');
        
        $this->User->Behaviors->load('Containable');
        $user = $this->User->find('first', array(
            'contain' => array(
            	'School',
                'Student'=>[
                	'City',
                	'State',
                	'School'
                ],
                'Notepad'
            ),
            'conditions'=>array('User.id'=>$this->Auth->user('id'))
        ));
        if( !empty($user) ){
            //$dataAuth['User'] = $user['User'];
            //$dataAuth['User']['Group']   = $dataAuth['User']['Group'];
            $dataAuth['User']['Student'] = $user['Student'];
            $dataAuth['User']['Notepad'] = $user['Notepad'];

            $this->Session->write('Auth', $dataAuth);
        }
    }

	/*
	 * __AttachmentNormalize
	 * Utilizado para tratamento de nomes de arquivos que estão sendo enviados ao servidor (Upload)
	 */
	public function __AttachmentNormalize($Attachments, $mult = false) {
		if ($mult):
			$attachments = null;

			foreach ($Attachments as $Attachment):

				if ($Attachment['attachment']['name']):

					$string = $Attachment['attachment']['name'];

					$pathinfo = pathinfo($string);

					$string = $pathinfo['filename'];

					$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
					$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
					$string = utf8_decode($string);
					$string = strtr($string, utf8_decode($a), $b);
					$string = str_replace("&", "e", $string);
					$string = str_replace(" ", "-", $string);
					$string = str_replace(".", "", $string);
					$string = str_replace("!", "", $string);
					$string = str_replace("?", "", $string);
					$string = str_replace(":", "", $string);
					$string = str_replace(";", "", $string);
					$string = str_replace(";", "", $string);
					$string = str_replace(",", "", $string);
					$string = str_replace("'", "", $string);
					$string = str_replace("\"", "", $string);
					$string = str_replace("/", "", $string);
					$string = str_replace("|", "", $string);
					$string = str_replace("--", "-", $string);
					$string = str_replace("---", "-", $string);
					$string = str_replace("----", "-", $string);
					$string = strtolower($string);

					$Attachment['attachment']['name'] = $string . '.' . $pathinfo['extension'];

					$attachments[] = $Attachment;

				endif;

			endforeach;

			return $attachments;

		else:

			$pathinfo = pathinfo($Attachments);
			$string = $pathinfo['filename'];

			$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
			$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
			$string = utf8_decode($string);
			$string = strtr($string, utf8_decode($a), $b);
			$string = str_replace("-", "", $string);
			$string = str_replace("&", "e", $string);
			$string = str_replace(" ", "-", $string);
			$string = str_replace(".", "", $string);
			$string = str_replace("!", "", $string);
			$string = str_replace("?", "", $string);
			$string = str_replace(":", "", $string);
			$string = str_replace(";", "", $string);
			$string = str_replace(";", "", $string);
			$string = str_replace(",", "", $string);
			$string = str_replace("'", "", $string);
			$string = str_replace("\"", "", $string);
			$string = str_replace("/", "", $string);
			$string = str_replace("|", "", $string);
			$string = str_replace("--", "-", $string);
			$string = str_replace("---", "-", $string);
			$string = str_replace("----", "-", $string);
			$string = strtolower($string);

			return $string . '.' . $pathinfo['extension'];
		endif;

	}

	/*
	 * Função responsável por tratar uma string,
	 * retirando os espaços e caracteres especiais.
	 */
	public function __Normalize($string) {
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$string = utf8_decode($string);
		$string = strtr($string, utf8_decode($a), $b);
		$string = str_replace("-", "", $string);
		$string = str_replace("&", "e", $string);
		$string = str_replace(" ", "-", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace("!", "", $string);
		$string = str_replace("?", "", $string);
		$string = str_replace(":", "", $string);
		$string = str_replace(";", "", $string);
		$string = str_replace(";", "", $string);
		$string = str_replace(",", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("\"", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("|", "", $string);
		$string = str_replace("--", "-", $string);
		$string = str_replace("---", "-", $string);
		$string = str_replace("----", "-", $string);
		$string = strtolower($string);

		return utf8_encode($string);
	}

	public function __RemoveAcentos($string) {
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b);
        return utf8_encode($string);
    }

	public function __getPlacesJson(){
		$this->loadModel('Place');                
        $this->loadModel('State');
        $states = $this->State->find('list',array('fields'=>array('abbreviation','name')));

        $mappf = array();
        $places = $this->Place->find('all',array('fields'=>array('state','count(state) as result'),'group'=>array('state'),'conditions'=>array('type'=>0)));
        foreach($places as $place):
            $mappf[$place['Place']['state']] = array('result'=>$place[0]['result'],'title'=> $states[$place['Place']['state']]);            
        endforeach;           
        $mappfjson = json_encode($mappf);
        $this->set('mappf',$mappfjson);  

        $mappj = array();
        $places = $this->Place->find('all',array('fields'=>array('state','count(state) as result'),'group'=>array('state'),'conditions'=>array('type'=>1)));
        foreach($places as $place):
            $mappj[$place['Place']['state']] = array('result'=>$place[0]['result'],'title'=> $states[$place['Place']['state']]);            
        endforeach;           
        $mappjjson = json_encode($mappj);
        $this->set('mappj',$mappjjson);        

        $mapmv = array();
        $places = $this->Place->find('all',array('fields'=>array('state','count(state) as result'),'group'=>array('state'),'conditions'=>array('type'=>2)));
        foreach($places as $place):
            $mapmv[$place['Place']['state']] = array('result'=>$place[0]['result'],'title'=> $states[$place['Place']['state']]);            
        endforeach;           
        $mapmvjson = json_encode($mapmv);
        $this->set('mapmv',$mapmvjson);     
	}

	public function __SendMail($data) {

        $Sistems = Configure::read('Sistems');

        $Email = new CakeEmail('gmail');
		
        $Email->from(array($Sistems['EmailTo'] => $Sistems['EmailName']));        

        $Email->emailFormat('html');

        $Email->template(isset($data['template']) ? $data['template'] : 'default');
        $Email->to($data['to']);
        $Email->cc($Sistems['EmailCc'] ? $Sistems['EmailCc'] : null );        
        $Email->bcc($Sistems['EmailBcc'] ? $Sistems['EmailBcc'] : null );
        $Email->replyTo(isset($data['replyTo']) ? $data['replyTo'] : null );
        $Email->subject($data['subject']);
        $Email->viewVars(array('data' => $data));



        try {
            $Email->send($data['content']);
            return true;
        } catch (SocketException $ex) {
            CakeLog::write('error', 'Send Mail error!' . sprintf(' with message "%s"', $ex->getMessage()));
            throw $ex;
        }

        return false;
    }




    /* PRIVATE LMS ----------------------------------------------------------- */
    private function __isDisciplineComplete($module_discipline){
    	if( isset($module_discipline['UserModuleLog']) and !empty($module_discipline['UserModuleLog']) ){
    		return (int) (count($module_discipline['UserModuleLog']) >= $module_discipline['module_discipline_slider_count']);
    	}
    	else{
    		return 0;
    	}
    }

    private function __getProgressDisciplines($module_discipline){
    	if( isset($module_discipline['UserModuleLog']) and !empty($module_discipline['UserModuleLog']) ){
    		if( count($module_discipline['UserModuleLog']) >= $module_discipline['module_discipline_slider_count'] ){
    			return 100;
    		}
    		else{												
				return floor((100 * count($module_discipline['UserModuleLog']))/$module_discipline['module_discipline_slider_count']);
			}
    	}
    	else{
    		return 0;
    	}
    }

    private function __extractUserModuleLog($data){
    	if( (isset($data['UserModuleLog'][0]['id']) and !empty($data['UserModuleLog'][0]['id'])) ){
    		return [
    			'id' => $data['UserModuleLog'][0]['id'],
    			'module_id' => $data['UserModuleLog'][0]['module_id'],
    			't_time' => $data['UserModuleLog'][0]['UserModuleLog'][0]['t_time'],
    			'count' => $data['UserModuleLog'][0]['UserModuleLog'][0]['count']
    		];
    	}else{
    		return array();
    	}
    }

    private function __extractUserModuleSummary($data, $extraField='module_id'){
    	if( (isset($data['UserModuleSummary'][0]['id']) and !empty($data['UserModuleSummary'][0]['id'])) ){
    		return [
    			'id' => $data['UserModuleSummary'][0]['id'],
    			'user_id' => $data['UserModuleSummary'][0]['user_id'],
    			$extraField => $data['UserModuleSummary'][0][$extraField],
    			'desblock' => $data['UserModuleSummary'][0]['desblock'],
    		];
    	}else{
    		return array();
    	}
    }

    private function __isDisciplineDesblock($module_discipline){
    	return isset($module_discipline['UserModuleSummary'][0]['desblock']) ? $module_discipline['UserModuleSummary'][0]['desblock'] : 0;
    }

    private function __isModuleDesblock($module_course){
    	return isset($module_course['UserModuleSummary'][0]['desblock']) ? $module_course['UserModuleSummary'][0]['desblock'] : 0;
    }


    private function __setConfigModules($module_course){

    	return [
    		'id' 				=> $module_course['Module']['id'],
			'is_introduction' 	=> $module_course['Module']['is_introduction'],
			'name' 				=> $module_course['Module']['name'],
			'value_time' 		=> $module_course['Module']['value_time'],
			'text' 				=> $module_course['Module']['text'],
			'token' 			=> $module_course['Module']['token'],
			'module_discipline_count' 			=> $module_course['Module']['module_discipline_count'],
			'module_discipline_total_progress' 	=> 0,
			'progress' 		=> 0,
			'countSlides' 	=> 0,
			'countSlidesAssistidos' => 0,
			'desblock' 			=> $this->__isModuleDesblock($module_course['Module']),
			'UserModuleLog' 	=> $this->__extractUserModuleLog($module_course['Module']),
			'UserModuleSummary' => $this->__extractUserModuleSummary($module_course['Module']),
			'UserQuestion' 		=> $module_course['Module']['UserQuestion'],
			'ModuleDiscipline' 	=> $module_course['Module']['ModuleDiscipline']
    	];
    }


    private function __setConfigDisciplines($module_discipline, $carga_horaria_disciplinas){ 

    	return [
    		'id'    => $module_discipline['id'],
			'name'  => $module_discipline['name'],
			'token' => $module_discipline['token'],
			'hours' => $carga_horaria_disciplinas,
			'module_discipline_slider_count' => $module_discipline['module_discipline_slider_count'],
			'module_discipline_player_count' => $module_discipline['module_discipline_player_count'],
			'is_discipline_complete' => $this->__isDisciplineComplete($module_discipline),
			'countSlidesAssistidos' => count($module_discipline['UserModuleLog']),
			'progress' => $this->__getProgressDisciplines($module_discipline),
			'desblock' => $this->__isDisciplineDesblock($module_discipline),
			'UserModuleLog' => $module_discipline['UserModuleLog'],
			'UserModuleSummary' => $this->__extractUserModuleSummary( $module_discipline, 'module_discipline_id' )
    	];	
    }

	/* Dto para listagem de módulos do curso */
	public function _DtoModuleCourse($module_courses){

		$next_block_module = 0;
		$dto_modules = [];
		$allow_next_module = $allow_next_discipline = 0;

		foreach ($module_courses as $kay => $module_course) {

			$somaCargaHorariaDisciplinas = $slidersAssistidos = $progressModule = $countSliders = 0;
			$carga_horaria_disciplinas 	 = $this->_qtTimeDisciplineDTO($module_course['Module']);
			$dto_modules[$kay]['Module'] = $this->__setConfigModules($module_course);

			//tratando as disciplinas do modulo
			foreach ( $module_course['Module']['ModuleDiscipline'] as $key_module_discipline => $module_discipline ) {

				$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline] = $this->__setConfigDisciplines($module_discipline, $carga_horaria_disciplinas);
				
				$slidersAssistidos 	+= count($module_discipline['UserModuleLog']);
				$progressModule 	+= $dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['progress'];
				$countSliders 		+= $dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['module_discipline_slider_count'];

				if($next_block_module){
					$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['desblock'] = 0;
				}else{
					$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['desblock'] = isset($module_discipline['UserModuleSummary'][0]['desblock'])?$module_discipline['UserModuleSummary'][0]['desblock']:0;
				}
				
				$somaCargaHorariaDisciplinas += $carga_horaria_disciplinas;
			}
			//die(debug($module_course));
			//$dto_modules[$kay]['Module'] = $this->__setConfigModules($module_course);
			
			$dto_modules[$kay]['Module']['module_discipline_total_progress'] = $dto_modules[$kay]['Module']['progress'] = $progressModule;
			$dto_modules[$kay]['Module']['countSlidesAssistidos'] += $slidersAssistidos;
			$dto_modules[$kay]['Module']['countSlides'] += $countSliders;
			
			//die(debug($dto_modules));
			//ajustando carga horaria pra + ou pra -
			$diff = $module_course['Module']['value_time'] - $somaCargaHorariaDisciplinas;
			if( $diff <> 0 ){
				$i = 0;
	    		$cont = abs($diff);
		    	foreach ($module_course['Module']['ModuleDiscipline'] as $key_module_discipline => $module_discipline) {
					if( $i < $cont ){
						if ( $diff > 0 ){
							$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['hours'] += 1;
						}else{
							$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['hours'] -= 1;
						}
					}
					$i++;
				}
			}

			$dto_modules[$kay]['Module']['QuestionAlternative']['count'] = count($module_course['Module']['QuestionAlternative']);

			if($next_block_module){
				$dto_modules[$kay]['Module']['desblock'] = 0;
			}else{
				$dto_modules[$kay]['Module']['desblock'] = isset($module_course['Module']['UserModuleSummary'][0]['desblock'])?$module_course['Module']['UserModuleSummary'][0]['desblock']:0;
			}
			
			$dto_modules[$kay]['Module']['is_avaliation_result'] = isset($module_course['Module']['UserQuestion'][0]['result'])?$module_course['Module']['UserQuestion'][0]['result']:0;
			$dto_modules[$kay]['Module']['avaliation_value_result'] = isset($module_course['Module']['UserQuestion'][0]['value_result'])?$module_course['Module']['UserQuestion'][0]['value_result']:0;
			$dto_modules[$kay]['Module']['avaliation_result_id'] = isset($module_course['Module']['UserQuestion'][0]['id'])?$module_course['Module']['UserQuestion'][0]['id']:0;
			
			$dto_modules[$kay]['Course']['is_module_avaliation'] = $module_course['Course']['is_module_avaliation'];
			$dto_modules[$kay]['Course']['value_module_avaliation'] = $module_course['Course']['value_module_avaliation'];
			$dto_modules[$kay]['Course']['is_module_block'] = $module_course['Course']['is_module_block'];

			/* Bloqueia o acesso a avaliação do módulo, até a conclusão de assistir todas as disciplinas */
			$is_show_avaliation = 0;
			if( $module_course['Course']['is_module_avaliation'] && $module_course['Module']['is_introduction'] == false ){

				$is_show_avaliation = $this->__allowShowLinkAvaliation( $module_course['Module']['ModuleDiscipline'], $dto_modules[$kay]['Module']['countSlidesAssistidos'] );

				$t_time_module = isset($module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['t_time'])?$module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['t_time']:0;
				if($t_time_module < $module_course['Module']['value_time'] OR !$dto_modules[$kay]['Module']['desblock']){
					$is_show_avaliation = 0;
				}
			}

			$dto_modules[$kay]['Module']['is_show_avaliation'] = $is_show_avaliation;

			$t_time_module = isset($module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['t_time'])?$module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['t_time']:0;
			$is_time_complete = 1;			
			if($t_time_module < $module_course['Module']['value_time']){
				$is_time_complete = 0;
			}

			if( isset($module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['count']) ){
				//$dto_modules[$kay]['Module']['countSlidesAssistidos'] += $module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['count'];
			}

			$dto_modules[$kay]['Module']['is_time_complete'] = $is_time_complete;			

			//die(debug($dto_modules[$kay]['Module']));
			$count = $dto_modules[$kay]['Module']['module_discipline_count'] > 0 ? $dto_modules[$kay]['Module']['module_discipline_count'] : 1;
			$dto_modules[$kay]['Module']['progress'] = floor($dto_modules[$kay]['Module']['module_discipline_total_progress']/$count);
			/*if($dto_modules[$kay]['Module']['is_time_complete'] == 1){
				$dto_modules[$kay]['Module']['progress'] = 100;
			}else{
				$count_completed_disciplines = 0;
				if(!empty($dto_modules[$kay]['Module']['ModuleDiscipline'])){
					foreach($dto_modules[$kay]['Module']['ModuleDiscipline'] as $module_discipline){
						if($module_discipline['is_discipline_complete'] == 1){
							$count_completed_disciplines++;
						}
					}
					$dto_modules[$kay]['Module']['progress'] = floor((100 * $count_completed_disciplines) / count($dto_modules[$kay]['Module']['ModuleDiscipline']));
				}				

			}*/

			/* Bloqueia o acesso as disciplinas do próximo modulo até concluir a avaliação do módulo anterior */
			if( $module_course['Course']['is_module_block'] && $module_course['Module']['is_introduction'] == false ){
				$next_block_module = 1;
				if($module_course['Course']['is_module_avaliation'] && $dto_modules[$kay]['Module']['is_avaliation_result']){
					$next_block_module = 0;
				}
			}
		}
		//die(debug($dto_modules));
		return $dto_modules;
	}

	public function _DtoModuleCourse2($module_courses){

		$next_block_module = 0;
		$dto_modules = [];

		foreach ($module_courses as $kay => $module_course) {

			$carga_horaria_disciplinas = $this->_qtTimeDisciplineDTO($module_course['Module']);

			$dto_modules[$kay]['Module']['id'] = $module_course['Module']['id'];
			$dto_modules[$kay]['Module']['is_introduction'] = $module_course['Module']['is_introduction'];
			$dto_modules[$kay]['Module']['name'] = $module_course['Module']['name'];
			$dto_modules[$kay]['Module']['value_time'] = $module_course['Module']['value_time'];
			$dto_modules[$kay]['Module']['text'] = $module_course['Module']['text'];
			$dto_modules[$kay]['Module']['token'] = $module_course['Module']['token'];
			$dto_modules[$kay]['Module']['module_discipline_count'] = $module_course['Module']['module_discipline_count'];
			$dto_modules[$kay]['Module']['module_discipline_total_progress'] = 0;
			$dto_modules[$kay]['Module']['progress'] = 0;

			$somaCargaHorariaDisciplinas = 0;
			$dto_modules[$kay]['Module']['countSlides'] = $dto_modules[$kay]['Module']['countSlidesAssistidos'] = 0;

			foreach ($module_course['Module']['ModuleDiscipline'] as $key_module_discipline => $module_discipline) {

				$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['id']    = $module_discipline['id'];
				$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['name']  = $module_discipline['name'];
				$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['token'] = $module_discipline['token'];
				$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['hours'] = $carga_horaria_disciplinas;
				$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['module_discipline_slider_count'] = $module_discipline['module_discipline_slider_count'];
				$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['module_discipline_player_count'] = $module_discipline['module_discipline_player_count'];
				$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['is_discipline_complete'] = 0;
				
				if( isset($module_discipline['UserModuleLog']) and !empty($module_discipline['UserModuleLog']) ){
					
					if( count($module_discipline['UserModuleLog']) >= $module_discipline['module_discipline_slider_count'] ){						
						$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['is_discipline_complete'] = 1;
						$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['progress'] = 100;

					}else{												
						$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['progress'] = floor((100 * count($module_discipline['UserModuleLog']))/$module_discipline['module_discipline_slider_count']);
					}
					$dto_modules[$kay]['Module']['countSlidesAssistidos'] += count($module_discipline['UserModuleLog']);
				}else{

					$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['progress'] = 0;
				}				
				$dto_modules[$kay]['Module']['module_discipline_total_progress'] += $dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['progress'];

				if($next_block_module){
					$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['desblock'] = 0;
				}else{
					$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['desblock'] = isset($module_discipline['UserModuleSummary'][0]['desblock'])?$module_discipline['UserModuleSummary'][0]['desblock']:0;
				}
				
				$somaCargaHorariaDisciplinas += $carga_horaria_disciplinas;
			}

			//ajustando carga horaria pra + ou pra -
			$diff = $module_course['Module']['value_time'] - $somaCargaHorariaDisciplinas;
			if( $diff <> 0 ){
				$i = 0;
	    		$cont = abs($diff);
		    	foreach ($module_course['Module']['ModuleDiscipline'] as $key_module_discipline => $module_discipline) {
					if( $i < $cont ){
						if ( $diff > 0 ){
							$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['hours'] += 1;
						}else{
							$dto_modules[$kay]['Module']['ModuleDiscipline'][$key_module_discipline]['hours'] -= 1;
						}
					}
					$i++;
				}
			}

			$dto_modules[$kay]['Module']['QuestionAlternative']['count'] = count($module_course['Module']['QuestionAlternative']);

			if($next_block_module){
				$dto_modules[$kay]['Module']['desblock'] = 0;
			}else{
				$dto_modules[$kay]['Module']['desblock'] = isset($module_course['Module']['UserModuleSummary'][0]['desblock'])?$module_course['Module']['UserModuleSummary'][0]['desblock']:0;
			}
			
			$dto_modules[$kay]['Module']['is_avaliation_result'] = isset($module_course['Module']['UserQuestion'][0]['result'])?$module_course['Module']['UserQuestion'][0]['result']:0;
			$dto_modules[$kay]['Module']['avaliation_value_result'] = isset($module_course['Module']['UserQuestion'][0]['value_result'])?$module_course['Module']['UserQuestion'][0]['value_result']:0;
			$dto_modules[$kay]['Module']['avaliation_result_id'] = isset($module_course['Module']['UserQuestion'][0]['id'])?$module_course['Module']['UserQuestion'][0]['id']:0;
			$dto_modules[$kay]['Course']['is_module_avaliation'] = $module_course['Course']['is_module_avaliation'];
			$dto_modules[$kay]['Course']['value_module_avaliation'] = $module_course['Course']['value_module_avaliation'];
			$dto_modules[$kay]['Course']['is_module_block'] = $module_course['Course']['is_module_block'];

			/* Bloqueia o acesso a avaliação do módulo, até a conclusão de assistir todas as disciplinas */
			$is_show_avaliation = 0;
			if( $module_course['Course']['is_module_avaliation'] && $module_course['Module']['is_introduction'] == false ){

				$is_show_avaliation = $this->__allowShowLinkAvaliation( $module_course['Module']['ModuleDiscipline'], $dto_modules[$kay]['Module']['countSlidesAssistidos'] );

				$t_time_module = isset($module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['t_time'])?$module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['t_time']:0;
				if($t_time_module < $module_course['Module']['value_time'] OR !$dto_modules[$kay]['Module']['desblock']){
					$is_show_avaliation = 0;
				}
			}

			$dto_modules[$kay]['Module']['is_show_avaliation'] = $is_show_avaliation;

			$t_time_module = isset($module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['t_time'])?$module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['t_time']:0;
			$is_time_complete = 1;			
			if($t_time_module < $module_course['Module']['value_time']){
				$is_time_complete = 0;
			}

			if( isset($module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['count']) ){
				//$dto_modules[$kay]['Module']['countSlidesAssistidos'] += $module_course['Module']['UserModuleLog'][0]['UserModuleLog'][0]['count'];
			}

			$dto_modules[$kay]['Module']['is_time_complete'] = $is_time_complete;			

			//die(debug($dto_modules[$kay]['Module']));
			$count = $dto_modules[$kay]['Module']['module_discipline_count'] > 0 ? $dto_modules[$kay]['Module']['module_discipline_count'] : 1;
			$dto_modules[$kay]['Module']['progress'] = floor($dto_modules[$kay]['Module']['module_discipline_total_progress']/$count);
			/*if($dto_modules[$kay]['Module']['is_time_complete'] == 1){
				$dto_modules[$kay]['Module']['progress'] = 100;
			}else{
				$count_completed_disciplines = 0;
				if(!empty($dto_modules[$kay]['Module']['ModuleDiscipline'])){
					foreach($dto_modules[$kay]['Module']['ModuleDiscipline'] as $module_discipline){
						if($module_discipline['is_discipline_complete'] == 1){
							$count_completed_disciplines++;
						}
					}
					$dto_modules[$kay]['Module']['progress'] = floor((100 * $count_completed_disciplines) / count($dto_modules[$kay]['Module']['ModuleDiscipline']));
				}				

			}*/

			/* Bloqueia o acesso as disciplinas do próximo modulo até concluir a avaliação do módulo anterior */
			if( $module_course['Course']['is_module_block'] && $module_course['Module']['is_introduction'] == false ){
				$next_block_module = 1;
				if($module_course['Course']['is_module_avaliation'] && $dto_modules[$kay]['Module']['is_avaliation_result']){
					$next_block_module = 0;
				}
			}
		}
		//die(debug($dto_modules));
		return $dto_modules;
	}

	//vefica se pode exibir o link do simulado
	public function __allowShowLinkAvaliation( $unidades, $countSlidesAssistidos ){
		$countSlidesUnidades = 0;
		foreach ($unidades as $unidade) {
			$countSlidesUnidades += $unidade['module_discipline_slider_count'] + $unidade['module_discipline_player_count'];
		}
		return $countSlidesAssistidos >= $countSlidesUnidades ? 1 : 0;
	}

	public function __getConfigAvaliationCourse($course, $modules){

		if( $course['Course']['is_course_avaliation'] ){

			$link_avaliation = Router::url('/', true).'meus-cursos/simulate_courses/'.$this->params['pass'][0].'/'.$course['Course']['token'];

			//se ele já fez a prova ao menos 1 vez
			if( !empty($course['UserQuestion']) ){

				$nota = $course['UserQuestion'][0]['value_result'];
		        $result = $course['UserQuestion'][0]['result'];
		        $user_question_id = $course['UserQuestion'][0]['id'];
		        $link_view_result = Router::url('/', true).'meus-cursos/simulate_result/'.$this->params['pass'][0].'/'.$user_question_id;
		        
		        //se passou
		        if( $result ){

		        	return [
		        		'show_certificate'=>true,
		                'message'=>'<span class="text-green-300"><i class="fa fa-fw fa-trophy"></i> Parabéns! Você acertou '.$nota.'%.</span>',
		                'link_avaliation'=> $link_view_result,
		                'circle'=>'text-grey-200',
		                'circle_box'=>'bg-orange-300 text-white',
		                'label_avaliation'=>'Ver Prova',
		                'icon_avaliation'=>'fa-eye'
		            ];
		        }
		        //se não passou
		        else{ 
		        	
        			return [
        				'show_certificate'=>false,
		                'message'=>'<span class="text-red-300"><i class="fa fa-fw fa-frown-o"></i> Pts mínimos não atingidos! Você acertou '.$nota.'%, o mínimo necessário é '.$course['Course']['value_course_avaliation'].'%.</span>',
		                'link_avaliation'=> $link_avaliation,
		                'circle'=>'text-red-200',
		                'circle_box'=>'bg-orange-300 text-white',
		                'label_avaliation'=>'Refazer Prova',
		                'icon_avaliation'=>'fa-edit'
		            ];
		        }
			}
			//se não fez a prova ainda
			else{

				//die(debug( $this->__completedModules($modules, $course) ));
				//se a prova já está liberada pra fazer
				if( $this->__completedModules($modules, $course) ){

					//se tem bloqueio nos modulos por nota
					if( $course['Course']['is_module_block'] ){
						//se passou em todos os modulos
						if( $this->__approvedAllModules($modules) ){
							return [
								'show_certificate'=>false,
								'message'=>'',
					            'link_avaliation'=>$link_avaliation,
					            'circle'=>'text-grey-200',
					            'circle_box'=>'bg-default text-gray',
		                		'label_avaliation'=>'Fazer Prova',
		                		'icon_avaliation'=>'fa-edit'
							];
						}
						//se nao passou em algum dos modulos
						else{
							//não liberado para fazer ainda
				            return [
				            	'show_certificate'=>false,
					            'message'=>'',
					            'link_avaliation'=>'javascript:void(0);',
					            'circle'=>'text-grey-200',
					            'circle_box'=>'bg-default text-gray',
		                		'label_avaliation'=>'Fazer Prova',
		                		'icon_avaliation'=>'fa-edit'
				          	];
						}
					}
					//se não tem bloqueio por nota nos modulos
					else{
						
						return [
							'show_certificate'=>false,
							'message'=>'',
				            'link_avaliation'=>$link_avaliation,
				            'circle'=>'text-grey-200',
				            'circle_box'=>'bg-default text-gray',
		                	'label_avaliation'=>'Fazer Prova',
		                	'icon_avaliation'=>'fa-edit'
						];
					}
	        	}
	        	//se não está liberada pq ainda não terminou de assistir aos modulos
	        	else{

		        	//não liberado para fazer ainda
		            return [
		            	'show_certificate'=>false,
			            'message'=>'',
			            'link_avaliation'=>'javascript:void(0);',
			            'circle'=>'text-grey-200',
			            'circle_box'=>'bg-default text-gray',
		                'label_avaliation'=>'',
		                'icon_avaliation'=>''
		          	];
	        	}
			}
		}
		//se o curso não tem avaliação final
		else{
			return false;
		}
    }

    public function __completedModules($modules, $course){

    	#TAXI 			 = 1;
		#ESPECIALIZADOS  = 2;
		#RECICLAGEM 	 = 3;
		#NEUTROS 	 	 = 4;

    	$countModules = count($modules);
    	$completedModules = 0;
    	if( in_array($course['CourseType']['id'], [CourseType::RECICLAGEM,CourseType::ESPECIALIZADOS, CourseType::NEUTROS]) ){

	    	foreach ($modules as $module) {
	    		if( $module['Module']['is_show_avaliation'] OR $module['Module']['is_introduction'] ){
	    			$completedModules += 1;
	    		}
	    	}
    	}else{
    		//se for taxi
    		foreach ($modules as $module) {
	    		if( $module['Module']['progress'] == 100 ){
	    			$completedModules += 1;
	    		}
	    	}
    	}

    	return $completedModules >= $countModules;
    }

    public function __approvedAllModules($modules){

    	foreach ($modules as $module) {
    		if( !$module['Module']['is_introduction'] ){
	    		$notaTiradaNoModulo = $module['Module']['avaliation_value_result'];
	    		$notaDeCorte = $module['Course']['value_module_avaliation'];
	    		if( $notaTiradaNoModulo < $notaDeCorte ){
	    			return false;
	    		}
    		}
    	}
    	return true;
    }

	/* Para acessar o curso com segurança do que foi comprado */
		public function _accessCourseSecurity($id){
			$ex = explode('_',$id);
			if(count($ex) == 2):

				$id = $ex[0];
				$token = $ex[1];

				$this->loadModel('OrderCourse');
				$this->loadModel('Payment');
				$this->OrderCourse->Behaviors->load('Containable');
				$OrderCourse = $this->OrderCourse->find('first', [
					'fields' => [
						'OrderCourse.id', 
						'OrderCourse.order_id', 
						'OrderCourse.course_id', 
						'OrderCourse.citie_id', 
						'OrderCourse.state_id'
					],
					'contain' => ['Order' => ['fields' => ['Order.user_id', 'Order.id']]],
					'conditions' => [
						'OrderCourse.id' => $id, 
						'Order.order_type_id' => [Payment::APROVADO,Payment::DISPONIVEL]
					]
				]);
				$OrderCourse['User']['id'] = $this->Auth->user('id');
				
				#####################################################
				# após inserir o order_id no find acima, deu problema na comparacao do token
				$order_id = $OrderCourse['OrderCourse']['order_id'];
				unset($OrderCourse['OrderCourse']['order_id']);
				unset($OrderCourse['OrderCourse']['token']);

				if($this->Auth->password(serialize($OrderCourse)) == $token):
					$OrderCourse['OrderCourse']['order_id'] = $order_id;
					return $OrderCourse;
				endif;
			endif;
			
			return false;
		}

	/* Para acessar a disciplina com segurança do que foi comprado */
		public function _accessDisciplineSecurity($id){
			$ex = explode('_',$id);
			if(count($ex) == 2):

				$id = $ex[0];
				$token = $ex[1];

				$arr = [
					'ModuleDiscipline' => [
						'id' => $id
					],
					'User' => [
						'id' => $this->Auth->user('id')
					]
				];

				if($this->Auth->password(serialize($arr)) == $token):
					return $id;
				endif;
			endif;
			
			return false;
		}

	/* Para acessar a o fale com intrutor */
		public function _accessDirectMessageSecurity($id){
			$ex = explode('_',$id);
			if(count($ex) == 2):

				$id = $ex[0];
				$token = $ex[1];

				$this->loadModel('CourseInstructor');
				$this->CourseInstructor->Behaviors->load('Containable');
				$CourseInstructor = $this->CourseInstructor->find('first', [
						'fields' => ['CourseInstructor.id', 'CourseInstructor.instructor_id'],
						'conditions' => ['CourseInstructor.id' => $id]
				]);
				$CourseInstructor['User']['id'] = $this->Auth->user('id');
				unset($CourseInstructor['CourseInstructor']['token']);
				if($this->Auth->password(serialize($CourseInstructor)) == $token):
					return $CourseInstructor;
				endif;
			endif;
			
			return false;
		}

	/* Para acessar o simulado do módulo com segurança do que foi comprado */
		public function _accessSimulateModuleSecurity($id){
			$ex = explode('_',$id);
			if(count($ex) == 2):

				$id = $ex[0];
				$token = $ex[1];

				$arr = [
					'Module' => [
						'id' => $id
					],
					'User' => [
						'id' => $this->Auth->user('id')
					]
				];

				if($this->Auth->password(serialize($arr)) == $token):
					return $id;
				endif;
			endif;
			
			return false;
		}

	/* Para acessar o simulado do curso com segurança do que foi comprado */
		public function _accessSimulateCourseSecurity($id){
			$ex = explode('_',$id);
			if(count($ex) == 2):

				$id = $ex[0];
				$token = $ex[1];

				$arr = [
					'Course' => [
						'id' => $id
					],
					'User' => [
						'id' => $this->Auth->user('id')
					]
				];

				if($this->Auth->password(serialize($arr)) == $token):
					return $id;
				endif;
			endif;
			
			return false;
		}	

	/* Para acessar o simulado do módulo com segurança do que foi comprado */
		public function _accessForumPostSecurity($id){
			$ex = explode('_',$id);
			if(count($ex) == 2):

				$id = $ex[0];
				$token = $ex[1];

				$arr = [
					'Forum' => [
						'id' => $id
					],
					'User' => [
						'id' => $this->Auth->user('id')
					]
				];

				if($this->Auth->password(serialize($arr)) == $token):
					return $id;
				endif;
			endif;
			
			return false;
		}

	/* Dados do curso */
		public function _findCourse($course_id = null, $order_id = null){

			$OptionsCourseUserQuestion = [
				'fields' => ['id', 'result', 'value_result', 'value_avaliation'],
				'conditions' => ['UserQuestion.model' => 'Course', 'UserQuestion.user_id' => $this->Auth->user('id')]
			];

			if( $order_id ){
				$OptionsCourseUserQuestion = [
					'fields' => ['id', 'result', 'value_result', 'value_avaliation','created'],
					'conditions' => [
						'UserQuestion.model' => 'Course', 
						'UserQuestion.user_id' => $this->Auth->user('id'),
						'UserQuestion.order_id' => $order_id
					],
					'limit' => 1,
					'order' => ['UserQuestion.id' => 'DESC']
				];
			}

			$this->loadModel('Course');
	    	$this->Course->Behaviors->load('Containable');
	    	return $this->Course->find('first', [
	    		'contain' => [
	    			'CourseType'=>['CourseState'],
	    			'UserQuestion' => $OptionsCourseUserQuestion,
					'CourseInstructor' => [
						'Instructor' => [
							'conditions' => ['Instructor.status' => 1],
							'User' => [
								'fields' => ['id', 'username', 'avatar']
							],
							'DirectMessage' => [
								'fields' => ['id', 'text', 'view_user', 'created'],
								'conditions' => [
									'DirectMessage.user_id' => $this->Auth->user('id'),
									'DirectMessage.status' => 1
								],
								'limit' => 1,
								'order' => ['DirectMessage.created' => 'DESC']
							]
						],
					]
				],
				'conditions' => [
					'Course.id' => $course_id,
					'Course.status' => 1
				]
			]);
		}

	/* Método para organizar a listagem de questões para simulado de curso */
		public function _simulateCourseQuestions($module_courses = null, $qt_question_course_avaliation = null){

			/* Unificando as questões de cada módulo em um único array */
			foreach ($module_courses as $module_course):
				foreach ($module_course['Module']['QuestionAlternative'] as $QuestionAlternative):
					$questions['QuestionAlternative'][] = $QuestionAlternative;
				endforeach;
			endforeach;

			if(count($questions['QuestionAlternative']) < $qt_question_course_avaliation):
				$qt_question_course_avaliation = count($questions['QuestionAlternative']);
			endif;
			shuffle($questions['QuestionAlternative']);
			for ($i=0; $i < $qt_question_course_avaliation; $i++) { 
				$questions_limit['QuestionAlternative'][] = $questions['QuestionAlternative'][$i];
			}
		
			return $questions_limit;
		}

	/* Controle de tempo máximo para estudo */
		public function _limitMaxTimeCourse($course = null){
			$this->__verifySecurity(4);

			$this->loadModel('ModuleCourse');
			$this->ModuleCourse->Behaviors->load('Containable');
			$module_course_list = $this->ModuleCourse->find('list', [
				'contain' => ['Module'],
				'fields' => ['module_id'],
				'conditions' => [
					'ModuleCourse.course_id' => $course['Course']['id'],
					'Module.is_introduction NOT' => 1
				]
			]);

			$this->loadModel('UserModuleLog');
			$this->UserModuleLog->Behaviors->load('Containable');
			$user_module_log = $this->UserModuleLog->find('first', [
				'fields' => ['total' => 'SUM(UserModuleLog.time) as time'],
				'recursive' => -1,
				'conditions' => [
					//'date(UserModuleLog.created) BETWEEN ? AND ?' => array(date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59'),
					'DATE_FORMAT(UserModuleLog.created, "%Y-%m-%d")' => date('Y-m-d'),
					'UserModuleLog.user_id' => $this->Auth->user('id'),
					'UserModuleLog.module_id' => $module_course_list
				]
			]);

			if(isset($user_module_log[0]['time'])):
				if($user_module_log[0]['time']>$course['Course']['max_time']):
					return true;
				endif;
			endif;
		}

	/* Quantidade de tempo de estudo para cada disciplina DTO  */
	public function _qtTimeDisciplineDTO($module = []){
		$this->__verifySecurity(4);
		
		if(isset($module['value_time']) && isset($module['module_discipline_count'])
			&& $module['value_time'] > 0 && $module['module_discipline_count'] > 0):
			return round($module['value_time']/$module['module_discipline_count']);
		endif;
		return 0;
	}

	/* Quantidade de tempo de estudo para cada disciplina  */
		public function _qtTimeDiscipline($module_id = null, $module_discipline=null){
			$this->__verifySecurity(4);

			if( $module_discipline ){
				$totalSliderPlayer = $module_discipline['ModuleDiscipline']['module_discipline_slider_count'] + $module_discipline['ModuleDiscipline']['module_discipline_player_count'];

				$timeModuleDisciplineInMinutes = intval($module_discipline['ModuleDiscipline']['value_time']) * 60;

				return round($timeModuleDisciplineInMinutes / $totalSliderPlayer);
			}
			
			$this->loadModel('Module');
			$this->Module->Behaviors->load('Containable');
			$module = $this->Module->find('first', [
				'contain' => [
					'ModuleDiscipline' => [
						'fields' => ['id'],
						'ModuleDisciplinePlayer' => [
							'fields' => ['id'],
							'conditions' => ['ModuleDisciplinePlayer.status' => 1]
						],
						'ModuleDisciplineSlider' => [
							'fields' => ['id'],
							'conditions' => ['ModuleDisciplineSlider.status' => 1]
						],
						'conditions' => ['ModuleDiscipline.status' => 1]
					]
				],
				'conditions' => [
					'Module.id' => $module_id
				]
			]);
			$count = 0;
			foreach ($module['ModuleDiscipline'] as $module_discipline):
				$count += count($module_discipline['ModuleDisciplineSlider']) + count($module_discipline['ModuleDisciplinePlayer']);
			endforeach;

			$qt_value_time_discipline = 0;
			if(isset($module['Module']['value_time']) && $module['Module']['value_time']):
				if($count==0)
					$count = 1;
				
				$qt_value_time_discipline = intval($module['Module']['value_time']*60) / $count;
			endif;
			
			return round($qt_value_time_discipline);
		}

	/* Auxilia o save de simulados */
		public function _UserQuestion($modelid, $course, $question_alternative_option_users, $token, $order_id=null){
	        // Nota de cada questão
	        $note = 100;
	        $qt_questions = count($question_alternative_option_users);
	        $qt_questions = isset($qt_questions)?$qt_questions:1;
	        $note_question = intval($note) / intval($qt_questions);
	        $correct = null;

	        foreach ($question_alternative_option_users as $value):
	        	if($value['QuestionAlternativeOptionUser']['correct']):
	        		$correct[] = 1;
	    		endif;
        		$this->request->data['UserQuestionOption'][]['question_alternative_option_user_id'] = $value['QuestionAlternativeOptionUser']['id'];
	        endforeach;
			
			//resultado em porcentagem
			$value_result = count($correct) * $note_question;
	        
			//resultado em pontos
	        //$value_result = number_format(intval(count($correct)) * intval($note_question), 1);

	        $result = 0;
	        if($value_result >= $course['Course']['value_module_avaliation']):
	        	$result = 1;
	    	endif;

	        // if(strpos($_SERVER["HTTP_REFERER"], 'simulate_courses')):
	        if(strpos($this->referer(), 'simulate_courses')):
	            $this->request->data['UserQuestion']['model'] = 'Course';

	        // elseif(strpos($_SERVER["HTTP_REFERER"], 'simulate_modules')):
	        elseif(strpos($this->referer(), 'simulate_modules')):
	            $this->request->data['UserQuestion']['model'] = 'Module';
	        endif;   

	        $this->request->data['UserQuestion']['order_id'] = $order_id;
	        $this->request->data['UserQuestion']['user_id'] = $this->Auth->user('id');
	        $this->request->data['UserQuestion']['modelid'] = $modelid;
	        $this->request->data['UserQuestion']['value_avaliation'] = $course['Course']['value_module_avaliation'];
	        $this->request->data['UserQuestion']['value_result'] = $value_result;
	        $this->request->data['UserQuestion']['result'] = $result;

	        $this->loadModel('UserQuestion');
	        if($this->UserQuestion->saveAll($this->request->data)){

                // Integração Detrans ----------------------------------------------------------------------------------
                App::uses('IntegracaoDetransService', 'IntegracaoDetrans');
                try {
                    $objIntegracao = new IntegracaoDetransService();
                    $objIntegracao->creditar($order_id, $course['Course']['id']);
                } catch (Exception $e) {//não faz nada em caso de erro
                }
                // Fim da Integração Detrans ---------------------------------------------------------------------------

	        	//mudando o redirect para o result sempre, a pedido do cliente
	        	return $this->redirect(array('action' => 'simulate_result', $token, $this->UserQuestion->id, 'manager' => false));
	        	//return $this->redirect(array('action' => 'course', $token, 'manager' => false));
	        }
	    }

	    public function _CookieLogin(){
	    	//Avatar
	    	if($this->Cookie->check('public_url_avatar')):
				if($this->Auth->user('public_url_avatar')):
					if($this->Auth->user('public_url_avatar') != $this->Cookie->read('public_url_avatar')):
						$this->Cookie->write('public_url_avatar',$this->Auth->user('public_url_avatar'));
					endif;
				endif;

				$this->set('public_url_avatar',$this->Cookie->read('public_url_avatar'));
			else:
				if($this->Auth->user('public_url_avatar')):
					$this->Cookie->write('public_url_avatar',$this->Auth->user('public_url_avatar'));
				endif;
			endif;

			//CPF
			if($this->Cookie->check('public_login')):
				if($this->Auth->user('public_login')):
					if($this->Auth->user('public_login') != $this->Cookie->read('public_login')):
						$this->Cookie->write('public_login',$this->Auth->user('public_login'));
					endif;
				endif;

				$this->set('public_login',$this->Cookie->read('public_login'));
			else:
				if($this->Auth->user('public_login')):
					$this->Cookie->write('public_login',$this->Auth->user('public_login'));
				endif;
			endif;
	    }

	function __getCourseModules($conditionsModuleCourse, $order_id){

		$module_courses = $this->ModuleCourse->find('all', [
    		'contain' => [
    			'Course' => [
    				'fields' => [
						'id', 
    					'is_module_avaliation', 
    					'value_module_avaliation',
    					'is_module_block',
					]
    			],
    			'Module' => [
    				'QuestionAlternative'=>['conditions'=>['QuestionAlternative.status'=>1]],
    				'ModuleDiscipline' => [
    					'UserModuleLog' => [
							'fields' => ['UserModuleLog.id'],
							'conditions' => [
								'UserModuleLog.user_id' => $this->Auth->user('id'),
								'UserModuleLog.order_id' => $order_id,
							]
						],
						'UserModuleSummary' => [
							//'fields' => ['desblock'],
							'conditions' => [
								'UserModuleSummary.user_id' => $this->Auth->user('id'), 
								'UserModuleSummary.desblock' => 1,
								'UserModuleSummary.order_id' => $order_id,
							],
							'limit' => 1,
							'order' => ['UserModuleSummary.id' => 'DESC']
						],
    					'fields' => ['id', 'module_id', 'name','module_discipline_slider_count','module_discipline_player_count'],
    					'conditions' => ['ModuleDiscipline.status' => 1],
    					'order' => ['ModuleDiscipline.position' => 'ASC']
					],
					'UserModuleSummary' => [
						'fields' => ['user_id', 'module_id', 'desblock','order_id'],
						'conditions' => [
							'UserModuleSummary.user_id' => $this->Auth->user('id'), 
							'UserModuleSummary.desblock' => 1,
							'UserModuleSummary.order_id' => $order_id,
						],
						'limit' => 1,
						'order' => ['UserModuleSummary.id' => 'DESC']
					],
					'UserQuestion' => [
						'fields' => ['result', 'value_result'],
						'conditions' => [
							'UserQuestion.model' => 'Module', 
							'UserQuestion.user_id' => $this->Auth->user('id'),
							'UserQuestion.order_id' => $order_id
						],
						'limit' => 1,
						'order' => ['UserQuestion.id' => 'DESC']
					],
					'UserModuleLog' => [
						'fields' => ['SUM(time) as t_time', 'count(id) as count'],
						'conditions' => [
							'UserModuleLog.user_id' => $this->Auth->user('id'),
							'UserModuleLog.order_id' => $order_id,
						]
					],
					'fields' => ['id', 'name', 'text', 'value_time', 'is_introduction', 'module_discipline_count'],
					'conditions' => ['Module.status' => 1]
				]
			],
			'fields' => ['id', 'module_id', 'course_id', 'citie_id', 'state_id'],
    		'conditions' => [
    			$conditionsModuleCourse
    			//'ModuleCourse.course_id' => $course_id,
    			//'ModuleCourse.citie_id' => $citie_id,
    			//'ModuleCourse.state_id' => $state_id
    		],
    		'order' => ['ModuleCourse.position' => 'ASC']
		]);

		return $module_courses;

	}

	function __showErrorsPayment($data=false){
        $msg = "";
        if(!empty($data['errors'])):
            foreach ($data['errors'] as $key => $value) :
            	$msg .= "<li>{$value['message']}</li>";
            endforeach;
        endif;
        return $msg;
    }

    function __showErrors($errors=false){
        $msg = "";
        if($errors):
            foreach ($errors as $key => $value) :
            	//die(debug($value));
            	//Caso um erro igual já esteja na mensagem, ele não é atribuído
            	//$msg .= strpos($msg, $this->__getErrorMessage($value)) ? '' : $this->__getErrorMessage($value);
            	$msg .= $this->__getErrorMessage($value);
            endforeach;
        endif;
        return $msg;
    }

    function __getErrorMessage($error){
    	if(is_array($error)){
    		$msg2 = '';
    		foreach($error as $key => $value){
    			$msg2 .= $this->__getErrorMessage($value);
    		}
    		return $msg2;
    	}else{
    		return "<li style='list-style: none;'>{$error}</li>";
    	}
    }

    function __getCourseForCart($course_id,$cart){
    	$this->loadModel('Course');
    	$this->Course->recursive = -1;
    	$this->Course->Behaviors->load('Containable');
    	$course = $this->Course->find('first',[
    		'fields' => ['Course.id','Course.price','Course.promotional_price','Course.image','Course.name'],
    		'conditions' => ['Course.id' => $course_id],
    		'contain' => [
    			'CourseType' => [
    				'fields' => ['CourseType.id','CourseType.scope']
    			]
    		]
    	]);
    	$course['Cart']  = $cart['Cart'];
    	if (isset($cart['State'])) {
            $course['State'] = $cart['State'];
        }
        if (isset($cart['City'])) {
            $course['City'] = $cart['City'];
        }
    	switch($course['CourseType']['scope']){    		
    		case CourseType::AMBITO_ESTADUAL:
    		$this->loadModel('CourseState');
    			$this->loadModel('CourseState');
    			$this->CourseState->recursive = -1;
    			$this->CourseState->Behaviors->load('Containable');
    			$state = $this->CourseState->find('first',[    				    				    					
					'conditions' => [
						'CourseState.state_id' => $cart['Cart']['state_id'],
						'CourseState.course_type_id' => $course['CourseType']['id']
					],
				]);

    			$course['Course']['promotional_price'] = $state['CourseState']['price'];
    			$course['Cart']['state_id'] = $cart['Cart']['state_id'];
    			break;
    		case CourseType::AMBITO_MUNICIPAL:
    			$this->loadModel('CourseState');
    			$this->CourseState->recursive = -1;
    			$this->CourseState->Behaviors->load('Containable');
    			$city = $this->CourseState->find('first',[    				    				    					
					'conditions' => [
						'CourseState.state_id' => $cart['Cart']['state_id'],
						'CourseState.course_type_id' => $course['CourseType']['id']
					],
					'contain' => [
						'CourseCity' => [
							'conditions' => [
    							'CourseCity.city_id' => $cart['Cart']['citie_id']
							],
						]
					]    					    			
    			]);  
    			$course['Cart']['state_id'] = $cart['Cart']['state_id'];
    			$course['Cart']['citie_id'] = $cart['Cart']['citie_id'];  			
    			$course['Course']['promotional_price'] = $city['CourseCity'][0]['price'];
    			break;
    	}    	
    	return $course;
    }

    public function __getConditionsForScope($course_id, $scope, $state_id=null, $citie_id=null){
    	switch ($scope) {
    		case CourseType::AMBITO_NACIONAL:
    			return [
	    			'ModuleCourse.course_id' => $course_id
	    		];
    		case CourseType::AMBITO_ESTADUAL:
    			return [
	    			'ModuleCourse.course_id' => $course_id,
	    			'ModuleCourse.state_id' => $state_id
	    		];
    		case CourseType::AMBITO_MUNICIPAL:
    			return [
	    			'ModuleCourse.course_id' => $course_id,
	    			'ModuleCourse.citie_id' => $citie_id,
	    			'ModuleCourse.state_id' => $state_id
	    		];
    		default:
    			return [
	    			'ModuleCourse.course_id' => $course_id,
	    			'ModuleCourse.citie_id' => $citie_id,
	    			'ModuleCourse.state_id' => $state_id
	    		];
    	}
    }

    public function __getSessionId(){
 		/*if(empty($this->Cookie->read('session_id'))){
            $this->Cookie->write('session_id',$this->Session->id());
        }   	
        return $this->Cookie->read('session_id');*/
        //return $this->Session->id();

        return $this->Session->read('user_bag');
    }

    public function __getCartsInSession($sessionid){
    	$this->loadModel("Cart");
        $this->Cart->Behaviors->load('Containable');
        $this->Cart->recursive = -1;
        $carts = $this->Cart->find('all',[
            'fields' => ['Cart.id','Cart.course_id','Cart.state_id','Cart.citie_id','Cart.unitary_value','Cart.unitary_discount', 'Cart.renach', 'Cart.cnh', 'Cart.cnh_category', 'Cart.tipo_reciclagem'],
            'contain' => [
                'State' => ['fields' => ['id', 'name', 'abbreviation']],
                'City'  => ['fields' => ['id', 'name']],
            ],
            'conditions'=>['Cart.sessionid'=>$sessionid]
        ]);

        $courses = [];
        foreach($carts as $cart){
            $courses[] = $this->__getCourseForCart($cart['Cart']['course_id'],$cart);
        }
        return $courses;
    }

    public function __MaskOrderId($id, $tam=6){
        return str_pad($id, $tam, '0', STR_PAD_LEFT);
    }

    public function __getDescriptionForCertificate($UserCertificate){
    	$return = $UserCertificate['Course']['description_certificate'];

    	if( isset($UserCertificate['Order']['OrderCourse'][0]['Citie']) and !empty($UserCertificate['Order']['OrderCourse'][0]['Citie']) ){
    		$return .= " - {$UserCertificate['Order']['OrderCourse'][0]['Citie']['name']}";
    	}

    	if( isset($UserCertificate['Order']['OrderCourse'][0]['State']) and !empty($UserCertificate['Order']['OrderCourse'][0]['State']) ){
    		$return .= " / {$UserCertificate['Order']['OrderCourse'][0]['State']['abbreviation']}";
    	}

    	return $return;
    }

    public function getGendersList(){
        return [1=>'Masculino',2=>'Feminino'];
    }

    public function getCnhCategoriesList(){
    	return ['A' => 'A',
				'B' => 'B',
				'C' => 'C',
				'D' => 'D',
				'E' => 'E',
				'X' => 'X',
				'AB' => 'AB',
				'AC' => 'AC',
				'AD' => 'AD',
				'AE' => 'AE',
				'XB' => 'XB',
				'XC' => 'XC',
				'XD' => 'XD',
				'XE' => 'XE'
			   ];
    }

    public function __getStudent($user_id = null){
    	if(empty($user_id)){
    		$user_id = $this->Auth->user('id');
    	}
    	$this->loadModel('Student');
    	return $this->Student->find('first',['conditions'=>['Student.user_id'=>$user_id]]);
    }

    /*
     * __calculateDate
     * Calculo de datas, informe a data no formato (AA-MM-DD) 
     * e a quantidade de didas futuro ou passado, + ou - respectivamente.
     */
    public function __calculateDate($datein, $count = 1) {

        $datexplode = explode('-', $datein);
        $dias = +$count;
        $dia = $datexplode[2];
        $mes = $datexplode[1];
        $ano = $datexplode[0];
        $datein = mktime(24 * $dias, 0, 0, $mes, $dia, $ano);
        $datein = date('Y-m-d', $datein);

        return $datein;
    }

    public function __checkDataClientInCart($cart_informations){
    	$isCustomerValid = $isBillingValid = false;
    	$isCustomerValid = $this->__checkCustomer($cart_informations['customer']);

    	if( $isCustomerValid ){
    		$isBillingValid = $this->__checkBilling($cart_informations['billing']);
    	}
    	if ($isCustomerValid and $isBillingValid) {
    		return $cart_informations;	
    	}else{
    		$this->Session->setFlash(__('É necessário completar seu cadastro para concluir a compra! Verifique principalmente seus dados de endereço.'), 'site/popup-error');
    		return $this->redirect(['controller'=>'virtual_room_users','action'=>'edit']);
    	}
    }

    /**
     * Valida dados pessoais do comprador antes de mandar para pagarme
     */
    public function __checkCustomer($customer){
    	foreach ($customer as $key => $value) {
    		if( $key == 'documents' ){
    			if( empty($value[0]['number']) ){
    				return false;
    			}
    		}else{
    			if( empty($value) ){
    				return false;
    			}
    		}
    	}
    	return true;
    }
    /**
     * Valida dados de endereço do comprador antes de mandar para pagarme
     */
    public function __checkBilling($billing){
    	$return = true;
    	foreach ($billing as $key => $value) {
    		if( $key == 'address' ){
    			foreach ($value as $k=>$v) {
    				if( $k == 'complementary' ) continue;
	    			if( empty($v) ){
	    				$return = false;
	    			}
    			}
    		}else{
    			if( empty($value) ){
    				$return = false;
    			}
    		}
    	}
    	return $return;
    }

    /**
     * Verifica se o cadastro do usuário está completo para finalização de uma compra
     * @param array $user chaves User e Student
     * @return bool
     */
    protected function checkStudent(array $user)
    {
        return isset($user['User']['name']) && !empty($user['User']['name']) && count(explode(' ', $user['User']['name'])) > 1
            && isset($user['User']['cpf']) && !empty($user['User']['cpf'])
            && isset($user['User']['email']) && !empty($user['User']['email'])
            && isset($user['Student']['cellphone']) && !empty($user['Student']['cellphone'])
            && isset($user['Student']['birth']) && !empty($user['Student']['birth'])
        ;
    }

    /**
	 * set o link de agendamemto do detran para o curso
	*/
	public function __GetSchedulingLinkDetran($course, $state_id){
		if( isset($course['CourseType']['CourseState']) and !empty($course['CourseType']['CourseState']) ){
			foreach ($course['CourseType']['CourseState'] as $courseState) {
				if( $courseState['state_id'] == $state_id ){
					return $courseState['scheduling_link_detran'];
				}
			}
		}
		return false;
	}
}
