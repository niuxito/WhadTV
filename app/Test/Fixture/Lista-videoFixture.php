<?php
/* Lista-video Fixture generated on: 2012-04-30 16:51:22 : 1335797482 */

/**
 * Lista-videoFixture
 *
 */
class Lista-videoFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'lista-video';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'idLista' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'idVideo' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'posicion' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => array('idLista', 'idVideo'), 'unique' => 1)),
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
			'idVideo' => 1,
			'posicion' => 1,
			'idUsuario' => 1,
			'timestamp' => 1335797482
		),
	);
}
