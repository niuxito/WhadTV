<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');
App::import('Controller', 'ListaDispositivos');
App::import('Controller', 'Dispositivos');
App::import('Controller', 'ListaDispositivos');
App::import('Controller', 'ActualizacionDispositivos');
App::import('Controller', 'Empresas');

/**
 * Reproductores Controller
 *
 * @property Reproductor $Reproductor
 */
class ReproductorsController extends AppController {
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Session', 'Auth');
	

	
	function beforeFilter(){
		parent::beforeFilter();
		//CakeLog::write("debug", "Ha pasado el filtro inicial");
		$this->Auth->fields = array(
        'username' => 'username', 
        'password' => 'password'
        );
		parent::testAuth();
		//CakeLog::write("debug", "Ha pasado el test");
		$idEmpresa = $this->getIdEmpresa();

		
	
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		$this->loadModel('Listum');
		$this->Reproductor->recursive = -1;
		$options['conditions'] = array("idEmpresa = ".$idEmpresa);
		$lista = $this->Listum->find("all", $options);
		$this->getReproductores();
		
		$this->set('listas', $lista);
		
		$this->render('index', 'loged');
	}

	public function getReproductores(){
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		//$this->loadModel('Listum');
		$this->Reproductor->recursive = -1;
		$dispositivos = $this->Reproductor->listaPorEmpresa( $idEmpresa );
		
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		if( !$empresaC->demoWebPasada() && !$empresaC->demoWebBloqueada() ) $this->set( 'demo', false );
		$this->Reproductor->recursive = 0;
		
		$this->set('dispositivos', $dispositivos);
	}
	
	public function updatedispositivos($idLista){
		if($this->request->is("POST")){
			$aDisp = new ActualizacionDispositivosController();
			$aDisp->constructClasses(); 

			CakeLog::write("debug", "Actualizando dispositivos");
			foreach($this->request->data['chec'] as $disp){

				$this->sendActualizar($disp);
				$aDisp->add($disp);
			}
			
			
		}else{
			$options = array();
			$options['fields'] = array('listaDispositivo.idLista','listaDispositivo.idDispositivo', 'Reproductor.descripcion');
			$options['conditions'] = array('listaDispositivo.idLista ='.$idLista);
			$options['group'] = array('listaDispositivo.idDispositivo');
			$options['joins'] = array(
					array('table' => 'listaDispositivo',
			        //'alias' => 'Listad',
			        'type' => 'LEFT',
			        'conditions' => array(
			            'Reproductor.idDispositivo = listaDispositivo.idDispositivo',
			        )
			    )
			);
			$resultado = $this->Reproductor->find('all',$options);
			$this->set('dispositivos', $resultado);
		}
	}
	
	public function asignar(){
		$user = $this->Session->read("Auth");
		if($this->request->is("POST")){
			$id = $this->request->data['Reproductor']['id'];
			$this->Reproductor->id = $id;
			if ($this->Reproductor->exists()) {
				$resultado =$this->Reproductor->find("all", array("fields"=>array("idEmpresa","descripcion"), "conditions"=>array("idDispositivo = '".$id."'")));
				if($resultado[0]['Reproductor']['idEmpresa'] == 0){
					$empresa = $this->Session->read("Empresa");
					$idEmpresa = $empresa['Empresa']['idEmpresa'];
					$data['Reproductor']['id'] = $id;
					$data['Reproductor']['idEmpresa'] = $idEmpresa;
					$data['Reproductor']['descripcion'] = $this->request->data['Reproductor']['descripcion'];
					$this->Reproductor->save($data);
					$this->Session->setFlash(__('El reproductor se ha asignado correctamente.'),'info');
					
					if($user['User']['welcome'] == 0){
						$this->redirect(array('controller'=>'users', 'action'=>'chwelcome'));
					}else{
						$this->redirect(array('action'=>'index'));
					}
					//$this->redirect("../Empresas/panel");
				}else{
					$empresa = $this->Session->read("Empresa");
					$idEmpresa = $empresa['Empresa']['idEmpresa'];
					if($idEmpresa == $resultado[0]['Reproductor']['idEmpresa']){
						$this->Session->setFlash("El reproductor ".$id.' ya está dado de alta con el nombre <h1>'.$resultado[0]['Reproductor']['descripcion'].'</h1>','info');	
					}else{
						$this->Session->setFlash(__('El reproductor '.$id.' ya está asignado a una empresa.'),'error');
					}
					if($user['User']['welcome'] == 0){
						$this->render('asignar');
					}else{
						$this->redirect(array('action'=>'index'));
					}
				}
			}else{
				$this->Session->setFlash('El reproductor '.$id.' no está en el sistema.','error');
				$this->redirect(array('action'=>'index'));
			}
		}else{
			if($user['User']['welcome'] == 0){
				$this->render('asignar');
			}else{
				$this->render('asignar','empty');
			}
		}
	}
	
