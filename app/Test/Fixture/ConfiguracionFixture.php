<?php

class ConfiguracionFixture extends CakeTestFixture {
    //public $import = array('model' => 'Configuracion', 'records' => true);
    //public $useDbConfig = 'test';
    public $fields = array(
			'id' => array(
				'type' => 'integer',
				'key' => 'primary',
				'null' => false
			),
			'Nombre' => array(
				'type' => 'string',
				'length' => 255,
				'null' => false
			),
			'Valor' => array(
				'type' => 'string',
				'length' => 255,
				'null' => false
			),
			'tipo' => array(
				'type' => 'integer',
				'default' => 0,
				'null' => false
			)
	);
	//tipo(0:interno,1:js,2:ambiguo)
	public $records = array(
		array(
			'id' => 1,
			'Nombre' => 'host',
			'Valor' => 'localhost',
			'tipo' => 2
		),
		array(
			'id' => 2,
			'Nombre' => 'directorio',
			'Valor' => '/GestVideo',
			'tipo' => 2
		),
		array(
			'id' => 3,
			'Nombre' => 'ua',
			'Valor' => 'UA-35714992-1',
			'tipo' => 1
		),
		array(
			'id' => 4,
			'Nombre' => 'max_file_size',
			'Valor' => '20000000',
			'tipo' => 2
		),
		array(
			'id' => 5,
			'Nombre' => 'predef_img_time',
			'Valor' => '8',
			'tipo' => 0
		),
		array(
			'id' => 6,
			'Nombre' => 'max_image_time',
			'Valor' => '10',
			'tipo' => 0
		),
		array(
			'id' => 7,
			'Nombre' => 'init_image_time',
			'Valor' => '5',
			'tipo' => 0
		),
		array(
			'id' => 8,
			'Nombre' => 'contacto_mail',
			'Valor' => 'pedro@whadtv.com',
			'tipo' => 0
		),
		array(
			'id' => 9,
			'Nombre' => 'registro_mail',
			'Valor' => 'pedro@whadtv.com',
			'tipo' => 0
		),
		array(
			'id' => 10,
			'Nombre' => 'beanstalk_host',
			'Valor' => '0.0.0.0',
			'tipo' => 0
		),
		array(
			'id' => 11,
			'Nombre' => 'bucket',
			'Valor' => 'whadtv-development-bucket',
			'tipo' => 0
		),
		array(
			'id' => 12,
			'Nombre' => 'process_method',
			'Valor' => 'directo',
			'tipo' => 0
		),
		array(
			'id' => 13,
			'Nombre' => 'process_server',
			'Valor' => 'http://localhost/GestVideoworkers/',
			'tipo' => 0
		),
		array(
			'id' => 14,
			'Nombre' => 'init_welcome_status',
			'Valor' => '1',
			'tipo' => 0
		),
		array(
			'id' => 15,
			'Nombre' => 'system_status',
			'Valor' => '1',
			'tipo' => 0
		)
	);
}

?>