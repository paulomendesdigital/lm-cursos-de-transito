<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseState Model
 *
 * @property City $City
 * @property Forum $Forum
 * @property ModuleCourse $ModuleCourse
 * @property OrderCourse $OrderCourse
 */
class CourseState extends AppModel {

	/**
 	* Validation rules
 	*
 	* @var array
 	*/
	public $validate = array(
		'course_type_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Tipo de curso não localizado!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'state_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'É obrigatório selecionar o Estado',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'price' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Preço por Estado é obrigatório!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $belongsTo = array(
		'State'=>array(
			'className' => 'State',
			'foreignKey' => 'state_id',
		),
		'CourseType'=>array(
			'className' => 'CourseType',
			'foreignKey' => 'course_type_id',
			'counterCache' => true,
			'counterScope' => ['CourseType.status'=>1]
		),
	);
	/**
 	* hasMany associations
 	*
 	* @var array
 	*/
	public $hasMany = array(
		'CourseCity' => array(
			'className' => 'CourseCity',
			'foreignKey' => 'course_state_id',
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
	);

	public function beforeSave($options = array()) {

		if( isset($this->data['CourseState']['id']) and !empty($this->data['CourseState']['id']) ){
			if( isset($this->data['CourseCity']) and !empty($this->data['CourseCity']) ){
				//zero os status para gravar apenas o quem no form
				//$this->query("UPDATE course_cities SET status = 0 WHERE course_state_id = {$this->data['CourseState']['id']}");
				//zero o count, para resolver o couterCache, pois a query acima foi feita fora do cake
				//$this->query("UPDATE course_states SET course_city_count = 0 WHERE id = {$this->data['CourseState']['id']}");
			}
		}
		return true;
	}

	public function dataProcessing($data){
		
		if( isset($data['CourseCity']) and !empty($data['CourseCity']) ){
			$priceState = $data['CourseState']['price'];
			$priceCity  = $data['CourseCity']['price'];
			$checkedAll = isset($data['CourseCity']['todas']) ? $data['CourseCity']['todas'] : false;

			unset($data['CourseCity']['todas']);
			unset($data['CourseCity']['price']);
			$i=0;
			foreach ($data['CourseCity'] as $city) {
				if( !isset($city['city_id']) ){
					unset($data['CourseCity'][$i]);
				}else{
					if( empty($city['price']) ){
						$data['CourseCity'][$i]['price'] = !empty($priceCity) ? $priceCity : $priceState;
					}
				}
				$i++;
			}
		}
		return $data;
	}

	public function __extractStatesList($courseStates){

		$states = false;
		foreach ($courseStates as $state) {
			$states[$state['State']['id']] = $state['State']['name'];
		}
		return $states;
	}

	public function __getCitiesByCourseState($state_id, $courseTypeId = null){
	    $conditions = [['CourseState.state_id'=>$state_id]];

	    if (!empty($courseTypeId)) {
	        $conditions[] = ['CourseState.course_type_id' => $courseTypeId];
        }
        $this->Behaviors->load('Containable');
		$courseState = $this->find('first', [
            'contain'=>['CourseCity'=>['City']],
            'conditions'=> $conditions
        ]);
        $cities = [];
        foreach($courseState['CourseCity'] as $city){
            $cities[$city['City']['id']] = $city['City']['name'];
        }
        return $cities;
	}
}
