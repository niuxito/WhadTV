<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Empresas');
App::import('Controller', 'EmpresaUsuarios');
/**
 * Users Controller
 *
 * @property User $User
 * 
 */
class UsersController extends AppController {
	
	//var $components = array('Auth','DebugKit.Toolbar');
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
		
	
    
	function index(){
		$this->redirect("lista");
		//$this->set('users', $this->paginate());
		
	}
	public function invitar(){
		if ($this->request->is('post')) {
			$resultado = $this->User->find("all", array('conditions' => "username = '".$this->request->data['User']['username']."'"));
			if( count( $resultado ) == 0){
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					$resultado = $this->User->find("all", array('conditions' => "username = '".$this->request->data['User']['username']."'"));
					if( count( $resultado ) > 0){
						 
						$id = $resultado[0]['User']['id'];
						$empresa = $this->Session->read("Empresa");
						//print_r($empresa);
						$idEmpresa = $empresa['EmpresaUsuario']['idEmpresa'];
						$EmpresaUsuarios = new EmpresaUsuariosController();
						$EmpresaUsuarios->constructClasses();
						$data = array('idEmpresa' => $idEmpresa, 'idUsuario' => $id, 'perfil' => '2');
		
						$EmpresaUsuarios->addRegistro($data);
		
						/*
						 * Mandar un mail al usuario indicando que se ha creado la cuenta,
						* cual es su contraseña y que deberá aceptar las condiciones para
						* poder acceder al sistema.
						*/
						$usuario = $this->Session->read("Auth");
						$empresa = new EmpresasController();
						$empresa->constructClasses();
						$resultado = $empresa->Empresa->find("all", array('conditions' => 'idEmpresa ='.$idEmpresa));
						
						//print_r($empresa);
						$mailData = array('empresa'=>$resultado[0], 'invitado' => $id, 'invitador' => $usuario );
						//$this->Session->write('mailData');
						$email = new CakeEmail('default');
						$email->sender('invite@whadtv.com', 'MyApp emailer');
						$email->from(array('invite@whadtv.com' => 'WhadTV'));
						$email->to($this->request->data['User']['username']);
						$email->subject('Te han invitado a usar WhadTV');
						$email->emailFormat('html');
						$email->viewVars($mailData);
						$email->template('invitacion');
						$email->send();
		
							
						$this->Session->setFlash(__('El usuario ha sido guardado.'));
						//$this->redirect(array('action' => '../Empresas/panel'));
					}else{
						$this->Session->setFlash(__('Se ha producido un error'));
					}
				} else {
					$this->Session->setFlash(__('La empresa no ha podido guardarse. Por favor, intentalo de nuevo.'));
				}
				//$this->redirect(array('action' => '../Empresas/panel'));
			}else{
				$id = $resultado[0]['User']['id'];
				$empresa = $this->Session->read("Empresa");
				$idEmpresa = $empresa['EmpresaUsuario']['idEmpresa'];
		
				$EmpresaUsuarios = new EmpresaUsuariosController();
				$EmpresaUsuarios->constructClasses();
				$resultado = $EmpresaUsuarios->EmpresaUsuario->find("all", array("conditions" => array("idUsuario = ".$id, "idEmpresa = ".$idEmpresa)));
				if( count( $resultado ) > 0 ){
					$this->Session->setFlash(__('El usuario introducido ya pertenece a la empresa.'));
				}else{
					$data = array('idEmpresa' => $idEmpresa, 'idUsuario' => $id, 'perfil' => '2');
					$EmpresaUsuarios->addRegistro($data);
					$this->Session->setFlash(__('Se ha añadido el usuario a la empresa.'));
				}
		
		
			}
		}
		
	}
	
	public function aceptarinvitacion($id, $idEmpresa){
		if ($this->request->is('post')) {
			
			
			
		}else{
			$this->request->data = $this->User->read(null, $id);
			$this->request->data['User']['password'] = "";
			$this->request->data['User']['cpassword'] = "";
		}
		
	}
	
	private function activarUsuarioInvitado(){
		$this->edit();
		$EmpresaUsuarios = new EmpresaUsuariosController();
		$EmpresaUsuarios->constructClasses();
		$resultado = $EmpresaUsuarios->EmpresaUsuario->find(
				"all",
				array('conditions' => array(
						'idEmpresa = '.$idEmpresa,
						'idUsuario = '.$id )));
		if( count( $resultado ) > 0){
			//print_r($resultado);
			$resultado[0]['EmpresaUsuario']['activo'] = 1;
			if($EmpresaUsuarios->EmpresaUsuario->save($resultado[0])){
				$this->Session->setFlash(__('Se ha activado el usuario.'));
				//$this->redirect(array('action' => '../Empresas/panel'));
			}
		}
	}

	public function activar($hash = null){
		
		if ($this->request->is('post')) {
			$hash = $this->request->data['User']['hashString'];
			$password = $this->Auth->password($this->request->data['User']['password']);
			$resultado = $this->User->find("all", array('conditions' => "hashString = '".$hash."'"));
			//print_r($resultado);
			if( count( $resultado ) > 0 ){
				
				if($password == $resultado[0]['User']['password']){
					$this->request->data['User']['username'] = $resultado[0]['User']['username'];
					$this->request->data['User']['nivel'] = 1;
					$this->request->data['User']['password'] = $password; 
					$this->request->data['User']['id'] = $resultado[0]['User']['id'];
					if($this->User->save($this->request->data)){
						$this->Session->setFlash("Ya puedes acceder a tu cuenta.", 'info');
						$this->Auth->login();
						//$this->redirect('welcome');
						$this->redirect("login");
					}else{
						$this->Session->setFlash("Se ha producido un error al activar el usuario.", 'error');
					}
				}else{
					$this->Session->setFlash("La contraseña no es válida.", "error");
					$this->request->data['User']['hashString']  = $hash;
					$this->render('password', 'logedout');
				}
			}else{
				$this->Session->setFlash("Hay un problema con su usuario, pongase en contacto con el administrador.", "error");
				$this->render('password', 'logedout');
			}
		}else{
			$resultado = $this->User->find("all", array('conditions' => "hashString = '".$hash."'"));
			//print_r($resultado);
			if( count( $resultado ) > 0 ){
				if($resultado[0]['User']['nivel'] == 100){
					$this->request->data['User']['hashString']  = $hash;
					$this->render('password', 'logedout');
				}else{
					$this->Session->setFlash("El usuario ya está activado.", 'info');
					$this->redirect("login");
				}
			}else{
				$this->Session->setFlash("El usuario no existe.");
				$this->redirect("login");
			}
		
			
		}
	}
	public function add(){
		if ($this->request->is('post')) {
			$resultado = $this->User->find("all", array('conditions' => "username = '".$this->request->data['User']['username']."'"));
			if( count( $resultado ) == 0){
				$this->request->data['User']['password']  = $this->Auth->password($this->request->data['User']['password']);
							
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					$resultado = $this->User->find("all", array('conditions' => "username = '".$this->request->data['User']['username']."'"));
					if( count( $resultado ) > 0){
							      		
						$id = $resultado[0]['User']['id'];
						$empresa = $this->Session->read("Empresa");
						//print_r($empresa);
						$idEmpresa = $empresa['EmpresaUsuario']['idEmpresa'];
						$EmpresaUsuarios = new EmpresaUsuariosController();
						$EmpresaUsuarios->constructClasses();	
						$data = array('idEmpresa' => $idEmpresa, 'idUsuario' => $id, 'perfil' => '2');
								       	
						$EmpresaUsuarios->addRegistro($data);
						
						/*
						 * Mandar un mail al usuario indicando que se ha creado la cuenta,
						 * cual es su contraseña y que deberá aceptar las condiciones para
						 * poder acceder al sistema.
						 */
						
					
					$this->Session->setFlash(__('El usuario ha sido guardado.'));
					$this->redirect(array('action' => '../Empresas/panel'));
					}else{
						$this->Session->setFlash(__('Se ha producido un error.'));	
					}
				} else {
					$this->Session->setFlash(__('La empresa no ha podido guardarse. Por favor, intentalo de nuevo.'));
				}
			}else{
				$id = $resultado[0]['User']['id'];
				$empresa = $this->Session->read("Empresa");
				$idEmpresa = $empresa['EmpresaUsuario']['idEmpresa'];
				
				$EmpresaUsuarios = new EmpresaUsuariosController();
				$EmpresaUsuarios->constructClasses();	
				$resultado = $EmpresaUsuarios->EmpresaUsuario->find("all", array("conditions" => array("idUsuario = ".$id, "idEmpresa = ".$idEmpresa)));
				if( count( $resultado ) > 0 ){
					$this->Session->setFlash(__('El usuario introducido ya pertenece a la empresa.'));
				}else{
					$data = array('idEmpresa' => $idEmpresa, 'idUsuario' => $id, 'perfil' => '2');      	
					$EmpresaUsuarios->addRegistro($data);
					$this->Session->setFlash(__('Se ha añadido el usuario a la empresa.'));
				}
				
				
			}
		}
	}
	
	function condiciones(){
		
	}
	
	function lista(){
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		$options['fields'] = array('id','username');
		$options['joins'] = array(
		    array('table' => 'empresaUsuario',
		        'alias' => 'b',
		        'type' => '',
		        'conditions' => array(
		            'User.id = b.idUsuario',
		    		"b.idEmpresa = '".$idEmpresa."'"
		        )
		    )
		    
		);
		
    	$users = $this->User->find("all", $options);
    	//$this->set("empresas", $empresas);
		$this->set('users', $users);
		$this->render("lista", 'loged');
	}
	
	public function login() {
		
		if (!$this->request->is('post')) {
			$logeado = $this->Session->read('Auth');
	    	$this->set( 'auth',$logeado );
	    	if(!is_null($logeado) && array_key_exists('User', $logeado)){
	    		$this->redirect(array('controller'=>'videos'));
	    	}else{
	    		$this->render("login", 'default');
	    	}
	    	return true;
		}

		$this->Auth->authenticate = array('Form');
		$user = $this->request->data['User'];
        if (!$this->Auth->login()) {
        	CakeLog::write('debug','Usuario incorrecto');
            return new 	CakeResponse(array('body' => json_encode( array('status'=>'usuario/password incorrecto') ) ) );
        }
	        	
    	/*
    	 * Comprobar que el usuario ha aceptado las condiciones
    	 */
    	$resultadoU = $this->User->find("all", array('conditions' => "username = '".$user['username']."'"));
		$id = $resultadoU[0]['User']['id'];

		$this->User->id = $id;
		$this->User->save();
    	
    	if($resultadoU[0]['User']['nivel'] > 99){
    		$this->Session->setFlash(__('Debes confirmar tu registro. Mira la bandeja de entrada de tu correo.'), 'info');
			$this->Auth->logout();
			//return new 	CakeResponse(array('body' => json_encode( array('status'=>__('Debes confirmar tu registro. Mira la bandeja de entrada de tu correo.')) ) ) );
    	}	
    	
    	/*
    	 * Comprobar si existen más empresas para este usuario
    	 */
		$this->loadModel('EmpresaUsuario');
		$empresas = $this->EmpresaUsuario->getEmpresasByUser( $id );

		$user = $this->Session->read('Auth');
		$this->User->id = $id;
		
		$this->User->save();

		
		(  ( SYSTEM_STATUS == 0 ) ) ? $this->redirect( array( 'action'=>'off' ) ) : false;

    	if( count( $empresas ) > 0 ){

    		/*
    		 * Muestra pantalla de gestión de empresas
    		 */
    		return new 	CakeResponse(array('body' => json_encode( array('status'=>'ok') ) ) );

    	}
    	return new 	CakeResponse(array('body' => json_encode( array('status'=>'El usuario no está asignado a ninguna empresa.') ) ) );
	 
	}
	
	public function off()
	{
		
	}	
	
	public function edit($id = null) {
		$data = $this->Session->read("Auth");
		$id = $data['User']['id'];
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid User'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$resultado = $this->User->find('all', array('conditions'=>'id = '.$id));
			if(count($resultado) > 0){
				$this->set('resultado', $resultado);
				
				$normas = $resultado[0]['User']['normas'];
				
				if ($normas != 0 ) {
					$oldPass = $this->Auth->password($this->request->data['User']['oldPass']);
					if( $resultado[0]['User']['password'] == $oldPass){
						if($this->request->data['User']['password'] == $this->request->data['User']['cpassword']){
							$this->request->data['User']['password']  = $this->Auth->password($this->request->data['User']['password']);
							
							if ($this->User->save($this->request->data)) {
								$this->Session->setFlash(__('La contraseña se ha actualizado.'), 'info');
								$this->redirect(array('controller'=>'videos','action' => 'index'));
							} else {
								$this->Session->setFlash(__('El usuario no ha podido guardarse. Por favor, intentalo de nuevo.'));
							}
						}else{
							$this->Session->setFlash(__('Las contaseñas no coinciden.'), 'error');
						}
					}else{
						$this->Session->setFlash(__('La contaseña no es correcta.'), 'error');
					}
				}else{
					$newNormas = $this->request->data['User']['normas'];
					if ($newNormas == 0){
						$this->Session->setFlash(__('Debes marcar la casilla para aceptar las normas.'),'error');
					}else{
						if ($this->User->save($this->request->data)) {
							$this->Session->write('Auth', $this->User->read(null,$id));
							$this->Session->setFlash(__('Las condiciones se han actualizado.'), 'info');
							$this->redirect(array('controller'=>'videos','action' => 'index'));
						} else {
							$this->Session->setFlash(__('Las condiciones no han podido guardarse. Por favor, intentalo de nuevo.'),'error');
						}
					}
				}
			}else{
				$this->Session->setFlash(__('El usuario no existe.'),'error');
			}
		}
		$this->request->data = $this->User->read(null, $id);
		$this->request->data['User']['password'] = "";
		$this->request->data['User']['cpassword'] = "";
		$this->render("edit", 'loged');
	}
		
	function listaUsers(){
		$this->set('users', $this->paginate());
		

	}
	function recuperarPass(){
		//Consultar en password si existe una referencia del id de usuario  y si la clave coincide con la almacenada
		//si las dos son verdaderas, cambiar la contraseña, si no mostrar un mensaje.
		if(!empty($this->request->query['k'])){
			$random = $this->request->query['k'];
			//echo $random;
			$this->set('random', $random);
		}else{
			
		}
	}
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->fields = array(
        'username' => 'username', 
        'password' => 'password'
        );
		$this->Auth->allow('logout');
		$this->Auth->allow('activar');
		$this->Auth->allow('register');
		$this->Auth->allow('contacto');
		$this->Auth->allow('solicitarPass');
		$this->Auth->allow('enviarSolicitudPass');
		parent::testAuth();
	}
	
	function logout() {
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}
	
	function welcome(){
		$this->render('welcome','loged');
	}
	function chwelcome(){
		$user = $this->Session->read("Auth");
		$this->User->id = $user['User']['id'];
		
		$data['User']['welcome'] = 1;
		if ($this->User->save($data)) {
			$user['User']['welcome'] = 1;
			$this->Session->write('Auth', $user);
			$this->redirect(array('controller'=>'videos','action'=>'index'));
		}else{
			$this->logout();
		}
	}
	
	public function contacto()
	{
		if($this->request->is('post')){
			$mailData = array('mail'=>$this->request->data['mail'], 'nombre' => $this->request->data['nombre'], 'tel' => $this->request->data['tel'],  'texto' => $this->request->data['texto']  );
			
			$email = new CakeEmail('default');
			$email->sender('contacto@whadtv.com', 'Formulario de contacto');
			$email->from(array('contacto@whadtv.com' => 'WhadTV'));
			( defined( 'CONTACTO_MAIL' ) ) ? $email->to( CONTACTO_MAIL ) : $email->to( "info@whadtv.com" );
			$email->subject('Se ha enviado un formulario de contacto');
			$email->emailFormat('html');
			$email->viewVars($mailData);
			$email->template('contacto');
			$email->send();
			$this->Session->setFlash("Se ha debido enviar el mail.", "info" );
			
		}
		
		$this->redirect('/#contacto');
		//$this->render('contacto');
	}

	public function validarRegistro($user){
		$validado = true;
		
		if($user['User']['empresa'] == ""){
			$validado = false;
			$this->Session->setFlash('Debes introducir un nombre de empresa.', 'info', array(), 'default');
		}
		if(!$this->isValidEmail($user['User']['username'])){
			$validado = false;
			$this->Session->setFlash('Debes introducir una dirección de correo correcta.', 'info', array(), 'default');
		}
		
		//Mejorar introduciendo control de alfanumerico y de uso de mayusculas
		if((strlen($user['User']['password']) < 6)){
			$validado = false;
			$this->Session->setFlash('La contraseña no cumple con los requisitos de seguridad.', 'info', array(), 'default');
		}
		
		if($user['User']['password'] != $user['User']['cpassword']){
			$validado = false;
			$this->Session->setFlash('La contraseña no coincide, recuerda que debes introducir la misma contraseña dos veces.', 'info', array(), 'default');
		}
		if($user['User']['normas'] != 1){
			$validado = false;
			$this->Session->setFlash(__('Para registrarte, debes aceptar las condiciones.'), 'info', array(), 'default');
		}
		return $validado;
	}
	
	public function isValidEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	public function register() {
		if(!empty($this->request->data)){
			$Empresas = new EmpresasController();
			$Empresas->constructClasses();
			//$this->User->set($this->request->data);
			if($this->validarRegistro($this->request->data)){
				
				$empresa = $this->request->data['User']['empresa'];
				$usuario = $this->request->data['User']['username'];
				
				$resultado = $Empresas->Empresa->find("all", array('conditions' => "nombre = '".$empresa."'"));
				if( count( $resultado ) == 0){
					$resultado = $this->User->find("all", array('conditions' => "username = '".$this->request->data['User']['username']."'"));
					if( count( $resultado ) == 0){
						$this->request->data['User']['password']  = $this->Auth->password($this->request->data['User']['password']);
						$this->request->data['User']['timestampCreacion'] = DboSource::expression('NOW()');
						$this->request->data['User']['welcome'] = ( defined( 'INIT_WELCOME_STATUS' ) ) ? INIT_WELCOME_STATUS : 0;
						$hash = $this->request->data['User']['hashString'] = Security::hash($this->request->data['User']['username'], 'sha1');
						//$this->request->data['User']['nivel'] = 0;
						if ($this->User->save($this->request->data)) {
					      	$resultado = $this->User->find("all", array('conditions' => "username = '".$this->request->data['User']['username']."'"));
					      	if( count( $resultado ) > 0){
					      		
					      		$id = $resultado[0]['User']['id'];
					      		unset($this->request->data['User']['cpassword']);
					      		$this->request->data['User']['nivel'] = $resultado[0]['User']['nivel'];
					      		$this->request->data['User']['welcome'] = $resultado[0]['User']['welcome'];
					   
					      	
						        $this->request->data['User'] = array_merge($this->request->data["User"], array('id' => $id));
						        $this->Auth->login($this->request->data['User']);
						        $this->request->data['User']['password'] = "";
						        $this->request->data['User']['cpassword'] = "";
						        
						        
						        /*
						         * Crear empresa
						         */
						        
								$data = array('Nombre' => $empresa);
						       	$resultado = $Empresas->addEmpresa($data);
						       	$idEmpresa = $resultado[0]['Empresa']['idEmpresa'];
						       	
						       	/*
						       	 * Crear relacion EmpresaUsuario
						       	 */
						       	$EmpresaUsuarios = new EmpresaUsuariosController();
								$EmpresaUsuarios->constructClasses();	
						       	$data = array('idEmpresa' => $idEmpresa, 'idUsuario' => $id, 'perfil' => '2', 'activo' => 1);
						       	
						       	$EmpresaUsuarios->addRegistro($data);
						        
						        
						        
						        /*
						         * Mandar mail de confirmación
						         */
						       	$this->sendRegistrationMail($hash);
						        
								
								
								$this->Session->setFlash(__('Debes confirmar tu registro. Mira la bandeja de entrada de tu correo.'), 'info', array(),'default');
								//$this->Auth->logout();
								//$this->Session->setFlash(__('Debes confirmar tu registro. Mira la bandeja de entrada de tu correo'), 'info');
									
								$this->redirect('gracias');
								
					      	}else{
					      		$this->Session->setFlash(__('Se ha producido un error.'), 'error', array(), 'default');
					      	}			        
					        
				      		$this->render('gracias');
			    		}
					    		$this->request->data['User']['password'] = "";
					}else{
						$this->Session->setFlash(__('El mail introducido ya existe en nuestra base de datos.'), 'info', array(), 'default');
					}
				}else{
					$this->Session->setFlash(__('Ya existe una empresa con el nombre introducido. 
					Pongase en contacto con el administrador para poder acceder.'), 'info', array(), 'default');	
				}
			}
			
		}
		$this->render('register', 'logedout');
	    
	}

	public function sendRegistrationMail($hash){
		$email = new CakeEmail('default');
        $email->sender('welcome@whadtv.com', 'WhadTV');
		$email->from(array('welcome@whadtv.com' => 'WhadTV'));
		$email->to($this->request->data['User']['username']);
		$email->subject('Bienvenido a WhadTV');
		$email->emailFormat('html');
		$email->viewVars(array('hash' => $hash));
		$email->template('bienvenida');
		$email->send();

		$email = new CakeEmail('default');
        $email->sender('admin@whadtv.com', 'WhadTV_ADM');
		$email->from(array('admin@whadtv.com' => 'WhadTV_ADM'));
		( defined( 'REGISTRO_MAIL' ) ) ?  $email->to( REGISTRO_MAIL )  : $email->to( "alexis@whadtv.com" );
		$email->subject('Usuario registrado');
		$email->emailFormat('html');
		$email->viewVars(array('data' => $this->request->data));
		$email->template('nuevo_registro');
		$email->send();
	}
	
	public function gracias()
	{
		$this->render('gracias','logedout');
	}
	public function enviarSolicitudPass(){
	 /*
	  * Comprobar que existe el usuario.
	  */
		if( $this->request->data['User']['username'] ){
			$this->User->id = $this->User->field( 'id',"username='".$this->request->data['User']['username']."'" );
			if( $this->User->exists() ){
				
			/* 
			 * Eliminar de la tabla passwords todas las referencias a ese id
			 */
				$this->User->query(
					"delete from passwords where id='".$this->User->id."'"
				);
				
			/* Generar una código aleatorio y almancenarlo en la tabla passwords 
	 		 * con el id de usuario y el timestamp de la solicitud.
	 		 */ 
			$this->random = md5(time() + Configure::read('Security.salt'));
			$this->User->query(
					"insert into passwords values('".$this->User->id."','".$this->random."','".time()."')"
				);	
			/*
	   		 * Enviar un mail con el link hhtp://redvalora.com/Users/recuperarPass?k=[código generado]
	  		 */
			$email = new CakeEmail('default');
			//$email->sender('welcome@redvalora.com', 'MyApp emailer');
			$email->from(array('recovery@redvalora.com' => 'Redvalora'));
			$email->to($this->request->data['User']['username']);
			$email->subject('Recovery system');
			$email->send(
				'Para recuperar tu contraseña pulsa sobre el <a href=http://localhost/RedValora/users/recuperarPass?k='.$this->random.'>enlace</a>'
			);	 
			
			$this->Session->setFlash(__($this->random), 'default', array(), 'default');
			}else{
				$this->Session->setFlash(__('El usuario no existe.'), 'default', array(), 'default');
			}
		}else{
			$this->Session->setFlash(__('Debes introducir una dirección de correo.'), 'default', array(), 'default');
		}
	  
		 
	  
	  
	  /* Reportar resultado de la operación
	  */
	}
	
	public function  solicitarPass(){
	}
	
}
