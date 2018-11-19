<?php
App::uses('AppModel', 'Model');

class StatusDetran extends AppModel {

    const NAO_VALIDADO         = '';
    const ERRO                 = 1;
    const VALIDADO             = 2;
    const MATRICULADO          = 3;
    const AGUARDANDO_CONCLUSAO = 4;
    const CONCLUIDO            = 5;
    const CANCELADO            = 6;

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nome' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			)
		),
	);
}
