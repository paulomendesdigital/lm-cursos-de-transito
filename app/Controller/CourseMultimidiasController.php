<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018 
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseMultimidias Controller
 *
 * @property CourseMultimidia $CourseMultimidia
 * @property PaginatorComponent $Paginator
 */
class CourseMultimidiasController extends AppController {

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
			$this->CourseMultimidia->create();
			if ($this->CourseMultimidia->save($this->request->data)) {
				$this->Session->setFlash(__('Multimidia gravada com sucesso.'));
				return $this->redirect(array('controller' => 'courses', 'action' => 'edit', $this->request->data['CourseMultimidia']['course_id']));
			} else {
				$this->Session->setFlash(__('Erro ao tentar gravar. Tente novamente.'));
			}
		}
		$courses = $this->CourseMultimidia->Course->find('list', ['conditions' => ['Course.id' => $course_id]]);
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
		if (!$this->CourseMultimidia->exists($id)) {
			throw new NotFoundException(__('Multimidia inválida'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CourseMultimidia->save($this->request->data)) {
				$this->Session->setFlash(__('Multimidia atualizada com sucesso.'));
				return $this->redirect(array('controller' => 'courses', 'action' => 'edit', $this->request->data['CourseMultimidia']['course_id']));
			} else {
				$this->Session->setFlash(__('Erro ao tentar gravar. Tente novamente.'));
			}
		} else {
			$options = array('conditions' => array('CourseMultimidia.' . $this->CourseMultimidia->primaryKey => $id));
			$this->request->data = $this->CourseMultimidia->find('first', $options);
		}
		$courses = $this->CourseMultimidia->Course->find('list');
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
		$this->CourseMultimidia->id = $id;
		if (!$this->CourseMultimidia->exists()) {
			throw new NotFoundException(__('Multimidia inválida'));
		}
		if ($this->CourseMultimidia->delete($id)) {
			$this->Session->setFlash(__('Multimidia deletada com sucesso!'));
		} else {
			$this->Session->setFlash(__('Erro ao tentar deletar. Tente novamente.'));
		}
		return $this->redirect($this->referer());
	}
}
