<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Webdoor Model
 *
 */
class Webdoor extends AppModel {

	public $actsAs = array(
		'Upload.Upload' => array(
	        'image' => array(
	            'fields' => array(
	                'dir' => 'image_dir'
	            ),
	            'thumbnailSizes' => array(
	                'xvga' 	=> '1920x540',
	                'vga' 	=> '1140x250',
	                'thumb' => '346x97'
	            )
	        )
	    ),
    );

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Dê um nome pera este webdoor!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		/*'image' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'A Imagem é obrigatória!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	function beforeSave( $options = array() ){
		if( !empty($this->data['Webdoor']['start']) ){
			$this->data['Webdoor']['start'] = $this->dateFormatBeforeSave( $this->data['Webdoor']['start'] );
		}
		if( !empty($this->data['Webdoor']['finish']) ){
			$this->data['Webdoor']['finish'] = $this->dateFormatBeforeSave( $this->data['Webdoor']['finish'] );
		}
		return true;
	}

	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $val) {
	        if (isset($val['Webdoor']['start'])) {
	            $results[$key]['Webdoor']['start'] = $this->dateFormatAfterFind( $val['Webdoor']['start'] );
	        }
	        if (isset($val['Webdoor']['finish'])) {
	            $results[$key]['Webdoor']['finish'] = $this->dateFormatAfterFind( $val['Webdoor']['finish'] );
	        }
	    }
	    return $results;
	}

	public function __getAll(){
		$hoje = date('Y-m-d');
		return $this->find('all', [
          'recursive'=>-1,
          'conditions'=>[
            'Webdoor.status'=>1,
            'Webdoor.start <=' => $hoje,
            'Webdoor.finish >=' => $hoje,
          ],
          'order'=>[
            'ISNULL(Webdoor.ordination)'=>'ASC', 
            'Webdoor.ordination'=>'ASC'
          ]
        ]);
	}
}