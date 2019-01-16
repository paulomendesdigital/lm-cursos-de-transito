<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Banner Model
 *
 */
class Banner extends AppModel {

	public $actsAs = array(
		'Upload.Upload' => array(
	        'image' => array(
	            'fields' => array(
	                'dir' => 'image_dir'
	            ),
	            'thumbnailSizes' => array(
	                'xvga' 	=> '1920x200',
	                'vga' 	=> '1140x100',
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
				'message' => 'Dê um nome pera este banner!',
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
		if( !empty($this->data['Banner']['start']) ){
			$this->data['Banner']['start'] = $this->dateFormatBeforeSave( $this->data['Banner']['start'] );
		}
		if( !empty($this->data['Banner']['finish']) ){
			$this->data['Banner']['finish'] = $this->dateFormatBeforeSave( $this->data['Banner']['finish'] );
		}
		return true;
	}

	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $val) {
	        if (isset($val['Banner']['start'])) {
	            $results[$key]['Banner']['start'] = $this->dateFormatAfterFind( $val['Banner']['start'] );
	        }
	        if (isset($val['Banner']['finish'])) {
	            $results[$key]['Banner']['finish'] = $this->dateFormatAfterFind( $val['Banner']['finish'] );
	        }
	    }
	    return $results;
	}

	public function __getAll(){
		$hoje = date('Y-m-d');
		return $this->find('all', [
          'recursive'=>-1,
          'conditions'=>[
            'Banner.status'=>1,
            'Banner.start <=' => $hoje,
            'Banner.finish >=' => $hoje,
          ],
          'order'=>[
            'ISNULL(Banner.ordination)'=>'ASC', 
            'Banner.ordination'=>'ASC'
          ]
        ]);
	}
}