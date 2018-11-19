<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Cart Model
 * @property Product $Product
 */
class Cart extends AppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	*/
	public $validate = array(
		'product_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'amount' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sessionid' => array(
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
	 * belongsTo associations
	 *
	 * @var array
	*/
	public $belongsTo = array(
	    'State' => [
	        'className'  => 'State',
            'foreignKey' => 'state_id'
        ],
		'City' => [
		  'className'  => 'City',
          'foreignKey' => 'citie_id'
        ],
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function __containCourseInCart($id, $sessionid){
		$carts = $this->find('all', [
			'recursive'=>-1,
			'conditions' => [
				'Cart.course_id' => $id,
				'Cart.sessionid' => $sessionid
			]
		]);
		return count($carts);
	}

	public function __setValuesInRequestData($course, $sessionid){
		return [
			'course_id'=>$course['Course']['id'],
			'amount'=>1,
			'unitary_value'=>!empty($course['Course']['promotional_price']) ? $course['Course']['promotional_price'] : $course['Course']['price'],
			'unitary_discount'=>NULL,
			'state_id' => isset($course['Cart']['state_id']) ? $course['Cart']['state_id'] : null,
			'citie_id' => isset($course['Cart']['citie_id']) ? $course['Cart']['citie_id'] : null,
			'sessionid' => $sessionid,
            'cnh' => isset($course['Cart']['cnh']) ? $course['Cart']['cnh'] : null,
            'renach' => isset($course['Cart']['renach']) ? strtoupper($course['Cart']['renach']) : null,
            'cnh_category' => isset($course['Cart']['cnh_category']) ? strtoupper($course['Cart']['cnh_category']) : null
		];
	}

	public function __getCartsInSession($sessionid){
		return $this->find('all',[
            'contain'=>[
                'Course'=>[
                	'fields'=>['Course.id','Course.name','Course.image']
                ]
            ],
            'conditions'=>['Cart.sessionid'=>$sessionid]
        ]);
	}

	public function __addDiscount($cart, $ticket){
		
		if( !empty($ticket['Course']) ){

			$idsNotAllowed = $this->__getCourseIds($ticket['Course']);

			if( !in_array($cart['Cart']['course_id'], $idsNotAllowed) ){
				$cart['Cart']['unitary_discount'] = ($cart['Cart']['unitary_value'] * ($ticket['Ticket']['value']/100)) * $cart['Cart']['amount'];
				if( $this->save($cart) ){
					$this->Course->Ticket->__decrements($ticket);
					return true;
				}
			}
		}else{
			//se ticket['Course'] for vazio, é pq pode dar desconto para qq produto
			$cart['Cart']['unitary_discount'] = ($cart['Cart']['unitary_value'] * ($ticket['Ticket']['value']/100)) * $cart['Cart']['amount'];
			if( $this->save($cart) ){
				$this->Course->Ticket->__decrements($ticket);
				return true;
			}
		}

		return false;
	}

	public function __removeDiscount($cart, $ticket){
		$cart['Cart']['unitary_discount'] = NULL;
		if( $this->save($cart) ){
			$this->Course->Ticket->__increments($ticket);
			return true;
		}
		return false;
	}

	public function __getDataForOrder($carts){
		$return['value'] = 0;
		$return['value_discount'] = 0;
		foreach ($carts as $cart) {
			$return['value'] += $cart['Cart']['unitary_value'];
			$return['value_discount'] += $cart['Cart']['unitary_discount'];
		}
		return $return;
	}

	private function __getCourseIds($courses){
		$ids = [];
		foreach ($courses as $course) {
			$ids[$course['id']] = $course['id'];
		}
		return $ids;
	}
}
