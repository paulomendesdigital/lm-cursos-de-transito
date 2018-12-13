<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Partner Model
 *
 * @property User $User
 * @property DirectMessage $DirectMessage
 */
class Partner extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
		'birth' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo nascimento é obrigatório!",
			)
		)
	);

	public $validateAll = array(
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
		'birth' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo nascimento é obrigatório!",
			)
		),
		'gender' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo sexo é obrigatório!",
			)
		),
		'cellphone' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo Celular é obrigatório!",
			)
		),
		'zipcode' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo CEP é obrigatório!",
			)
		),
		'address' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo Endereço é obrigatório!",
			)
		),
		'number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo Número é obrigatório! Caso não possua número, coloque S/N",
			)
		),
		'neighborhood' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo Bairro é obrigatório!",
			)
		),
		'state_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo Estado é obrigatório!",
			)
		),
		'city_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Campo Cidade é obrigatório!",
			)
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
		)
	);

	public function beforeSave($options = array()){
		if( isset($this->data['Partner']['birth']) ) {
			$this->data['Partner']['birth'] = $this->dateFormatBeforeSave($this->data['Partner']['birth']);
		}
		return true;
	}

	public function afterFind($results, $primary = false){
		$new_result = [];
			
		foreach ($results as $key => $value) {
			if( isset($value['Partner']['name']) and !empty($value['Partner']['name']) ):
				$dataName = $this->__extractNameLastName($value['Partner']['name']);
				$value['Partner']['first_name'] = $dataName[0];
				$value['Partner']['last_name']  = isset($dataName[1]) ? $dataName[1] : NULL;
			endif;

			$new_result[$key] = $value;
		}
		return $new_result;
	}

	public function dateFormatBeforeSave($dateString){
	    if (!empty($dateString) && $dateString != '0000-00-00') {
            if (strpos($dateString, '/') !== false && $date = date_create_from_format('d/m/Y', $dateString)) {
                return $date->format('Y-m-d');
            } else if ($date = date_create($dateString)) {
                return $date->format('Y-m-d');
            }
        }
        return null;
	}


    public function validationTelefone($arrParams)
    {
        $value = isset($arrParams['cellphone']) ? $arrParams['cellphone'] : '';
        if (!is_string($value)) {
            return false;
        }

        $value = preg_replace('/[^0-9]/', '', $value);

        if ((strlen($value) != 10 && strlen($value) != 11)) {
            $valido = false;
        } else {
            $valido = !preg_match('/(.)\1{6,}/', preg_replace('/[^0-9]/', '', $value)); //mesmo número seguido repetido mais de 6 vezes
        }
        return $valido;
    }


}
