<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserCertificate Model
 *
 * @property User $User
 * @property Course $Course
 * @property UserCertificateModule $UserCertificateModule
 */
class UserCertificate extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'course_name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'UserCertificateModule' => array(
			'className' => 'UserCertificateModule',
			'foreignKey' => 'user_certificate_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function __getCertificate($order_id, $user_id, $course_id){
		$this->Behaviors->load('Containable');
		return $this->find('first', [
			'contain'=>[
				'User',
				'UserCertificateModule',
				'Course',
				'Order'=>['OrderCourse'=>['State','Citie']]
			],
			'conditions' =>[
    			'UserCertificate.order_id' 	=> $order_id,
    			'UserCertificate.user_id' 	=> $user_id,
    			'UserCertificate.course_id' => $course_id
			]
		]);
	}

	public function __getTotalWorkload($certificateModules){
		$t_workload = 0;
		foreach ($certificateModules as $UserCertificateModule):
			$t_workload += $UserCertificateModule['value_time'];
		endforeach;
		return $t_workload;
	}

	public function __createCertificate($order, $user_id, $course, $modules){

		$this->data['UserCertificate']['order_id'] 	  = $order['Order']['id'];
		$this->data['UserCertificate']['user_id'] 	  = $user_id;
		$this->data['UserCertificate']['course_id']   = $course['Course']['id'];
		$this->data['UserCertificate']['course_name'] = $course['Course']['name'];
		$this->data['UserCertificate']['description'] = $course['Course']['description_certificate'];
		$this->data['UserCertificate']['start'] 	  = $order['Order']['created'];
		$this->data['UserCertificate']['finish'] 	  = $course['UserQuestion'][0]['created'];
		$this->data['UserCertificate']['score']		  = $course['UserQuestion'][0]['value_result'];

		foreach ($modules as $key => $module) {
			if( !$module['Module']['is_introduction'] ){
				$this->data['UserCertificateModule'][$key]['module_name'] = $module['Module']['name'];
				$this->data['UserCertificateModule'][$key]['value_time']  = $module['Module']['value_time'];
				$this->data['UserCertificateModule'][$key]['score']  	  = isset($module['Module']['UserQuestion'][0]['value_result']) ? $module['Module']['UserQuestion'][0]['value_result'] : NULL;
			}
		}

		if ( $this->saveAll($this->data) ) {
		    $this->integracaoCertificado($order['Order']['id'], $course['Course']['id']);
		    return true;
        } else {
		    return false;
        }
	}

	public function __updateCertificate($order, $user_id, $course, $modules, $UserCertificate){
		$this->data['UserCertificate'] = $UserCertificate['UserCertificate'];
		$this->data['UserCertificate']['order_id'] 	  = $order['Order']['id'];
		$this->data['UserCertificate']['user_id'] 	  = $user_id;
		$this->data['UserCertificate']['course_id']   = $course['Course']['id'];
		$this->data['UserCertificate']['course_name'] = $course['Course']['name'];
		$this->data['UserCertificate']['description'] = $course['Course']['description_certificate'];
		$this->data['UserCertificate']['start'] 	  = $order['Order']['created'];
		$this->data['UserCertificate']['finish'] 	  = $course['UserQuestion'][0]['created'];
		$this->data['UserCertificate']['score']		  = $course['UserQuestion'][0]['value_result'];

		//apagando registros da tabela user_certificate_modules para gravar novamente
		$this->UserCertificateModule->deleteAll(['UserCertificateModule.user_certificate_id'=>$this->data['UserCertificate']['id']]);

		foreach ($modules as $key => $module) {
			if( !$module['Module']['is_introduction'] ){
				$this->data['UserCertificateModule'][$key]['module_name'] = $module['Module']['name'];
				$this->data['UserCertificateModule'][$key]['value_time']  = $module['Module']['value_time'];
				$this->data['UserCertificateModule'][$key]['score']  	  = isset($module['Module']['UserQuestion'][0]['value_result']) ? $module['Module']['UserQuestion'][0]['value_result'] : NULL;
			}
		}

        if ( $this->saveAll($this->data) ) {
            $this->integracaoCertificado($order['Order']['id'], $course['Course']['id']);
            return true;
        } else {
            return false;
        }
	}

    public function integracaoCertificado($orderId, $courseId)
    {
        App::uses('IntegracaoDetransService', 'IntegracaoDetrans');

        $objIntegracaoService = new IntegracaoDetransService();

        try {
            $objIntegracaoService->concluir($orderId, $courseId);
        } catch (Exception $ex) {

        }
    }
}