	/*
	 * Funciones para envío de mensajes push
	 */
	
	public function sendActualizar($id){
		$opcion = "ACTUALIZAR";
		$gId = $this->getGoogleIdFromId($id);
		$resultado =( $gId != "0" ) ? $this->push( $opcion, $gId ) : $this->wsMessage( 'sendActualizar',$id );
		CakeLog::write("debug", $resultado);
		$this->logPush(array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado);
		return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
	}

	public function sendUpdateApk($id){
		$opcion = "APK";
		$gId = $this->getGoogleIdFromId($id);
		$resultado =( $gId != "0" ) ? $this->push( $opcion, $gId ) : false ; //$this->wsMessage( 'sendActualizar',$id );
		CakeLog::write("debug", $resultado);
		$this->logPush(array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado);
		return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
	}

	public function sendDetener($id){
		$opcion = "DETENER";
		$this->Reproductor->id = $id;
		$data['Reproductor']['id'] = $id;
		$data['Reproductor']['play'] = "0";
		$this->Reproductor->save($data);
		$gId = $this->getGoogleIdFromId($id);
		$resultado =( $gId == "0" ) ? $this->wsMessage( 'sendStop',$id ) :$this->push( $opcion, $gId );
		$this->logPush( array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado );
		return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
	}
	public function sendReproducir($id){
		$opcion = "REPRODUCIR";
		$this->Reproductor->id = $id;
		$data['Reproductor']['id'] = $id;
		$data['Reproductor']['play'] = "1";
		$this->Reproductor->save($data);
		$gId = $this->getGoogleIdFromId($id);
		$resultado =( $gId == "0" ) ? $this->wsMessage( 'sendPlay',$id ) :$this->push( $opcion, $gId );
		//$resultado =( $gId !== 0 ) ? $this->push( $opcion, $gId ) : $this->wsMessage( 'sendPlay',$id );
		
		$this->logPush(array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado);
		return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
	}
	
	public function sendLogReproducir($id, $estado){
		$opcion = "VERBOSE|".$estado;
		$gId = $this->getGoogleIdFromId($id);
		$resultado = $this->push($opcion, $gId);
	
		$this->logPush(array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado);
		return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
	}
	
	public function sendCambiarURL($url, $id){
		
		$opcion = "DIRECCION";
		$gId = $this->getGoogleIdFromId($id);
		$resultado = $this->push($opcion."|".$url, $gId);
		$this->logPush(array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado);
		return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
	}
	
	public function sendFlush($id){
		$opcion = "FLUSH";
		$gId = $this->getGoogleIdFromId($id);
		$this->push($opcion, $gId);
		$this->logPush(array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado);
		return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
	}
	
	
	public function sendLogo($eId){
		$dispositivos = $this->Reproductor->find("all", array("conditions" => "idEmpresa = ".$eId));
		CakeLog::write('Dispositivos', "LOGO: Se van a enviar ".count( $dispositivos )." mensajes a los dispositivos de la empresa ".$eId);
		foreach( $dispositivos as $dispositivo){
			
			$id = $dispositivo['Reproductor']['idDispositivo'];
			$gId = $this->getGoogleIdFromId($id);
			//Capturar el logo de alguna parte
			$resultado = $this->push("LOGO|".$eId, $gId);
			CakeLog::write('Dispositivos', "Se ha ejecutado sendLogo");
		}
		
		//CakeLog::write('Dispositivos', print_r($resultado));
		
		$this->redirect($this->referer());
	}
	public function sendEspacio(){
		$this->push("DISCO");
	}
	
	public function getGoogleIdFromId( $id ){
		$options[ 'fields' ] = array( 'idGoogle' );
		$options[ 'conditions' ]   = array( "idDispositivo = '".$id."'" ); 
		$resultado = $this->Reproductor->find("all", $options); // "Select idEmpresa from empresa as Empresa where idEmpresa = '".$id."'" );
		if( count( $resultado ) > 0){
			$idGoogle = $resultado[0]['Reproductor']['idGoogle'];
			return $idGoogle;
		}
		return false;
	}
	public function logPush($parametros, $resultado){
	if( $resultado !== false){
			CakeLog::write("Dispositivos", $parametros['opcion'].": El mensaje se ha enviado correctamente y google ha devuelto: ".$resultado);
		}else{
			CakeLog::write("Dispositivos", $parametros['opcion'].": No hay respuesta de Google");
		}
	}
	
