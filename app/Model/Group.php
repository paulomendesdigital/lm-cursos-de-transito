<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Group Model
 *
 * @property User $User
 */
class Group extends AppModel {

	CONST ADMINISTRADOR = 1;
	CONST INSTRUTOR = 2;
	CONST OPERADOR = 3;
	CONST ALUNO = 4;
	CONST TUTOR = 5;
	CONST PARCEIRO = 6;
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'group_id',
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

	public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        return null;
    }

    public function getStatusList(){
        return array(
            self::ADMINISTRADOR => "Administrador",
            self::INSTRUTOR  	=> "Instrutor",
            self::OPERADOR      => "Operador",
			self::ALUNO         => "Aluno",
			self::PARCEIRO		=> "Parceiro",
            self::TUTOR         => "Tutor"
        );
    }

    public function getAdministrador(){
        return self::ADMINISTRADOR;
    }

	public function getInstrutor(){
        return self::INSTRUTOR;
    }

    public function getProfessor(){
        return self::INSTRUTOR;
    }

	public function getTutor(){
        return self::TUTOR;
	}

	public function getOperador(){
        return self::OPERADOR;
	}

	public function getAluno(){
        return self::ALUNO;
	}

	public function getParceiro(){
        return self::PARCEIRO;
	}

	public function getGroup($group_id=1){
		$groups = self::getStatusList();
		return $groups[$group_id];
	}
}
