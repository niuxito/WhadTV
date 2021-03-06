<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'ListaDispositivos');
/**
 * Programacions Controller
 *
 * @property Programacion $Programacion
 */
class ProgramacionsController extends AppController {
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Auth');
	public $tocken = "a";



	function beforeFilter(){
		parent::beforeFilter();
		
		$this->Auth->fields = array(
        'username' => 'username', 
        'password' => 'password'
        );
		$this->Auth->allow('lanzarCambios');
		parent::testAuth();
		CakeLog::write("debug", "Ha pasado el test");
		//$idEmpresa = $this->getIdEmpresa();

		
	
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
	}



	public function add(){
		if ( $this->request->is( 'post' ) ){
			$auth 		= $this->Session->read(	'Auth' );
			$idUsuario 	= $auth[ 'User' ][ 'id' ];
			
			$this->request->data[ 'Programacion' ][ 'idUsuario' ] 			= $idUsuario;
			$this->request->data[ 'Programacion' ][ 'idListaDispositivo' ] 	= $this->request->data['idListaDispositivo'];
			$this->request->data[ 'Programacion' ][ 'hora' ] = 0;
			$this->request->data[ 'Programacion' ][ 'minuto' ] = 5;
			if( $this->Programacion->save( $this->request->data ) ) {
				$id = $this->Programacion->getInsertID();
				$resultado = $this->Programacion->read(null, $id);
				$this->set('programa', $resultado);
				$this->render('/Elements/programa', 'popup');
				//return new CakeResponse( array( 'body' => json_encode( $resultado ) ) );
			}else{
				$resultado[ 'saved' ] = false;
				return new CakeResponse( array( 'body' => json_encode( $resultado ) ) );
			}

		}else{
			return new CakeResponse( array( 'body' => 'null' ) );
		}
	}

	public function delete(){
		if ( $this->request->is( 'post' ) ){

			$this->Programacion->id = $this->request->data['id'];
			if (!$this->Programacion->exists()) {
				throw new NotFoundException(__('Invalid programa'));
			}
		
			if ($this->Programacion->delete()) {
				$resultado[ 'saved' ] 	= true;
				$resultado[ 'id' ]		= $this->request->data['id']; 
				return new CakeResponse( array( 'body' => json_encode( $resultado ) ) );
			}else{
				$resultado[ 'saved' ] = false;
				return new CakeResponse( array( 'body' => json_encode( $resultado ) ) );
			}

		}else{
			$this->redirect( array( 'controller'=>'Videos', 'action'=>'index' ) );
		}	

	}
	

	public function edit(){
		if ( $this->request->is( 'post' ) ){
			$this->Programacion->id = $this->request->data[ 'Programacion' ][ 'id' ];

			
			$auth 		= $this->Session->read(	'Auth' );
			$idUsuario 	= $auth[ 'User' ][ 'id' ];
			
			$this->request->data[ 'User' ][ 'idUsuario' ] = $idUsuario;
			if( $this->Programacion->save( $this->request->data ) ) {
				$resultado[ 'saved' ] = true;
				$resultado[ 'fecha' ] = $this->request->data[ 'Programacion' ][ 'fecha' ];
				return new CakeResponse( array( 'body' => json_encode( $resultado ) ) );
			}else{
				$resultado[ 'saved' ] = false;
				return new CakeResponse( array( 'body' => json_encode( $resultado ) ) );
			}

		}else{
			$this->redirect( array( 'controller'=>'Videos', 'action'=>'index' ) );
		}	
	}

	public function listarProgramas($idListaDispositivo){
		$options['conditions'] = array('idListaDispositivo = '.$idListaDispositivo);
		$options['order'] = array('fecha, hora, minuto');
		$response = $this->Programacion->find('all', $options);
		$this->set('programaciones', $response);
		$this->set('idListaDispositivo', $idListaDispositivo);
	}



	/*
	 * Proceso que se ejecuta desde Cron para realizar los cambios programados.
	 */

	public function lanzarCambios($tocken){
		$listaDispC = new ListaDispositivosController();
		$listaDispC->constructClasses();
		$modificados = 0;
		if($tocken == $this->tocken){
			$tiempo = $this->getTimeArray();
			//$options= array();
			$options['conditions'] = array("fecha = '".$tiempo['fecha']."' and hora = ".$tiempo['hora']." and minuto between ".$tiempo['minuto']." and ".($tiempo['minuto']+4));
			$options['order'] = array('fecha, hora, minuto');
			$eventos = $this->Programacion->find('all', $options);
			foreach($eventos as $evento){
				$listaDispC->ListaDispositivo->id = $evento['Programacion']['idListaDispositivo'];
				$data['ListaDispositivo']['activa'] = $evento['Programacion']['estado'];
				if($listaDispC->ListaDispositivo->save($data)){
					$listaDispC->updateDispositivo($evento['Programacion']['idListaDispositivo']);
					$modificados++;

				}
			}
			
			return new CakeResponse( array( 'body' =>  'fecha: '.$tiempo['fecha']. ' hora: '.$tiempo['hora'].' minuto: '.$tiempo['minuto'].'</br>'.
											'Se han modificado '.$modificados.' listas y se han actualizado los reproductores asociados.' ) );
		}else{
			return new CakeResponse( array( 'body' => 'validación erronea:'.date('Y-m-d') ) );
		}


	}


	public function getTimeArray(){
		date_default_timezone_set('Europe/Madrid');
		$partes['fecha'] = date('Y-m-d');
		$partes['hora'] = date('H');
		$partes['minuto'] = date('i');
		return $partes;
	}

	
}
