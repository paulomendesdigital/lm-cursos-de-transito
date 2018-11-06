<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserCertificateModule Model
 *
 * @property UserCertificate $UserCertificate
 */
class UserCertificateModule extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'module_name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'UserCertificate' => array(
			'className' => 'UserCertificate',
			'foreignKey' => 'user_certificate_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


}
