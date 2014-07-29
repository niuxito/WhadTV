<?php
App::uses('AppModel', 'Model');
/**
 * AgenciaUsuario Model
 *
 */
class Apk extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'apk';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';


	public function getLastURL()
	{
		$options = array(
			'conditions' => array( 'version = ( select max( version ) from apk where activa = 1 )' ),
			'fields' 	=> array( 'url' )
		);
		$resultado = $this->find('all', $options );

		if( count( $resultado ) > 0 ){
			return $resultado[0]['Apk']['url'];
		}else{
			return "";
		}

	}

	public function getURLVersion( $version )
	{

	}
}
