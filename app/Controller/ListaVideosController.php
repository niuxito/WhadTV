<?php
App::uses('AppController', 'Controller');
/**
 * ListaVideos Controller
 *
 * @property ListaVideo $ListaVideo
 */
class ListaVideosController extends AppController {

	var $components = array ('RequestHandler','DebugKit.Toolbar', 'Auth');
	public $opciones = array();
/**
 * index method
 *
 * @return void
 */
	public function index( ) {
		$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
		
		//$this->opciones['idLista'] = $valor;
		//$this->Session->write('opciones', $this->opciones);
		$this->ListaVideo->recursive = 0;
		$this->set('listaVideos', $this->paginate('ListaVideo', $this->opciones));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ListaVideo->id = $id;
		if (!$this->ListaVideo->exists()) {
			throw new NotFoundException(__('Invalid lista video'));
		}
		$this->set('listaVideo', $this->ListaVideo->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			if($this->request->data['posicion'] == "0"){
				$options['fields'] = array('max(posicion) posicion');
				$options['conditions'] = array('ListaVideo.idLista = '.$this->request->data['idLista']);
				//$options['order'] = array('ListaVideo.posicion asc');
				$resultado =$this->ListaVideo->find("all", $options);
				print_r($resultado);
				if( count( $resultado) > 0){
					$this->request->data['posicion'] = $resultado[0][0]['posicion'] + 1;
				}else{
					$this->request->data['posicion'] = 1;
				}
			}
			
			$array = $this->ListaVideo->find('all', array(
				'conditions'=>array(
					'ListaVideo.idLista'=>trim($this->request->data['idLista']),
					'posicion >='=> $this->request->data['posicion']
				),
				'order'=> array('ListaVideo.posicion' => 'ASC')
			));
			//print_r($array);
			$this->arreglarPosiciones($array,$this->request->data['posicion']);
			$this->ListaVideo->create();
			$this->request->data['ListaVideo']['idUsuario'] ="1";
			/*if( count($array) > 0){
				//print_r($resultado);
				$this->request->data['ListaVideo']['posicion'] = $this->request->data['posicion'];
			}else{
				$this->request->data['ListaVideo']['posicion'] = 1;
					
			}*/
			$this->request->data['ListaVideo']['posicion'] = $this->request->data['posicion'];
			$this->request->data['ListaVideo']['idLista']  = $this->request->data['idLista'] ;
			$this->request->data['ListaVideo']['idVideo']  = $this->request->data['idVideo'] ;
			if ($this->ListaVideo->save($this->request->data)) {
				$this->ordenar($this->request->data['idLista']);
				//$this->Session->setFlash(__('The lista video has been saved'));
				
				
			} else {
				$this->Session->setFlash(__('El video no se ha podido añadir. Por favor, intentalo de nuevo.'), 'info');
				//$this->redirect(array('action' => '../Videos/index'));
			}
			return new CakeResponse( array( 'body' => json_encode( "OK") ) );
		}
	}
	
	
	/**
	 * add method
	 *
	 * @return void
	 */
	public function move() {
		if ($this->request->is('post')) {
			
			$resultado = $this->ListaVideo->read('posicion', $this->request->data['id']);
			$posicionAnt = $resultado['ListaVideo']['posicion'];
			$posicionAct = 	$this->request->data['posicion'];

			// Desde delante hacia atras
			if($posicionAnt > $posicionAct){
				
			}else{ //Desde atras hacia adelante
				//CakeLog:write("Debug", "de atras hacia adelante");
				$posicionAct++;
				
			}
			var_dump($posicionAnt);
			var_dump($posicionAct);
			$array = $this->ListaVideo->find('all', array(
						'conditions'=>array(
								'ListaVideo.idLista'=>trim($this->request->data['idLista']),
								'posicion >='=> $posicionAct
						),
						'order'=> array('ListaVideo.posicion' => 'ASC')
				));
			//var_dump($this->request->data['posicion']);
			
			//if(count($array) != 1){
				$this->arreglarPosiciones($array,$posicionAct);
				$this->ListaVideo->id = $this->request->data['id'];
				$this->request->data['ListaVideo']['posicion'] = $posicionAct;
			/*}else{
				$this->request->data['ListaVideo']['posicion'] = $this->request->data['posicion'] +1 ;
			}*/
			
			//$this->request->data['ListaVideo']['posicion'] = $this->request->data['posicion'];
			if ($this->ListaVideo->save($this->request->data)) {
				$this->ordenar($this->request->data['idLista']);
				//$this->Session->setFlash(__('The lista video has been saved'));
	
	
			} else {
				$this->Session->setFlash(__('El video no se ha podido añadir. Por favor, intentalo de nuevo.'), 'info');
				//$this->redirect(array('action' => '../Videos/index'));
			}
			return new CakeResponse( array( 'body' => json_encode( $array) ) );
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit() {
		if ($this->request->is('post') || $this->request->is('put')) {
			$id = $this->request->data['id'];
			$this->ListaVideo->id = $id;
			if (!$this->ListaVideo->exists()) {
				throw new NotFoundException(__('Invalid lista video'));
			}
			if ($this->ListaVideo->save($this->request->data)) {
				$this->Session->setFlash(__('El video ha sido añadido'), 'info');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('El video no se ha podido añadir. Por favor, intentalo de nuevo.'),'info');
			}
		} else {
			$this->request->data = $this->ListaVideo->read(null, $id);
		}
		
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null, $idLista = null) {
		$this->ListaVideo->id = $id;
		if (!$this->ListaVideo->exists()) {
			throw new NotFoundException(__('Invalid lista video'));
		}
		/*$array = $this->ListaVideo->find('all', array(
				'conditions'=>array(
					'ListaVideo.id'=>trim($id),
					'posicion >='=> $this->ListaVideo->data['posicion']
				),
				'order'=> array('ListaVideo.posicion' => 'DESC')
			));*/
			//print_r($this->ListaVideo->);
		if ($this->ListaVideo->delete()) {
			//$this->Session->setFlash(__('Lista video deleted'));
			$this->redirect(array('controller'=>'videos','action'=>'videosxlista', $idLista));
		}
		$this->Session->setFlash(__('Lista video was not deleted'));
		$this->redirect(array('controller'=>'videos','action'=>'videosxlista', $idLista));
	}
	
	
	
/**
 * videosFormLista method
 *
 * @param string $idLista
 * @return void
 */	
	
	public function videosFromLista( $idLista = null ){
		if( $idLista == null ){
			$idLista = $this->request->query['idLista'];
		}
		$this->opciones['idLista'] = $idLista;
		$this->Session->write('opciones', $this->opciones);
		$array = $this->ListaVideo->find('all', array('conditions'=>array('ListaVideo.idLista'=>trim($idLista)),'order' => array( 'ListaVideo.posicion' => 'ASC')));
		$array = $this->invertirArray($array);//$array = $this->ListaVideo->find("all");
		/*if( count( $array ) == 0 ){
			$array = array("idVideo"=>"");
		}*/
		$silencio = $this->ListaVideo->query("Select mute from lista where idLista = '".$idLista."'");
		$respuesta = array('mute'=>$silencio[0]['lista']['mute'], 'videos'=>$array);
		return new CakeResponse( array( 'body' => json_encode( $respuesta) ) );
	}
	
	private function invertirArray(  $array ){
		$newArray = array();
		for( $i=0; $i<count( $array ); $i++ ){
			$newArray["ListaVideo"][] = $array[$i]["ListaVideo"];
		}
		return $newArray;
	}
	
	private function arreglarPosiciones( $array, $posicion  ){
		if( !is_null( $array) ){
			foreach( $array as $lvideo ){
				$posicion +=1;
				$lvideo['ListaVideo']['posicion'] = $posicion;
				//print_r( $lvideo);
				//var_dump($lvideo);
				if ($this->ListaVideo->save($lvideo['ListaVideo'])) {
				//	$this->Session->setFlash(__('El video ha sido añadido'), 'info');
					//$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('El video no se ha podido añadir. Por favor, intentalo de nuevo.'),'info');
				}
			
			}
		}
		//$this->ListaVideo->id = $array['id']';
	}
	
	private function ordenar($idLista){
		$posicion = 0;
		$array = $this->ListaVideo->find('all', array(
				'conditions'=>array(
						'ListaVideo.idLista'=>trim($idLista)
				),
				'order'=> array('ListaVideo.posicion' => 'ASC')
		));
		if( !is_null( $array) ){
			foreach( $array as $lvideo ){
				$posicion +=1;
				$lvideo['ListaVideo']['posicion'] = $posicion;
				//print_r( $lvideo);
				if ($this->ListaVideo->save($lvideo['ListaVideo'])) {
					//$this->Session->setFlash(__('The lista video has been saved'));
					//$this->redirect(array('action' => 'index'));
				} else {
					//$this->Session->setFlash(__('The lista video could not be saved. Please, try again.'));
				}
					
			}
		}
		//$this->ListaVideo->id = $array['id']';
	}
}
