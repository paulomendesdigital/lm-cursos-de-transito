<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2017 * @author Grupo Grow - www.grupogrow.com.br
 * Question Model
 *
 * @property Poll $Poll
 * @property PollQuestionAlternative $PollQuestionAlternative
 */
class PollQuestion extends AppModel {

	/**
 	* Validation rules
 	*
 	* @var array
 	*/
	public $validate = array(
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
 	* belongsTo associations
 	*
 	* @var array
 	*/
	public $belongsTo = array(
		'Poll' => array(
			'className' => 'Poll',
			'foreignKey' => 'poll_id',
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
		'PollQuestionAlternative' => array(
			'className' => 'PollQuestionAlternative',
			'foreignKey' => 'poll_question_id',
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