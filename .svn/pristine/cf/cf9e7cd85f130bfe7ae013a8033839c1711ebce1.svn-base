<?php 
App::import('Controller', 'Users');
App::import('Controller', 'EmpresaUsuarios');
App::import('Controller', 'Dispositivos');
App::import('Controller', 'ListaDispositivos');
App::import('Controller', 'Videos');
App::import('Controller', 'ListaVideos');
App::import('Controller', 'Lista');
App::import('Controller', 'Consejos');
App::import('Controller', 'ActualizacionDispositivos');
App::import('Controller', 'Reproductors');
App::import('Controller', 'Programacions');
class AgenciaController extends AppController{

	var $name="Agencia";
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Auth');
	var $uses = array('Users','Empresas'); 
	
	
	public function beforeFilter(){
		parent::beforeFilter();
		$empresa = $this->Session->read('Empresa');
		if($empresa['agencia']['clientes'] > 0){
			$this->layout = 'agencia';
		}else{
			$this->redirect(array('controller'=>'Videos','action'=>'index'));
		}
		
	}

	public function clearCache(){
		Cache::clear(false);
		$this->redirect(array('action'=>'index'));
	}
	public function index(){
		$this->render('index', 'agencia');
	}

	public function listadoReproductores(){
		$this->render('listadoReproductores','agencia');
	}

	public function cargarEmpresas(){
		$this->loadModel('Dispositivo');
		$this->loadModel('Empresa');
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];

