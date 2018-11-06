<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2017 * @author Grupo Grow - www.grupogrow.com.br
 * PollQuestionAlternative Model
 *
 * @property PollQuestion $PollQuestion
 * @property PollResponse $PollResponse
 */
class PollResponse extends AppModel {

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
		'poll_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'poll_question_alternative_id' => array(
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
		'Poll' => array(
			'className' => 'Poll',
			'foreignKey' => 'poll_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PollQuestion' => array(
			'className' => 'PollQuestion',
			'foreignKey' => 'poll_question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PollQuestionAlternative' => array(
			'className' => 'PollQuestionAlternative',
			'foreignKey' => 'poll_question_alternative_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}