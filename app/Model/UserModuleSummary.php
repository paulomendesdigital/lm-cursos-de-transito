<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserModuleSummary Model
 *
 * @property User $User
 * @property Module $Module
 * @property ModuleDiscipline $ModuleDiscipline
 */
class UserModuleSummary extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'module_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'module_discipline_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'desblock' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

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
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'module_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ModuleDiscipline' => array(
			'className' => 'ModuleDiscipline',
			'foreignKey' => 'module_discipline_id',
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

	public function __desblockNextModule($order_id, $user_id, $course_id, $current_module_id){
		$user_module_summaries = $this->find('first', [
			'recursive' => -1,
			'conditions' => [
				'UserModuleSummary.order_id' => $order_id,
				'UserModuleSummary.user_id'  => $user_id,
				'UserModuleSummary.desblock' => 0
			]
		]);
		if( !empty($user_module_summaries) ){
			$this->id = $user_module_summaries['UserModuleSummary']['id'];
			$bolOK = $this->saveField('desblock', 1);
		}else{
			$bolOK = false;
		}

        // Integração Detrans ----------------------------------------------------------------------------------
        if (empty($user_module_summaries) || $user_module_summaries['UserModuleSummary']['module_id'] != $current_module_id) {
            App::uses('IntegracaoDetransService', 'IntegracaoDetrans');
            try {
                $objIntegracao = new IntegracaoDetransService();
                $objIntegracao->creditar($order_id, $course_id);
            } catch (Exception $e) {//não faz nada em caso de erro
            }
        }
        // Fim da Integração Detrans ---------------------------------------------------------------------------

        return $bolOK;
	}
}
