<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Grupo Grow - www.grupogrow.com.br
 * TicketCourse Model
 *
 * @property Ticket $Ticket
 * @property Course $Course
 */
class TicketCourse extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'ticket_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}