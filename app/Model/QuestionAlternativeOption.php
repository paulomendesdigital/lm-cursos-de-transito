<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * QuestionAlternativeOption Model
 *
 * @property QuestionAlternative $QuestionAlternative
 * @property QuestionAlternativeOptionUser $QuestionAlternativeOptionUser
 */
class QuestionAlternativeOption extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'question_alternative_id' => array(
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
		'QuestionAlternative' => array(
			'className' => 'QuestionAlternative',
			'foreignKey' => 'question_alternative_id',
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
		'QuestionAlternativeOptionUser' => array(
			'className' => 'QuestionAlternativeOptionUser',
			'foreignKey' => 'question_alternative_option_id',
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
