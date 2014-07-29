<?php

class EmpresaFixture extends CakeTestFixture {
    //public $import = array('model' => 'Empresa', 'records' => true);
    //public $useDbConfig = 'test';
    public $fields = array(
      'idEmpresa' => array(
          'type' => 'integer',
          'key' => 'primary',
          'null' => false),
        'Nombre' => 'text',
        'url' => 'text'
    );
    
    public $records = array(
          array(
            'idEmpresa' => 68,
            'Nombre' => 'Empresa',
            'url' => 'files/2012-11-21-193031CIelo_llanorel.jpg'
          ),
          array(
            'idEmpresa' => 113,
            'Nombre' => 'Moreno',
            'url' => ' '
          ),
          array(
            'idEmpresa' => 116,
            'Nombre' => '',
            'url' => ''
          )
    );
}

?>