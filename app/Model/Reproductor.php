<?php
App::uses('AppModel', 'Model');
/**
 * Dispositivo Model
 *
 */
class Reproductor extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'dispositivo';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'idDispositivo';
	
	public $hasMany = array(
		'ListaDispositivo' => array(
			'className' => 'ListaDispositivo',
			'foreignKey' => 'idDispositivo'
			
	));

	public function listaPorEmpresa( $idEmpresa, $oculto = false )
	{
		$options['conditions'] = array("idEmpresa = ".$idEmpresa);
		$options['fields'] = array('idDispositivo','descripcion','play','mute', 'caducidad', 'count(Listad.idLista) listas', 'now() ahora', 'version'); // Lista.idLista','Lista.Descripcion','Listad.activa', 'count(Listav.idVideo) videos');
		$options['conditions'] = ( $oculto ) 
			?  array( "Reproductor.idEmpresa = ".$idEmpresa ) 
			:  array( "Reproductor.idEmpresa = ".$idEmpresa." and visible = 1" ) ;
		$options['group'] = array("Reproductor.idDispositivo");
		$options['joins'] = array(
		    array('table' => 'listaDispositivo',
		        'alias' => 'Listad',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'Reproductor.idDispositivo = Listad.idDispositivo',
		            "Listad.tipo_relacion = 'basica'"
		        )
		    ),
		   
		);
    	$dispositivos = $this->find("all", $options);
    	return $dispositivos;
	}

	public function getReproductoresWeb( $idEmpresa = null )
	{
		//$options['conditions'] = array("tipo = 'web' and idEmpresa = ".$idEmpresa);
		$options['fields'] = array('idDispositivo','descripcion','play','mute', 'caducidad', 'count(Listad.idLista) listas', 'now() ahora'); // Lista.idLista','Lista.Descripcion','Listad.activa', 'count(Listav.idVideo) videos');
		$options['conditions'] = array( "Reproductor.tipo = 'web' and idEmpresa = ".$idEmpresa );
		$options['group'] = array("Reproductor.idDispositivo");
		$options['joins'] = array(
		    array('table' => 'listaDispositivo',
		        'alias' => 'Listad',
		        'type' => 'LEFT',
		        'conditions' => array(
		            'Reproductor.idDispositivo = Listad.idDispositivo',
		            "Listad.tipo_relacion = 'basica'"
		        )
		    ),
		   
		);
    	$dispositivos = $this->find("all", $options);
    	return $dispositivos;
	}

	public function incrementarUnMes(){
		$options['fields'] = array( 'caducidad' );
		$options['conditions'] = array( 'Reproductor.idDispositivo' => $this->id );

		$resultado = $this->find( 'all', $options );
		$fechaBase;
		$hoy 	= new DateTime( );
		$fecha 	= new DateTime( $resultado[0]['Reproductor']['caducidad'] );
		
		if( $fecha > $hoy ){
			$fechaBase = $fecha;
		}else{
			$fechaBase = $hoy;
		}
		$fechaBase->add( new DateInterval( 'P1M' ) );
		$data['Reproductor']['caducidad'] = $fechaBase->format( 'Y-m-d' );
		if( $this->save( $data ) ){
			CakeLog::write( 'debug', 'Se ha incrementado en un mes el reproductor '.$this->id );
		}
		
	}

	public function incrementarUnAnyo(){
		$options['fields'] = array( 'caducidad' );
		$options['conditions'] = array( 'Reproductor.idDispositivo' => $this->id );

		$resultado = $this->find( 'all', $options );
		$fechaBase;
		$hoy 	= new DateTime( );
		$fecha 	= new DateTime( $resultado[0]['Reproductor']['caducidad'] );
		
		if( $fecha > $hoy ){
			$fechaBase = $fecha;
		}else{
			$fechaBase = $hoy;
		}
		$fechaBase->add( new DateInterval( 'P1Y' ) );
		$data['Reproductor']['caducidad'] = $fechaBase->format( 'Y-m-d' );
		if( $this->save( $data ) ){
			CakeLog::write( 'debug', 'Se ha incrementado en un mes el reproductor '.$this->id );
		}
		
	}
}
