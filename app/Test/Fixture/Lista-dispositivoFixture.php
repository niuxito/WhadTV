<?php
/* Lista-dispositivo Fixture generated on: 2012-04-30 16:51:01 : 1335797461 */

/**
 * Lista-dispositivoFixture
 *
 */
class Lista-dispositivoFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'lista-dispositivo';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'idLista' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'idDispositivo' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => array('idLista', 'idDispositivo'), 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'idLista' => 1,
			'idDispositivo' => 1,
			'idUsuario' => 1,
			'timestamp' => 1335797461
		),
	);
}
