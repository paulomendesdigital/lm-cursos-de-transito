<?php
App::uses('AppModel', 'Model');

/**
 * DisciplineCode Model
 * @property DisciplineCode $DisciplineCode
 */
class CourseCode extends AppModel
{

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = [
        'CourseType' => [
            'className'  => 'CourseType',
            'foreignKey' => 'course_type_id',
        ]
    ];

    public $virtualFields = [
        'code_name' => 'CONCAT(CourseCode.code, " - ", CourseCode.name)'
    ];
}
