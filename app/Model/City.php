<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * City Model
 *
 * @property State $State
 */
class City extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'state_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function getOptionsForSelect($state_id, $label = 'Selecione'){
		$cities = $this->find('list',['conditions'=>['state_id'=>$state_id]]);
		$options = '<option value="">Selecione</option>';
		foreach($cities as $city_id => $city_name){
			$options .= '<option value="'.$city_id.'">'.$city_name.'</option>';
		}
		return $options;
	}
}
