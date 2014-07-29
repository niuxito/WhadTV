<?php
App::uses('AppController', 'Controller');
/**
 * EmpresaUsuarios Controller
 *
 * @property EmpresaUsuario $EmpresaUsuario
 */
class EmpresaUsuariosController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
		
		$this->EmpresaUsuario->recursive = 0;
		$this->set('empresaUsuarios', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->EmpresaUsuario->id = $id;
		if (!$this->EmpresaUsuario->exists()) {
			throw new NotFoundException(__('Invalid empresa usuario'));
		}
		$this->set('empresaUsuario', $this->EmpresaUsuario->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->EmpresaUsuario->create();
			if ($this->EmpresaUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('La empresa-usuario ha sido guardada.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La empresa-usuario no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		}
	}
	
	public function addRegistro($data){
		$this->EmpresaUsuario->create();
			if ($this->EmpresaUsuario->save($data)) {
				return $this->EmpresaUsuario->find("all", array('conditions' => "idEmpresa = '".$data['idEmpresa']."'"));
			} else {
				return null;
			}
		//}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->EmpresaUsuario->id = $id;
		if (!$this->EmpresaUsuario->exists()) {
			throw new NotFoundException(__('Invalid empresa usuario'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->EmpresaUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('La empresa-usuario ha sido guardada.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La empresa-usuario no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		} else {
			$this->request->data = $this->EmpresaUsuario->read(null, $id);
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
		$this->EmpresaUsuario->id = $id;
		if (!$this->EmpresaUsuario->exists()) {
			throw new NotFoundException(__('Invalid empresa usuario'));
		}
		if ($this->EmpresaUsuario->delete()) {
			$this->Session->setFlash(__('La empresa-usuario ha sido eliminada.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('La empresa-usuario no ha sido eliminada.'));
		$this->redirect(array('action' => 'index'));
	}
}
