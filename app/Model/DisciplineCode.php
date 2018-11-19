<?php
App::uses('AppModel', 'Model');

/**
 * DisciplineCode Model
 * @property CourseCode $CourseCode
 */
class DisciplineCode extends AppModel
{
    public $actsAs = array('Containable');

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = ['code_name' => 'CONCAT(' . $this->alias . '.code, " - ", ' . $this->alias . '.name)'];
    }

    public function getDisciplineCodesListByCourseTypeId($courseTypeId = null, $exam = false) {
        $alias = $this->alias;

        $this->virtualFields['course_code_name'] = 'CONCAT(CourseCode.code, " - ", CourseCode.name)';

        $conditions = ["$alias.is_exam" => $exam ? 1 : 0];

        if ($courseTypeId != null ) {
            $conditions['CourseCode.course_type_id'] = $courseTypeId;
        }

        return $this->find('list', [
            'fields' => ['id', 'code_name', 'course_code_name'],
            'joins' => [
                [
                    'table' => 'course_codes',
                    'alias' => 'CourseCode',
                    'type' => 'INNER',
                    'conditions' => [
                        "CourseCode.id = $alias.course_code_id"
                    ]
                ]
            ],
            'conditions' => $conditions,
            'order' => "CourseCode.code, $alias.code"
        ]);
    }
}
