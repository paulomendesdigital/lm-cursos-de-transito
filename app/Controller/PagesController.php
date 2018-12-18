<?php
App::uses('AppController', 'Controller');

class PagesController extends AppController {

    public $uses = array();

    public function index(){
        $this->loadModel('Course');        
        $this->Course->recursive = -1;
        $courses = $this->Course->find('all',[
            'fields'=>['id','name','image','active_order'],
            'conditions' => [
                'Course.status' => 1]
        ]);
        $this->set('courses',$courses);

        $this->loadModel('Webdoor');
        $webdoors = $this->Webdoor->find('all',[
            'conditions' => [
                'status'=>1
            ]
        ]);


        // ESTADOS*************************************************************************************
        // 3 = Curso de Reciclagem
        $courseTypeId = '3';

        $course = $this->Course->find('first', [
            'conditions' => [
                'Course.status' => 1,
                'Course.course_type_id' => $courseTypeId
            ],
            'fields' => ['id', 'name']
        ]);
        
        $this->loadModel('CourseState');
        $this->CourseState->Behaviors->load('Containable');

        //estados
        $arrStatesEnabled = $this->CourseState->find('list', [
            'fields' => ['State.id', 'State.id'],
            'contain'    => ['State'],
            'conditions' => [
                'CourseState.course_type_id' => $courseTypeId,
                'CourseState.status'         => 1
            ]
        ]);

        $arrStatesModuleEnabled = $this->Course->ModuleCourse->find('list',[
            'fields'=>['ModuleCourse.state_id'],
            'conditions'=> ['ModuleCourse.course_id'=>$course['Course']['id']]
        ]);

        $arrStatesEnabled = array_intersect($arrStatesEnabled, $arrStatesModuleEnabled);

        $this->loadModel('State');
        $this->State->recursive = 0;
        $statesResult = $this->State->find('all',[
            'conditions'=>[
                'State.id' => $arrStatesEnabled,
            ]
        ]);

        $states = [];
        foreach ($statesResult as $val) {
            $states[$val['State']['id']]['name'] = $val['State']['name'];
            $states[$val['State']['id']]['abbreviation'] = $val['State']['abbreviation'];
        }

        //Home page button colors
        $colorStates[] = 'success';
        $colorStates[] = 'primary';
        $colorStates[] = 'warning';
        $colorStates[] = 'info';
        $colorStates[] = 'danger';
        $colorStates[] = 'success';
        $colorStates[] = 'primary';
        $colorStates[] = 'warning';
        $colorStates[] = 'info';
        $colorStates[] = 'danger';

        // FIM ESTADOS*************************************************************************************

        $this->set(compact('webdoors', 'course', 'states', 'colorStates'));

    	//return $this->redirect(array('controller' => 'meus-cursos' ,'action' => 'index', 'manager' => false));    
	}

	public function nossosrepresentantes(){
		
	}

	public function quemsomos(){
        $this->loadModel('Grille');
        $quemsomos = $this->Grille->findById( Grille::QUEM_SOMOS );
        $this->set(compact('quemsomos'));
    }

    public function partner()
    {
        if($_POST):
            $this->autoRender = false;
            $template = 'pages_partner';

            $Sistems = Configure::read('Sistems');
            
            $data = array(
                'template' => $template, // Template do email
                'to' => $Sistems['EmailTo'], // Destino do email
                'subject' => '[Contato do Site - Parceria]', // Assunto do email
                'content' => array(

                    'name' => $this->request->data['Partner']['name'],
                    'sex' => $this->request->data['Partner']['sex'],
                    'birth' => $this->request->data['Partner']['birth'],
                    'cpf' => $this->request->data['Partner']['cpf'],

                    'street' => $this->request->data['Partner']['street'],
                    'number' => $this->request->data['Partner']['number'],
                    'complement' => $this->request->data['Partner']['complement'],
                    'neighborhood' => $this->request->data['Partner']['neighborhood'],
                    'zip_code' => $this->request->data['Partner']['zip_code'],
                    'city' => $this->request->data['Partner']['city'],
                    'state' => $this->request->data['Partner']['state'],
                    'phone' => $this->request->data['Partner']['phone'],
                    'cellphone' => $this->request->data['Partner']['cellphone'],
                    'email' => $this->request->data['Partner']['email'],
                    
                    'messenger' => $this->request->data['Partner']['message']
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

        endif;
    }

    public function certificate($id) 
    {
        $this->loadModel('User');

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Condutor inválio'));
        }

        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));

        $this->set('user', $this->User->find('first', $options));

    	/* Validação de Token de acesso */
    	// $OrderCourse = $this->_accessCourseSecurity($id);
    	// if(!$OrderCourse){
    	// 	throw new NotFoundException(__('Curso Inválido'));
    	// }

    	// $user_id = $id;

    	// $order_id 	= $OrderCourse['OrderCourse']['order_id'];
    	// $course_id 	= $OrderCourse['OrderCourse']['course_id'];
    	// $citie_id 	= $OrderCourse['OrderCourse']['citie_id'];
    	// $state_id 	= $OrderCourse['OrderCourse']['state_id'];
		
		// /* Identificar o início do curso */
	    // $this->loadModel('Order');
	    // $this->Order->recursive = -1;
	    // $order = $this->Order->findById($order_id);

	    // /* Consulta a configuação do curso e os dados da conclusão */
		// $course = $this->_findCourse($course_id, $order_id);

		// if(!$course){
		// 	throw new NotFoundException(__('Curso Inválido'));
    	// }

    	// $this->loadModel('UserCertificate');
    	// $UserCertificate = $this->UserCertificate->__getCertificate($order_id, $user_id, $course_id);

    	// $conditionsModuleCourse = $this->__getConditionsForScope($course_id, $course['CourseType']['scope'], $state_id, $citie_id);
		
		// /* Consulta da lista de módulos */
    	// $this->loadModel('ModuleCourse');
    	// $module_courses = $this->ModuleCourse->__getModuleCourseInOrder($order_id, $user_id, $conditionsModuleCourse, $course);

	    // if( empty($UserCertificate) ){

	    // 	//criando o certificado
	    // 	if( !$this->UserCertificate->__createCertificate($order, $user_id, $course, $module_courses) ){
	    // 		throw new NotFoundException(__('Não foi possível gerar o certificado!'));
	    // 	}
	    // }
	    // else{

	    // 	//atualizando dados do certificado
	    // 	if( !$this->UserCertificate->__updateCertificate($order, $user_id, $course, $module_courses, $UserCertificate) ){
	    // 		throw new NotFoundException(__('Não foi possível gerar o certificado!'));
	    // 	}
	    // }

	    // //recarrega UserCertificate
	    // $UserCertificate = $this->UserCertificate->__getCertificate($order_id, $user_id, $course_id);

	    // $this->__printCertificate( $order_id,  $UserCertificate);
    }

	public function termoservico(){
		$this->loadModel('Grille');
        $termoservico = $this->Grille->findById( Grille::TERMOS );
        $this->set(compact('termoservico'));
	}

    public function passoapasso(){
        $this->loadModel('Grille');
        $passoapasso = $this->Grille->findById( Grille::PASSO_A_PASSO );
        $this->set(compact('passoapasso'));
    }

    public function contact(){                  
        if($_POST):            
            $this->autoRender = false;            
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

        endif;
    }

    public function manager_index() {
    }

    
}
