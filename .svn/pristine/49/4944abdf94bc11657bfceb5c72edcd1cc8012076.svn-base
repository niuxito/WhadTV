<?php
App::uses('AppModel', 'Model');
/**
 * Dispositivo Model
 *
 */
class Dispositivo extends AppModel {
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
}
