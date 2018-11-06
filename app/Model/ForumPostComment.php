<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ForumPostComment Model
 *
 * @property ForumPost $ForumPost
 * @property User $User
 */
class ForumPostComment extends AppModel {
	public $displayField = 'text';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'forum_post_id' => array(
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
		'text' => array(
			'notempty' => array(
                'rule' => array('notempty'),
                'message' => array('Campo Obrigatório'),
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
		'ForumPost' => array(
			'className' => 'ForumPost',
			'foreignKey' => 'forum_post_id',
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

	public function afterFind($results, $primary = false){
		$result_customs = [];
		foreach ($results as $result) {
			if(isset($result['ForumPostComment']['created'])):
				$dataFuturo = $result['ForumPostComment']['created'];
				 $dataAtual = date('Y-m-d H:i:s');

				 $date_time  = new DateTime($dataAtual);
				 $diff       = $date_time->diff( new DateTime($dataFuturo));

				 $result['ForumPostComment']['diff']['month'] = $diff->format('%m');
				 $result['ForumPostComment']['diff']['day'] = $diff->format('%d');
				 $result['ForumPostComment']['diff']['hour'] = $diff->format('%H');
				 $result['ForumPostComment']['diff']['minute'] = $diff->format('%i');

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
