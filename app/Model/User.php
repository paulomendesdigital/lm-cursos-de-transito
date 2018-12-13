<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * User Model
 *
 * @property Group $Group
 * @property DirectMessage $DirectMessage
 * @property ForumPostComment $ForumPostComment
 * @property ForumPost $ForumPost
 * @property Forum $Forum
 * @property Instructor $Instructor
 * @property Order $Order
 * @property UserCertificate $UserCertificate
 * @property UserModuleLog $UserModuleLog
 * @property UserModuleSummary $UserModuleSummary
 * @property UserQuestion $UserQuestion
 */
class User extends AppModel {

	/**
 	* Display field
 	*
 	* @var string
 	*/
	public $displayField = 'name';
	
	public $actsAs = array(
        'Upload.Upload' => array(
            'avatar' => array(
                'fields' => array(
                    'dir' => 'photo_dir'
                ),
                'thumbnailSizes' => array(
                    'thumb' => '100x100',
                    'vga' => '200x200'
                )
            )
        ),
    	'Acl' => array('type' => 'requester')
    );

	/**
 	* Validation rules
 	*
 	* @var array
 	*/
	public $validate = array(
		'username' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => array('Campo Obrigatório'),
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Este login já está em uso!',
            ),
        ),
        /*'cpf' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => array('Campo Obrigatório'),
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'Este cpf já está em uso!',
            ),
        ),*/	
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
 	* belongsTo associations
 	*
 	* @var array
 	*/
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'School' => array(
			'className' => 'School',
			'foreignKey' => 'school_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasOne = array(
		'Notepad' => array(
			'className' => 'Notepad',
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
		'Instructor' => array(
			'className' => 'Instructor',
			'foreignKey' => 'user_id',
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
			'foreignKey' => 'user_id',
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
		'Partner' => array(
			'className' => 'Partner',
			'foreignKey' => 'user_id',
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
		'Manager' => array(
			'className' => 'Manager',
			'foreignKey' => 'user_id',
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
		'DirectMessage' => array(
			'className' => 'DirectMessage',
			'foreignKey' => 'user_id',
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
		'ForumPostComment' => array(
			'className' => 'ForumPostComment',
			'foreignKey' => 'user_id',
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
		'ForumPost' => array(
			'className' => 'ForumPost',
			'foreignKey' => 'user_id',
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
		'Forum' => array(
			'className' => 'Forum',
			'foreignKey' => 'user_id',
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
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'user_id',
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
		'UserCertificate' => array(
			'className' => 'UserCertificate',
			'foreignKey' => 'user_id',
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
		'UserModuleLog' => array(
			'className' => 'UserModuleLog',
			'foreignKey' => 'user_id',
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
			'foreignKey' => 'user_id',
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
		'UserQuestion' => array(
			'className' => 'UserQuestion',
			'foreignKey' => 'user_id',
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
		'Complement' => array(
			'className' => 'Complement',
			'foreignKey' => 'user_id',
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


	public function beforeSave($options = array()) {
		if( isset($this->data['User']['password']) ){
			if ($this->data['User']['password'] && !empty($this->data['User']['password'])) {
				$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			}else{
				unset($this->data['User']['password']);
			}
		}
		return true;
	}

	public function afterSave($created, $options = array()){
	    if (isset($this->data['User']['group_id'])) {
            switch ($this->data['User']['group_id']) {
                case $this->Group->getAdministrador():
                    unset($this->data['Complement']);
                    break;
                case $this->Group->getInstrutor():
                    //$this->data['Complement']['user_id'] = $this->data['Instructor']['user_id'] = $this->id;
                    //$this->Complement->save($this->data);
                    //if( isset($this->data['Instructor'][0]['id']) and !empty($this->data['Instructor'][0]['id']) ){
                    //	$this->data['Instructor']['id'] = $this->data['Instructor'][0]['id'];
                    //	unset($this->data['Instructor'][0]);
                    //}
                    //$this->data['Instructor']['name'] 	= $this->data['User']['name'];
                    //$this->data['Instructor']['status'] = $this->data['User']['status'];
                    //$this->Instructor->save($this->data);
                    //break;
                case $this->Group->getOperador():
                    unset($this->data['Complement']);
                    break;;
                case $this->Group->getAluno():
                    $this->data['Complement']['user_id'] = $this->data['Instructor']['user_id'] = $this->id;
                    $this->Complement->save($this->data);
                    break;
                default:
                    unset($this->data['Complement']);
                    break;
            }
        }
		return true;
	}

	public function afterFind($results, $primary = false){
		$new_result = [];
			
		foreach ($results as $key => $value) {
			if(isset($value['User']['avatar']) && isset($value['User']['id'])):
				$value['User']['public_url_avatar'] = Router::url('/', true).'files/user/avatar/'.$value['User']['id'].'/thumb_'.$value['User']['avatar'];
			endif;
			
			if(isset($value['User']['cpf']) && isset($value['User']['id'])):
				$value['User']['public_login'] = $value['User']['cpf'];
			endif;

			if( isset($value['User']['name']) and !empty($value['User']['name']) ):
				$dataName = $this->__extractNameLastName($value['User']['name']);
				$value['User']['first_name'] = $dataName[0];
				$value['User']['last_name']  = isset($dataName[1]) ? $dataName[1] : '';
			endif;

			$new_result[$key] = $value;
		}
		return $new_result;
	}

	public function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
		} else {
			$groupId = $this->field('group_id');
		}
		if (!$groupId) {
			return null;
		} else {
			return array('Group' => array('id' => $groupId));
		}
	}

	public function getTitlePage($action='index',$group_id=1){
		if( $action == 'index' ){
			switch ($group_id) {
				case $this->Group->getAdministrador(): return 'Administradores';
				case $this->Group->getProfessor(): return 'Professores';
				case $this->Group->getOperador(): return 'Operadores';
				case $this->Group->getAluno(): return 'Alunos';
				case $this->Group->getParceiro(): return 'Parceiros';
				default: return 'Usuários';
			}
		}else{
			switch ($group_id) {
				case $this->Group->getAdministrador(): return 'Administrador';
				case $this->Group->getProfessor(): return 'Professor';
				case $this->Group->getOperador(): return 'Operador';
				case $this->Group->getAluno(): return 'Aluno';
				case $this->Group->getParceiro(): return 'Parceiro';
				default: return 'Usuário';
			}
		}
	}

	public function getActionReturn($group_id){
		switch ($group_id) {
			case $this->Group->getAdministrador(): return 'index';
			case $this->Group->getProfessor(): return 'instructors';
			case $this->Group->getOperador(): return 'operators';
			case $this->Group->getAluno(): return 'students';
			case $this->Group->getParceiro(): return 'partners';
			default: return 'users';
		}
	}

	public function getViewAdministrador(){
		$this->contain([
                'Group',
                'Manager',
        ]);
	}
	public function getViewProfessor(){
		$this->contain([
                'Group',
                'Complement',
                'Instructor'=>[
                	'City',
                	'State',
                	'DirectMessage'=>[
                		'fields'=>['DISTINCT DirectMessage.user_id'],
                		'User'=>['id','name','email'],
            		],
                ]
        ]);
	}
	public function getViewOperador(){
		$this->contain([
                'Group',
                'Complement',
        ]);
	}
	public function getViewAluno(){
		$this->contain([
                'Group',
                'Student'=>['fields' => ['address', 'number', 'neighborhood'], 'City', 'State'],
                'Order' => [
                	'UserModuleSummary' => [
                		'Module' => ['fields' => ['name']],
                		'ModuleDiscipline' => ['fields' => ['name']] 
                	],
                	'UserModuleLog' => ['Module' => ['fields' => ['name']],'ModuleDiscipline' => ['fields' => ['name']] ],
                	'UserQuestion' => ['Module' => ['fields' => ['name']],'Course' => ['fields' => ['name']] ],
                	'OrderType' => ['fields' => ['name']],
                	'OrderCourse' => [
                	    'fields' => ['id', 'codigo_retorno_detran', 'mensagem_retorno_detran'],
                        'Course'=>['id','name', 'course_type_id'],
                        'StatusDetran'
                    ]
            	],
                'DirectMessage' => ['Instructor' => ['fields' => ['name']]],
                'ForumPostComment',
                'ForumPost' => ['Forum' => ['fields' => ['name']] ],
                'Forum' => ['Course' => ['fields' => ['name']], 'Citie' => ['fields' => ['name']], 'State' => ['fields' => ['name']]],
                //'UserModuleLog' => ['Module' => ['fields' => ['name']],'ModuleDiscipline' => ['fields' => ['name']] ],
                //'UserModuleSummary' => ['Module' => ['fields' => ['name']],'ModuleDiscipline' => ['fields' => ['name']] ],
                //'UserQuestion' => ['Module' => ['fields' => ['name']],'Course' => ['fields' => ['name']] ],
        ]);
	}
	public function getViewParceiro(){
		$this->contain([
                'Group',
                'Partner'=>['fields' => ['address', 'number', 'neighborhood'], 'City', 'State'],
                //'UserModuleLog' => ['Module' => ['fields' => ['name']],'ModuleDiscipline' => ['fields' => ['name']] ],
                //'UserModuleSummary' => ['Module' => ['fields' => ['name']],'ModuleDiscipline' => ['fields' => ['name']] ],
                //'UserQuestion' => ['Module' => ['fields' => ['name']],'Course' => ['fields' => ['name']] ],
        ]);
	}

	public function __setPasswordStudent($string=''){
        return substr(str_replace('-', '', str_replace('.', '', $string)),-4);
    }

	public function __setPasswordPartner($string=''){
        return substr(str_replace('-', '', str_replace('.', '', $string)),-4);
    }

    public function prepareValidationForCadastroAluno()
    {
        $this->validate = array_merge($this->validate, [
            'name' => [
                'notempty' => [
                    'rule'    => 'notempty',
                    'message' => 'Este campo é obrigatório.',
                ],
                'completo' => [
                    'rule'    => '/[A-zÀ-ž\.]+[\s][A-zÀ-ž\.\s]+/i',
                    'message' => 'Preencha o seu Nome Completo'
                ]
            ],
            'cpf' => [
                'notempty' => [
                    'rule'    => 'notempty',
                    'message' => 'Este campo é obrigatório.',
                ],
                'valido' => [
                    'rule'    => ['validationCpf'],
                    'message' => 'CPF Inválido'
                ],
                'unique' => [
                    'rule'    => 'isUnique',
                    'message' => 'Este CPF já está cadastrado.'
                ],
            ],
            'email' => [
                'email' => [
                    'rule'    => 'email',
                    'message' => 'E-mail inválido'
                ]
            ],
            'password' => [
                'notempty' => [
                    'rule'    => 'notempty',
                    'message' => 'Informe uma senha.',
                ],
                'minLength' => [
                    'rule'    => ['minLength', 4],
                    'message' => 'A senha deve no mínimo 4 caracteres.'
                ],
                'maxLength' => [
                    'rule'    => ['maxLength', 8],
                    'message' => 'A senha deve no máximo 8 caracteres.'
                ]
            ]
        ]);

        $this->Student->validate = array_merge($this->Student->validate, [
            'cellphone' => [
                'notempty' => [
                    'rule'    => 'notempty',
                    'message' => 'Este campo é obrigatório.',
                ],
                'valido' => [
                    'rule'    => ['validationTelefone'],
                    'message' => 'Telefone ou Celular Inválido'
                ],
            ],
            'birth' => [
                'notempty' => [
                    'rule'    => 'notempty',
                    'message' => "Preencha a Data de Nascimento",
                ],
                'dataValida' => [
                    'rule'    => ['date', 'dmy'],
                    'message' => 'Data de Nascimento inválida.'
                ],
            ]
        ]);

        $this->Partner->validate = array_merge($this->Partner->validate, [
            'cellphone' => [
                'notempty' => [
                    'rule'    => 'notempty',
                    'message' => 'Este campo é obrigatório.',
                ],
                'valido' => [
                    'rule'    => ['validationTelefone'],
                    'message' => 'Telefone ou Celular Inválido'
                ],
            ],
            'birth' => [
                'notempty' => [
                    'rule'    => 'notempty',
                    'message' => "Preencha a Data de Nascimento",
                ],
                'dataValida' => [
                    'rule'    => ['date', 'dmy'],
                    'message' => 'Data de Nascimento inválida.'
                ],
            ]
        ]);
    }

    public function validationCpf(array $arrParams)
    {
        $strCPF = isset($arrParams['cpf']) ? $arrParams['cpf'] : '';

        //Elimina possivel mascara
        $strCPF = preg_replace('/[^0-9]/', '', $strCPF);
        $strCPF = str_pad($strCPF, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($strCPF) != 11) {
            return false;

            // Verifica se nenhuma das sequências invalidas abaixo
            // foi digitada. Caso afirmativo, retorna falso
        } else if ($strCPF == '00000000000' || $strCPF == '11111111111' || $strCPF == '22222222222' ||
            $strCPF == '33333333333' || $strCPF == '44444444444' ||  $strCPF == '55555555555' || $strCPF == '66666666666' ||
            $strCPF == '77777777777' || $strCPF == '88888888888' || $strCPF == '99999999999') {

            return false;

            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $strCPF{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($strCPF{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }
}