	public function push($parametro, $idGoogle){
		//esto es fijo siempre para la cuenta que he creado
		$apiKey = "AIzaSyCjVKF5lGm312uXk0rrjswJhhDsidJ3qps"; //Vieja API_KEY
		//$apiKey = "AIzaSyAhHU7n_LIEaer85rMcPrI3w53_J-F6h54"; //API_KEY con niuxxx
		
		//id_google lo habremos obtenido del alta
		//$registrationIDs = array( "id_google");
		$registrationIDs = array($idGoogle);
		
		// esto podra ser UPDATE  , FLUSH , GETESTADO ….. SETICON/{idIcono}
		//$message = "UPDATE";
		$message = $parametro;
		$url = 'https://android.googleapis.com/gcm/send';
		
		$fields = array(
		            	'registration_ids'  => $registrationIDs,
		            	'data'          	=> array( "message" => $message ),
		            	);
		
		$headers = array(
		                	'Authorization: key=' . $apiKey,
		                	'Content-Type: application/json'
		            	);
		
		// Open connection
		$ch = curl_init();
		
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, $url );
		
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		CakeLog::write("debug", "Esto es lo que se manda en el push: ".$ch);
		
		// Execute post

		$result = curl_exec($ch);
		CakeLog::write("debug", $result);
		
		
		//print_r($fields);
		CakeLog::write("Dispositivos", "Enviado el mensaje ".$parametro." al dispositivo con idGoogle: ".$idGoogle);
		// Close connection
		curl_close($ch);
		
		return $result;


	}

	public function wsMessage( $accion, $id )
	{
		$url = WS_SERVER.$accion.'?dispositivo='.$id;
		CakeLog::write( "Dispositivos", $url );
		return file_get_contents( $url );
	} 
	
	public function addlista($idDispositivo, $idLista = null){
		$idEmpresa = $this->getIdEmpresa();
		$this->loadModel('Listum');
		$optionsL['conditions'] = array("idEmpresa = ".$idEmpresa);
		$listas = $this->Listum->find("all", $optionsL);
		$this->set('listas', $listas);
		$this->set('dispositivo', $idDispositivo);
		if( !is_null($idLista)){
			$listaD = new ListaDispositivosController();
			$listaD->constructClasses();
			$data['ListaDispositivo']['idDispositivo'] = $idDispositivo;
			$data['ListaDispositivo']['idLista'] = $idLista;
			//print_r($data);
			if($listaD->ListaDispositivo->save($data)){
				$this->Session->setFlash("Lista insertada correctamente.",'info');
			}else{
				$this->Session->setFlash("No lo inserta.");
			}
			//$this->render('addlista','');
			$this->redirect(array('action'=>'view',$idDispositivo));
		}else{
			
			$this->render('addlista');
		}
	}
	
	public function deleteLista($idDispositivo, $idLista){
		if($this->request->is("POST")){
			
			$lista = new ListaDispositivosController();
			$lista->constructClasses();
			$resultado =  $lista->ListaDispositivo->find('all',array('conditions'=>array("idDispositivo ='".$idDispositivo."'", 'idLista ='.$idLista)));
			if(count($resultado) > 0){
				if($lista->ListaDispositivo->delete($resultado[0]['ListaDispositivo']['id'])){
					$this->Session->setFlash("Lista eliminada correctamente.",'info');
				}else{
					$this->Session->setFlash("No se ha encontrado la lista.",'error');
				}
				
			}
			$this->redirect(array('action'=>'view',$idDispositivo));
		}
	}
	
	
	
	
	
    
	
    
    public function getIdEmpresa(){
    	$empresa = $this->Session->read("Empresa");
    	if(is_null ($empresa) ){
    		$this->redirect(array('controller'=>'empresas', 'action'=>'selectEmpresa'));
    	}
    	$idEmpresa = $empresa['Empresa']['idEmpresa'];
    	return $idEmpresa;
    }
    
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if( $this->request->is( 'post' ) && $this->request->data['chk_reproductor'] != 0 ){
			$id = $this->request->data['chk_reproductor'];
		}
			$idEmpresa = $this->getIdEmpresa();
			$this->loadModel('Listum');
			$optionsL['fields'] = array(
				'listaDispositivo.activa',
			 	'Listum.idLista',
			  	'listaDispositivo.idDispositivo',
			   	'Listum.descripcion',
			    'listaDispositivo.id',
			    'Listum.mute',
			    'count(distinct listaVideo.id) videos'
			);
			$optionsL['conditions'] = array( "idEmpresa = ".$idEmpresa, 'listaDispositivo.idDispositivo'=>$id );
			$optionsL['group'] = array('listaDispositivo.id');
			$optionsL['joins'] = array(
						
					array('table' => 'listaDispositivo',
								
							'type' => 'left',
							'conditions' => array(
									'Listum.idLista = listaDispositivo.idLista',
									 'listaDispositivo.tipo_relacion = "basica"'
							)
					),
					array('table' => 'listaVideo',
					
							'type' => 'left',
							'conditions' => array(
									'listaVideo.idLista = Listum.idLista'
							)
					)
					
			);
			$listas = $this->Listum->find("all", $optionsL);
			$this->set('listas', $listas);
			$this->getReproductores();

		$this->Reproductor->id = $id;
		if (!$this->Reproductor->exists()) {
			//throw new NotFoundException(__('Invalid dispositivo'));
			print_r($this->Reproductor->id);
		}
		
		$this->set('dispositivo', $this->Reproductor->read(null, $id));
		$this->render('view','loged');
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//print_r($this->request->data);
		if ($this->request->is('post')) {
			$this->Reproductor->create();
			$this->request->data['Reproductor']['timestamp'] = DboSource::expression('NOW()');
			if ($this->Reproductor->save($this->request->data)) {
				$this->Session->setFlash(__('El dispositivo ha sido guardado.'),'info');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('El dispositivo no ha podido guardarse. Por favor, intentalo de nuevo.'),'error');
			}
		}
	}


	