		$cuentaClientes = $empresa['agencia']['clientes'];
		if ( $cuentaClientes > 0 ){
			$i = 1;
			$clientes = $empresa['agencia'];
			//La Empresa del Agente
			$nombreEmpresa = $this->Empresa->read('Nombre', $idEmpresa);
			$emp['empresa']['idRelacionAgencia'] = '';
			$emp['empresa']['idEmpresa'] = $idEmpresa;
			$emp['empresa']['Nombre'] = $nombreEmpresa['Empresa']['Nombre'];
			//$dispositivos = $this->Dispositivo->find('all',array('conditions'=>'idEmpresa ='.$idEmpresa));
			//$emp['empresa']['dispositivos'] = $dispositivos;
			$arrayEmpresas[$i] = $emp;
			//Los clientes del Agente
			foreach( $clientes as $cliente){
				if (is_array($cliente)){
					$emp['empresa']['idRelacionAgencia'] = $cliente['Agencia']['id'];
					$emp['empresa']['idEmpresa'] = $cliente['Agencia']['idCliente'];
					$emp['empresa']['Nombre'] = $cliente['empresa']['Nombre'];
					//$dispositivos = $this->Dispositivo->find('all',array('conditions'=>'idEmpresa ='.$cliente['Agencia']['idCliente']." and acepta_terceros = 1"));
					//$emp['empresa']['dispositivos'] = $dispositivos; 
					$i++;
					$arrayEmpresas[$i] = $emp;
				}
			}
			return new CakeResponse( array( 'body' => json_encode( $arrayEmpresas) ) );
		}
		return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
	}

	public function cargarReproductores($idEmpresa = null){
		$this->loadModel('Dispositivo');
		$empresa = $this->Session->read('Empresa');
		$options['fields'] = array('idDispositivo','descripcion','play','mute','timestamp','caducidad','count(listaDispositivo.idLista) listas', 'now() ahora','acepta_terceros');
		if ( $empresa['Empresa']['idEmpresa'] == $idEmpresa ){
			$options['conditions'] = array('idEmpresa ='.$idEmpresa);
		}else{
			$options['conditions'] = array('idEmpresa ='.$idEmpresa.' and acepta_terceros = 1');
		}
		$options['group'] = array("Dispositivo.idDispositivo");
		$options['joins'] = array(
				array('table' => 'listaDispositivo',
						'type' => 'LEFT',
						'conditions' => array(
								'Dispositivo.idDispositivo = listaDispositivo.idDispositivo',
						)
				)
		);
		$dispositivos = $this->Dispositivo->find('all',$options);
		if ( count($dispositivos) > 0 ){
			return new CakeResponse( array( 'body' => json_encode( $dispositivos) ) );
		}else{
			return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		}
	}

	public function obtenerEmpresaReproductor(){
		$idReproductor = $this->request->data['idReproductor'];
		$this->loadModel('Reproductor');
		$idEmpresa = $this->Reproductor->read('idEmpresa',$idReproductor);
		if ( $idEmpresa != null ){
			return new CakeResponse( array( 'body' => json_encode( $idEmpresa) ) );
		}else{
			return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		}
	}

	public function cargarListas($idReproductor = null){
		$this->loadModel('Listum');
		
		$options['fields'] = array('listaDispositivo.activa', 'Listum.idLista', 'listaDispositivo.idDispositivo','dispositivo.descripcion', 'Listum.descripcion', 'listaDispositivo.id','Listum.mute','listaDispositivo.tipo_relacion','count(distinct listaVideo.id) videos');
		$options['conditions'] = array("listaDispositivo.idDispositivo = '".$idReproductor."'");
		$options['group'] = array('listaDispositivo.id');
		$options['joins'] = array(
				array('table' => 'listaDispositivo',
	
						'type' => 'left',
						'conditions' => array(
								'Listum.idLista = listaDispositivo.idLista'
						)
				),
				array('table' => 'listaVideo',
							
						'type' => 'left',
						'conditions' => array(
								'listaVideo.idLista = Listum.idLista'
						)
				),
				array('table' => 'dispositivo',
							
						'type' => 'left',
						'conditions' => array(
								'listaDispositivo.idDispositivo = dispositivo.idDispositivo'
						)
				)
					
		);
		$options['order'] = array('listaDispositivo.tipo_relacion ASC, Listum.idLista');
		$listas = $this->Listum->find("all", $options);
		if ( count($listas) > 0 ){
			return new CakeResponse( array( 'body' => json_encode( $listas ) ) );
		}else{
			return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		}
	}
	
	public function vistaReproductor($idReproductor = null){
		$this->loadModel('Reproductor');
		$this->set('Reproductor',$this->Reproductor->read(null,$idReproductor));
		$this->render('vistaReproductor','agencia');
	}

	public function obtenerReproductoresCliente($idEmpresaCliente = null){
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		$this->loadModel('Listum');
		$this->loadModel('Reproductor');
		$this->loadModel('ListaDispositivo');
		$this->Reproductor->recursive = -1;

		$options['fields'] = array('idDispositivo','descripcion','play','mute', 'caducidad', 'count(Listad.idLista) listas', 'now() ahora','acepta_terceros');
		if ( $idEmpresaCliente == $idEmpresa ){
			$options['conditions'] = array('Reproductor.idEmpresa ='.$idEmpresaCliente);
		}else{
			$options['conditions'] = array('Reproductor.idEmpresa ='.$idEmpresaCliente.' and acepta_terceros = 1');
		}
		$options['group'] = array("Reproductor.idDispositivo");
		$options['joins'] = array(
		    array('table' => 'listaDispositivo',
		        'alias' => 'Listad',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'Reproductor.idDispositivo = Listad.idDispositivo',
		        )
		    ),
		   
		);

    	$dispositivos = $this->Reproductor->find("all", $options);
		$this->Reproductor->recursive = 0;
		
		if (count($dispositivos) > 0){
			return new CakeResponse( array( 'body' => json_encode(array('dispositivos'=>$dispositivos) ) ) );
		}else{
			return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		}

		/*$length = count($dispositivos);
		for($i=0;$i<count($dispositivos);$i++){
 			$idDispositivo = $dispositivos[$i]['Reproductor']['idDispositivo'];
			$optionsD['fields'] = array("count(*)cuenta");
			$optionsD['conditions'] = array("idDispositivo = '".$idDispositivo."' and tipo_relacion = 'terceros'");
			$cuentaTerceros = $this->ListaDispositivo->find('all',$optionsD);
			$dispositivos[$i][0]['cuentaTerceros'] = $cuentaTerceros[0][0]['cuenta'];
 		}*/


		//$this->set('dispositivos', $dispositivos);
	}

	public function editarReproductor($idDispositivo = null){
		$this->loadModel('Reproductor');
		$this->Reproductor->id = $idDispositivo;
		$this->set('reproductor',$this->Reproductor->read(null,$idDispositivo));
		if (!$this->Reproductor->exists()) {
			throw new NotFoundException(__('Invalid Reproductor'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Reproductor->save($this->request->data)) {
				$this->Session->setFlash(__('El reproductor ha sido guardado.'), 'info');
				$this->redirect(array('action' => 'vistaReproductor/'.$idDispositivo));
			} else {
				$this->Session->setFlash(__('El reproductor no ha podido guardarse. Por favor, intentalo de nuevo.'), 'error');
			}
		} else {
			$this->request->data = $this->Reproductor->read(null, $idDispositivo);
			$this->render('editarReproductor','agencia');
		}
	}

	public function deleteReproductor( $idDispositivo = null ) {
		( is_null( $idDispositivo ) ) ? $idDispositivo = $this->request->data['idDispositivo'] : false;
		$this->loadModel('Reproductor');
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Reproductor->id = $idDispositivo;
		if (!$this->Reproductor->exists()) {
			throw new NotFoundException(__('Invalid Reproductor'));
		}
		$dispositivo = $this->Reproductor->read(null, $idDispositivo);
		$dispositivo['Reproductor']['idEmpresa'] = "";
		if ($this->Reproductor->save($dispositivo)) {
			$lista = new ListaDispositivosController();
			$lista->constructClasses();
			
			$lista->ListaDispositivo->deleteAll("idDispositivo = '".$idDispositivo."'");
			
			//$this->Session->setFlash(__('El reproductor se ha eliminado con éxito.'),'info');
			//$this->redirect(array('action'=>'ListadoReproductores'));
			return new CakeResponse( array( 'body' => json_encode(array('idDispositivo'=>$idDispositivo) ) ) );
		}
		CakeLog::write('debug','El reproductor con id '.$idDispositivo.' no se ha eliminado.');
		//$this->Session->setFlash(__('El reproductor no se ha podido eliminar.'), 'error');
		return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		//$this->redirect(array('action'=>'ListadoReproductores'));
	}

	public function asignarReproductor(){
		$this->loadModel('Reproductor');
		$user = $this->Session->read("Auth");

		$this->loadModel('Empresa');
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		$idEmpresas = array();
		array_push($idEmpresas,$idEmpresa);
		$cuentaClientes = $empresa['agencia']['clientes'];
		if ( $cuentaClientes > 0 ){
			$clientes = $empresa['agencia'];
			foreach( $clientes as $cliente){
				if (is_array($cliente)){
					array_push($idEmpresas,$cliente['Agencia']['idCliente']);
				}
			}
		}
		$this->set('empresas',$this->Empresa->find('all', array('conditions' => array('idEmpresa' => $idEmpresas))));

		if($this->request->is("POST")){
			$idDispositivo = $this->request->data['Agencia']['idDispositivo'];
			$this->Reproductor->id = $idDispositivo;
			if ($this->Reproductor->exists()) {
				$resultado =$this->Reproductor->find("all", array("fields"=>array("idEmpresa","descripcion"), "conditions"=>array("idDispositivo = '".$idDispositivo."'")));
				if($resultado[0]['Reproductor']['idEmpresa'] == 0){

					//$empresa = $this->Session->read("Empresa");
					//$idEmpresa = $empresa['Empresa']['idEmpresa'];
					$data['Reproductor']['idDispositivo'] = $idDispositivo;
					//$data['Reproductor']['idEmpresa'] = $idEmpresa;
					$data['Reproductor']['idEmpresa'] = $this->request->data['Agencia']['idEmpresa'];
					$data['Reproductor']['descripcion'] = $this->request->data['Agencia']['descripcion'];
					$this->Reproductor->save($data);
					$this->Session->setFlash(__('El reproductor se ha asignado correctamente.'),'info');
					
					$this->redirect(array('action' => 'ListadoReproductores'));
				}else{
					//$empresa = $this->Session->read("Empresa");
					//$idEmpresa = $empresa['Empresa']['idEmpresa'];
					$idEmpresa = $this->request->data['Agencia']['idEmpresa'];
					if($idEmpresa == $resultado[0]['Reproductor']['idEmpresa']){
						$this->Session->setFlash("El reproductor ".$idDispositivo.' ya está dado de alta con el nombre <h1>'.$resultado[0]['Reproductor']['descripcion'].'</h1>','info');	
					}else{
						$this->Session->setFlash(__('El reproductor '.$idDispositivo.' ya está asignado a una empresa.'),'error');
					}
					$this->redirect(array('action' => 'ListadoReproductores'));
				}
			}else{
				$this->Session->setFlash('El reproductor '.$idDispositivo.' no está en el sistema.','error');
				$this->redirect(array('action' => 'ListadoReproductores'));
			}
			$this->redirect(array('action'=>'ListadoReproductores'));
		}else{
			//$this->redirect(array('action' => 'ListadoReproductores'));
			$this->render('asignarReproductor','agencia');
		}
	}

	public function asignarLista($idReproductor = null, $tipo = null, $idLista = null){
		$this->loadModel('Reproductor');
		$this->loadModel('Listum');
		$this->loadModel('Empresa');
		$EmpresaAgente = $this->Session->read('Empresa');
		$idEmpresaAgente = $EmpresaAgente['Empresa']['idEmpresa'];
		
		$reproductor = $this->Reproductor->read('idEmpresa', $idReproductor);
		$idEmpresa = $reproductor['Reproductor']['idEmpresa'];

		$options['order'] = array('idLista');
		$options['conditions'] = array("idEmpresa = '".$idEmpresaAgente."'"); 
		$listasEmpresaAgente = $this->Listum->find('all',$options);
		$empresaAgente = $this->Empresa->read(null,$idEmpresaAgente);
		$datos = array();
		array_push($datos,$empresaAgente);
		$datos[0]['listas'] = $listasEmpresaAgente;
		if ($idEmpresaAgente != $idEmpresa){
			$options['conditions'] = array("idEmpresa = '".$idEmpresa."'");
			$listasEmpresa = $this->Listum->find('all',$options);
			$empresa = $this->Empresa->read(null,$idEmpresa);
			array_push($datos,$empresa);
			$datos[1]['listas'] = $listasEmpresa;
		}
		$this->set('datos',$datos);
		$this->set('dispositivo', $idReproductor);
		$this->set('tipo',$tipo);
		$usuario = $this->Session->read('Auth');
		$idUsuario = $usuario['User']['id'];
		if( !is_null($idLista)){
			$this->loadModel('ListaDispositivo');
			$data['ListaDispositivo']['idDispositivo'] = $idReproductor;
			$data['ListaDispositivo']['idLista'] = $idLista;
			$data['ListaDispositivo']['idUsuario'] = $idUsuario;
			$data['ListaDispositivo']['tipo_relacion'] = $tipo;
			if($this->ListaDispositivo->save($data)){
				$this->Session->setFlash("Lista asignada correctamente.",'info');
			}else{
				$this->Session->setFlash("No se ha podido asignar la lista.",'error');
			}
			//$this->redirect(array('controller'=>'agencia' ,'action'=>'vistaReproductor',$idReproductor));
			$this->redirect(array('controller' => 'agencia' , 'action' => 'vistaReproductor/'.$idReproductor));
		}else{
			$this->render('asignarLista','empty');	
		}
		$this->render('asignarLista','empty');
	}

	public function desvincularLista(){
		//$idReproductor = $this->request->data['idReproductor'];
		//$idLista = $this->request->data['idLista'];
		$idLD = $this->request->data['idLD'];
		$this->loadModel('ListaDispositivo');
		if($this->request->is("POST")){
			$resultado = $this->ListaDispositivo->read(null,$idLD);
			if(count($resultado) > 0){
				if($this->ListaDispositivo->delete($resultado['ListaDispositivo']['id'])){
					$programacion = new ProgramacionsController();
					$programacion->constructClasses();
					$programacion->Programacion->deleteAll("idListaDispositivo = '".$idLD."'");
					//$this->Session->setFlash("Lista eliminada correctamente.",'info');
					return new CakeResponse( array( 'body' => json_encode(array('idLD'=>$idLD) ) ) );
				}else{
					CakeLog::write('debug','La lista con id '.$resultado[0]['ListaDispositivo']['id'].' no se ha eliminado.');
					return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
					//$this->Session->setFlash("No se ha encontrado la lista.",'error');
				}
			}
			return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );		
			//$this->redirect(array('action'=>'vistaReproductor/',$idReproductor));
		}
	}

	public function videosLista($idLista = null,$idListaDispositivo = null){
		$this->loadModel('Listum');
		$this->loadModel('Video');
		$this->loadModel('ListaDispositivo');
		$idReproductor = $this->ListaDispositivo->read('idDispositivo',$idListaDispositivo);
		$this->set('idReproductor',$idReproductor['ListaDispositivo']['idDispositivo']);
		$idEmpresa = $this->Listum->read('idEmpresa',$idLista);
			
		$options['fields'] = array('listaVideo.id','listaVideo.posicion','idVideo','fotograma','descripcion','url','name','mute','time','estado','count(distinct lv.idLista) listas', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
		$options['group'] = array('listaVideo.id');
		$options['order'] = array('listaVideo.posicion');
		$options['conditions'] = array("Video.idEmpresa = '".$idEmpresa."'", "listaVideo.idLista =".$idLista );
		$options['joins'] = array(
			array('table' => 'listaVideo',
					'type' => 'left',
					'conditions' => array(
							'Video.idVideo = listaVideo.idVideo',
					)
			),
			array('table' => 'listaDispositivo',
					'type' => 'left',
					'conditions' => array(
							'listaVideo.idLista = listaDispositivo.idLista'
					)
			),
			array('table' => 'lista',
					'type' => 'left',
					'conditions' => array(
							'listaVideo.idLista = lista.idLista'
					)
			),
			array('table' => 'listaVideo',
					'alias' => 'lv',
					'type' => 'left',
					'conditions' => array(
							'listaVideo.idVideo = lv.idVideo'
					)
			)
		);
		$videos = $this->Video->find("all", $options);
		$this->set('videos', $videos);
		//$this->cargarListas();
		//$this->cargarLista($idLista);
		$this->render('videosLista', 'agencia');
	
	}

	public function obtenerDatosLista(){
		$idLista = $this->request->data['idLista'];
		$idListaDispositivo = $this->request->data['idListaDispositivo'];
		$this->loadModel('Listum');
		$this->loadModel('ListaDispositivo');
		$idEmpresa = $this->Listum->read('idEmpresa',$idLista);
		$idReproductor = $this->ListaDispositivo->find('all',array("conditions" =>"id = '".$idListaDispositivo."'"));
		$datos = array();
		array_push($datos,$idEmpresa['Listum']['idEmpresa']);
		array_push($datos,$idReproductor[0]['ListaDispositivo']['idDispositivo']);
		if ( $datos != null ){
			return new CakeResponse( array( 'body' => json_encode( $datos) ) );
		}else{
			return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		}
	}

	public function addLista($idEmpresa = null,$idLista = null,$idListaDispositivo = null) {
		$this->loadModel('Listum');
		/*$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];*/
		$this->request->data['Listum']['idEmpresa'] = $idEmpresa;
		$usuario = $this->Session->read('Auth');
		$idUsuario = $usuario['User']['id'];
		if ($this->request->is('post')) {
			$this->Listum->create();
			$this->request->data['Listum']['idUsuario'] = $idUsuario;
			$this->request->data['Listum']['timestamp'] = DboSource::expression('NOW()');				
			if ($this->Listum->save($this->request->data)) {
				$this->Session->setFlash(__('Se ha creado una lista nueva.'), 'info');
			} else {
				$this->Session->setFlash(__('La lista no ha podido crearse. Por favor, intentalo de nuevo.'), 'error');
			}
			$this->redirect(array('action' => 'videosLista/'.$idLista."/".$idListaDispositivo));
		}
		$this->render('addNewLista', 'empty');
	}

	public function editarLista($idLista = null,$idListaDispositivo = null,$idReproductor = null) {
		$this->set('idLista',$idLista);
		$this->set('idListaDispositivo',$idListaDispositivo);
		$this->set('idReproductor',$idReproductor);
		
		$this->loadModel('Listum');
		$this->Listum->id = $idLista;
		if (!$this->Listum->exists()) {
			throw new NotFoundException(__('Invalid Listum'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Listum->save($this->request->data)) {
				$this->Session->setFlash(__('La lista ha sido modificada.'), 'info');
				$this->redirect(array('action' => 'videosLista/'.$idLista."/".$idListaDispositivo));
			} else {
				$this->Session->setFlash(__('La lista no ha podido guardarse. Por favor, intentalo de nuevo.'), 'error');
			}
		} else {
			$this->request->data = $this->Listum->read(null, $idLista);
			$this->render('editarLista','loged');
		}
	}

	public function deleteLista($idLista = null, $idReproductor = null) {
		$this->loadModel('Listum');
		if (!$this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		$this->Listum->id = $idLista;
		if (!$this->Listum->exists()) {
			throw new NotFoundException(__('Invalid Listum'));
		}
		if ($this->Listum->delete()) {
			
			$lista = new ListaDispositivosController();
			$lista->constructClasses();
			$lista->ListaDispositivo->deleteAll('idLista = '.$idLista);			
			
			$lista = new ListaVideosController();
			$lista->constructClasses();
			$lista->ListaVideo->deleteAll('idLista = '.$idLista);
			
			$this->Session->setFlash(__('Lista eliminada.'), 'info');
			//$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
			$this->redirect(array('action'=>'vistaReproductor/'.$idReproductor));
		}
		$this->Session->setFlash(__('La lista no se ha eliminado.'), 'error');
		$this->redirect(array('action'=>'vistaReproductor/'.$idReproductor));
	}

	public function cargarContenido($idLista = null,$idEmpresa = null){
		$this->loadModel('Video');
		$options['fields'] = array('listaVideo.id','listaVideo.posicion','idVideo','fotograma','descripcion','url','name','mute','time','estado','count(distinct lv.idLista) listas', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
		$options['group'] = array('listaVideo.id');
		$options['order'] = array('listaVideo.posicion');
		$options['conditions'] = array("listaVideo.idLista =".$idLista );
		//"Video.idEmpresa = '".$idEmpresa."'", 
		$options['joins'] = array(
				array('table' => 'listaVideo',
						'type' => 'left',
						'conditions' => array(
								'Video.idVideo = listaVideo.idVideo',
						)
				),
				array('table' => 'listaDispositivo',
						'type' => 'left',
						'conditions' => array(
								'listaVideo.idLista = listaDispositivo.idLista'
						)
				),
				array('table' => 'lista',
						'type' => 'left',
						'conditions' => array(
								'listaVideo.idLista = lista.idLista'
						)
				),
				array('table' => 'listaVideo',
						'alias' => 'lv',
						'type' => 'left',
						'conditions' => array(
								'listaVideo.idVideo = lv.idVideo'
						)
				)
		);
		$contenido = $this->Video->find("all", $options);
		if (count($contenido) > 0){
			return new CakeResponse( array( 'body' => json_encode(array('videos'=>$contenido) ) ) );
		}else{
			return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		}
	}

	public function desvincularVideo(){
		$idLV = $this->request->data['idLV'];
		$this->loadModel('ListaVideo');
		$this->ListaVideo->id = $idLV;
		if (!$this->ListaVideo->exists()) {
			//throw new NotFoundException(__('Invalid lista video'));
			return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		}
		if ($this->ListaVideo->delete()) {
			//$this->redirect(array('controller'=>'videos','action'=>'videosxlista', $idLista));
			return new CakeResponse( array( 'body' => json_encode(array('idLV'=>$idLV) ) ) );
		}
		//$this->Session->setFlash(__('Lista video no ha sido borrado.'));
		CakeLog::write('debug','La lista con id '.$resultado[0]['ListaDispositivo']['id'].' no se ha eliminado.');
		return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		//$this->redirect(array('controller'=>'videos','action'=>'videosxlista', $idLista));


	}

	public function cargarTodosVideos($idLista = null, $idEmpresa = null){
		$empresa = $this->Session->read("Empresa");
		$idEmpresaAgente = $empresa['Empresa']['idEmpresa']; 
		
		$this->loadModel('Video');
		$options['fields'] = array('listaVideo.id','idVideo','listaVideo.posicion','descripcion','fotograma','url','name','mute','time', 'estado','count(distinct listaVideo.idLista) listas', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
		$options['group'] = array('Video.idVideo');
		if ($idEmpresaAgente != $idEmpresa){
			$options['conditions'] = array("Video.idEmpresa in ('".$idEmpresa."','".$idEmpresaAgente."')");
		}else{
			$options['conditions'] = array("Video.idEmpresa = '".$idEmpresa."'");
		}
		$options['joins'] = array(
				array('table' => 'listaVideo',
						'type' => 'left',
						'conditions' => array(
								'Video.idVideo = listaVideo.idVideo',
						)
				),
				array('table' => 'listaDispositivo',
						'type' => 'left',
						'conditions' => array(
								'listaVideo.idLista = listaDispositivo.idLista'
						)
				)
		);
		$options['order'] = array('Video.idEmpresa, Video.idVideo');
		$videos = $this->Video->find("all", $options);
		$this->set('videos', $videos);
		$this->set('lista', $idLista);
		$this->render('/Videos/todos','empty');
	}

	public function listadoVideos(){
		$this->render('listadoVideos', 'agencia');
	}

	public function cargarTodoContenido($idEmpresa = null){
		$this->loadModel('Video');
		$this->loadModel('Listum');
		$optionsL['conditions'] = array("idEmpresa = ".$idEmpresa);
		$listas = $this->Listum->find("all", $optionsL);
		$options['fields'] = array('listaVideo.id','idVideo','idEmpresa','listaVideo.posicion','descripcion','fotograma','url','name','mute','time', 'estado','count(distinct listaVideo.idLista) listas', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
		$options['group'] = array('Video.idVideo');
		$options['conditions'] = array("Video.idEmpresa = '".$idEmpresa."'");
		$options['order'] = array('Video.idEmpresa');
		$options['joins'] = array(
				array('table' => 'listaVideo',
						'type' => 'left',
						'conditions' => array(
								'Video.idVideo = listaVideo.idVideo',
						)
				),
				array('table' => 'listaDispositivo',
						'type' => 'left',
						'conditions' => array(
								'listaVideo.idLista = listaDispositivo.idLista'
						)
				)
		);
		$videos = $this->Video->find("all", $options);
		$datos = array();
		array_push($datos,$listas);
		array_push($datos,$videos);
		if ( $datos != null ){
			return new CakeResponse( array( 'body' => json_encode( $datos) ) );
		}else{
			return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		}
	}

	public function addVideo() {
		$this->loadModel('Empresa');
		$videosC = new VideosController();
		$videosC->constructClasses();
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		$idEmpresas = array();
		array_push($idEmpresas,$idEmpresa);
		$cuentaClientes = $empresa['agencia']['clientes'];
		if ( $cuentaClientes > 0 ){
			$clientes = $empresa['agencia'];
			foreach( $clientes as $cliente){
				if (is_array($cliente)){
					array_push($idEmpresas,$cliente['Agencia']['idCliente']);
				}
			}
		}
		$this->set('empresas',$this->Empresa->find('all', array('conditions' => array('idEmpresa' => $idEmpresas))));
		if ($this->request->is('post')) {
			if($this->add($this->request->data['Video']['idEmpresa'])){	
				$fileOK = $videosC->uploadVideo('img/files', $this->request->data['Video']['Document']);
				if(!is_null($fileOK) && (( !array_key_exists("errors", $fileOK)) || (count( $fileOK['errors'] ) == 0 ))){
					$auth = $this->Session->read("Auth");
					$this->request->data['Video']['name'] = $fileOK['name'];
					if(array_key_exists('S3URL', $fileOK) && $fileOK[ 'S3URL' ] != ""){
						$this->request->data['Video'][ 'url' ] = str_replace( '.'.$fileOK[ 'rutas' ][ 'extension' ], '', $fileOK[ 'S3URL' ] );
					}else{
						$this->request->data['Video'][ 'url' ] = json_encode( array( 'orig' => FULL_BASE_URL.DIRECTORIO.'/'.$fileOK['rutas']['URLArchivo'] ) );
					}
					$this->request->data['Video']['idEmpresa'] = $this->request->data['Video']['idEmpresa'];
					$this->request->data['Video']['fotograma'] = str_replace("img/","",$fileOK['rutas']['fotograma']);
					$this->request->data['Video']['estado'] = 'sin procesar';
					$this->request->data['Video']['timestamp'] = DboSource::expression('NOW()');
					$this->request->data['Video']['idUsuario'] = $auth['User']['id'];
					$this->request->data['Video']['tipo'] = "video";
					$this->request->data['Video']['time'] = $this->request->data['Video']['tiempo'];
					CakeLog::write("Comando", "url del fotograma: ".$this->request->data['Video']['fotograma']);
					if ($videosC->Video->save($this->request->data)) {
						$video = $videosC->Video->read(null, null);
						/*$videosC->processVideo(
							$video['Video']['idVideo'],
							'crt_mp4',
							"http://".HOST.DIRECTORIO."/videos/updateVideoJsonPlusHTML5/".$video['Video']['idVideo']
						);*/
						CakeLog::write('debug','El fichero con nombre '.$this->request->data['Video']['Document']['name'].' ha sido almacenado con el id: '.$videosC->Video->id);
						$this->Session->setFlash(__('El video ha llegado correctamente, va ser procesado por nuestros servidores.'), 'info');
						return new 	CakeResponse(array('body' => json_encode( $video) ) );
					} else {
						$this->Session->setFlash(__('El video no ha podido guardarse. Por favor, intentalo de nuevo.'));
						$this->redirect(array('action' => 'listadoVideos'));
					}
				}else{
					$this->redirect(array('action' => 'listadoVideos'));
				}
			}			
		}
	}

	public function addImagen() {
		$this->loadModel('Empresa');
		$videosC = new VideosController();
		$videosC->constructClasses();
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		$idEmpresas = array();
		array_push($idEmpresas,$idEmpresa);
		$cuentaClientes = $empresa['agencia']['clientes'];
		if ( $cuentaClientes > 0 ){
			$clientes = $empresa['agencia'];
			foreach( $clientes as $cliente){
				if (is_array($cliente)){
					array_push($idEmpresas,$cliente['Agencia']['idCliente']);
				}
			}
		}
		$this->set('empresas',$this->Empresa->find('all', array('conditions' => array('idEmpresa' => $idEmpresas))));
		if ($this->request->is('post')) {
			if($this->add($this->request->data['Video']['idEmpresa'])){
				$fileOK = $videosC->uploadImagen('img/files', $this->request->data['Video']['Document']);
				if(!is_null($fileOK) && (( !array_key_exists("errors", $fileOK)) || (count( $fileOK['errors'] ) == 0 ))){
					$this->request->data['Video']['name'] = $fileOK['name'];
					$this->request->data['Video'][ 'url' ] = json_encode( array( "img" => FULL_BASE_URL.DIRECTORIO.'/'.$fileOK['rutas']['URLArchivo']  ) );
					$this->request->data['Video']['idEmpresa'] = $this->request->data['Video']['idEmpresa'];
					$this->request->data['Video']['fotograma'] = str_replace("img/","",$fileOK['rutas']['fotograma']);
					$this->request->data['Video']['time'] = $this->request->data['Video']['tiempo'];
					$this->request->data['Video']['estado'] = 'sin procesar';
					$this->request->data['Video']['timestamp'] = DboSource::expression('NOW()');
					$this->request->data['Video']['tipo'] = "imagen";
					if( $videosC->Video->save( $this->request->data ) ) {
						$video = $videosC->Video->read(null, null);
						$videosC->processImage(
							$video['Video']['idVideo'],
							'crt_image'
						);
						$videosC->processImage(
							$video['Video']['idVideo'],
							'crt_image_max',
							array('h' =>90, 'w' => 160),
							"http://".HOST.DIRECTORIO."/videos/updateFotogramaJson/".$video['Video']['idVideo']
						);
						return new 	CakeResponse(array('body' => json_encode( $video) ) );
					} else {							
						$this->Session->setFlash(__('La imagen no ha sido guardada, prueba de nuevo.'));
						$this->redirect(array('action' => 'listadoVideos'));
					}
				}else{
					$this->redirect(array('action' => 'listadoVideos'));
				}

			}
		}
	}

	private function add($idEmpresa = null){
		$this->loadModel('Video');
		//$empresa = $this->Session->read("Empresa");
		//$idEmpresa = $empresa['Empresa']['idEmpresa'];
		//$this->request->data['Video']['idEmpresa'] = $idEmpresa;
		$this->Video->create();
		if(array_key_exists('Document', $this->data['Video']) || array_key_exists('cartel', $this->data['Video'])){
			$this->request->data['Video']['estado'] = 'sin procesar';
			if ($this->Video->save($this->request->data)) {
				return true;
			}
		}else{
			$this->Session->setFlash(__('El fichero no se ha añadido, es posible que sea demasiado grande.'), 'info');
			$this->redirect(array('action' => 'listadoVideos'));
		}
	}

	public function deleteVideo(){
		$idVideo = $this->request->data['idVideo'];
		$videosC = new VideosController();
		$videosC->constructClasses();
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$videosC->Video->id = $idVideo;
		if (!$videosC->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		$videosC->Video->read();
		
		//print_r( $this->Video );
		$videosC->eliminarArchivo( $videosC->Video->data['Video']['url'] );
		$videosC->eliminarArchivo( 'img/'.$videosC->Video->data['Video']['fotograma']);
		if ($videosC->Video->delete()) {
			
			$lista = new ListaVideosController();
			$lista->constructClasses();
			$lista->ListaVideo->deleteAll('idVideo = '.$idVideo);
			
			return new CakeResponse( array( 'body' => json_encode(array('idVideo'=>$idVideo ) ) ) );
			//$this->Session->setFlash(__('El video ha sido eliminado.'), 'info');
			//$this->redirect(array('action'=>'index'));
		}
		return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
		//$this->Session->setFlash(__('El video no ha sido eliminado.'));
		//$this->redirect(array('action' => 'index'));
	}

}

	
	

?>