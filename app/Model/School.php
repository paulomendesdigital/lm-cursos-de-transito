<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * School Model
 *
 * @property User $User
 * @property DirectMessage $DirectMessage
 * @property State $State
 */
class School extends AppModel {

	public $actsAs = array(
        'Upload.Upload' => array(
            'image' => array(
                'fields' => array(
                    'dir' => 'image_dir'
                ),
                'thumbnailSizes' => array(
                    'xvga' 	=> '400x400',
                    'vga'	=> '200x200',
                    'thumb' => '216x80'
                )
            )
        ),
    );

	/**
	 * Validation rules
	 *
	 * @var array
	*/
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Campo nome é obrigatório!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'address' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Campo endereço é obrigatório!',
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
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Instructor' => array(
			'className' => 'Instructor',
			'foreignKey' => 'school_id',
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
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'school_id',
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
		if( isset($this->data['School']['site']) and !empty($this->data['School']['site']) ){
			if ( !strstr($this->data['School']['site'], 'http://') and !strstr($this->data['School']['site'], 'https://') ) {
				$this->data['School']['site'] = "http://{$this->data['School']['site']}";
			}
		}
		if( isset($this->data['School']['facebook']) and !empty($this->data['School']['facebook']) ){
			if ( !strstr($this->data['School']['facebook'], 'http://') and !strstr($this->data['School']['facebook'], 'https://') ) {
				$this->data['School']['facebook'] = "http://{$this->data['School']['facebook']}";
			}
		}
		return true;
	}

	public function afterFind($results, $primary = false){
		$new_result = [];
			
		foreach ($results as $key => $value) {
			if( isset($value['School']['address']) ):
				$value['School']['full_address'] = "{$value['School']['address']}, {$value['School']['number']}, {$value['School']['complement']} {$value['School']['neighborhood']}";
				if( isset($value['City']['name']) and isset($value['State']['abbreviation']) ){
					$value['School']['full_address'] .= "- {$value['City']['name']} / {$value['State']['abbreviation']}";
				}
			endif;
			$new_result[$key] = $value;
		}
		return $new_result;
	}
}
