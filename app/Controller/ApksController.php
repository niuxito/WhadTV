<?php
App::uses('AppController', 'Controller');

/**
 * Dispositivos Controller
 *
 * @property Dispositivo $Dispositivo
 */
class ApksController extends AppController {
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Session', 'Auth');
	

	function beforeFilter(){
		parent::beforeFilter();
		CakeLog::write("debug", "Ha pasado el filtro inicial");
		$this->Auth->fields = array(
        'username' => 'username', 
        'password' => 'password'
        );
		$this->Auth->allow('index');
		parent::testAuth();
		//CakeLog::write("debug", "Ha pasado el test");
		//$idEmpresa = $this->getIdEmpresa();

		
	
	}


	public function index( $version = null ) 
	{
		/*
		 *
		*Buscar la version de la Apk, si este no existe entregar la ultima versión
		*/

		if( is_null( $version ) ){
			$filename = $this->Apk->getLastURL();
		}else{
			$filename = $this->Apk->getURLVersion( $version );
		}

		if( $filename != "" ){
			$filename = 'webroot/img/files/apks/'.$filename;
			$this->response->type('application/apk');
			$this->response->file($filename	, array('download' => true, 'name' => 'WhadTV-Player.apk'));
			return $this->response;
		}else{
			return new CakeResponse( array( 'body' => 'No se encuentra' ) );
		}
	
	}


	public function newVersion()
	{

		if ($this->request->is('post')) {
			$file = $this->request->data['Apk']['apk'];
			$this->request->data['Apk']['timestamp'] = 	DboSource::expression('NOW()');
			$this->request->data['Apk']['activa'] 	 = 0;
			$this->request->data['Apk']['descargas'] = 0;

			CakeLog::write("debug", "Intento de publicación:");
			CakeLog::write("debug", "Apk con nombre ".$file['name']." de ".$file['size']." bytes.");
			move_uploaded_file( $file['tmp_name'], 'img/files/apks/'.$file['name'] );
			$this->request->data['Apk']['url'] = $file['name'];
			if(  $this->Apk->save( $this->request->data ) ){
				return new CakeResponse( array( 'body' => 'Guardado correctamente' ) );
			}
			
					
		
		}else{
			return new CakeResponse( array( 'body' => 'Formato erroneo' ) );
		}
	}

	public function changeStateApk( $idApk )
	{
		if( !is_null( $idApk ) ){
			$this->Apk->id = $idApk;
			$resultado = $this->Apk->read( 'activa', $idApk );
			$resultado['Apk']['activa'] = ( $resultado['Apk']['activa'] - 1 ) * -1;
			$this->Apk->save( $resultado );
			$this->Session->setFlash( "Se ha cambiado el estado.", 'info' );
		}else{
			$this->Session->setFlash( "No se han pasado los parametros.", 'error' );
		}
			$this->redirect(array('controller' => 'adm', 'action' => 'listadoApks' ) ); 

	}

	public function lista()
	{
	}

}

?>