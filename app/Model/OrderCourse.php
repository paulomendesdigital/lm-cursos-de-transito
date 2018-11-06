<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * OrderCourse Model
 *
 * @property Order $Order
 * @property Course $Course
 * @property Citie $Citie
 * @property State $State
 * @property StatusDetran $StatusDetran
 */
class OrderCourse extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'order_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'citie_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'state_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
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
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Citie' => array(
			'className' => 'Citie',
			'foreignKey' => 'citie_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'StatusDetran' => array(
            'className' => 'StatusDetran',
            'foreignKey' => 'status_detran_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
	);

	public function afterFind($results, $primary = false){
		$newResult = [];
		foreach ($results as $key => $value) {
			if(isset($value['OrderCourse']['id']) && isset($value['OrderCourse']['order_id']) && isset($value['Order']['user_id'])):
				$arr = [
					'OrderCourse' => [
						'id' => $value['OrderCourse']['id'],
						'course_id' => $value['OrderCourse']['course_id'],
						'citie_id' => $value['OrderCourse']['citie_id'],
						'state_id' => $value['OrderCourse']['state_id'],
					],
					'Order' => [
						'user_id' => $value['Order']['user_id'],
						'id' => $value['OrderCourse']['order_id']
					],
					'User' => [
						'id' => $value['Order']['user_id']
					]
				];
			endif;
			$newResult[$key] = $value;
			if(isset($arr)):
				$newResult[$key]['OrderCourse']['token'] = $value['OrderCourse']['id'].'_'.AuthComponent::password(serialize($arr));
			endif;
		}
		return $newResult;
	}


}
