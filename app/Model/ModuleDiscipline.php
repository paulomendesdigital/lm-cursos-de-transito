<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleDiscipline Model
 *
 * @property Module $Module
 * @property ModuleDisciplinePlayer $ModuleDisciplinePlayer
 * @property ModuleDisciplineSlider $ModuleDisciplineSlider
 * @property UserModuleLog $UserModuleLog
 * @property UserModuleSummary $UserModuleSummary
 * @property DisciplineCode $DisciplineCode
 */
class ModuleDiscipline extends AppModel {

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
		'position' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'discipline_code_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
		'allowEmpty' => true,
            )
        )
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
		),
        'DisciplineCode' => [
            'className' => 'DisciplineCode',
            'foreignKey' => 'discipline_code_id',
        ]
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ModuleDisciplinePlayer' => array(
			'className' => 'ModuleDisciplinePlayer',
			'foreignKey' => 'module_discipline_id',
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
		'ModuleDisciplineSlider' => array(
			'className' => 'ModuleDisciplineSlider',
			'foreignKey' => 'module_discipline_id',
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
		'UserModuleLog' => array(
			'className' => 'UserModuleLog',
			'foreignKey' => 'module_discipline_id',
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
		'UserModuleSummary' => array(
			'className' => 'UserModuleSummary',
			'foreignKey' => 'module_discipline_id',
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
		$newResult = [];
		foreach ($results as $key => $value) {
			if(isset($value['ModuleDiscipline']['id'])):
				$arr = [
					'ModuleDiscipline' => [
						'id' => $value['ModuleDiscipline']['id']
					],
					'User' => [
						'id' => AuthComponent::user('id')
					]
				];
			endif;
			$newResult[$key] = $value;
			if(isset($arr)):
				$newResult[$key]['ModuleDiscipline']['token'] = $value['ModuleDiscipline']['id'].'_'.AuthComponent::password(serialize($arr));
			endif;
		}
		return $newResult;
	}

	public function beforeSave($options = []){
		
		//Remove ModuleDisciplineSlider relacionados ao salvar ModuleDiscipline
		if(isset($this->data['ModuleDisciplineSlider']) && isset($this->data['ModuleDiscipline']['id'])):
			$this->removeModuleDisciplineSlider($this->data['ModuleDisciplineSlider'], $this->data['ModuleDiscipline']['id']);
		endif;

		//Remove ModuleDisciplinePlayer relacionados ao salvar ModuleDiscipline
		if(isset($this->data['ModuleDisciplinePlayer']) && isset($this->data['ModuleDiscipline']['id'])):
			$this->removeModuleDisciplinePlayer($this->data['ModuleDisciplinePlayer'], $this->data['ModuleDiscipline']['id']);
		endif;
	}

	private function removeModuleDisciplineSlider($data, $id){
		
		$value_id = [];
		foreach ($data as $value):
			if(isset($value['ModuleDisciplineSlider']['id'])):
				$value_id[] = $value['ModuleDisciplineSlider']['id'];
			endif;
		endforeach;

		$this->Behaviors->load('Containable');
		$ModuleDiscipline = $this->find('first', [
				'contain' => ['ModuleDisciplineSlider' => ['fields' => 'id']],
				'conditions' => ['ModuleDiscipline.id' => $id]
			]);

		$value__db_id = [];
		foreach ($ModuleDiscipline['ModuleDisciplineSlider'] as $value):
			$value__db_id[] = $value['id'];
		endforeach;
		$ids_delete = array_diff($value__db_id, $value_id);
		if($ids_delete)
			$this->ModuleDisciplineSlider->deleteAll(array('ModuleDisciplineSlider.id' => $ids_delete));
	}

	private function removeModuleDisciplinePlayer($data, $id){
		
		$value_id = [];
		foreach ($data as $value):
			if(isset($value['ModuleDisciplinePlayer']['id'])):
				$value_id[] = $value['ModuleDisciplinePlayer']['id'];
			endif;
		endforeach;

		$this->Behaviors->load('Containable');
		$ModuleDiscipline = $this->find('first', [
				'contain' => ['ModuleDisciplinePlayer' => ['fields' => 'id']],
				'conditions' => ['ModuleDiscipline.id' => $id]
			]);

		$value__db_id = [];
		foreach ($ModuleDiscipline['ModuleDisciplinePlayer'] as $value):
			$value__db_id[] = $value['id'];
		endforeach;
		$ids_delete = array_diff($value__db_id, $value_id);
		if($ids_delete)
			$this->ModuleDisciplinePlayer->deleteAll(array('ModuleDisciplinePlayer.id' => $ids_delete));		
	}



}
