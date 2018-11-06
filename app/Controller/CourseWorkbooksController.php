<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018 
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseWorkbooks Controller
 *
 * @property CourseWorkbook $CourseWorkbook
 * @property PaginatorComponent $Paginator
 */
class CourseWorkbooksController extends AppController {

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
			$this->CourseWorkbook->create();
			if ($this->CourseWorkbook->save($this->request->data)) {
				$this->Session->setFlash(__('Apostila gravada com sucesso.'));
				return $this->redirect(array('controller' => 'courses', 'action' => 'edit', $this->request->data['CourseWorkbook']['course_id']));
			} else {
				$this->Session->setFlash(__('Erro ao tentar gravar. Tente novamente.'));
			}
		}
		$courses = $this->CourseWorkbook->Course->find('list', ['conditions' => ['Course.id' => $course_id]]);
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
		if (!$this->CourseWorkbook->exists($id)) {
			throw new NotFoundException(__('Apostila inválida'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CourseWorkbook->save($this->request->data)) {
				$this->Session->setFlash(__('Apostila atualizada com sucesso.'));
				return $this->redirect(array('controller' => 'courses', 'action' => 'edit', $this->request->data['CourseWorkbook']['course_id']));
			} else {
				$this->Session->setFlash(__('Erro ao tentar gravar. Tente novamente.'));
			}
		} else {
			$options = array('conditions' => array('CourseWorkbook.' . $this->CourseWorkbook->primaryKey => $id));
			$this->request->data = $this->CourseWorkbook->find('first', $options);
		}
		$courses = $this->CourseWorkbook->Course->find('list');
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
		$this->CourseWorkbook->id = $id;
		if (!$this->CourseWorkbook->exists()) {
			throw new NotFoundException(__('Apostila inválida'));
		}
		if ($this->CourseWorkbook->delete($id)) {
			$this->Session->setFlash(__('Apostila deletada com sucesso!'));
		} else {
			$this->Session->setFlash(__('Erro ao tentar deletar. Tente novamente.'));
		}
		return $this->redirect($this->referer());
	}}
