<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleDisciplinePlayer Model
 *
 * @property ModuleDiscipline $ModuleDiscipline
 */
class ModuleDisciplinePlayer extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'UserModuleLog' => array(
			'className' => 'UserModuleLog',
			'foreignKey' => 'modelid',
			'dependent' => false,
			'conditions' => ['UserModuleLog.model' => 'ModuleDisciplinePlayer'],
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ModuleDiscipline' => array(
			'className' => 'ModuleDiscipline',
			'foreignKey' => 'module_discipline_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
			'counterScope' => ['ModuleDiscipline.status'=>1]
		)
	);


}
