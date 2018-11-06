<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Rafael Bordallo - www.rafaelbordallo.com.br
 * CourseLibrary Model
 *
 * @property Course $Course
 */

class CourseWorkbook extends AppModel {

	public $actsAs = array(
        'Upload.Upload' => array(
            'image' => array(
                'fields' => array(
                    'dir' => 'image_dir'
                ),
                'thumbnailSizes' => array(
                    'xvga' 	=> '400x400',
                    'vga'	=> '200x200',
                    'thumb' => '140x140'
                )
            ),
            'filename'
        ),
    );

    /**
    * Display field
    *
    * @var string
    */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
    * belongsTo associations
    *
    * @var array
    */
	public $belongsTo = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    public function __getCourseWorkbooks($course_id){
        return $this->find('all',['conditions'=>['CourseWorkbook.course_id'=>$course_id,'CourseWorkbook.status'=>1]]);
    }
}