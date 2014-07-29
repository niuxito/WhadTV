<?php
App::uses('AppModel', 'Model');
/**
 * Video Model
 *
 */
class Video extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'video';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'idVideo';


	public function sinContenido( $idEmpresa = null )
	{
		if( count( $this->cargarTodosVideos( $idEmpresa ) ) == 0 ) return true;
		return false;
	}
	

	public function cargarTodosVideos( $idEmpresa ){
		
		$options['fields'] = array('listaVideo.id','idVideo','listaVideo.posicion','descripcion','fotograma','url','name','mute','time', 'estado','count(distinct listaVideo.idLista) listas', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
		$options['group'] = array('Video.idVideo');
		
		$options['conditions'] = array("Video.idEmpresa = '".$idEmpresa."'");
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
		$videos = $this->find("all", $options);
		return $videos;
	}
}
