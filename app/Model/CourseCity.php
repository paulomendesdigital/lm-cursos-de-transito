<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseCity Model
 */
class CourseCity extends AppModel {

	/**
 	* Validation rules
 	*
 	* @var array
 	*/
	public $validate = array(
		'course_state_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'É obrigatório selecionar o Estado',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $belongsTo = array(
		'CourseState'=>array(
			'className' => 'CourseState',
			'foreignKey' => 'course_state_id',
			'counterCache' => true,
			'counterScope' => ['CourseCity.status'=>1]
		),
		'City'=>array(
			'className' => 'City',
			'foreignKey' => 'city_id',
		),
	);
}