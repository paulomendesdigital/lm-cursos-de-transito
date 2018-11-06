<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Order Model
 *
 * @property OrderType $OrderType
 * @property User $User
 * @property OrderCourse $OrderCourse
 */
class Order extends AppModel {

    /**
     * Flag para verificar o model está sendo gravado juntamente com outros models associados
     * @var bool
     */
    private $isSalvingAssociated = false;

	/**
	 * Validation rules
	 *
	 * @var array
	*/
	public $validate = array(
		'order_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Status não identificado!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Usuário não idenditicado na compra!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            //'purchased'  => [
            //    'rule'    => 'havePurchaseForThisUserValidation',
            //    'message' => 'Já existe uma matrícula para o aluno neste curso.',
            //    'on'      => 'create'
            //],
            'integracao' => [
                'rule' => 'integracaoConsultaValidation',
                'message' => 'Problemas na validação do Detran!',
                'on' => 'create'
            ],
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	*/
	public $belongsTo = array(
		'OrderType' => array(
			'className' => 'OrderType',
			'foreignKey' => 'order_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Method' => array(
			'className' => 'Method',
			'foreignKey' => 'method_id'
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	*/
	public $hasMany = array(
		'Payment' => array(
            'className' => 'Payment',
            'foreignKey' => 'order_id',
            'dependent' => true,
        ),
		'OrderCourse' => array(
			'className' => 'OrderCourse',
			'foreignKey' => 'order_id',
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
		'UserModuleSummary' => array(
			'className' => 'UserModuleSummary',
			'foreignKey' => 'order_id',
			'dependent' => true,
		),
		'UserQuestion' => array(
			'className' => 'UserQuestion',
			'foreignKey' => 'order_id',
			'dependent' => true,
		),
		'UserModuleLog' => array(
			'className' => 'UserModuleLog',
			'foreignKey' => 'order_id',
			'dependent' => true,
		),
	);

	public function afterSave($created, $options = []){

	    //Pagamento Aprovado
		if ( $this->data['Order']['order_type_id'] == $this->Payment->getStatusByText('Aprovado') ) {



            //Verifica se os módulos já foram disponibilizados para esta compra
            $UserModuleSummary = $this->UserModuleSummary->find('count', ['conditions' => ['UserModuleSummary.order_id' => $this->id]]);

            if ($UserModuleSummary == false) {
                if (!empty($this->data['OrderCourse'])) {
                    $this->insertUserModuleSummary($this->data);
                }
            } else {
                if (!empty($this->data['OrderCourse'])) {
                    $this->updateUserModuleSummary($this->data);
                }
            }
		    
		    if (!$this->isSalvingAssociated) {
                $this->integracaoMatricula($this->data);
            }
        }

		return true;
	}

	public function beforeSave($options = []){
		if( empty($this->data) ){
			return false;
		}

		return true;
	}

	public function havePurchaseForThisUserValidation() {

        $this->Behaviors->attach('Containable');
        foreach ($this->data['OrderCourse'] as $orderCourse) {
            if (isset($orderCourse['OrderCourse'])) {
                $orderCourse = $orderCourse['OrderCourse'];
            }
            $order = $this->find('first', array(
                'contain'    => array(
                    'OrderCourse' => array(
                        'conditions' => array(
                            'OrderCourse.course_id' => isset($orderCourse['course_id']) ? $orderCourse['course_id'] : null,
                            'OrderCourse.state_id'  => isset($orderCourse['state_id']) ? $orderCourse['state_id'] : null,
                            'OrderCourse.citie_id'  => isset($orderCourse['citie_id']) ? $orderCourse['citie_id'] : null
                        )
                    )
                ),
                'conditions' => array(
                    'Order.user_id'       => $this->data['Order']['user_id'],
                    'Order.order_type_id' => [
                        $this->Payment->getStatusAprovado(),
                        $this->Payment->getStatusDisponivel()
                    ]
                )
            ));
            if (!empty($order['OrderCourse'])) {
                return false;
            }
        }
        return true;
	}

	public function insertUserModuleSummary($data, $order_id=false){

		foreach ($data['OrderCourse'] as $order_course):

			//se tiver $order_id é pq veio do controller o pedido de gravacao
			if( $order_id ){
				$this->id = $order_id;
			}

            $order_course = isset($order_course['OrderCourse']) ? $order_course['OrderCourse'] : $order_course;

			$conditions['ModuleCourse.course_id'] = $order_course['course_id'];

			if( !empty($order_course['citie_id']) ){
				$conditions['ModuleCourse.citie_id'] = $order_course['citie_id'];
			}
			if( !empty($order_course['state_id']) ){
				$conditions['ModuleCourse.state_id'] = $order_course['state_id'];
			}

			$this->OrderCourse->Course->ModuleCourse->Behaviors->load('Containable');
			$module_courses = $this->OrderCourse->Course->ModuleCourse->find('all', [
	    		'contain' => [
	    			'Module' => [
	    				'ModuleDiscipline' => [
	    					'fields' => ['id', 'module_id', 'name'],
	    					'conditions' => ['ModuleDiscipline.status' => 1],
	    					'order' => ['ModuleDiscipline.position' => 'ASC']
						],
						'fields' => ['id', 'name', 'value_time'],
						'conditions' => ['Module.status' => 1]
					]
				],
				'fields' => ['id', 'module_id', 'course_id', 'citie_id', 'state_id'],
	    		'conditions' => $conditions,
	    		'order' => ['ModuleCourse.position' => 'ASC', 'ModuleCourse.id' => 'ASC']
			]);

			$i = 0;
			foreach ($module_courses as $module_course):
				if( !empty($module_course['Module']['ModuleDiscipline']) ):
					foreach ($module_course['Module']['ModuleDiscipline'] as $module_discipline):
						/* Cria o Sumário do curso para o aluno */
						$this->data['UserModuleSummary']['order_id'] = $this->id;
						$this->data['UserModuleSummary']['user_id'] = $data['Order']['user_id'];
						$this->data['UserModuleSummary']['module_id'] = $module_course['Module']['id'];
						$this->data['UserModuleSummary']['module_discipline_id'] = $module_discipline['id'];
						$this->data['UserModuleSummary']['desblock'] = $i==0?1:0;

						$this->User->UserModuleSummary->create();
						$this->User->UserModuleSummary->save($this->data);
						unset($this->data['UserModuleSummary']);
						$i++;
					endforeach;
				endif;
			endforeach;
		endforeach;
	}

	private function updateUserModuleSummary($data){
		foreach ($data['OrderCourse'] as $order_course):

            $order_course = isset($order_course['OrderCourse']) ? $order_course['OrderCourse'] : $order_course;

			$conditions['ModuleCourse.course_id'] = $order_course['course_id'];

			if( isset($order_course['citie_id']) and !empty($order_course['citie_id']) ){
				$conditions['ModuleCourse.citie_id'] = $order_course['citie_id'];
			}
			if( isset($order_course['state_id']) and !empty($order_course['state_id']) ){
				$conditions['ModuleCourse.state_id'] = $order_course['state_id'];
			}

			$this->OrderCourse->Course->ModuleCourse->Behaviors->load('Containable');
			$module_courses = $this->OrderCourse->Course->ModuleCourse->find('all', [
	    		'contain' => [
	    			'Module' => [
	    				'ModuleDiscipline' => [
	    					'fields' => ['id', 'module_id', 'name'],
	    					'conditions' => [
	    						'ModuleDiscipline.status' => 1,
	    						'NOT'=>[
	    							'ModuleDiscipline.id'=>$this->UserModuleSummary->find('list',['fields'=>['module_discipline_id'],'conditions'=>['UserModuleSummary.order_id'=>$this->id]])
	    						]
	    					],
	    					'order' => ['ModuleDiscipline.position' => 'ASC']
						],
						'fields' => ['id', 'name', 'value_time'],
						'conditions' => ['Module.status' => 1]
					]
				],
				'fields' => ['id', 'module_id', 'course_id', 'citie_id', 'state_id'],
	    		'conditions' => $conditions,
	    		'order' => ['ModuleCourse.position' => 'ASC', 'ModuleCourse.id' => 'ASC']
			]);

			$i = 0;
			foreach ($module_courses as $module_course):
				if( !empty($module_course['Module']['ModuleDiscipline']) ):
					foreach ($module_course['Module']['ModuleDiscipline'] as $module_discipline):
						/* Cria o Sumário do curso para o aluno */
						$this->data['UserModuleSummary']['order_id'] = $this->id;
						$this->data['UserModuleSummary']['user_id'] = $data['Order']['user_id'];
						$this->data['UserModuleSummary']['module_id'] = $module_course['Module']['id'];
						$this->data['UserModuleSummary']['module_discipline_id'] = $module_discipline['id'];
						$this->data['UserModuleSummary']['desblock'] = $i==0?1:0;

						$this->User->UserModuleSummary->create();
						$this->User->UserModuleSummary->save($this->data);
						unset($this->data['UserModuleSummary']);
						$i++;
					endforeach;
				endif;
			endforeach;
		endforeach;
	}

	public function integracaoConsultaValidation()
    {
        App::uses('IntegracaoDetransService', 'IntegracaoDetrans');

        $objIntegracaoService = new IntegracaoDetransService();

        foreach ($this->data['OrderCourse'] as $key => $courseData) {
            $courseData = isset($courseData['OrderCourse']) ? $courseData['OrderCourse'] : $courseData;
            try {

                if (isset($this->data['User']['cpf']) && !empty($this->data['User']['cpf'])) {
                    $user = $this->data['User'];
                } elseif (isset($this->data['Order']['user_id'])) {
                    $user = $this->User->find('first', [
                        'recursive' => false,
                        'conditions' => ['User.id' => $this->data['Order']['user_id']],
                        'fields' => ['id', 'cpf']]);
                } else {
                    $user = [];
                }
                $arrParams = array_merge($user, $courseData);

                if ($objIntegracaoService->validar($courseData['course_id'], $courseData['state_id'], $courseData['citie_id'], $arrParams)) {

                    if ($objIntegracaoService->getRetorno()->getCodigo() != 'OK') {
                        $this->data['OrderCourse'][$key]['status_detran_id']        = StatusDetran::VALIDADO;
                        $this->data['OrderCourse'][$key]['codigo_retorno_detran']   = $objIntegracaoService->getRetorno()->getCodigo();
                        $this->data['OrderCourse'][$key]['mensagem_retorno_detran'] = $objIntegracaoService->getRetorno()->getMensagem();
                        $this->data['OrderCourse'][$key]['data_status_detran']      = date('Y-m-d H:i:s');
                    }

                } else {
                    return 'Consulta DETRAN: ' . $objIntegracaoService->getRetorno()->getCodigoEMensagem();
                }
            } catch (IntegracaoException $ex) { //exception que pode ser exibida ao usuário
                return 'Consulta DETRAN: ' . $objIntegracaoService->getRetorno()->getCodigoEMensagem();
            } catch (Exception $ex) { //erro de comunicação/sistema
            }
        }
        return true;
    }

    /**
     * Saves a single record, as well as all its directly associated records.
     *
     * Método sobrescrito da classe Model pai permitir identificar se o Order Model está sendo salvo junto com
     * outros models relacionados. Pois a transaction do banco de dados só é commitada após o final.
     *
     * @see AppModel::saveAssociated()
     * @param array $data
     * @param array $options
     * @return mixed
     */
    public function saveAssociated($data = array(), $options = array()){
	    $this->isSalvingAssociated = true;
        $savedAll = parent::saveAssociated($data, $options);
        if ($savedAll) {
            $this->integracaoMatricula($data);
        }
        $this->isSalvingAssociated = false;
        return $savedAll;
    }

    /**
     * Faz a Matrícula no Detran Após salvar o pedido
     * @param array $data
     */
    public function integracaoMatricula(array $data = [])
    {
        App::uses('IntegracaoDetransService', 'IntegracaoDetrans');

        $objIntegracaoService = new IntegracaoDetransService();

        foreach ($data['OrderCourse'] as $courseData) {
            $courseData = isset($courseData['OrderCourse']) ? $courseData['OrderCourse'] : $courseData;
            try {
                $objIntegracaoService->matricular($this->id, $courseData['course_id']);
            } catch (Exception $ex) {//erro de comunicação/sistema
            }
        }
    }
}
