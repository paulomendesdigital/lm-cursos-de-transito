<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * QuestionAlternativeOptionUser Model
 *
 * @property User $User
 * @property QuestionAlternative $QuestionAlternative
 * @property QuestionAlternativeOption $QuestionAlternativeOption
 */
class QuestionAlternativeOptionUser extends AppModel {

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
		'question_alternative_option_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sessionid' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		'QuestionAlternative' => array(
			'className' => 'QuestionAlternative',
			'foreignKey' => 'question_alternative_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'QuestionAlternativeOption' => array(
			'className' => 'QuestionAlternativeOption',
			'foreignKey' => 'question_alternative_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'UserQuestionOption' => array(
			'className' => 'UserQuestionOption',
			'foreignKey' => 'question_alternative_option_user_id',
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

	public function beforeSave($options = []){
		if(!isset($this->data['QuestionAlternativeOptionUser']['user_id'])):
			$this->data['QuestionAlternativeOptionUser']['user_id'] = AuthComponent::user('id');
		endif;

		if( isset($this->data['QuestionAlternativeOptionUser']['question_alternative_option_id']) and !empty($this->data['QuestionAlternativeOptionUser']['question_alternative_option_id']) ):
			$question_alternative_option = $this->QuestionAlternativeOption->read(null,$this->data['QuestionAlternativeOptionUser']['question_alternative_option_id']);
			if($question_alternative_option['QuestionAlternativeOption']['correct']):
				$this->data['QuestionAlternativeOptionUser']['correct'] = 1;
			endif;
		else:
			unset($this->data['QuestionAlternativeOptionUser']);
		endif;

		$this->data['QuestionAlternativeOptionUser']['sessionid'] = session_id();
	}

}
