<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Method Model
 *
 * @property Order $Order
 */
class Method extends AppModel {

    CONST PAGARME_BOLETO          = 1;    
    CONST PAGARME_BOLETO_CODE = 'boleto';
	CONST PAGARME_CARTAO_CREDITO  = 2;
    CONST PAGARME_CARTAO_CREDITO_CODE = 'credit_card';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'method_id',
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

	public function getActiveMethods(){
        return $this->find('list', array('conditions'=>array('Method.status'=>1)));
    }

    public function getMetodoPagamentoPagarmeCartaoId(){
        return self::PAGARME_CARTAO_CREDITO;
    }
    public function getMetodoPagamentoPagarmeBoletoId(){
        return self::PAGARME_BOLETO;
    }
    public function getMetodoPagamentoPagarmeCartaoCode(){
        return self::PAGARME_CARTAO_CREDITO_CODE;
    }
    public function getMetodoPagamentoPagarmeBoletoCode(){
        return self::PAGARME_BOLETO_CODE;
    }

}