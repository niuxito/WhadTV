<?php

class UsersFixture extends CakeTestFixture {
    //public $import = array('model' => 'Empresa', 'records' => true);
    //public $useDbConfig = 'test';
    public $fields = array(
      'id' => array(
          'type' => 'integer',
          'key' => 'primary',
          'null' => false),
      'username' => array(
        'type' => 'string',
        'length' => 50),
      'password' => array(
        'type' => 'string',
        'length' => 50),
      'normas' => array(
        'type' => 'integer',
        'default' => 0,
        'null' => false
      ),
      'nivel' =>array(
        'type' => 'integer',
        'default' => 0,
        'null' => false
      ),
      'timestampCreacion' => 'timestamp',
      'timestampLAcceso' => 'timestamp',
      'hashString' => array(
        'type' => 'string',
        'length' => 255),
      'welcome' => array(
        'type' => 'integer',
        'default' => 0,
        'null' => false
      )
    );
    
    public $records = array(
          array(
            'id' => 214,
            'username' => 'morenox24@gmail.com',
            'password' => '7dd2f8b16129b070eaa8e0463e9432b643684dde',
            'normas' => 1,
            'nivel' => 0,
            'timestampCreacion' => '2013-05-07 10:03:00',
            'timestampLAcceso' => '2014-05-08 11:03:25',
            'hashString' => 'a694f12687453ba42b3480a7eaaf66b694ca7b59',
            'welcome' => 1
          ),
          array(
            'id' => 233,
            'username' => 'pedro@whadtv.com',
            'password' => '7dd2f8b16129b070eaa8e0463e9432b643684dde',
            'normas' => 1,
            'nivel' => 1,
            'timestampCreacion' => '2014-03-11 13:41:54',
            'timestampLAcceso' => '2014-03-11 13:42:49',
            'hashString' => 'c4ad881f4fdcbd0313db52083dd5b7de2caedc35',
            'welcome' => 1
          ),
    );
}

?>