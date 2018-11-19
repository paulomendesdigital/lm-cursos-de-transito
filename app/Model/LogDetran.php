<?php
App::uses('AppModel', 'Model');

class LogDetran extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'integracao' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			)
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
		)
	);
}
