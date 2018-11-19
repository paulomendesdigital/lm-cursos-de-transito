<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Forum Model
 *
 * @property Course $Course
 * @property Citie $Citie
 * @property State $State
 * @property User $User
 * @property ForumPost $ForumPost
 */
class Forum extends AppModel {

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
		/*'citie_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'state_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
		'ForumPost' => array(
			'className' => 'ForumPost',
			'foreignKey' => 'forum_id',
			'dependent' => false,
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
		$newResult = [];
		foreach ($results as $key => $value) {
			if(isset($value['Forum']['id'])):
				$arr = [
					'Forum' => [
						'id' => $value['Forum']['id']
					],
					'User' => [
						'id' => AuthComponent::user('id')
					]
				];
			endif;
			$newResult[$key] = $value;
			if(isset($arr)):
				$newResult[$key]['Forum']['token'] = $value['Forum']['id'].'_'.AuthComponent::password(serialize($arr));
			endif;


			if(isset($value['Forum']['created'])):
				$dataFuturo = $value['Forum']['created'];
				 $dataAtual = date('Y-m-d H:i:s');

				 $date_time  = new DateTime($dataAtual);
				 $diff       = $date_time->diff( new DateTime($dataFuturo));

				 $newResult[$key]['Forum']['diff']['month'] = $diff->format('%m');
				 $newResult[$key]['Forum']['diff']['day'] = $diff->format('%d');
				 $newResult[$key]['Forum']['diff']['hour'] = $diff->format('%H');
				 $newResult[$key]['Forum']['diff']['minute'] = $diff->format('%i');

			 elseif(isset($value['created'])):
				$dataFuturo = $value['created'];
				 $dataAtual = date('Y-m-d H:i:s');

				 $date_time  = new DateTime($dataAtual);
				 $diff       = $date_time->diff( new DateTime($dataFuturo));

				 $newResult[$key]['diff']['month'] = $diff->format('%m');
				 $newResult[$key]['diff']['day'] = $diff->format('%d');
				 $newResult[$key]['diff']['hour'] = $diff->format('%H');
				 $newResult[$key]['diff']['minute'] = $diff->format('%i');
			endif;
		}
		return $newResult;
	}
}
