<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018 
 * @author Rafael Bordallo - www.rafaelbordallo.com.br
 * CourseLibraries Controller
 *
 * @property CourseLibrary $CourseLibrary
 * @property PaginatorComponent $Paginator
 */
class CourseLibrariesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * manager_add method
 *
 * @return void
 */
	public function manager_add($course_id=null) {
		if ($this->request->is('post')) {
			$this->CourseLibrary->create();
			if ($this->CourseLibrary->save($this->request->data)) {
				$this->Session->setFlash(__('The course library has been saved.'));
				return $this->redirect(array('controller' => 'courses', 'action' => 'edit', $this->request->data['CourseLibrary']['course_id']));
			} else {
				$this->Session->setFlash(__('The course library could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CourseLibrary->Course->find('list', ['conditions' => ['Course.id' => $course_id]]);
		$this->set(compact('courses', 'course_id'));

	}

/**
 * manager_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function manager_edit($id = null) {
		if (!$this->CourseLibrary->exists($id)) {
			throw new NotFoundException(__('Invalid course library'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CourseLibrary->save($this->request->data)) {
				$this->Session->setFlash(__('The course library has been saved.'));
				return $this->redirect(array('controller' => 'courses', 'action' => 'edit', $this->request->data['CourseLibrary']['course_id']));
			} else {
				$this->Session->setFlash(__('The course library could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CourseLibrary.' . $this->CourseLibrary->primaryKey => $id));
			$this->request->data = $this->CourseLibrary->find('first', $options);
		}
		$courses = $this->CourseLibrary->Course->find('list');
		$this->set(compact('courses'));
	}

/**
 * manager_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function manager_delete($id = null) {
		$this->CourseLibrary->id = $id;
		if (!$this->CourseLibrary->exists()) {
			throw new NotFoundException(__('Invalid course library'));
		}
		if ($this->CourseLibrary->delete($id)) {
			$this->Session->setFlash(__('The course library has been deleted.'));
		} else {
			$this->Session->setFlash(__('The course library could not be deleted. Please, try again.'));
		}
		return $this->redirect($this->referer());
	}}
