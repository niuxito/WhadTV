<?php
App::uses('AppController', 'Controller');
App::import( 'Controller','ListaDispositivos');
App::import( 'Controller','Videos');
App::import( 'Controller','ActualizacionDispositivos');
/**
 * Dispositivos Controller
 *
 * @property Dispositivo $Dispositivo
 */
class DispositivosController extends AppController {
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Session', 'Auth');
	

	
	function beforeFilter(){
		parent::beforeFilter();
		CakeLog::write("debug", "Ha pasado el filtro inicial");
		$this->Auth->fields = array(
        'username' => 'username', 
        'password' => 'password'
        );
		$this->Auth->allow('actualizar');
		$this->Auth->allow('sendActualizar');
		$this->Auth->allow('logo');
		$this->Auth->allow('video');
		$this->Auth->allow('alta');
		$this->Auth->allow('infoUpdate');
		$this->Auth->allow('infoUpdateFin');
		$this->Auth->allow('infoVideo');
		$this->Auth->allow('infoVideoReproduccion');
		parent::testAuth();
		CakeLog::write("debug", "Ha pasado el test");
		//$idEmpresa = $this->getIdEmpresa();

		
	
	}
	
/**
 * index method
 *
 * @return void
 */
	
	public function asignar(){
		$user = $this->Session->read("Auth");
		if($this->request->is("POST")){
			$id = $this->request->data['Dispositivo']['id'];
			$this->Dispositivo->id = $id;
			if ($this->Dispositivo->exists()) {
				$resultado =$this->Dispositivo->find("all", array("fields"=>array("idEmpresa","descripcion"), "conditions"=>array("idDispositivo = '".$id."'")));
				if($resultado[0]['Dispositivo']['idEmpresa'] == 0){
					$empresa = $this->Session->read("Empresa");
					$idEmpresa = $empresa['Empresa']['idEmpresa'];
					$data['Dispositivo']['id'] = $id;
					$data['Dispositivo']['idEmpresa'] = $idEmpresa;
					$data['Dispositivo']['descripcion'] = $this->request->data['Dispositivo']['descripcion'];
					$this->Dispositivo->save($data);
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
					if($idEmpresa == $resultado[0]['Dispositivo']['idEmpresa']){
						$this->Session->setFlash("El reproductor ".$id.' ya está dado de alta con el nombre <h1>'.$resultado[0]['Dispositivo']['descripcion'].'</h1>','info');	
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
	
	public function sendActualizar($id, $response = true){
		$opcion = "ACTUALIZAR";
		$gId = $this->getGoogleIdFromId($id);
		$resultado = $this->push($opcion, $gId);
		CakeLog::write("debug", $resultado);
		$this->logPush(array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado);
		if($response){
			return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
		}
	}
	public function sendDetener($id, $response = true){
		$opcion = "DETENER";
		$this->Dispositivo->id = $id;
		$data['Dispositivo']['id'] = $id;
		$data['Dispositivo']['play'] = "0";
		$this->Dispositivo->save($data);
		$gId = $this->getGoogleIdFromId($id);
		$resultado = $this->push("$opcion", $gId);
		$this->logPush(array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado);
		return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
	}
	public function sendReproducir($id){
		$opcion = "REPRODUCIR";
		$this->Dispositivo->id = $id;
		$data['Dispositivo']['id'] = $id;
		$data['Dispositivo']['play'] = "1";
		$this->Dispositivo->save($data);
		$gId = $this->getGoogleIdFromId($id);
		$resultado = $this->push($opcion, $gId);
		
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
	
	public function sendFlush($id, $response = true){
		$opcion = "FLUSH";
		$gId = $this->getGoogleIdFromId($id);
		$resultado = $this->push($opcion, $gId);
		$this->logPush(array( 'gId' => $gId, 'id' => $id, 'opcion' => $opcion ), $resultado);
		$this->sendActualizar($id, false);
		if($response){
			return new CakeResponse( array( 'body' => json_encode( $resultado) ) );
		}
	}
	
	
	public function sendLogo($eId){
		$dispositivos = $this->Dispositivo->find("all", array("conditions" => "idEmpresa = ".$eId));
		CakeLog::write('Dispositivos', "LOGO: Se van a enviar ".count( $dispositivos )." mensajes a los dispositivos de la empresa ".$eId);
		foreach( $dispositivos as $dispositivo){
			
			$id = $dispositivo['Dispositivo']['idDispositivo'];
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
		$options[ 'conditions' ]   = array( "idDispositivo = '".$id."'", 'tipo'=>'android' ); 
		$resultado = $this->Dispositivo->find("all", $options); // "Select idEmpresa from empresa as Empresa where idEmpresa = '".$id."'" );
		if( count( $resultado ) > 0){
			$idGoogle = $resultado[0]['Dispositivo']['idGoogle'];
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

	public function generarJSON($id){
			
			$this->Dispositivo->recursive = -1;
			$options['fields'] = array('idDispositivo','mute', 'caducidad', 'disco','play', 'alto', 'ancho', 'orientacion', 'tipo',
										'Lista.idLista','Lista.mute','Listad.activa','Listav.posicion',
										'video.idVideo','video.mute', 'video.name', 'video.time', 'video.tipo', 'video.url');
			$options['conditions'] = array('Dispositivo.idDispositivo' => $id);
			$options['order'] =  array('Lista.idLista','Listav.posicion');
			$options['joins'] = array(
			    array('table' => 'listaDispositivo',
			        'alias' => 'Listad',
			        'type' => 'LEFT',
			        'conditions' => array(
			            'Dispositivo.idDispositivo = Listad.idDispositivo',
			            "Listad.tipo_relacion = 'basica'"
			        )
			    ),
			    array('table' => 'lista',
			        'alias' => 'Lista',
			        'type' => 'LEFT',
			        'conditions' => array(
			            'Listad.idLista = Lista.idLista',
			        )
			    ),
			    array('table' => 'listaVideo',
			        'alias' => 'Listav',
			        'type' => 'LEFT',
			        'conditions' => array(
			            'Listav.idLista = Lista.idLista',
			        )
			    ),
			    array('table' => 'video',
			        'alias' => 'video',
			        'type' => 'LEFT',
			        'conditions' => array(
			            'video.idVideo = Listav.idVideo',
			        )
			        
			    )
			);
			CakeLog::write("Dispositivos", $options);
	    	$respuestaPre = $this->Dispositivo->find("all", $options);
	    	//var_dump($respuestaPre);
			if(count($respuestaPre) > 0){
				
				$respuesta = $respuestaPre[0]['Dispositivo'];
				$respuesta['caducidad'] = $this->construirCaducidad($respuesta['caducidad']);
				if($respuestaPre[0]['Dispositivo']['play'] < 2){
					$respuesta['listas'] = $this->generarListasConVideos( $respuestaPre ) ;
					( is_null( $respuesta['listas'] ) ) ? $respuesta['listas'] = array() : false;
				}else{

					/*
					 *Se ejecuta un reset del dispositivo
					 */
					
					CakeLog::write("Dispositivos", "Reseteando dispositivo");
					$this->Dispositivo->id = $id;
					if (!$this->Dispositivo->exists()) {
						throw new NotFoundException(__('Invalid dispositivo'));
					}
					$data = "";
					if($respuestaPre[0]['Dispositivo']['play'] == 2){
						$data['Dispositivo']['play'] = 3;
						$respuesta['listas'] = array() ;
						$this->sendActualizar($id, false);
					}else{
						$this->sendFlush($id, false);
						$data['Dispositivo']['play'] = 0;
						$respuesta['listas'] = $this->generarListasConVideos( $respuestaPre ) ;
						( is_null( $respuesta['listas'] ) ) ? $respuesta['listas'] = array() : false;
					}
					if($this->Dispositivo->save($data)) {
						
					}
				}
				if($respuesta['mute'] > 0){
					$respuesta['mute'] = true;
				}else{
					$respuesta['mute'] = false;
				}
				return json_encode( $respuesta );
			}else{
				return false ;
			}
	
	}
	
	public function actualizar($id = null){
		$respuesta = $this->generarJSON($id);
		if( !$respuesta ){
			return new CakeResponse( array( 'body' => 'No se encuentra' ) );
		}else{
			return new CakeResponse( array( 'body' =>  $respuesta ) );
		}

	}

	public function construirCaducidad($fecha){
		$fecha = strtotime($fecha);
		CakeLog::write("Dispositivos", "La fecha actual es:".$fecha);
		//return		"".($fecha-time());
		return		"".($fecha);
	}
	public function generarListasConVideos( $datos ){
		$salida = array();
		$lista = array();
		$id = 0;
		//print_r($datos);
		foreach( $datos as $dato ){
			if($dato['Lista']['idLista'] == ""){
				$lista = null;
			}else{
				if( $id != $dato['Lista']['idLista'] ){
					if( $id != 0 ){ 
						array_push( $salida, $lista  );
					}
					$id = $dato['Lista']['idLista'];
					if($dato['Listad']['activa'] > 0){
						$dato['Lista']['activa'] = true;
					}else{
						$dato['Lista']['activa'] = false;
					}
					if($dato['Lista']['mute'] > 0){
						$dato['Lista']['mute'] = true;
					}else{
						$dato['Lista']['mute'] = false;
					}
					
					$lista = $dato['Lista'];
					
					
					if($dato['video']['idVideo'] == ""){
						$lista['videos'] = null;
					}else{
						if($dato['video']['mute'] > 0){
							$dato['video']['mute'] = true;
						}else{
							$dato['video']['mute'] = false;
						}

						$dato['video']['url'] = $this->obtenerURL( 
							$dato['video']['url'], 
							$dato['Dispositivo']['orientacion'],
							$dato['Dispositivo']['ancho'].'x'.$dato['Dispositivo']['alto'],
							$dato['video']['time'],
							$dato['Dispositivo']['tipo'],
							$dato['video']['tipo']
						);

						$lista['videos'] = array( $dato['video'] )  ; 
					}
				}else{
					//print_r($lista);
					if($dato['video']['idVideo'] != ""){
						if($dato['video']['mute'] > 0){
							$dato['video']['mute'] = true;
						}else{
							$dato['video']['mute'] = false;
						}

						$dato['video']['url'] = $this->obtenerURL( 
							$dato['video']['url'], 
							$dato['Dispositivo']['orientacion'],
							$dato['Dispositivo']['ancho'].'x'.$dato['Dispositivo']['alto'],
							$dato['video']['time'],
							$dato['Dispositivo']['tipo'],
							$dato['video']['tipo']
						);

						( !is_null( $dato['video']['url'] ) ) ? @array_push($lista['videos'], $dato['video'] ) : false; 
					}	
				}
			}
			//print_r($lista);
		}
		array_push( $salida, $lista  );
		//print_r($salida);
		return $salida;
	}
	
	public function obtenerURL( $data, $orientacion, $medidas, $tiempo, $tipoDispositivo, $tipoContenido )
	{
		$contenido = json_decode( $data, true );
		if($tipoContenido == 'imagen'){
			$url = $contenido['imgs'][$orientacion]['720p'];
		}else{
			$url = @$contenido[$tiempo][$orientacion][$medidas]['mp4'];
			if( is_null( $url ) ){
				$url = $contenido[$tiempo][$orientacion]['720x1080']['mp4'];
			}
		}
		return $url;

	}
	public function logo($id){
		$resultado = $this->Dispositivo->query("Select idEmpresa, url from empresa as Empresa where idEmpresa = ".$id);
		if( count( $resultado ) > 0){
			$posicionNombre = strrpos($resultado[0]['Empresa']['url'], '/',-1);
			$nombreEnServidor = substr($resultado[0]['Empresa']['url'], $posicionNombre +1 );
			$url = substr($resultado[0]['Empresa']['url'],0, $posicionNombre );
			$posicionNombre = strrpos($resultado[0]['Empresa']['url'], '.',-1);
			$extension = substr($resultado[0]['Empresa']['url'], $posicionNombre +1 );
			
			
			$this->viewClass = 'Media';
	        // Download app/outside_webroot_dir/example.zip
	        $params = array(
	            'id'        => $nombreEnServidor,
	            'name'      => $resultado[0]['Empresa']['idEmpresa'],
	            'download'  => true,
	            'extension' => $extension,
	            'path'      => 'img/'.$url.'/'
	        );
	        $this->set($params);
		}else{
			return new CakeResponse( array( 'body' => 'No se encuentra' ) );
		}
		
	}
	
	public function video($id) {
		/*
		 * 
		 *Buscar el video con sus dimensiones al final, si este no existe entregar el original
		 */
		$resultado = $this->Dispositivo->query("Select idVideo, descripcion, url from video as Video where idVideo = ".$id);
		if( count( $resultado ) > 0){
			$posicionNombre = strrpos($resultado[0]['Video']['url'], '/',-1);
			$nombreEnServidor = substr($resultado[0]['Video']['url'], $posicionNombre +1 );
			$url = substr($resultado[0]['Video']['url'],0, $posicionNombre );
			$posicionNombre = strrpos($resultado[0]['Video']['url'], '.',-1);
			$extension = substr($resultado[0]['Video']['url'], $posicionNombre +1 );
			
			
			$this->viewClass = 'Media';
	        // Download app/outside_webroot_dir/example.zip
	        $params = array(
	            'id'        => $nombreEnServidor.'.webm',
	            'name'      => $resultado[0]['Video']['idVideo'],
	            'download'  => true,
	            'extension' => $extension,
	            'path'      => ''.$url.'/'
	        );
	        $this->set($params);
		}else{
			return new CakeResponse( array( 'body' => 'No se encuentra' ) );
		}
        
    }
    
    public function videoOk($idDispositivo, $idVideo){
    	CakeLog::write("Dispositivos", "El video ".$idVideo." se ha enviado correctamente a ".$idDispositivo);
    	//Logear la correcta llegada del video al dispositivo.
    }
    
    public function alta( $id = null ,$id_google = "" ,$ancho = null, $alto = null, $version = null ){
    	CakeLog::write("debug", "Alta ");
    	if( is_null( $id ) || is_null( $ancho ) || is_null( $alto ) ){
    		CakeLog::write( "debug", "Faltan parametros..." );
    		CakeLog::write( "debug", "ID: "		.$id );
    		CakeLog::write( "debug", "Alto: "	.$alto );
    		CakeLog::write( "debug", "Ancho: "	.$ancho );

    		return new CakeResponse( array( 'body' => json_encode( array( 'errorCode' => '0001', 'errorText' => 'Faltan Parametros' ) ) ) );
    	}
    	//Buscar si id está en la base de datos
    	$this->Dispositivo->id = $id;
    	if (!$this->Dispositivo->exists()) {
			//Si no está crear el registro y generar log
			$array = array( 
				'idDispositivo' 	=> $id,
				'idGoogle' 			=> $id_google,
				'ancho' 			=> $ancho,
				'alto' 				=> $alto,
				'timestampCreacion' => DboSource::expression('NOW()'),
				'tipo' 				=> ( $id_google == 0 ) ? 'x86' :'android'
			);
			( !is_null( $version ) ) ? $array['version'] = $version : false;
			
			$this->Dispositivo->create();
			if ($this->Dispositivo->save($array)) {
				CakeLog::write("Dispositivos", "Alta del dispositivo ".$array['idDispositivo'].
				" con idGoogle ( PUSH ): ".$array['idGoogle']." y unas medidas de ".
				$array['alto']."x".$array['ancho']);
				CakeLog::write("Dispositivos", "Se ha activado el dispositivo ".$id);
				return new CakeResponse( array( 'body' => json_encode( array( 'status' => 0, 'msg' => 'Nuevo dispositivo' ) ) ) );
				
			}
			CakeLog::write("Dispositivos", "ERROR: No se ha dado de alta el dispositivo ".$array['idDispositivo'].
				" con idGoogle ( PUSH ): ".$array['id_google']." y unas medidas de ".
				$array['alto']."x".$array['ancho']);
			return new CakeResponse( array( 'body' => json_encode( array('errorCode' => '0002', 'errorText' => 'No se ha guardado') ) ) ) ;
		}else{
			$array = array(
				'idDispositivo' => $id,
				'idGoogle' 		=> $id_google,
				'ancho' 		=> $ancho,
				'alto' 			=> $alto,
				'timestamp' 	=> DboSource::expression('NOW()')

			);
			( !is_null( $version ) ) ? $array['version'] = $version : false;

			if ($this->Dispositivo->save($array)) {
				CakeLog::write("Dispositivos", "Actualizacion del dispositivo ".$array['idDispositivo'].
				" version: ".$version." con idGoogle ( PUSH ): ".$array['idGoogle']." y unas medidas de ".
				$array['alto']."x".$array['ancho']);
				CakeLog::write("Dispositivos", "Se ha activado el dispositivo ".$id);
				return new CakeResponse( array( 'body' => json_encode( array( 'status' => 1, 'msg' => 'Dispositivo activado' ) ) ) );
			}
				CakeLog::write("Dispositivos", "ERROR: No se ha dado de alta el dispositivo ".$array['idDispositivo'].
				" con idGoogle ( PUSH ): ".$array['id_google']." y unas medidas de ".
				$array['alto']."x".$array['ancho']);
				return new CakeResponse( array( 'body' => json_encode( array('errorCode' => '0002', 'errorText' => 'No se ha guardado') ) ) );
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
		
			$idEmpresa = $this->getIdEmpresa();
			$this->loadModel('Listum');
			$optionsL['fields'] = array('listaDispositivo.activa', 'Listum.idLista', 'listaDispositivo.idDispositivo', 'Listum.descripcion', 'listaDispositivo.id','Listum.mute','count(distinct listaVideo.id) videos');
			$optionsL['conditions'] = array("idEmpresa = ".$idEmpresa, 'listaDispositivo.idDispositivo'=>$id);
			$optionsL['group'] = array('listaDispositivo.id');
			$optionsL['joins'] = array(
						
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
					)
					
			);
			$listas = $this->Listum->find("all", $optionsL);
			$this->set('listas', $listas);
		

		$this->Dispositivo->id = $id;
		if (!$this->Dispositivo->exists()) {
			throw new NotFoundException(__('Invalid dispositivo'));
		}
		$this->set('dispositivo', $this->Dispositivo->read(null, $id));
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
			$this->Dispositivo->create();
			$this->request->data['Dispositivo']['timestamp'] = DboSource::expression('NOW()');
			if ($this->Dispositivo->save($this->request->data)) {
				$this->Session->setFlash(__('El dispositivo ha sido guardado.'));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('El dispositivo no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		}
	}


	
/**
 * mute method
 * 
 * @return void
 */	
	public function mute(){
			$this->Dispositivo->id = $this->request->data['id'];
			$this->request->data['Dispositivo']['mute'] = $this->request->data['mute'];
			if ($this->Dispositivo->save($this->request->data)) {
				$this->Session->setFlash(__('La lista ha sido guardada.'));
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
		$this->Dispositivo->id = $id;
		if (!$this->Dispositivo->exists()) {
			throw new NotFoundException(__('Invalid dispositivo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Dispositivo->save($this->request->data)) {
				$this->Session->setFlash(__('El dispositivo ha sido guardado.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El dispositivo no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		} else {
			$this->request->data = $this->Dispositivo->read(null, $id);
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
		$this->Dispositivo->id = $id;
		if (!$this->Dispositivo->exists()) {
			throw new NotFoundException(__('Invalid dispositivo'));
		}
		$dispositivo = $this->Dispositivo->read(null, $id);
		$dispositivo['Dispositivo']['idEmpresa'] = "";
		if ($this->Dispositivo->save($dispositivo)) {
			$lista = new ListaDispositivosController();
			$lista->constructClasses();
			
			$lista->ListaDispositivo->deleteAll("idDispositivo = '".$id."'");
			
			$this->Session->setFlash(__('El reproductor se ha eliminado con éxito.'),'info');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('El reproductor no se ha podido eliminar.'));
		CakeLog::write('debug','El reproductor con id '.$id.' no se ha eliminado.');
		$this->redirect(array('action' => 'index'));
	}
	

	public function reset($id = null){
		$this->sendDetener($id, false);
		$this->Dispositivo->id = $id;
		if (!$this->Dispositivo->exists()) {
			throw new NotFoundException(__('Invalid dispositivo'));
		}
		$datos['Dispositivo']['play'] = 2;
		if ($this->Dispositivo->save($datos)) {
			//CakeLog::write("Dispositivos", "UPDATE: El dispositivo ( ".$id." ) ha reportado ".$estado);
			//$this->sendDetener($id);
			$this->sendActualizar($id);
		}
		return new CakeResponse( array( 'body' => json_encode( "") ) );
		//$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
	}


	

	
/**
 * Mensajes de retorno desde el dispositivo
 */
	
	public function infoUpdate($id, $estado, $info=null){
		$actualizacionDispositivoC = new ActualizacionDispositivosController();
		$actualizacionDispositivoC->constructClasses();
		if(is_null($info)){
			CakeLog::write("Dispositivos", "UPDATE: El dispositivo ( ".$id." ) ha reportado ".$estado);
			$resultado = $actualizacionDispositivoC->actualizarRegistro($id,"ok","");
		}else{
			CakeLog::write("Dispositivos", "UPDATE: ERROR: El dispositivo ( ".$id." ) ha reportado ".$estado." con la siguiente información:");
			CakeLog::write("Dispositivos", "UPDATE: ERROR: ".$info);
			$resultado = $actualizacionDispositivoC->actualizarRegistro($id,"error",$info);
		}
		(!$resultado) ? CakeLog::write("error", "La tabla actualizacionDispositivos no se ha actualizado") : false;
		return new CakeResponse( array( 'body' => $estado ) );
	}

	public function infoUpdateFin($id, $estado, $info=null){
		if(is_null($info)){
			CakeLog::write("Dispositivos", "UPDATEFIN: El dispositivo ( ".$id." ) ha reportado ".$estado);
		}else{
			CakeLog::write("Dispositivos", "UPDATEFIN: ERROR: El dispositivo ( ".$id." ) ha reportado ".$estado." con la siguiente información:");
			CakeLog::write("Dispositivos", "UPDATEFIN: ERROR: ".$info);
		}
		return new CakeResponse( array( 'body' => $estado ) );
	}
	
	public function infoVideo($id, $idVideo, $estado, $info=null){
		if($estado == "OK"){
			CakeLog::write("Dispositivos", "VIDEO: El dispositivo ( ".$id." ) ha reportado ".$estado." al obtener el video ( ".$idVideo." ) con la siguiente información:");
			CakeLog::write("Dispositivos", "VIDEO: ".$info);
		}else{
			CakeLog::write("Dispositivos", "VIDEO: ERROR: El dispositivo (  ".$id." ) ha reportado ".$estado." al obtener el video ( ".$idVideo." ) con la siguiente información:");
			CakeLog::write("Dispositivos", "VIDEO: ERROR: ".$info);
		}
		return new CakeResponse( array( 'body' => $estado ) );
		
	}
	
	public function infoVideoReproduccion($id, $idVideo, $estado, $info=null){
		if(is_null($info)){
			CakeLog::write("Dispositivos", "REPRODUCCION: El dispositivo ( ".$id." ) ha reportado ".$estado." al reproducir el video ( ".$idVideo." )");
			if( $estado == "CORRECTO"){
				/*
				 * Actualizar el contador del video añadiendo el nº de veces que 
				 * está contenido en info y en su defecto actualizar en uno.
				 */
			}
		
		}else{
			CakeLog::write("Dispositivos", "REPRODUCCION: ERROR: El dispositivo (  ".$id." ) ha reportado ".$estado." al reproducir el video ( ".$idVideo." ) con la siguiente información:");
			CakeLog::write("Dispositivos", "REPRODUCCION: ERROR: ".$info);
		}
		return new CakeResponse( array( 'body' => $estado ) );
	}
	
	
}
