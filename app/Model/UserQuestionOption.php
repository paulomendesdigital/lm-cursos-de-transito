<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserQuestionOption Model
 *
 * @property UserQuestion $UserQuestion
 * @property QuestionAlternativeOptionUser $QuestionAlternativeOptionUser
 */
class UserQuestionOption extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'UserQuestion' => array(
			'className' => 'UserQuestion',
			'foreignKey' => 'user_question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'QuestionAlternativeOptionUser' => array(
			'className' => 'QuestionAlternativeOptionUser',
			'foreignKey' => 'question_alternative_option_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


}
