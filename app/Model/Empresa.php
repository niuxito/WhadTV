<?php
App::uses('AppModel', 'Model');
/**
 * Empresa Model
 *
 */
class Empresa extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'empresa';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'idEmpresa';


	public function setDemo( $value )
	{
		$data['Empresa']['demo_web'] = $value;
		$this->save($data);
	}
}
