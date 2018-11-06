<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ForumPost Model
 *
 * @property Forum $Forum
 * @property User $User
 * @property ForumPostComment $ForumPostComment
 */
class ForumPost extends AppModel {
	public $displayField = 'text';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'forum_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'Forum' => array(
			'className' => 'Forum',
			'foreignKey' => 'forum_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ForumPostComment' => array(
			'className' => 'ForumPostComment',
			'foreignKey' => 'forum_post_id',
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
		$result_customs = [];
		foreach ($results as $result) {
			if(isset($result['ForumPost']['created'])):
				$dataFuturo = $result['ForumPost']['created'];
				 $dataAtual = date('Y-m-d H:i:s');

				 $date_time  = new DateTime($dataAtual);
				 $diff       = $date_time->diff( new DateTime($dataFuturo));

				 $result['ForumPost']['diff']['month'] = $diff->format('%m');
				 $result['ForumPost']['diff']['day'] = $diff->format('%d');
				 $result['ForumPost']['diff']['hour'] = $diff->format('%H');
				 $result['ForumPost']['diff']['minute'] = $diff->format('%i');

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



}
