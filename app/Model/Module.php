<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Module Model
 *
 * @property CourseType $CourseType
 * @property ModuleCourse $ModuleCourse
 * @property ModuleDiscipline $ModuleDiscipline
 * @property QuestionAlternative $QuestionAlternative
 * @property UserModuleLog $UserModuleLog
 * @property UserModuleSummary $UserModuleSummary
 * @property DisciplineCode $ExamDisciplineCode
 */
class Module extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'course_type_id' => array(
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
		'CourseType' => array(
			'className' => 'CourseType',
			'foreignKey' => 'course_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true,
			'counterScope' => ['Module.status'=>1]
		),
        'ExamDisciplineCode' => array(
            'className' => 'DisciplineCode',
            'foreignKey' => 'exam_discipline_code_id'
        )
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ModuleCourse' => array(
			'className' => 'ModuleCourse',
			'foreignKey' => 'module_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ['ModuleCourse.position'=>'ASC'],
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ModuleDiscipline' => array(
			'className' => 'ModuleDiscipline',
			'foreignKey' => 'module_id',
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
		'QuestionAlternative' => array(
			'className' => 'QuestionAlternative',
			'foreignKey' => 'module_id',
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
			'foreignKey' => 'module_id',
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
			'foreignKey' => 'module_id',
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
		'UserQuestion' => array(
			'className' => 'UserQuestion',
			'foreignKey' => 'modelid',
			'dependent' => true,
			'conditions' => ['UserQuestion.model' => 'Module'],
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
			
	);

	public function afterFind($results, $primary = false){
		$newResult = [];
		foreach ($results as $key => $value) {
			if(isset($value['Module']['id'])):
				$arr = [
					'Module' => [
						'id' => $value['Module']['id']
					],
					'User' => [
						'id' => AuthComponent::user('id')
					]
				];
			endif;
			$newResult[$key] = $value;
			if(isset($arr)):
				$newResult[$key]['Module']['token'] = $value['Module']['id'].'_'.AuthComponent::password(serialize($arr));
			endif;
		}
		return $newResult;
	}

	public function __getListWithTypeCourse($course_type_id=null){
		$modules = [];
		$conditions['Module.status'] = 1;

		if( $course_type_id ){
			$conditions['Module.course_type_id'] = $course_type_id;
		}

		$modulesList = $this->find('all', ['recursive'=>0,'conditions'=>$conditions]);

		foreach ($modulesList as $module) {
			$modules[$module['Module']['id']] = "{$module['CourseType']['name']} :: {$module['Module']['name']}";
		}
		return $modules;
	}

	public function __getModule($id){
		$this->recursive = 0;
		return $this->findById($id);
	}

	//replica os modulos/disciplinas/sliders e todas as questoes de simulados/provas vinculadas a ele para um novo tipo de curso
	public function __replicate_all($course_type_id, $module){
		$data['Module'] = $module[0]['Module'];
		$data['QuestionAlternative'] = (isset($module[0]['QuestionAlternative']) and !empty($module[0]['QuestionAlternative'])) ? $module[0]['QuestionAlternative'] : array();
		$data['ModuleDiscipline'] = (isset($module[0]['ModuleDiscipline']) and !empty($module[0]['ModuleDiscipline'])) ? $module[0]['ModuleDiscipline'] : array();
		
		unset($data['Module']['id']);
		$data['Module']['course_type_id'] = $course_type_id;

		$this->create();
		if( $this->save($data['Module']) ){

			if( !empty($data['ModuleDiscipline']) ){
				$this->__createModuleDisciplines($data['ModuleDiscipline']);
			}

			if( !empty($data['QuestionAlternative']) ){
				$this->__createQuestionAlternatives($data['QuestionAlternative']);
			}
		}
	}

	private function __createModuleDisciplines($moduleDisciplines){

		foreach ( $moduleDisciplines as $moduleDiscipline ) {
			
			$data['ModuleDiscipline'] = $moduleDiscipline;
			unset($data['ModuleDiscipline']['id']);
			$data['ModuleDiscipline']['module_id'] = $this->id;

			$data['ModuleDisciplineSlider'] = $moduleDiscipline['ModuleDisciplineSlider'];
			unset($data['ModuleDiscipline']['ModuleDisciplineSlider']);
			
			$this->ModuleDiscipline->create();
			if( $this->ModuleDiscipline->save($data['ModuleDiscipline']) ){
				foreach ($data['ModuleDisciplineSlider'] as $moduleDisciplineSlider) {
					unset($moduleDisciplineSlider['id']);
					$moduleDisciplineSlider['module_discipline_id'] = $this->ModuleDiscipline->id;
					
					$this->ModuleDiscipline->ModuleDisciplineSlider->create();
					$this->ModuleDiscipline->ModuleDisciplineSlider->save($moduleDisciplineSlider);
				}
			}
		}
	}

	private function __createQuestionAlternatives($questionAlternatives){

		foreach ( $questionAlternatives as $questionAlternative ) {
					
			$data['QuestionAlternative'] = $questionAlternative;
			unset($data['QuestionAlternative']['id']);
			$data['QuestionAlternative']['module_id'] = $this->id;

			$data['QuestionAlternativeOption'] = $questionAlternative['QuestionAlternativeOption'];
			unset($data['QuestionAlternative']['QuestionAlternativeOption']);
			
			$this->QuestionAlternative->create();
			if( $this->QuestionAlternative->save($data['QuestionAlternative']) ){
				foreach ($data['QuestionAlternativeOption'] as $qao) {
					$option['QuestionAlternativeOption'] = $qao;
					$option['QuestionAlternativeOption']['question_alternative_id'] = $this->QuestionAlternative->id;
					unset($option['QuestionAlternativeOption']['id']);
					$this->QuestionAlternative->QuestionAlternativeOption->create();
					$this->QuestionAlternative->QuestionAlternativeOption->save($option);
				}
			}
		}
	}

}
