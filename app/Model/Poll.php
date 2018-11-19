<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2017 * @author Grupo Grow - www.grupogrow.com.br
 * Poll Model
 *
 * @property PollQuestion $PollQuestion
 */
class Poll extends AppModel {

	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'O campo nome é obrigatório!',
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
		'PollQuestion' => array(
			'className' => 'PollQuestion',
			'foreignKey' => 'poll_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PollResponse' => array(
			'className' => 'PollResponse',
			'foreignKey' => 'poll_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
}