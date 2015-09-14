<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $helpers = array( 'MyHtml' );
	public $components = array('DebugKit.Toolbar', 'RequestHandler','Session',
		    	'Auth' => array(
		        	'loginAction' => array(
			            'action' => 'login'
	        		),
		        'authError' => 'Did you really think you are allowed to see that?',
		        'authenticate' => array(
		            'Form' => array(
		                'fields' => array(
		                	'username' => 'username',
	        				'password' => 'password')
		            )
		        )
		    )
		);
	
	function beforeFilter() 
	{
		//CakeLog::write('debug', 'Se está cargando la configuración');
	  	App::import( 'Controller', 'Configuracions' );
	  	App::import( 'Controller', 'Consejos' );
		$confC = new ConfiguracionsController();
		$confC->constructClasses();
		$config = $confC->listar();
		$confC->definir();
		$this->set( 'config', $config );
		
		$usuario = $this->Session->read( 'Auth' );
		if ( isset( $usuario ) && isset( $usuario['User']['normas'] ) ){
			$consejosC = new ConsejosController();
			$consejosC->constructClasses();
			$cuenta = $consejosC->cuentaConsejos( $usuario['User']['id'] );
			$this->set( 'cuentaConsejos',$cuenta );
			$normas = $usuario['User']['normas'];
			if ( $normas === false && ( $this->action != 'edit' && $this->action != 'logout' ) ){
				$this->redirect( array( 'controller'=>'Users','action'=>'edit' ) );
			}
		}
	}

	function testAuth()
	{
		$user = $this->Session->read( "Auth" );
		if( $this->action != 'logout' && $this->action != 'activar' && $this->action != 'gracias'){
			if( !isset( $user['User'] )  ){
				if( !$this->action == 'procesado' ){
					CakeLog::write("debug", "Mostramos login");
					$this->redirect( array( 'controller'=>'users', 'action'=>'login' ) );
				}
			}else{
				if( isset( $user['User']['welcome'] ) ){
					if( $this->action != 'welcome' && $user['User']['welcome'] == 0 && $user['User']['nivel'] <= 1 ){
						$this->redirect( array( 'controller'=>'users', 'action'=>'welcome' ) );
					}
				}else{
					if( !$this->action == 'procesado' ){
						$this->redirect( array( 'controller'=>'Users', 'action'=>'logout' ) );
					}
				}
				if( isset( $user['User']['nivel'] ) && $user['User']['nivel'] > 1 ){
					$this->redirect( array( 'controller'=>'Users', 'action'=>'logout' ) );
				}
			}
		}
	}
}
