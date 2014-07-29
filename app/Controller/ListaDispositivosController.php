<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Dispositivos');
/**
 * ListaDispositivos Controller
 *
 * @property ListaDispositivo $ListaDispositivo
 */
class ListaDispositivosController extends AppController {
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Auth');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
		
		$this->ListaDispositivo->recursive = 0;
		$this->set('listaDispositivos', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ListaDispositivo->id = $id;
		if (!$this->ListaDispositivo->exists()) {
			throw new NotFoundException(__('Invalid lista dispositivo'));
		}
		$this->set('listaDispositivo', $this->ListaDispositivo->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//print_r($this->request->data);
		if ($this->request->is('post')) {
			$this->ListaDispositivo->create();
			if ($this->ListaDispositivo->save($this->request->data)) {
				$this->Session->setFlash(__('La lista-dispositivo ha sido guardada.'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('La lista-dispositivo no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		}
	}

	
	public function activa(){
			$this->ListaDispositivo->id = $this->request->data['id'];
			$this->request->data['ListaDispositivo']['activa'] = $this->request->data['activa'];
			
			if ($this->ListaDispositivo->save($this->request->data)) {
				print_r($this->ListaDispositivo);
				$this->Session->setFlash(__('La lista se ha activado'));
				$this->redirect($this->referer());
			}else{
				$this->redirect($this->referer());
			}
	}
/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ListaDispositivo->id = $id;
		if (!$this->ListaDispositivo->exists()) {
			throw new NotFoundException(__('Invalid lista dispositivo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ListaDispositivo->save($this->request->data)) {
				$this->Session->setFlash(__('La lista-dispositivo ha sido guardada.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La lista-dispositivo no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		} else {
			$this->request->data = $this->ListaDispositivo->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		/*if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}*/
		$this->ListaDispositivo->id = $id;
		if (!$this->ListaDispositivo->exists()) {
			throw new NotFoundException(__('Invalid lista dispositivo'));
		}
		if ($this->ListaDispositivo->delete()) {
			$this->Session->setFlash(__('La lista-dispositivo ha sido eliminada.'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('La lista-dispositivo no ha sido eliminada.'));
		$this->redirect($this->referer());
	}


	public function updateDispositivo($idListaDispositivo){
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$this->ListaDispositivo->id = $idListaDispositivo;
		$idDispositivo = $this->ListaDispositivo->field('idDispositivo');
		$dispositivoC->sendActualizar($idDispositivo, false);
		return false;
	}
}
