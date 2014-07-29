<?php

class ConsejoFixture extends CakeTestFixture {
    //public $import = array('model' => 'Consejo', 'records' => true);
    //public $useDbConfig = 'test';
    public $fields = array(
			'idConsejo' => array(
				'type' => 'integer',
				'key' => 'primary',
				'null' => false
			),
			'idUsuario' => array(
				'type' => 'integer',
				'default' => 0,
				'null' => false
			),
			'descripcion' => array(
				'type' => 'string',
				'length' => 255,
				'null' => false
			),
			'created' => 'datetime',
			'page' => array(
				'type' => 'string',
				'length' => 255,
				'null' => false
			),
			'situacion' => array(
				'type' => 'integer',
				'default' => 0,
				'null' => false
			),
			'idAsunto' => array(
				'type' => 'integer',
				'default' => 0,
				'null' => false
			)
	);
	//situacion(0:noleido,1:leido,2:trabajando,3:cerrado)
	public $records = array(
		array(
			'idConsejo' => 1,
			'idUsuario' => 214,
			'descripcion' => 'Respuesta 1 IdAsunto 1',
			'created' => '2014-04-24 10:25:05',
            'page' => 'http://localhost/GestVideo/adm/listadoAsunto/1',
			'situacion' => 0,
			'idAsunto' => 1
		),
		array(
			'idConsejo' => 2,
			'idUsuario' => 214,
			'descripcion' => 'Respuesta 2 IdAsunto 1',
			'created' => '2014-04-24 10:26:00',
			'page' => 'http://localhost/GestVideo/adm/listadoAsunto/1',
			'situacion' => 0,
			'idAsunto' => 1
		),
		array(
			'idConsejo' => 3,
			'idUsuario' => 214,
			'descripcion' => 'Respuesta 3 IdAsunto 1',
			'created' => '2014-04-24 10:27:00',
			'page' => 'http://localhost/GestVideo/adm/listadoAsunto/1',
			'situacion' => 0,
			'idAsunto' => 1
		)
	);
}

?>