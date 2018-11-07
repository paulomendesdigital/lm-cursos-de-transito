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
        $this->set('webdoors',$webdoors);

    	//return $this->redirect(array('controller' => 'meus-cursos' ,'action' => 'index', 'manager' => false));    
	}

	public function nossosrepresentantes(){
		
	}

	public function quemsomos(){
        $this->loadModel('Grille');
        $quemsomos = $this->Grille->findById( Grille::QUEM_SOMOS );
        $this->set(compact('quemsomos'));
	}

    public function partner(){
        if($_POST):
            $this->autoRender = false;
            $template = 'pages_partner';

            $Sistems = Configure::read('Sistems');
            
            $data = array(
                'template' => $template, // Template do email
                'to' => $Sistems['EmailTo'], // Destino do email
                'subject' => '[Contato do Site - Parceria] '.$this->request->data['Partner']['subject'], // Assunto do email
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
