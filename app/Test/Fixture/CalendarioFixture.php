<?php
/* Calendario Fixture generated on: 2012-04-30 16:46:41 : 1335797201 */

/**
 * CalendarioFixture
 *
 */
class CalendarioFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'calendario';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'idCalendario' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'idCalendario', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'idCalendario' => 1,
			'idUsuario' => 1,
			'timestamp' => 1335797200
		),
	);
}
