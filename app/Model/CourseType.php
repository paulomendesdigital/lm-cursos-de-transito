<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseType Model
 *
 * @property Course $Course
 * @property Module $Module
 */
class CourseType extends AppModel {

	CONST TAXI 			 = 1;
	CONST ESPECIALIZADOS = 2;
	CONST RECICLAGEM 	 = 3;
	CONST NEUTROS 	 	 = 4;

    CONST AMBITO_NEUTRO    = 0;
	CONST AMBITO_NACIONAL  = 1;
	CONST AMBITO_ESTADUAL  = 2;
	CONST AMBITO_MUNICIPAL = 3;

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
 	* hasMany associations
 	*
 	* @var array
 	*/
	public $hasMany = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_type_id',
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
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'course_type_id',
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
		'CourseState' => array(
			'className' => 'CourseState',
			'foreignKey' => 'course_type_id',
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

	public function __listScopes($id=null){
		$list = [
            self::AMBITO_NEUTRO   => 'Neutro',
			self::AMBITO_NACIONAL => 'Nacional',
			self::AMBITO_ESTADUAL => 'Estadual',
			self::AMBITO_MUNICIPAL => 'Municipal'
		];
		return $id ? $list[$id] : $list;
	}

	public function __listScopesForOrder($id=null){
		$list = [
            self::AMBITO_NEUTRO    => 'neutro',
			self::AMBITO_NACIONAL  => 'nacional',
			self::AMBITO_ESTADUAL  => 'estadual',
			self::AMBITO_MUNICIPAL => 'municipal'
		];
		return $id !== null ? $list[$id] : $list;
	}

	public function __listScopesByText(){
		return [
            'Neutro'    => self::AMBITO_NEUTRO,
			'Nacional'  => self::AMBITO_NACIONAL,
			'Estadual'  => self::AMBITO_ESTADUAL,
			'Municipal' => self::AMBITO_MUNICIPAL
		];
	}
	public function __getTaxiId(){
		return self::TAXI;
	}

	public function __getEspecializadosId(){
		return self::ESPECIALIZADOS;
	}

	public function __getReciclagemId(){
		return self::RECICLAGEM;
	}
}
