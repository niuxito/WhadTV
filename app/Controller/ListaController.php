<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'ListaVideos');
App::import( 'Controller','ListaDispositivos');
/**
 * Lista Controller
 *
 * @property Listum $Listum
 */
class ListaController extends AppController {
	public $components = array('DebugKit.Toolbar', 'RequestHandler');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
		$this->Listum->recursive = 0;
		$this->set('lista', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Listum->id = $id;
		if (!$this->Listum->exists()) {
			throw new NotFoundException(__('Invalid listum'));
		}
		$this->set('listum', $this->Listum->read(null, $id));
		$this->redirect($this->referer());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		$this->request->data['Listum']['idEmpresa'] = $idEmpresa;
		if ($this->request->is('post')) {
			if( $this->request->data['Listum']['descripcion'] != ""){
				$this->Listum->create();
				$this->request->data['Listum']['idUsuario'] ="1";
				$this->request->data['Listum']['timestamp'] = DboSource::expression('NOW()');				
				if ($this->Listum->save($this->request->data)) {
					$this->Session->setFlash(__('Se ha añadido una nueva lista.'), 'info');
					$this->redirect(array('controller'=>'videos','action' => 'index'));
				} else {
					$this->Session->setFlash(__('La lista no ha podido guardarse. Por favor, intentalo de nuevo.'), 'error');
				}
			
			}else{
				$this->Session->setFlash(__('Debes escribir un nombre para la lista.'), 'info');
				$this->redirect(array('controller'=>'videos','action' => 'index'));
			}
		}
		$this->render('add', 'empty');
	}

/**
 * mute method
 * 
 * @return void
 */	
	public function mute(){
		//print_r($this->request->data);
		//if( $this->request->is( 'post' ) ){
			$this->Listum->id = $this->request->data['id'];
			$this->request->data['Listum']['mute'] = $this->request->data['mute'];
			if ($this->Listum->save($this->request->data)) {
				$this->Session->setFlash(__('The listum has been saved'));
				$this->redirect(array('action' => 'index'));
			}else{
				$this->redirect(array('action' => 'index'));
			}
			
		//}else{
		//	echo "error";
		//}
	}
/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Listum->id = $id;
		if (!$this->Listum->exists()) {
			throw new NotFoundException(__('Invalid listum'));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if($this->request->data['Listum']['descripcion'] != "" ){
				if ($this->Listum->save($this->request->data)) {
					$this->Session->setFlash(__('La lista ha sido modificada.'), 'info');
					$this->redirect(array('controller'=>'videos', 'action'=>'index'));
				} else {
					$this->Session->setFlash(__('La lista no ha podido guardarse. Por favor, intentalo de nuevo.'), 'error');
				}
			}else{
				$this->Session->setFlash(__('Debes escribir un nombre para la lista.'), 'info');
				$this->render('edit','loged');
			}
		} else {
			$this->request->data = $this->Listum->read(null, $id);
			$this->render('edit','loged');
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		$this->Listum->id = $id;
		if (!$this->Listum->exists()) {
			throw new NotFoundException(__('Invalid listum'));
		}
		if ($this->Listum->delete()) {
			
			$lista = new ListaDispositivosController();
			$lista->constructClasses();
			$lista->ListaDispositivo->deleteAll('idLista = '.$id);
			
			
			$lista = new ListaVideosController();
			$lista->constructClasses();
			$lista->ListaVideo->deleteAll('idLista = '.$id);
			
			
			$this->Session->setFlash(__('Lista eliminada.'), 'info');
			$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
		}
		$this->Session->setFlash(__('La lista no se ha eliminado.'), 'error');
		$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
	}


	public function getListas(){
		$listas = $this->Listum->getListasByEmpresa($this->Session->read('Empresa.Empresa.idEmpresa'));
		$listas_json = array();
		foreach($listas as $lista){
			$listas_json[$lista['Listum']['idLista']] = $lista['Listum'];
			foreach($lista['ListaVideo'] as $video){
			$listas_json[$lista['Listum']['idLista']]['contenido'][] = $video['Video']['fotograma']; 
			}
			//$listas_json[$lista['Listum']['idLista']]['contenido'][$lista['Video']['idVideo']] = $lista['Video'];
			//$listas_json[$lista['Listum']['idLista']]['contenido'][$lista['Video']['idVideo']]['url'] = 

			//json_decode($listas_json[$lista['Listum']['idLista']]['contenido'][$lista['Video']['idVideo']]['url'], 1); 
		}
		return new CakeResponse(array('body'=>json_encode($listas_json)));
	}
}
