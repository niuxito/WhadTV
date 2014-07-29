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
	));
}
