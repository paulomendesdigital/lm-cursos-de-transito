<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleCourse Model
 *
 * @property Module $Module
 * @property Course $Course
 * @property Citie $Citie
 * @property State $State
 */
class ModuleCourse extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
		'course_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'position' => array(
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
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'module_id',
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
		'Citie' => array(
			'className' => 'Citie',
			'foreignKey' => 'citie_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function __getModuleCourseInOrder($order_id, $user_id, $conditionsModuleCourse, $course=null){
		

		if( $course ){
			//se nào tem bloqueio por modulo, não posso buscar na teabela UserQuestion para obert os modulos estudados
			if( !$course['Course']['is_module_block'] ){
				$this->Module->UserModuleLog->Behaviors->load('Containable');
				return $this->Module->UserModuleLog->find('all', [
		    		'contain' => [
		    			'Module' => [
							'fields' => ['id', 'name', 'value_time','is_introduction'],
							'conditions' => ['Module.status' => 1],
							'ModuleCourse'=>[
								'fields' => ['id', 'module_id', 'course_id', 'citie_id', 'state_id'],
								'conditions' => [
					    			$conditionsModuleCourse
					    		],
					    		'order' => ['ModuleCourse.position' => 'ASC']
							]
						]
					],
		    		'conditions' => [
		    			'UserModuleLog.order_id' => $order_id, 
						'UserModuleLog.user_id' => $user_id
		    		],
		    		'group' => ['UserModuleLog.module_id'],
		    		'order' => ['UserModuleLog.id' => 'ASC']
				]);
			}
		}

		$this->Behaviors->load('Containable');
    	return $this->find('all', [
    		'contain' => [
    			'Module' => [
					'fields' => ['id', 'name', 'value_time','is_introduction'],
					'conditions' => ['Module.status' => 1],
					'UserQuestion' => [
						'fields' => ['result', 'value_result'],
						'conditions' => [
							'UserQuestion.model' => 'Module', 
							'UserQuestion.order_id' => $order_id, 
							'UserQuestion.user_id' => $user_id, 
							'UserQuestion.result' => 1
						],
						'limit' => 1,
						'order' => ['UserQuestion.id' => 'DESC']
					],
				]
			],
			'fields' => ['id', 'module_id', 'course_id', 'citie_id', 'state_id'],
    		'conditions' => [
    			$conditionsModuleCourse
    		],
    		'order' => ['ModuleCourse.position' => 'ASC']
		]);
	}
}
