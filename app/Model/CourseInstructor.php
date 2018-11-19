<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseInstructor Model
 *
 * @property Course $Course
 * @property Instructor $Instructor
 */
class CourseInstructor extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'course_id' => array(
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
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
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
		$newResult = [];
		foreach ($results as $key => $value) {
			if(isset($value['CourseInstructor']['id']) && isset($value['CourseInstructor']['instructor_id'])):
				$arr = [
					'CourseInstructor' => [
						'id' => $value['CourseInstructor']['id'],
						'instructor_id' => $value['CourseInstructor']['instructor_id'],
					],
					'User' => [
						'id' => AuthComponent::user('id')
					]
				];
			endif;
			$newResult[$key] = $value;
			if(isset($arr)):
				$newResult[$key]['CourseInstructor']['token'] = $value['CourseInstructor']['id'].'_'.AuthComponent::password(serialize($arr));
			endif;
		}
		return $newResult;
	}


}
