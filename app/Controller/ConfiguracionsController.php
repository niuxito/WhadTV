<?php
App::uses('AppController', 'Controller');
/**
 * Configuracions Controller
 *
 * @property Configuracion $Configuracion
 */
class ConfiguracionsController extends AppController {
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Auth');

	public function beforeFilter(){
		parent::beforeFilter();
		parent::testAuth();
		$user = $this->Session->read('Auth');
		if(isset($user['User']) && $user['User']['nivel'] != 0){
			$this->redirect(array('controller'=>'Videos','action'=>'index'));
		}
		$this->layout = 'admin';
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Configuracion->recursive = 0;
		$this->set('configuracions', $this->paginate());
	}

	public function listar(){
		return $this->Configuracion->find('all',array("conditions"=>array("tipo in ('js','ambiguo')")));
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Configuracion->id = $id;
		if (!$this->Configuracion->exists()) {
			throw new NotFoundException(__('Invalid configuracion'));
		}
		$this->set('configuracion', $this->Configuracion->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Configuracion->create();
			if ($this->Configuracion->save($this->request->data)) {
				$this->Session->setFlash(__('La configuración ha sido guardada.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La configuración no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Configuracion->id = $id;
		if (!$this->Configuracion->exists()) {
			throw new NotFoundException(__('Invalid configuracion'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Configuracion->save($this->request->data)) {
				$this->Session->setFlash(__('La configuración ha sido guardada.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La configuración no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		} else {
			$this->request->data = $this->Configuracion->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Configuracion->id = $id;
		if (!$this->Configuracion->exists()) {
			throw new NotFoundException(__('Invalid configuracion'));
		}
		if ($this->Configuracion->delete()) {
			$this->Session->setFlash(__('La configuración ha sido eliminada.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('La configuración no ha sido eliminada.'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function definir(){
			$lineas = $this->Configuracion->find('all', array("conditions"=>array("tipo in ('interno','ambiguo')")));
			foreach( $lineas as $linea){
				if(!defined(strtoupper($linea['Configuracion']['Nombre']))){
					define(strtoupper($linea['Configuracion']['Nombre']),$linea['Configuracion']['Valor']);
					//CakeLog::write("debug", "Se ha definido ".strtoupper($linea['Configuracion']['Nombre']));
					//CakeLog::write("debug", "Valor de ".strtoupper($linea['Configuracion']['Nombre']).': '.constant(strtoupper($linea['Configuracion']['Nombre'])));
				}
			}
	}
}
