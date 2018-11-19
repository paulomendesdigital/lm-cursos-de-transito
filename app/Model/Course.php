<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Course Model
 *
 * @property CourseType $CourseType
 * @property CourseInstructor $CourseInstructor
 * @property CourseCode $CourseCode
 * @property Forum $Forum
 */
class Course extends AppModel {

	public $actsAs = array(
        'Upload.Upload' => array(
            'image' => array(
                'fields' => array(
                    'dir' => 'image_dir'
                ),
                'thumbnailSizes' => array(
                    'xvga' 	=> '400x400',
                    'vga'	=> '200x200',
                    'thumb' => '140x140'
                )
            ),
            'student_guide',
            'navigability_guide'
        ),
    );

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
			'order' => ''
		),
        'CourseCode' => [
            'className'  => 'CourseCode',
            'foreignKey' => 'course_code_id'
        ],
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CourseMultimidia' => array(
			'className' => 'CourseMultimidia',
			'foreignKey' => 'course_id',
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
		'CourseWorkbook' => array(
			'className' => 'CourseWorkbook',
			'foreignKey' => 'course_id',
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
		'CourseLibrary' => array(
			'className' => 'CourseLibrary',
			'foreignKey' => 'course_id',
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
		'CourseInstructor' => array(
			'className' => 'CourseInstructor',
			'foreignKey' => 'course_id',
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
		'Forum' => array(
			'className' => 'Forum',
			'foreignKey' => 'course_id',
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
			'conditions' => ['UserQuestion.model' => 'Course'],
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ModuleCourse' => array(
			'className' => 'ModuleCourse',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ['ModuleCourse.state_id'=>'ASC', 'ModuleCourse.citie_id'=>'ASC','ModuleCourse.position'=>'ASC'],
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public $hasAndBelongsToMany = array(
        'Instructor' =>
        array(
        	'className' => 'Instructor',
            'joinTable' => 'course_instructors',
            'foreignKey' => 'course_id',
            'associationForeignKey' => 'instructor_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Ticket' => array(
    		'className' => 'Ticket',
            'joinTable' => 'ticket_courses',
            'foreignKey' => 'course_id',
            'associationForeignKey' => 'ticket_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

        

	public function afterFind($results, $primary = false){
		$newResult = [];
		foreach ($results as $key => $value) {
			if(isset($value['Course']['id'])):
				$arr = [
					'Course' => [
						'id' => $value['Course']['id']
					],
					'User' => [
						'id' => AuthComponent::user('id')
					]
				];
			endif;
			$newResult[$key] = $value;
			if(isset($arr)):
				$newResult[$key]['Course']['token'] = $value['Course']['id'].'_'.AuthComponent::password(serialize($arr));
			endif;
		}
		return $newResult;
	}

	public function beforeSave($options = []){

		//Remove ModuleCourse relacionados ao salvar Course
		if(isset($this->data['ModuleCourse']) && isset($this->data['Course']['id']) && $this->data['Course']['id'] != ''):
			$this->removeModuleCourse($this->data['ModuleCourse'], $this->data['Course']['id']);
		endif;
		return true;
	}

	private function removeModuleCourse($data, $id){
		
		$value_id = [];
		foreach ($data as $value):
			if(isset($value['id'])):
				$value_id[] = $value['id'];
			endif;
		endforeach;

		$this->Behaviors->load('Containable');
		$Course = $this->find('first', [
				'contain' => ['ModuleCourse' => ['fields' => 'id']],
				'conditions' => ['Course.id' => $id]
			]);

		$value__db_id = [];
		foreach ($Course['ModuleCourse'] as $value):
			$value__db_id[] = $value['id'];
		endforeach;
		$ids_delete = array_diff($value__db_id, $value_id);
		if($ids_delete)
			$this->ModuleCourse->deleteAll(array('ModuleCourse.id' => $ids_delete));
	}

	public function __getCourse($course_id){				
		return $this->find('first',['conditions'=>['Course.id'=>$course_id]]);
	}

	public function __getList($course_type_id=null){
		if( !$course_type_id ){
			return $this->find('list',['fields'=>['id','name'],'conditions'=>['status'=>1],'order'=>'name']);
		}else{
			return $this->find('list',['fields'=>['id','name'],'conditions'=>['status'=>1,'course_type_id'=>$course_type_id],'order'=>'name']);
		}
	}

	public function __getListForHABTM(){
		return $this->find('list',['fields'=>['Course.id','name'],'order'=>'name'],['conditions'=>['Course.status'=>1]]);
	}

	public function getStatesOfCourse($course_id)
    {
        $this->Behaviors->load('Containable');
        $course = $this->find('first', [
            'recursive'  => false,
            'conditions' => array('Course.id' => $course_id),
            'fields'  => ['id', 'course_type_id'],
            'contain' => [
                'CourseType' => ['fields' => ['id', 'scope'],
                    'CourseState' => ['fields' => [],
                        'State'
                    ]
                ]
            ]
        ]);
        return $this->CourseType->CourseState->__extractStatesList($course['CourseType']['CourseState']);
    }

}
