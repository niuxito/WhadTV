<?php
/* CalendarioVideo Fixture generated on: 2012-04-30 16:55:26 : 1335797726 */

/**
 * CalendarioVideoFixture
 *
 */
class CalendarioVideoFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'calendarioVideo';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'idCalendario' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'idVideo' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'fechaReproduccion' => array('type' => 'date', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => array('idCalendario', 'idVideo'), 'unique' => 1)),
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
			'idVideo' => 1,
			'fechaReproduccion' => '2012-04-30',
			'idUsuario' => 1,
			'timestamp' => 1335797726
		),
	);
}
