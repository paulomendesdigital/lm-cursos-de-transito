<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Instructor Model
 *
 * @property User $User
 * @property DirectMessage $DirectMessage
 */
class Instructor extends AppModel {

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
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
		),
		'School' => array(
			'className' => 'School',
			'foreignKey' => 'school_id',
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'DirectMessage' => array(
			'className' => 'DirectMessage',
			'foreignKey' => 'instructor_id',
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

	public function afterFind($results, $primary = false){
		$new_result = [];

		if( isset($results['name']) and !empty($results['name']) ){
			$dataName = $this->__extractNameLastName($results['name']);
			$results['first_name'] = $dataName[0];
			$results['last_name']  = $dataName[1];
			$new_result = $results;
		}
		else{
			foreach ($results as $key => $value) {

				if( isset($value['Instructor']['name']) and !empty($value['Instructor']['name']) ):
					$dataName = $this->__extractNameLastName($value['Instructor']['name']);
					$value['Instructor']['first_name'] = $dataName[0];
					$value['Instructor']['last_name']  = $dataName[1];
				endif;

				$new_result[$key] = $value;
			}
		}

		return $new_result;
	}
}