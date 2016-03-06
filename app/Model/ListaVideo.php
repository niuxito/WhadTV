<?php
App::uses('AppModel', 'Model');
/**
 * ListaVideo Model
 *
 */
class ListaVideo extends AppModel {
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'listaVideo';
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';

	public $belongsTo = array(
		'Video' => array(
            'className' => 'Video',
            'foreignKey' => 'idVideo'
        ));

}
