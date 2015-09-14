<?php
App::uses('AppModel', 'Model');
/**
 * EmpresaUsuario Model
 *
 */
class EmpresaUsuario extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'empresaUsuario';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';

	public function getEmpresasByUser( $user_id ){
		$options = array(
			'conditions' => array('idUsuario'=>$user_id)
		);
		$resultado = $this->find('all', $options);
		return $resultado;
	}
}
