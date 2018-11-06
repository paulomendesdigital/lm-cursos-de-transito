<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * QuestionAlternative Model
 *
 * @property Module $Module
 * @property QuestionAlternativeOptionUser $QuestionAlternativeOptionUser
 * @property QuestionAlternativeOption $QuestionAlternativeOption
 */
class QuestionAlternative extends AppModel {

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
			'order' => '',
			'counterCache' => true,
			'counterScope' => ['Module.status'=>1]
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
			'foreignKey' => 'question_alternative_id',
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
		'QuestionAlternativeOption' => array(
			'className' => 'QuestionAlternativeOption',
			'foreignKey' => 'question_alternative_id',
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

	public function beforeSave($options = []){
		//Remove QuestionAlternativeOption relacionados ao salvar QuestionAlternative
		if(isset($this->data['QuestionAlternativeOption'])  && isset($this->data['QuestionAlternative']['id'])):
			$this->removeQuestionAlternativeOption($this->data['QuestionAlternativeOption'], $this->data['QuestionAlternative']['id']);
		endif;
	}

	private function removeQuestionAlternativeOption($data, $id){

		$value_id = [];
		foreach ($data as $value):
			if(isset($value['QuestionAlternativeOption']['id'])):
				$value_id[] = $value['QuestionAlternativeOption']['id'];
			endif;
		endforeach;

		$this->Behaviors->load('Containable');
		$QuestionAlternative = $this->find('first', [
				'contain' => ['QuestionAlternativeOption' => ['fields' => 'id']],
				'conditions' => ['QuestionAlternative.id' => $id]
			]);

		$value__db_id = [];
		foreach ($QuestionAlternative['QuestionAlternativeOption'] as $value):
			$value__db_id[] = $value['id'];
		endforeach;
		$ids_delete = array_diff($value__db_id, $value_id);
		if($ids_delete)
			$this->QuestionAlternativeOption->deleteAll(array('QuestionAlternativeOption.id' => $ids_delete));
	}


}
