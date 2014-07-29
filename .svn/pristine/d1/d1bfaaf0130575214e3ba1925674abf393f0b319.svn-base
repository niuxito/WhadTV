<?php
App::uses('AppController', 'Controller');
/**
 * Calendarios Controller
 *
 * @property Calendario $Calendario
 */
class CalendariosController extends AppController {

	//var $components = array('Auth');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Calendario->recursive = 0;
		$this->set('calendarios', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Calendario->id = $id;
		if (!$this->Calendario->exists()) {
			throw new NotFoundException(__('Invalid calendario'));
		}
		$this->set('calendario', $this->Calendario->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Calendario->create();
			if ($this->Calendario->save($this->request->data)) {
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
		$this->Calendario->id = $id;
		if (!$this->Calendario->exists()) {
			throw new NotFoundException(__('Invalid calendario'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Calendario->save($this->request->data)) {
				$this->Session->setFlash(__('El calendario ha sido guardado.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El calendario no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		} else {
			$this->request->data = $this->Calendario->read(null, $id);
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
		$this->Calendario->id = $id;
		if (!$this->Calendario->exists()) {
			throw new NotFoundException(__('Invalid calendario'));
		}
		if ($this->Calendario->delete()) {
			$this->Session->setFlash(__('El calendario ha sido eliminado.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('El calendario no ha sido eliminado.'));
		$this->redirect(array('action' => 'index'));
	}
}
