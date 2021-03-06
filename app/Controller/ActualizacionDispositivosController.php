<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Reproductors');
/**
 * ActualizacionDispositivos Controller
 *
 * @property ActualizacionDispositivo $ActualizacionDispositivo
 */
class ActualizacionDispositivosController extends AppController {

	public $components = array('DebugKit.Toolbar','RequestHandler', 'Auth');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->fields = array(
        'username' => 'username', 
        'password' => 'password'
        );
		$this->Auth->allow('getContenido');
		parent::testAuth();
		//CakeLog::write("debug", "Ha pasado el test");
		//$idEmpresa = $this->getIdEmpresa();

		
	
	}

	public function sendActualizar($idReproductor = null)
	{
		$valor = $this->add($idReproductor);
		if ($valor){
			$dispositivosC = new ReproductorsController();
			$dispositivosC->constructClasses();
			//$resultado = $dispositivosC->Dispositivo->read('idGoogle', $idReproductor);
			//CakeLog::write("debug", implode(",", $resultado['Dispositivo']));
			//$idGoogle = $resultado['Dispositivo']['idGoogle'];
			//( $idGoogle == "0" ) ?  $this->mandarMensaje($idReproductor, 'sendActualizar') : $dispositivosC->sendActualizar( $idReproductor );
			$dispositivosC->sendActualizar( $idReproductor );
			return new CakeResponse( array( 'body' => json_encode(array( 'resultado' => 'OK'))));
		}else{
			return new CakeResponse( array( 'body' => $valor) ) ;
		}
	}

	public function mandarMensaje($idReproductor,$mensaje){
		$ruta = WS_SERVER.$mensaje.'?dispositivo='.$idReproductor;
		file_get_contents($ruta);
	}

	public function getContenido($idReproductor = null){
		if (!is_null($idReproductor)){
			CakeLog::write("debug", $idReproductor);
			$contenido = $this->ActualizacionDispositivo->find('all',array('conditions' => "idReproductor ='".$idReproductor."' and situacion ='pendiente'"));
			CakeLog::write("debug", @implode("",$contenido));
			return new CakeResponse( array( 'body' => $contenido[0]['ActualizacionDispositivo']['contenido'] ) );
		}else{
			return new CakeResponse( array( 'body' => 'No se encuentra') ); 
		}
		
	}

	public function add($idReproductor = null)
	{
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		CakeLog::write("debug", "Guardando actualización");
		$user = $this->Session->read('Auth');
		$this->request->data['ActualizacionDispositivo']['idUsuario'] = $user['User']['id'];
		$this->request->data['ActualizacionDispositivo']['idReproductor'] = $idReproductor;
		$contenido = $dispositivoC->generarJSON($idReproductor);
		//$contenido = json_decode($contenido);

		$this->request->data['ActualizacionDispositivo']['contenido'] = $contenido;
		
		$this->request->data['ActualizacionDispositivo']['fsolicitud'] = DboSource::expression('NOW()');
		
		$resultados = $this->ActualizacionDispositivo->find('all', array('conditions' => "idReproductor = '".$idReproductor."' and situacion = 'pendiente'"));
			

		if ($this->ActualizacionDispositivo->save($this->request->data)) {
			if( !$contenido ){
				return json_encode(array('error' => 'No se ha generado el JSON'));
				//return new CakeResponse( array( 'body' => 'No se encuentra' ) );
			}else{
				if (count($resultados) > 0){
					foreach( $resultados as $resultado){
						$resultado['ActualizacionDispositivo']['situacion'] = 'caducado';
						if (!$this->ActualizacionDispositivo->save($resultado)){
							return json_encode(array('error' => 'No se ha actualizado el registro ActualizacionDispositivos/'.$resultado['ActualizacionDispositivo']['id']));
						}
					}
					//return true;
				}
				return true;
				//return new CakeResponse( array( 'body' =>  $contenido ) );
			}
		}
		return json_encode(array('error' => 'No se ha guardado el nuevo registro'));
		//return new CakeResponse( array( 'body' => 'No se encuentra' ) );
	}	

	public function actualizarRegistro($idReproductor = null, $estado, $info = null){
		$valor = $this->ActualizacionDispositivo->find('all',array('conditions'=>"idReproductor ='".$idReproductor."' and situacion ='pendiente'" ));
		if (count($valor) != 1){
			return false;
		}else{
			$valor[0]['ActualizacionDispositivo']['observaciones'] = $info;
			$valor[0]['ActualizacionDispositivo']['situacion'] = $estado;
			$valor[0]['ActualizacionDispositivo']['fentrega'] = DboSource::expression('NOW()');
			return $this->ActualizacionDispositivo->save($valor[0]);
		}

	}

	public function comprobarPendiente($idReproductor = null){
		$contador = $this->ActualizacionDispositivo->find('all',array('conditions'=>"idReproductor ='".$idReproductor."' and situacion ='pendiente'"));
		if ( count($contador) > 0 ){
			return true;
		}else{
			return false;
		}
	}

}
