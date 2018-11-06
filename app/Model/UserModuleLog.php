<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserModuleLog Model
 *
 * @property User $User
 * @property Module $Module
 * @property ModuleDiscipline $ModuleDiscipline
 */
class UserModuleLog extends AppModel {

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
		'modelid' => array(
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

	/*public function afterSave($created, $options = []){

		if($created):
			$t_sliders = 0;
			$t_players = 0;

			$t_sliders = $this->countDisciplineSliders($this->data['UserModuleLog']['module_discipline_id']);
			$t_players = $this->countDisciplinePlayers($this->data['UserModuleLog']['module_discipline_id']);
			$t_discipline = $t_sliders + $t_players;

			$t_user_log = sizeof($this->find('all', [
				'fields' => ['id'],
				'recursive' => -1,
				'conditions' => [
					'UserModuleLog.module_discipline_id' => $this->data['UserModuleLog']['module_discipline_id'], 
					'UserModuleLog.user_id' => AuthComponent::user('id'), 
				]
			]));
			debug($t_user_log);
			die(debug($t_discipline));
			if($t_user_log >= $t_discipline):
				$user_module_summaries = $this->User->UserModuleSummary->find('first', [
					'recursive' => -1,
					'conditions' => [
						'UserModuleSummary.user_id' => AuthComponent::user('id'),
						'UserModuleSummary.desblock' => 0
					]
				]);
				$this->data['UserModuleSummary'] = $user_module_summaries['UserModuleSummary'];
				$this->data['UserModuleSummary']['desblock'] = 1;
				$this->User->UserModuleSummary->save($this->data);
			endif;
		endif;
	}*/

	public function afterSave($created, $options = []) {
	    if ($created) {

        }
    }

	public function __getCountUserModuleLog($order_id, $user_id, $module_discipline_id){
		return (int) $this->find('count',[
			'recursive' => -1,
			'conditions'=>[
				'UserModuleLog.order_id'=>$order_id,
				'UserModuleLog.user_id'=>$user_id,
				'UserModuleLog.module_discipline_id'=>$module_discipline_id
			]
		]);
	}

	public function countDisciplineSliders($module_discipline_id){
		$count = $this->ModuleDiscipline->ModuleDisciplineSlider->find('all', [
			'fields' => ['id'],
			'recursive' => -1,
			'conditions' => [
				'ModuleDisciplineSlider.module_discipline_id' => $module_discipline_id,
				'ModuleDisciplineSlider.status' => 1,
			]
		]);
		return sizeof($count);
	}

	private function countDisciplinePlayers($module_discipline_id){
		$count = $this->ModuleDiscipline->ModuleDisciplinePlayer->find('all', [
			'fields' => ['id'],
			'recursive' => -1,
			'conditions' => [
				'ModuleDisciplinePlayer.module_discipline_id' => $module_discipline_id,
				'ModuleDisciplinePlayer.status' => 1,
			]
		]);
		return sizeof($count);
	}
}
