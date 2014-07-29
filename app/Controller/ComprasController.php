<?php
App::uses('AppController', 'Controller');

/**
 * Compras Controller
 *
 * 
 */
class ComprasController extends AppController {
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Session', 'Auth');
	
	public function whadtv(){
		$this->set('precio',array('whadtv'=>'150'));
		$this->render('whadtv','loged');
	}

	public function web_player()
	{
		$this->render('web_player', 'loged');
	}
	
}
?>