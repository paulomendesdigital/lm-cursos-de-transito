<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * DirectMessage Model
 *
 * @property User $User
 * @property Instructor $Instructor
 */
class DirectMessage extends AppModel {

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
		'instructor_id' => array(
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
		'Instructor' => array(
			'className' => 'Instructor',
			'foreignKey' => 'instructor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function afterFind($results, $primary = false){
		$result_customs = [];
		foreach ($results as $result) {
			if(isset($result['DirectMessage']['created'])):
				$dataFuturo = $result['DirectMessage']['created'];
				 $dataAtual = date('Y-m-d H:i:s');

				 $date_time  = new DateTime($dataAtual);
				 $diff       = $date_time->diff( new DateTime($dataFuturo));

				 $result['DirectMessage']['diff']['month'] = $diff->format('%m');
				 $result['DirectMessage']['diff']['day'] = $diff->format('%d');
				 $result['DirectMessage']['diff']['hour'] = $diff->format('%H');
				 $result['DirectMessage']['diff']['minute'] = $diff->format('%i');

			 elseif(isset($result['created'])):
				$dataFuturo = $result['created'];
				 $dataAtual = date('Y-m-d H:i:s');

				 $date_time  = new DateTime($dataAtual);
				 $diff       = $date_time->diff( new DateTime($dataFuturo));

				 $result['diff']['month'] = $diff->format('%m');
				 $result['diff']['day'] = $diff->format('%d');
				 $result['diff']['hour'] = $diff->format('%H');
				 $result['diff']['minute'] = $diff->format('%i');
			endif;
			$result_customs[] = $result;
		}
		return $result_customs;
	}

	public function beforeSave($options = []){
		//$this->data['DirectMessage']['author'] = AuthComponent::user('id');
	}
}
