<?php
/* Video Fixture generated on: 2012-04-30 16:52:01 : 1335797521 */

/**
 * VideoFixture
 *
 */
class VideoFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'video';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'idVideo' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'descripcion' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'idVideo', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'idVideo' => 1,
			'idUsuario' => 1,
			'descripcion' => 'Lorem ipsum dolor sit amet',
			'timestamp' => 1335797521
		),
	);
}
