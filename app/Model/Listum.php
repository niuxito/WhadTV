<?php
App::uses('AppModel', 'Model');
/**
 * Listum Model
 *
 */
class Listum extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'idLista';
	
	public $hasMany = array(
		'ListaDispositivo' => array(
			'className' => 'ListaDispositivo',
			'foreignKey' => 'idLista'
		),
		'ListaVideo' => array(
			'className' => 'ListaVideo',
			'foreignKey' => 'idLista'
		)
	);



	public function getListasByEmpresa($empresa_id){
		$options = array(
			'conditions'=> array( 'idEmpresa'=>$empresa_id)
		);
		$this->recursive = 2;
		$listas = $this->find('all', $options);
		return $listas;
	}
}
