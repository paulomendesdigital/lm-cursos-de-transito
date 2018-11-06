<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2017 * @author Grupo Grow - www.grupogrow.com.br
 * PollQuestionAlternative Model
 *
 * @property PollQuestion $PollQuestion
 * @property PollResponse $PollResponse
 */
class PollQuestionAlternative extends AppModel {

	/**
 	* Validation rules
	*
 	* @var array
 	*/
	public $validate = array(
		'poll_question_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
 	* belongsTo associations
 	*
 	* @var array
 	*/
	public $belongsTo = array(
		'PollQuestion' => array(
			'className' => 'PollQuestion',
			'foreignKey' => 'poll_question_id',
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
		'PollResponse' => array(
			'className' => 'PollResponse',
			'foreignKey' => 'poll_question_alternative_id',
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



}
