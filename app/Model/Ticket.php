<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Ticket Model
 *
 * @property User $User
 * @property Order $Order
 * @property TicketCourse $TicketCourse
 */
class Ticket extends AppModel {

	public $validate = array(
		'code' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Já existe outra cupom com este código!'
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'O campo código é obrigatório!',
			),
		),
		'amount' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'O campo quantidade é obrigatório!',
			),
		),
		'start' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'O campo data de início é obrigatório!',
			),
		),
		'finish' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'O campo data de fim é obrigatório!',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'ticket_id',
			'dependent' => false,
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

	public $hasAndBelongsToMany = array(
        'Course' => array(
    		'className' => 'Course',
            'joinTable' => 'ticket_courses',
            'foreignKey' => 'ticket_id',
            'associationForeignKey' => 'Course_id',
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

    public $hasOne = array(
        '_TicketCourse' => array(
            'className' => 'TicketCourse',
            'foreignKey' => 'ticket_id',
            'fields' => array('id', 'ticket_id')
        ),
        '_Course' => array(
            'className' => 'Course',
            'foreignKey' => false,
            'conditions' => '_Course.id = _TicketCourse.course_id',
            'fields' => 'id'
        ),
    );

    function beforeSave( $options = array() ){
		if( !empty($this->data['Ticket']['start']) ){
			$this->data['Ticket']['start'] = $this->dateFormatBeforeSave( $this->data['Ticket']['start'] );
		}
		if( !empty($this->data['Ticket']['finish']) ){
			$this->data['Ticket']['finish'] = $this->dateFormatBeforeSave( $this->data['Ticket']['finish'] );
		}
		return true;
	}

    public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $val) {
	        if (isset($val['Ticket']['start'])) {
	            $results[$key]['Ticket']['start'] = $this->dateFormatAfterFind( $val['Ticket']['start'] );
	        }
	        if (isset($val['Ticket']['finish'])) {
	            $results[$key]['Ticket']['finish'] = $this->dateFormatAfterFind( $val['Ticket']['finish'] );
	        }
	    }
	    return $results;
	}

	public function __getTicketByCode($code){
		return $this->find('first',[
			'contain'=>[
				'Course'=>[
					'fields'=>['Course.id','Course.name','Course.promotional_price','Course.price','Course.image']
				],
			],
			'conditions'=>['Ticket.code'=>$code]
		]);
	}

	public function __isValid($ticket){
		$hoje = date('Ymd'); 
		$finish = date('Ymd', strtotime($this->dateFormatBeforeSave($ticket['Ticket']['finish']) ));
		return ($finish >= $hoje) and ($ticket['Ticket']['status'] == 1) and ($ticket['Ticket']['amount']>0);
	}

	//retira 1 qtde do ticket que acabou de ser usado
	public function __decrements($ticket){
		$ticket['Ticket']['amount'] = $ticket['Ticket']['amount'] - 1;
		return $this->save($ticket);
	}

	//incrementa 1 qtde do ticket, caso o cliente desiste de usar o cupom
	public function __increments($ticket){
		$ticket['Ticket']['amount'] = $ticket['Ticket']['amount'] + 1;
		return $this->save($ticket);
	}

	public function __getList(){
		return $this->find('list',[
			'fields'=>['Ticket.id','Ticket.code'],
			'order'=>['Ticket.code']
		]);
	}
}