/**
 * mute method
 * 
 * @return void
 */	
	public function mute(){
			$this->Reproductor->id = $this->request->data['id'];
			$this->request->data['Reproductor']['mute'] = $this->request->data['mute'];
			if ($this->Reproductor->save($this->request->data)) {
				$this->Session->setFlash(__('La lista ha sido guardada.'), 'info');
				$this->redirect(array('action' => 'index'));
			}else{
				$this->redirect(array('action' => 'index'));
			}
			
	
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this->Reproductor->id = $id;
		if (!$this->Reproductor->exists()) {
			throw new NotFoundException(__('Invalid dispositivo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Reproductor->save($this->request->data)) {
				$this->Session->setFlash(__('El dispositivo ha sido guardado.'), 'info');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El dispositivo no ha podido guardarse. Por favor, intentalo de nuevo.'), 'error');
			}
		} else {
			$this->request->data = $this->Reproductor->read(null, $id);
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
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Reproductor->id = $id;
		if (!$this->Reproductor->exists()) {
			throw new NotFoundException(__('Invalid dispositivo'));
		}
		$dispositivo = $this->Reproductor->read(null, $id);
		$dispositivo['Reproductor']['idEmpresa'] = "";
		if ($this->Reproductor->save($dispositivo)) {
			$lista = new ListaDispositivosController();
			$lista->constructClasses();
			
			$lista->ListaDispositivo->deleteAll("idDispositivo = '".$id."'");
			
			$this->Session->setFlash(__('El reproductor se ha eliminado con éxito.'),'info');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('El reproductor no se ha podido eliminar.'), 'error');
		CakeLog::write('debug','El reproductor con id '.$id.' no se ha eliminado.');
		$this->redirect(array('action' => 'index'));
	}
	
	
	/**
	 * Mensajes de retorno desde el dispositivo
	 */
	
	
/**
 * Función para enviar un mail avisando de que se quiere renovar dispositivo
 */

	public function renovarReproductor($idDispositivo = null){
		
		$this->LoadModel('Dispositivo');
		$options['fields'] = array('idDispositivo','descripcion','caducidad','empresa.nombre');
		$options['group'] = array("Dispositivo.idDispositivo");
		$options['conditions'] = array("Dispositivo.idDispositivo=".$idDispositivo );
		$options['joins'] = array(
				array('table' => 'empresa',
						'type' => 'LEFT',
						'conditions' => array(
								'Dispositivo.idEmpresa = empresa.idEmpresa',
						)
				)
		);
		$resultado = $this->Dispositivo->find("all", $options);
		$user = $this->Session->read('Auth');
		
		$mailData = array('idDispositivo'=> $resultado[0]['Dispositivo']['idDispositivo'], 
						'descripcion' => $resultado[0]['Dispositivo']['descripcion'], 
						'caducidad' => date('d-m-Y',strtotime($resultado[0]['Dispositivo']['caducidad'])),
						'nombre' => $resultado[0]['empresa']['nombre'], 
						'idUsuario' => $user['User']['id'] ,
						'username' => $user['User']['username'] );
			
		$email = new CakeEmail('default');
        $email->sender('admin@whadtv.com', 'WhadTV_ADM');
		$email->from(array('admin@whadtv.com' => 'WhadTV_ADM'));
		( defined( 'REGISTRO_MAIL' ) ) ?  $email->to( REGISTRO_MAIL )  : $email->to( "info@whadtv.com" );
		$email->subject('Renovación Reproductor');
		$email->emailFormat('html');
		$email->viewVars($mailData);
		$email->template('renovar_reproductor');
		try{
			$email->send();
			$this->Session->setFlash(__('Mensaje enviado con éxito, ¡en breve contactaremos contigo!'),'info');
		}catch(Exception $e){
			$this->Session->setFlash(__('Error al enviar mensaje, inténtalo de nuevo.'),'error');
			CakeLog::write("error", "Error al enviar CakeMail:".$e->getMessage());
		}
		$this->redirect($this->referer());
	}

	public function removeListasTerceros($idDispositivo = null){
		$this->loadModel('ListaDispositivo');
		$resultado = $this->ListaDispositivo->find('all',array('conditions'=> 'idDispositivo ='.$idDispositivo.' and tipo_relacion = "terceros"'));
		if ($resultado > 0) {
			foreach( $resultado as $listaDispositivo){
				$this->removelistaTerceros($listaDispositivo['ListaDispositivo']['id']);
			}
		}else{
			$this->Session->setFlash(__('El dispositivo no tiene listas de terceros.'));
		}
	}

	public function removeListaTerceros($id = null){
		$this->loadModel('ListaDispositivo');
		$this->ListaDispositivo->id = $id;
		if (!$this->ListaDispositivo->exists()) {
			throw new NotFoundException(__('Invalid ListaDispositivo'));
		}
		if ($this->ListaDispositivo->delete()){
			$this->Session->setFlash(__('Se ha desvinculado correctamente.'),'info');
		}else{
			$this->Session->setFlash(__('No se ha podido desvincular.'));
		}
	}

	public function crear(){
		//print_r($this->request->data);
		if ($this->request->is('post')) {
			$empresa = $this->Session->read("Empresa");
			$idEmpresa = $empresa['Empresa']['idEmpresa'];

			if( $idEmpresa != 0 ){
				$this->Reproductor->create();
				$this->request->data['Reproductor']['timestamp'] 		= DboSource::expression('NOW()');
				$this->request->data['Reproductor']['idDispositivo'] 	= md5(microtime());
				$this->request->data['Reproductor']['idEmpresa'] 		= $idEmpresa;
				$this->request->data['Reproductor']['idGoogle'] 		= 0;
				$this->request->data['Reproductor']['tipo'] 			= "web";
				$this->request->data['Reproductor']['timestampCreacion']= DboSource::expression('NOW()');
				$this->request->data['Reproductor']['caducidad']		
							= ( $empresa['Empresa']['demo_web'] == 1) 
							? DboSource::expression('NOW()')
							: DboSource::expression('DATE_ADD(NOW(), INTERVAL 15 DAY)');


				if ($this->Reproductor->save($this->request->data)) {
					$this->Session->setFlash(__('El dispositivo ha sido guardado.'),'info');
					$this->loadModel( 'Video' );
					$this->loadModel( 'ListaDispositivo');
					if( $this->Video->sinContenido( $idEmpresa ) || $this->ListaDispositivo->sinContenido( $idEmpresa ) ){
						$this->redirect(array('controller' => 'videos', 'action'=>'index'));
						return false;
					}
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash(__('El dispositivo no ha podido guardarse. Por favor, intentalo de nuevo.'),'error');
				}
			}
		}else{
			$empresaC = new EmpresasController();
			$empresaC->constructClasses();
			if( !$empresaC->demoWebPasada() ) $this->set( 'demo', false );
		}
	}

}