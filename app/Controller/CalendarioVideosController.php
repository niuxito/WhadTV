<?php
App::uses('AppController', 'Controller');
/**
 * CalendarioVideos Controller
 *
 * @property CalendarioVideo $CalendarioVideo
 */
class CalendarioVideosController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CalendarioVideo->recursive = 0;
		$this->set('calendarioVideos', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CalendarioVideo->id = $id;
		if (!$this->CalendarioVideo->exists()) {
			throw new NotFoundException(__('Invalid calendario video'));
		}
		$this->set('calendarioVideo', $this->CalendarioVideo->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CalendarioVideo->create();
			if ($this->CalendarioVideo->save($this->request->data)) {
				$this->Session->setFlash(__('El calendario ha sido guardado.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El calendario no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CalendarioVideo->id = $id;
		if (!$this->CalendarioVideo->exists()) {
			throw new NotFoundException(__('Invalid calendario video'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CalendarioVideo->save($this->request->data)) {
				$this->Session->setFlash(__('El calendario ha sido guardado.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El calendario no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		} else {
			$this->request->data = $this->CalendarioVideo->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->CalendarioVideo->id = $id;
		if (!$this->CalendarioVideo->exists()) {
			throw new NotFoundException(__('Invalid calendario video'));
		}
		if ($this->CalendarioVideo->delete()) {
			$this->Session->setFlash(__('El calendario ha sido eliminado.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('El calendario no ha sido eliminado.'));
		$this->redirect(array('action' => 'index'));
	}
}
