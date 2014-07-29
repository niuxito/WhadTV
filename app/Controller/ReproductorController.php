<?php
App::uses('AppController', 'Controller');
App::import( 'Controller','Lista');
App::import( 'Controller','Dispositivos');
/**
 * Calendarios Controller
 *
 * @property Calendario $Calendario
 */
class ReproductorController extends AppController {
	
	public function index($tipo, $id){
		$this->set('id', $id);
		$this->set('tipo', $tipo);
		$this->render("index", "empty");
	}
	
	public function lista(){
		$id = $this->request->data['id'];
		//$this->Dispositivo->recursive = -1;
		$options['fields'] = array(
				'Listum.idLista','Listum.mute',
				'Listav.posicion','video.idVideo','video.mute');
		$options['conditions'] = array('Listum.idLista' => $id);
		$options['order'] =  array('Listum.idLista','Listav.posicion');
		$options['joins'] = array(
				array('table' => 'listaVideo',
						'alias' => 'Listav',
						'type' => 'LEFT',
						'conditions' => array(
								'Listav.idLista = Listum.idLista',
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
		$listaC = new ListaController();
		$listaC->constructClasses();
		$dispC = new DispositivosController();
		$dispC->constructClasses();
		$listaC->Listum->name = "Lista";
		$respuestaPre = $listaC->Listum->find("all", $options);
		//$respuestaPre = $this->Dispositivo->read(array('mute','caducidad','disco'), $id);
		//print_r($respuestaPre);
		if(count($respuestaPre) > 0){
				
			//$respuesta = $respuestaPre[0]['Dispositivo'];
			//$respuesta['caducidad'] = $this->construirCaducidad($respuesta['caducidad']);
			$respuesta['listas'] = $this->generarListasConVideos( $respuestaPre ) ;
			/*if($respuesta['mute'] > 0){
				$respuesta['mute'] = true;
			}else{
				$respuesta['mute'] = false;
			}*/
				
		
			return new CakeResponse( array( 'body' => json_encode( $respuesta) ) );
			//return new CakeResponse( array( 'body' => json_encode( "asdasfsdfgasafasdf")));
		}else{
			return new CakeResponse( array( 'body' => 'No se encuentra' ) );
		}
		}
	
	
	public function generarListasConVideos( $datos ){
		$salida = array();
		$Listum = array();
		$id = 0;
		//print_r($datos);
		foreach( $datos as $dato ){
			if($dato['Listum']['idLista'] == ""){
				$Listum = null;
			}else{
				if( $id != $dato['Listum']['idLista'] ){
					if( $id != 0 ){
						array_push( $salida, $Listum  );
					}
					$id = $dato['Listum']['idLista'];
					if($dato['Listum']['mute'] > 0){
						$dato['Listum']['mute'] = true;
					}else{
						$dato['Listum']['mute'] = false;
					}
						
					$Listum = $dato['Listum'];
						
						
					if($dato['video']['idVideo'] == ""){
						$Listum['videos'] = null;
					}else{
						if($dato['video']['mute'] > 0){
							$dato['video']['mute'] = true;
						}else{
							$dato['video']['mute'] = false;
						}
						$Listum['videos'] = array( $dato['video'] )  ;
					}
				}else{
					//print_r($Listum);
					if($dato['video']['idVideo'] != ""){
						if($dato['video']['mute'] > 0){
							$dato['video']['mute'] = true;
						}else{
							$dato['video']['mute'] = false;
						}
						@array_push($Listum['videos'], $dato['video'] );
					}
				}
			}
			//print_r($Listum);
		}
		array_push( $salida, $Listum  );
		//print_r($salida);
		return $Listum;
	}

	public function dispositivo () {
		$id = $this->request->data['id'];
		$this->redirect(array('controller'=>'Dispositivos', 'action'=>'actualizar', $id));

	}
	
}
