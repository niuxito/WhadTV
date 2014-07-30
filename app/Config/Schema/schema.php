<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $calendario = array(
		'idCalendario' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => null),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'idCalendario', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $calendarioVideo = array(
		'idCalendario' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'idVideo' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'fechaReproduccion' => array('type' => 'date', 'null' => false, 'default' => null),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => null),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('idCalendario', 'idVideo'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $compra = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'key' => 'primary'),
		'dir_factura' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fecha' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $configuracion = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'Nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'Valor' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $consejo = array(
		'idConsejo' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6, 'key' => 'primary'),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'descripcion' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'page' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'idAsunto' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'indexes' => array(
			'PRIMARY' => array('column' => 'idConsejo', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $dispositivo = array(
		'idDispositivo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'idCalendario' => array('type' => 'integer', 'null' => false, 'default' => null),
		'idEmpresa' => array('type' => 'integer', 'null' => false, 'default' => null),
		'descripcion' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'latitud' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'longitud' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'idGoogle' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mute' => array('type' => 'integer', 'null' => false, 'default' => null),
		'caducidad' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'disco' => array('type' => 'integer', 'null' => false, 'default' => null),
		'alto' => array('type' => 'integer', 'null' => false, 'default' => null),
		'ancho' => array('type' => 'integer', 'null' => false, 'default' => null),
		'play' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'idDispositivo', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $empresa = array(
		'idEmpresa' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'Nombre' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'idEmpresa', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $empresaUsuario = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'idEmpresa' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'perfil' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'activo' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'idEmpresa' => array('column' => 'idEmpresa', 'unique' => 0),
			'Usuario' => array('column' => 'idUsuario', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $lista = array(
		'idLista' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'descripcion' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'idEmpresa' => array('type' => 'integer', 'null' => false, 'default' => null),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'mute' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'idLista', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $listaDispositivo = array(
		'idLista' => array('type' => 'integer', 'null' => false, 'default' => null),
		'idDispositivo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => null),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'activa' => array('type' => 'integer', 'null' => false, 'default' => null),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $listaVideo = array(
		'idLista' => array('type' => 'integer', 'null' => false, 'default' => null),
		'idVideo' => array('type' => 'integer', 'null' => false, 'default' => null),
		'posicion' => array('type' => 'integer', 'null' => false, 'default' => null),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => null),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $programacion = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'idListaDispositivo' => array('type' => 'integer', 'null' => false, 'default' => null),
		'estado' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'hora' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2),
		'minuto' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2),
		'fecha' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'idUsuario' => array('type' => 'integer', 'null' => false, 'default' => null),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'normas' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'nivel' => array('type' => 'integer', 'null' => false, 'default' => '100', 'length' => 6),
		'timestampCreacion' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'timestampLAcceso' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'hashString' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'welcome' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $video = array(
		'idVideo' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'idEmpresa' => array('type' => 'integer', 'null' => false, 'default' => null),
		'descripcion' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'timestamp' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mute' => array('type' => 'integer', 'null' => false, 'default' => null),
		'time' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fotograma' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'idVideo', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

}
