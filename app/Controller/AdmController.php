<?php 
App::import('Controller', 'Users');
//App::import('Controller', 'Empresas');
App::import('Controller', 'Videos');
App::import('Controller', 'EmpresaUsuarios');
App::import('Controller', 'Dispositivos');
App::import('Controller', 'ListaDispositivos');
App::import('Controller', 'ListaVideos');
App::import('Controller', 'Lista');
App::import('Controller', 'Consejos');
App::import('Controller', 'ActualizacionDispositivos');
App::import('Controller', 'Reproductors');
class AdmController extends AppController{

	var $name="Adm";
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Auth');
	var $uses = array('Users','Empresas'); 
	
	
	public function beforeFilter(){
		parent::beforeFilter();
		$user1 = $this->Session->read('Auth');
		if(isset($user1['User']['nivel']) && $user1['User']['nivel'] == 0){
			$this->layout = 'admin';
		}else{
			$this->redirect(array('controller'=>'Videos','action'=>'index'));
		}
		
	}

	public function clearCache(){
		Cache::clear(false);
		$this->redirect(array('action'=>'index'));
	}
	public function index(){
		$userC = new UsersController();
		$userC->constructClasses();
		$resultado = $userC->User->find('all', array('fields'=>array('count(id) total',
											'(select count(id) inactivos from users where nivel != 100) activados',
											'(select count(id) inactivos from users where welcome != 0) activos'
											)));
		$nUsers = $resultado[0][0];
		
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$resultado = $empresaC->Empresa->find('all', array('fields'=>'count(idEmpresa) total'));
		$nEmpresas = $resultado[0][0];
		
		$videoC = new VideosController();
		$videoC->constructClasses();
		$resultado = $videoC->Video->find('all', array('fields'=>'count(idVideo) total'));
		$nVideos = $resultado[0][0];
		
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$resultado = $dispositivoC->Dispositivo->find('all', array('fields'=>array('count(idDispositivo) total',
			'(select count(idDispositivo) caducados from dispositivo where caducidad < curdate() ) caducados'
			)));
		$nDispositivos= $resultado[0][0];
		
		$consejosC = new ConsejosController();
		$consejosC->constructClasses();
		$resultado = $consejosC->Consejo->find('all',array('fields'=>'count(idConsejo) total'));
		$nConsejos=$resultado[0][0];

		$actualizacionDispositivosC = new ActualizacionDispositivosController();
		$actualizacionDispositivosC->constructClasses();
		$resultado = $actualizacionDispositivosC->ActualizacionDispositivo->find('all',array('fields'=>'count(distinct(idReproductor)) total'));
		$nActualizacionDispositivos = $resultado[0][0];

		$resumen['usuarios'] = $nUsers;
		$resumen['empresas'] = $nEmpresas;
		$resumen['videos'] = $nVideos;
		$resumen['dispositivos'] = $nDispositivos;
		$resumen['consejos'] = $nConsejos;
		$resumen['actualizacionDispositivos'] = $nActualizacionDispositivos;
		
		$this->set('resumen',$resumen);
		$this->render('index');//, 'admin');
	}
	
	public function listadoUsuarios(){
		$options['fields'] = array('User.id','User.username','timestampCreacion','timestampLAcceso','count(distinct empresaUsuario.idEmpresa) empresas', 'nivel', 'welcome');
		$options['group'] = array('User.id');
		$options['order'] = array('User.timestampLAcceso DESC');
		$options['joins'] = array(
				array('table' => 'empresaUsuario',			
						'type' => 'left',
						'conditions' => array(
								'empresaUsuario.idUsuario = User.id',
									
						)
				)
		);
		$this->listarUsuarios($options);
		$this->render('listadoUsuarios','admin');
	}
	
	public function listarUsuarios($options = null){
		$userC = new UsersController();
		$userC->constructClasses();
		$resultado = $userC->User->find('all',$options);
		$users = $resultado;
		$this->set('users',$users);
	}
	
	public function listadoEmpresasUsuarios($id = null){
		$userC = new UsersController();
		$userC->constructClasses();
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$options['fields'] = array('Empresa.idEmpresa','Empresa.nombre','empresaUsuario.id');
		$options['conditions'] = array("empresaUsuario.idUsuario= ".$id);
		$options['joins'] = array(
				array('table' => 'empresaUsuario',
						'type' => 'left',
						'conditions' => array(
								"empresaUsuario.idEmpresa = Empresa.idEmpresa and empresaUsuario.idUsuario = ".$id,
									
						)
				)
		);
		$options['order'] = ('empresaUsuario.idEmpresa');
		$resultadoUsuario = $userC->User->find('all',array('conditions'=>'id = '.$id));
		$this->set('user',$resultadoUsuario);
		$resultadoEmpresa = $empresaC->Empresa->find('all',$options);
		$this->set('empresas',$resultadoEmpresa);
		$this->render('listadoEmpresasUsuarios', 'admin');
	}
	
	public function deleteEmpresasUsuarios($idEmpresaUsuario = null){
		$eUsuariosC = new EmpresaUsuariosController();
		$eUsuariosC->constructClasses();
		$eUsuariosC->EmpresaUsuario->id = $idEmpresaUsuario;
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$resultado = $eUsuariosC->EmpresaUsuario->find('all',array('conditions'=>'id = '.$idEmpresaUsuario));
		if ($resultado == 0) {
			$this->Session->setFlash(__('El usuario no existe en esta empresa.'));
		}else{
			if ($eUsuariosC->EmpresaUsuario->delete()){
				$this->Session->setFlash(__('El usuario ha sido dado de baja correctamente en la empresa.'));
				//$this->redirect(array('action' => 'listadoEmpresasUsuarios'));
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('El usuario no ha podido ser dado de baja en la empresa.'));
			}
		}
	}
	
	public function deleteEmpresasUsuariosId($idEmpresaUsuario = null){
		$this->loadModel('EmpresaUsuario');
		$this->EmpresaUsuario->id = $idEmpresaUsuario;
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$resultado = $this->EmpresaUsuario->find('all',array('conditions'=>'id = '.$idEmpresaUsuario));
		if ($resultado == 0) {
			$this->Session->setFlash(__('El usuario no existe en esta empresa.'));
		}else{
			if ($this->EmpresaUsuario->delete()){
				$this->Session->setFlash(__('El usuario ha sido dado de baja correctamente en la empresa.'));
			}else{
				$this->Session->setFlash(__('El usuario no ha podido ser dado de baja en la empresa.'));
			}
		}
	}
	
	public function addUsuario(){
		$userC = new UsersController();
		$userC->constructClasses();
		
		if ($this->request->is('post')) {
			if($userC->isValidEmail($this->request->data['User']['username'])){
				if (Trim($this->request->data['User']['password'] != '')) {
					$resultado = $userC->User->find("all", array('conditions' => "username = '".$this->request->data['User']['username']."'"));
					if(count($resultado) == 0){
						//$this->Session->setFlash(__('El usuario no existe.'),'info');
						if($this->request->data['User']['password'] == $this->request->data['User']['cpassword']){
							$this->request->data['User']['timestampCreacion'] = DboSource::expression('NOW()');
							$this->request->data['User']['password']  = $this->Auth->password($this->request->data['User']['password']);
							if ($userC->User->save($this->request->data)) {
								$resultado = $userC->User->find("all", array('conditions' => "username = '".$this->request->data['User']['username']."'"));
								if(count($resultado) > 0){	
									$id = $resultado[0]['User']['id'];
									$this->Session->setFlash(__('El usuario ha sido guardado.'));
									$this->redirect(array('action' => 'listadousuarios'));
								}else{
									$this->Session->setFlash(__('El usuario no ha podido guardarse. Por favor, intentalo de nuevo.'));
								}
							} else {
								$this->Session->setFlash(__('El usuario no ha podido guardarse. Por favor, intentalo de nuevo.'));
							}
						}else{
							$this->Session->setFlash(__('Las contaseñas no coinciden.'), 'error');
						}
					}else{	
						$this->Session->setFlash(__('El usuario ya existe.'),'error');
						//$this->redirect(array('action' => '../Adm/addUsuario'));
					}
				}else{
					$this->Session->setFlash('Debes introducir una contraseña.', 'error');
				}
			}else{
					$this->Session->setFlash('Debes introducir una dirección de correo correcta.', 'error');
			}
		}
		$this->render("addUsuario", 'admin');
	}
	
	public function editarUsuario($id = null){
		$userC = new UsersController();
		$userC->constructClasses();
		$userC->User->id = $id;
		if ($this->request->is('post') || $this->request->is('put')) {
			if (Trim($this->request->data['User']['password'] != '')) {
				if($this->request->data['User']['password'] == $this->request->data['User']['cpassword']){
					$this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
					if ($userC->User->save($this->request->data)) {
						$this->Session->setFlash(__('La contraseña se ha actualizado.'), 'info');
						$this->redirect(array('controller'=>'adm','action' => 'index'));
					} else {
						$this->Session->setFlash(__('El usuario no ha podido guardarse. Por favor, intentalo de nuevo.'));
					}
				}else{
					$this->Session->setFlash(__('Las contaseñas no coinciden.'), 'error');
				}
			}else{
				$data = $this->request->data;
				unset($data['User']['password']);
				if ($userC->User->save($data)) {
						$this->Session->setFlash(__('La contraseña se ha actualizado.'), 'info');
						$this->redirect(array('controller'=>'adm','action' => 'index'));
					} else {
						$this->Session->setFlash(__('El usuario no ha podido guardarse. Por favor, intentalo de nuevo.'));
					}
			}
		}

		$this->set('users',$this->Users->read(null,$id));
		$this->render("editarUsuario", 'admin');
	}
	
	public function gestUsuario( $id = null , $idUsuario = null , $idEmpresa = null ){
		$eUsuariosC = new EmpresaUsuariosController();
		$eUsuariosC->constructClasses();
		$eUsuariosC->EmpresaUsuario->id = $id;
		$userC = new UsersController();
		$userC->constructClasses();
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		//$eUsuariosC->EmpresaUSuario->perfil = $eUsuariosC->EmpresaUsuario->find("empresaUsuario.perfil", array('conditions' => "idUsuario = '".$idUsuario."' and idEmpresa ='".$idEmpresa."'"));
		$resultado = $eUsuariosC->EmpresaUsuario->find("all", array('conditions' => "idUsuario = '".$idUsuario."' and idEmpresa ='".$idEmpresa."'"));
		if ($resultado != 0 ){
			//$this->Session->setFlash('Existe');
			//$this->request->data['User']['password']
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($eUsuariosC->EmpresaUsuario->save($this->request->data)) {
					$this->Session->setFlash(__('Los permisos se han actualizado.'), 'info');
					$this->redirect(array('controller'=>'adm','action' => 'listadousuariosempresa/'.$idEmpresa));
				} else {
					$this->Session->setFlash(__('Los permisos no han podido guardarse. Por favor, intentalo de nuevo.'));
				}
			}
		}else{
			$this->Session->setFlash(__('El usuario no esta dado de alta en la empresa.'), 'error');
		}
		
		
		$resultadoEmpresaUsuarios = $eUsuariosC->EmpresaUsuario->find('all',array('conditions'=>"idEmpresa = '".$idEmpresa."' and idUsuario = '".$idUsuario."'"));
		$this->set('empresaUsuario',$resultadoEmpresaUsuarios);
		$resultadoEmpresa = $empresaC->Empresa->find('all',array('conditions'=>'idEmpresa = '.$idEmpresa));
		$this->set('empresas',$resultadoEmpresa);
		$resultadoUsuario = $userC->User->find('all',array('conditions'=>'id= '.$idUsuario));
		$this->set('users',$resultadoUsuario);
		$this->request->data = $eUsuariosC->EmpresaUsuario->read(null,$id);
		$this->render("gestUsuario", 'admin');
		
	}
	
	public function deleteUsuario($idUsuario= null) {
		$this->loadModel('Usuarios');
		$this->Usuarios->id = $idUsuario;
		$this->loadModel('EmpresaUsuario');

		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->Usuarios->exists()) {
			throw new NotFoundException(__('Invalid Usuario'));
		}
		
		
		$resultado =$this->EmpresaUsuario->find("all", array('conditions'=>'idUsuario='.$idUsuario));
		if(count( $resultado) > 0){
			foreach( $resultado as $empresaUsuario){
				$this->deleteEmpresasUsuariosId($empresaUsuario['EmpresaUsuario']['id']);
			}
		}
		
		$resultado = $this->Usuarios->find('all',array('conditions'=>'id = '.$idUsuario));
		if ($resultado == 0) {
			$this->Session->setFlash(__('El usuario no existe.'));
		}else{
			if ($this->Usuarios->delete()){
				$this->Session->setFlash(__('El usuario ha sido eliminado correctamente.'));
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('El usuario no ha podido ser eliminado.'));
			}
		}
	}
	
	public function listadoEmpresas(){
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		
		$options['fields'] = array(
				'Empresa.idEmpresa','Empresa.nombre','count(distinct lista.idLista) listas', 'count(distinct dispositivo.idDispositivo) dispositivos',
				 'count(distinct video.idVideo) videos','count(distinct empresaUsuario.idUsuario) usuarios','count(distinct agencia.id)agencias'
				);
		$options['group'] = array('Empresa.idEmpresa');
		$options['joins'] = array(
				array('table' => 'dispositivo',
						'type' => 'left',
						'conditions' => array(
								'dispositivo.idEmpresa = Empresa.idEmpresa',
						)
				),
				array('table'=>'video',
						'type' => 'left',
						'conditions' => array(
								'video.idEmpresa = Empresa.idEmpresa'
						)
				),
				array('table' => 'lista',
						'type' => 'left',
						'conditions' => array(
								'lista.idEmpresa = Empresa.idEmpresa'
						)
				),
				array('table' => 'empresaUsuario',
						'type' => 'left',
						'conditions' => array(
								'empresaUsuario.idEmpresa = Empresa.idEmpresa'
						)
				),
				array('table' => 'agencia',
						'type' => 'left',
						'conditions' => array(
								'agencia.idCliente = Empresa.idEmpresa'
						)
				)
		);
		$options['order'] = ('Empresa.idEmpresa');
		$empresas = $empresaC->Empresa->find("all", $options);
		$this->set('empresas',$empresas);
		$this->render('listadoEmpresas', 'admin');
	}
	
	public function deleteEmpresa($id = null){
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$empresaC->Empresa->id = $id;
	
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$resultado = $empresaC->Empresa->find('all',array('conditions'=>'idEmpresa = '.$id));
		if ($resultado == 0) {
			$this->Session->setFlash(__('La empresa no existe..'));
		}else{
			if ($empresaC->Empresa->delete()){
				$this->Session->setFlash(__('La empresa ha sido dada de baja correctamente.'));
				$this->redirect(array('action' => 'listadoEmpresas'));
			}else{
				$this->Session->setFlash(__('La empresa no ha podido ser dada de baja.'));
			}
		}
	}
	
	public function asignarUsuario($id = null){
		$userC = new UsersController();
		$userC->constructClasses();
 		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$empresaC->Empresa->id = $id;
		
		$options['fields'] = array('User.id','User.username');
		$options['conditions'] = array("User.id NOT IN (SELECT `empresaUsuario`.`idUsuario` FROM `empresaUsuario` WHERE `empresaUsuario`.`idempresa`= '".$id."')");
		$options['order'] = ('User.id');
		//$result = $eUsuariosC->EmpresaUsuario->find('all',array("EmpresaUsuario.idUsuario= '".$id."'"));
		/*if (count($resultado !=0)){
		 $this->redirect(array('action' => 'listadoUsuarios'));
		}*/
		$resultado = $userC->User->find('all',$options);
		$users = $resultado;
		$this->set('users',$resultado);
		$resultado2 = $empresaC->Empresa->find('all',array('conditions'=>'idEmpresa = '.$id));
		$this->set('empresa',$resultado2);
		$this->render('asignarUsuario', 'admin');
	}
	
	public function asignarUsuarioEmpresa($idUsuario = null,$idEmpresa = null){
		$eUsuariosC = new EmpresaUsuariosController();
		$eUsuariosC->constructClasses();

		if ($this->request->is('post')) {
			
			$resultado = $eUsuariosC->EmpresaUsuario->find("all", array('conditions' => "idUsuario = '".$idUsuario."' and idEmpresa ='".$idEmpresa."'"));
			if(count($resultado) == 0){
				$this->request->data['EmpresaUsuario']['idUsuario'] = $idUsuario;
				$this->request->data['EmpresaUsuario']['idEmpresa'] = $idEmpresa;
				$this->request->data['EmpresaUsuario']['perfil'] = '2';
				$this->request->data['EmpresaUsuario']['activo'] = '1';
				if ($eUsuariosC->EmpresaUsuario->save($this->request->data)) {
					$resultado = $eUsuariosC->EmpresaUsuario->find("all", array('conditions' => "idUsuario = '".$idUsuario."' and idEmpresa ='".$idEmpresa."'"));
					if(count($resultado) > 0){
						$id = $resultado[0]['EmpresaUsuario']['idUsuario'];
	
						$this->Session->setFlash(__('El usuario ha sido asignado a la empresa.'));
						$this->redirect(array('action' => 'listadoUsuariosEmpresa',$idEmpresa));
					}else{
						$this->Session->setFlash(__('El usuario no ha podido asignarse. Por favor, intentalo de nuevo.'));
					}
				} else {
					$this->Session->setFlash(__('El usuario no ha podido asignarse. Por favor, intentalo de nuevo.'));
				}
			}else{
				$this->Session->setFlash(__('El usuario ya esta asignado a la empresa.'),'error');
				//$this->redirect(array('action' => '../Adm/addUsuario'));
			}
			
		}
		$this->redirect($this->referer());
		$this->render("asignarUsuario", 'admin');
	}
	
	public function listadoUsuariosEmpresa($id = null){
		$userC = new UsersController();
		$userC->constructClasses();
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$empresaC->Empresa->id = $id;
		
		$options['fields'] = array('User.id','User.username','empresaUsuario.id');
		$options['conditions'] = array("empresaUsuario.idEmpresa = '".$id."'");
		$options['joins'] = array(
				array('table' => 'empresaUsuario',
						'type' => 'left',
						'conditions' => array(
								'empresaUsuario.idUsuario = User.id',
									
						)
				)
		);
		$options['order'] = ('User.id');
		//$result = $eUsuariosC->EmpresaUsuario->find('all',array("EmpresaUsuario.idUsuario= '".$id."'"));
		/*if (count($resultado !=0)){
		 $this->redirect(array('action' => 'listadoUsuarios'));
		}*/
		$resultado = $userC->User->find('all',$options);
		$users = $resultado;
		$this->set('users',$resultado);
		$resultado2 = $empresaC->Empresa->find('all',array('conditions'=>'idEmpresa = '.$id));
		$this->set('empresa',$resultado2);
		$this->render('listadousuariosempresa', 'admin');
		
	}
	
	public function listadoVideos($idEmpresa = null){
		$this->loadModel('Video');
		if($this->request->is('post') && $this->request->data['chk_empresa'] != 0){
			$idEmpresa = $this->request->data['chk_empresa'];
		}
		if(!is_null($idEmpresa)){
			$options['conditions'] = array("Video.idEmpresa = '".$idEmpresa."'");
		} 
		$options['fields'] = array('listaVideo.id','idVideo','listaVideo.posicion','descripcion','timestamp','fotograma','url','name','mute','time','estado','idEmpresa','count(distinct listaVideo.idLista) listas', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
		$options['group'] = array('Video.idVideo');
		$options['joins'] = array(
				array('table' => 'listaVideo',		
						'type' => 'left',
						'conditions' => array(
								'Video.idVideo = listaVideo.idVideo',		
						)
				),
				array('table' => 'listaDispositivo',
						'type' => 'left',
						'conditions' => array(
								'listaVideo.idLista = listaDispositivo.idLista'
						)
				)
		);
		$videos = $this->Video->find("all", $options);
		$this->set('videos', $videos);

		$this->loadModel('Empresa');
		$empresas = $this->Empresa->find("all");
		$this->set('empresas', $empresas);

		if (!is_null($idEmpresa)){
			$optionsL['conditions'] = array("idEmpresa = ".$idEmpresa);
			$empresa = $this->Empresa->find("all", $optionsL);
			$this->set('empresaC', $empresa);
		}else{
			$empresa[0]['Empresa']['idEmpresa'] = '0';
			$this->set('empresaC', $empresa);
		}

	}
	
	public function addVideoImagen(){
		$this->loadModel('Video');
		$this->loadModel('Empresa');
		$this->set('empresas',$this->Empresa->find('all'));
		$this->render('addVideoImagen','empty');
	}
	
	public function add(){
		$this->loadModel('Video');
		$this->Video->create();
		if(array_key_exists('Document', $this->data['Video'])){
			$this->request->data['Video']['estado'] = 'sin procesar';
			if ($this->Video->save($this->request->data)) {
				return true;
			}
		}else{
			$this->Session->setFlash(__('El fichero no se ha añadido, es posible que sea demasiado grande.'), 'info');
			$this->redirect(array('action' => 'addVideoImagen'));
		}
		
	}
	public function addVideo() {
		$videosC = new VideosController();
		$videosC->constructClasses();
		if ($this->request->is('post')) {
			if($this->add()){	
				$fileOK = $videosC->uploadVideo('img/files', $this->request->data['Video']['Document']);
				if(!is_null($fileOK) && (( !array_key_exists("errors", $fileOK)) || (count( $fileOK['errors'] ) == 0 ))){
					$auth = $this->Session->read("Auth");
					$this->request->data['Video']['name'] = $fileOK['name'];
					if(array_key_exists('S3URL', $fileOK) && $fileOK[ 'S3URL' ] != ""){
						$this->request->data['Video'][ 'url' ] = str_replace( '.'.$fileOK[ 'rutas' ][ 'extension' ], '', $fileOK[ 'S3URL' ] );
					}else{
						$this->request->data['Video'][ 'url' ] = json_encode( array( 'orig' => FULL_BASE_URL.DIRECTORIO.'/'.$fileOK['rutas']['URLArchivo'] ) );
					}
					$this->request->data['Video']['fotograma'] = str_replace("img/","",$fileOK['rutas']['fotograma']);
					$this->request->data['Video']['estado'] = 'sin procesar';
					$this->request->data['Video']['timestamp'] = DboSource::expression('NOW()');
					$this->request->data['Video']['idUsuario'] = $auth['User']['id'];
					$this->request->data['Video']['tipo'] = "video";
					$this->request->data['Video']['time'] = $this->request->data['Video']['tiempo'];
					
					CakeLog::write("Comando", "url del fotograma: ".$this->request->data['Video']['fotograma']);
		
					if ($videosC->Video->save($this->request->data)) {
						$video = $videosC->Video->read(null, null);
						$videosC->processVideo(
							$video['Video']['idVideo'],
							'crt_mp4',
							"http://".HOST.DIRECTORIO."/videos/updateVideoJsonPlusHTML5/".$video['Video']['idVideo']
						);
						CakeLog::write('debug','El fichero con nombre '.$this->request->data['Video']['Document']['name'].' ha sido almacenado con el id: '.$videosC->Video->id);
						$this->Session->setFlash(__('El video ha llegado correctamente, va ser procesado por nuestros servidores.'), 'info');
						return new 	CakeResponse(array('body' => json_encode( $video) ) );
			
					} else {
						$this->Session->setFlash(__('El video no ha podido guardarse. Por favor, intentalo de nuevo.'));
						$this->redirect(array('action' => 'addVideoImagen'));
					}
		
				}else{
					$this->redirect(array('action' => 'addVideoImagen'));
				}
			}
		}
	}
	
	public function addImagen(){
		$videosC = new VideosController();
		$videosC->constructClasses();
		if ($this->request->is('post')){
			if($this->add()){
				$fileOK = $videosC->uploadImagen('img/files', $this->request->data['Video']['Document']);
				if(!is_null($fileOK) && (( !array_key_exists("errors", $fileOK)) || (count( $fileOK['errors'] ) == 0 ))){
					$this->request->data['Video']['name'] = $fileOK['name'];
					$this->request->data['Video'][ 'url' ] = json_encode( array( "img" => FULL_BASE_URL.DIRECTORIO.'/'.$fileOK['rutas']['URLArchivo']  ) );
					$this->request->data['Video']['fotograma'] = str_replace("img/","",$fileOK['rutas']['fotograma']);
					$this->request->data['Video']['time'] = $this->request->data['Video']['tiempo'];
					$this->request->data['Video']['estado'] = 'sin procesar';
					$this->request->data['Video']['timestamp'] = DboSource::expression('NOW()');
					$this->request->data['Video']['tipo'] = "imagen";
					if( $videosC->Video->save( $this->request->data ) ){
						$video = $videosC->Video->read(null, null);
						$videosC->processImage(
							$video['Video']['idVideo'],
							'crt_image'
						);
						$videosC->processImage(
							$video['Video']['idVideo'],
							'crt_image_max',
							array('h' =>90, 'w' => 160),
							"http://".HOST.DIRECTORIO."/videos/updateFotogramaJson/".$video['Video']['idVideo']
						);
						return new 	CakeResponse(array('body' => json_encode( $video) ) );
					}else{
						$this->Session->setFlash(__('La imagen no ha sido guardada, prueba de nuevo.'));
						$this->redirect(array('action' => 'addVideoImagen'));
					}
				}else{
					$this->redirect(array('action' => 'addVideoImagen'));
				}
			}
		}
		/*$this->loadModel('Video');
		if ($this->request->is('post')) {
			if($this->add()){
				$fileOK = $videosC->uploadImagen('img/files', $this->request->data['Video']['Document'], $this->request->data['Video']['tiempo']);
					
				if(!is_null($fileOK) && (( !array_key_exists("errors", $fileOK)) || (count( $fileOK['errors'] ) == 0 ))){
					//CakeLog::write("Comando", "url del fotograma: ".print_r($fileOK));
					$this->request->data['Video']['name'] = $fileOK['name'];
					$this->request->data['Video'][ 'url' ] = $fileOK[ 'urls' ][0];
					$this->request->data['Video']['fotograma'] = $fileOK['fotograma'];
					$this->request->data['Video']['timestamp'] = DboSource::expression('NOW()');
					
					//$this->request->data['Video']['']
					CakeLog::write("Comando", "url del fotograma: ".$this->request->data['Video']['fotograma']);
	
					if ($this->Video->save($this->request->data)) {
						//$this->Session->setFlash(__('The video has been saved'), 'info');
	
						CakeLog::write('debug','El fichero con nombre '.$this->request->data['Video']['Document']['name'].' ha sido almacenado con el id: '.$this->Video->id);
						$this->redirect(array('action' => 'listadoVideos'));
					} else {
						$this->Session->setFlash(__('La imagen no ha podido guardarse. Por favor, intentalo de nuevo.'));
						$this->redirect(array('action' => 'addVideoImagen'));
					}
	
				}else{
					//$this->Session->setFlash(__('Este formato de video no está soportado'));
					$this->redirect(array('action' => 'addVideoImagen'));
				}
			}
		}*/
	}
	
	public function editarVideo($idVideo = null, $orientacion = "Horizontal"){
		$videosC = new VideosController();
		$videosC->constructClasses();
		$videosC->Video->id = $idVideo;
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$resultado = $videosC->Video->find("all", array('conditions'=> 'idVideo = '.$idVideo));
		if(count($resultado) == 0){
			throw new NotFoundException(__('Invalid video'));
		}
		
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($videosC->Video->save($this->request->data) == True )  {
				$this->LoadModel('ListaVideo');
						
				$idEmpresa = $this->request->data['Video']['idEmpresa'];
				
				$options['fields'] = array('ListaVideo.id');
				$options['conditions'] = array("ListaVideo.idVideo = '".$idVideo."' and lista.idEmpresa <> '".$idEmpresa."'");
				$options['joins'] = array(
						array('table' => 'lista',
								'type' => 'left',
								'conditions' => array(
										'ListaVideo.idLista = lista.idLista'
								)
						)
				);
				$resultado = $this->ListaVideo->find("all", $options);
				if(count( $resultado) > 0){
					foreach( $resultado as $listaVideo){
						$idListaVideo = $listaVideo['ListaVideo']['id'];
						$resultado2 = $this->ListaVideo->find('all',array('conditions'=>'id = '.$idListaVideo));
						if ($resultado2 > 0) {
							$this->ListaVideo->id = $idListaVideo;
							$this->ListaVideo->delete();
						}
					}
				}
				
				$this->Session->setFlash(__('Los datos han sido actualizados.'));
				$this->redirect(array('controller'=>'adm','action' => 'listadoVideos'));
				
				
			} else {
				$this->Session->setFlash(__('Los datos no han podido guardarse. Por favor, intentalo de nuevo.'),'error');
			}
		}
		$this->set('empresas',$empresaC->Empresa->find('all',array('order' => 'nombre')));
		
		$resultado = $videosC->Video->read(null, $idVideo);
		$formatos = json_decode($resultado['Video']['url'],1);
		$parametros = array(
			'time' 			=> $resultado['Video']['time'],
			'orientacion' 	=> $orientacion,
			'size'			=> '720x1080'	
		);
		$resultado['Video']['formatos'] = $videosC->getVideoUrl($formatos, $parametros, $resultado['Video']['tipo']);
		$this->set('video', $resultado);
		$this->render("editarVideo", 'popup');		
	}

	public function revisarVideoEmpresa($idVideo = null,$idEmpresa = null){
		$this->LoadModel('ListaVideo');
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$options['fields'] = array('ListaVideo.id');
		$options['conditions'] = array("ListaVideo.idVideo = '".$idVideo."' and lista.idEmpresa <> '".$idEmpresa."'");
		$options['joins'] = array(
				array('table' => 'lista',
						'type' => 'left',
						'conditions' => array(
								'ListaVideo.idLista = lista.idLista'
						)
				)
		);
		$resultado = $this->ListaVideo->find("all", $options);
		if(count( $resultado) > 0){
			foreach( $resultado as $listaVideo){
				$this->deleteListaVideoIdLista($listaVideo['ListaVideo']['id']);
			}
		}
		
		//$this->redirect(array('controller'=>'adm','action' => 'listadoVideos'));
	}
	
	public function deleteVideo($idVideo = null){
		$videosC = new VideosController();
		$videosC->constructClasses();
		$videosC->Video->id = $idVideo;
		$listavC = new ListaVideosController();
		$listavC->constructClasses();
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		if (!$videosC->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		$videosC->Video->read();
		
		$videosC->eliminarArchivo( $videosC->Video->data['Video']['url'] );
		$videosC->eliminarArchivo( 'img/'.$videosC->Video->data['Video']['fotograma']);
		if ($videosC->Video->delete()) {
			$listavC->ListaVideo->deleteAll('ListaVideo.idVideo = '.$idVideo);
			
			$this->Session->setFlash(__('El video ha sido eliminado correctamente.'), 'info');
			$this->redirect(array('action'=>'listadoVideos'));
		}
		$this->Session->setFlash(__('El video no ha sido eliminado.Por favor, inténtalo de nuevo'));
		$this->redirect(array('action' => 'listadoVideos'));
	}
	
	public function allVideos(){
			$videosC = new VideosController();
			$videosC->constructClasses();
				
			$options['fields'] = array('listaVideo.id','idVideo','listaVideo.posicion','descripcion','fotograma','url','name','mute','time','count(distinct listaVideo.idLista) listas', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
			$options['group'] = array('video.idVideo');
			
			//$options['conditions'] = array("Video.idEmpresa = '".$idEmpresa."'");
			$options['joins'] = array(
			
					array('table' => 'listaVideo',
			
							'type' => 'left',
							'conditions' => array(
									'video.idVideo = listaVideo.idVideo',
			
							)
					),
					array('table' => 'listaDispositivo',
			
							'type' => 'left',
							'conditions' => array(
									'listaVideo.idLista = listaDispositivo.idLista'
							)
					)
			);
			$videos = $videosC->Video->find("all", $options);
			$this->set('videos', $videos);
			//$this->set('lista', $idLista);
			$this->render('todosVideos', 'admin');
			
		
	}
	
	public function addEmpresa(){
		$empresasC = new EmpresasController();
		$empresasC->constructClasses();
		if ($this->request->is('post')) {
			if (Trim($this->request->data['Empresa']['nombre'] != '')) {
				$resultado = $empresasC->Empresa->find("all", array('conditions' => "nombre = '".$this->request->data['Empresa']['nombre']."'"));
				if(count($resultado) == 0){
					$this->request->data['Empresa']['url'] = '';
					if ($empresasC->Empresa->save($this->request->data)) {
						$this->Session->setFlash(__('La empresa ha sido guardada.'));
						$this->redirect(array('action' => 'listadoempresas'));
					} else {
						$this->Session->setFlash(__('La empresa no ha podido guardarse. Por favor, intentalo de nuevo.'));
					}
				}else{	
					$this->Session->setFlash(__('La empresa ya existe.'),'error');
				}
			}else{
				$this->Session->setFlash('Debes introducir un nombre.', 'error');
			}
		}
		$this->render("addEmpresa", 'admin');	
	}
	
	public function gestEmpresa($idEmpresa){
		/*$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$empresa = $empresaC->Empresa->read(null,$idEmpresa);
		$this->set('empresa',$empresa);
		$this->render('gestEmpresa', 'admin');*/
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$empresaC->Empresa->id = $idEmpresa;
		//$empresaC = $empresaC->Empresa->read(null,$idEmpresa);
		$resultado = $empresaC->Empresa->find("all", array('conditions'=> "idEmpresa = '".$idEmpresa."'"));
		if(count($resultado) == 0){
		//if (!$empresaC->Empresa->exists()) {
			throw new NotFoundException(__('Invalid empresa'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$resultado = $empresaC->Empresa->find("all", array('conditions'=> "nombre = '".$this->data['Empresa']['nombre']."'"));
			if( count( $resultado ) == 0){
				if ($empresaC->Empresa->save($this->request->data)) {
					//$this->recargarEmrpesa();
					$this->Session->setFlash(__('Se han cambiado los datos de la empresa exitosamente.'), 'info');
					//$this->redirect(array('controller'=>'videos', 'action'=>'index'));
				} else {
					$this->Session->setFlash(__('Los datos no se han cambiado, prueba de nuevo'), 'error');
				}
			}else{
				$this->Session->setFlash( __("Ya existe una empresa con ese nombre."),'info');			}
		}
		$this->request->data = $empresaC->Empresa->read(null, $idEmpresa);
		$empresa = $empresaC->Empresa->read(null,$idEmpresa);
		$this->set('empresa',$empresa);
		$this->render("gestEmpresa", 'admin');
		
	}
	
	public function cambiarLogoEmpresa($idEmpresa = null){
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$empresaC->Empresa->id = $this->request->data['Empresa']['idEmpresa'];
		$fileOK = $empresaC->Empresa->uploadFiles('files', $this->request->data['Empresa']['Document']);
		$this->request->data['Empresa'][ 'url' ] = $fileOK[ 'urls' ][0];
		if ($empresaC->Empresa->save($this->request->data)) {
			$this->Session->setFlash(__('El logo ha sido cambiado'),'info');
			//$this->recargarEmrpesa();
			$this->redirect(array('controller'=>'adm', 'action' => 'gestEmpresa',$idEmpresa));
		} else {
			$this->Session->setFlash(__('El logo no se ha podido guardar correctamente', 'error'));
			$this->redirect($this->referer());		
		}
	}
	
	public function listadoDispositivos(){
		$this->loadModel('Dispositivo');
		
		$this->Dispositivo->recursive = -1;
		$options['fields'] = array('idDispositivo','descripcion','play','mute','timestamp','caducidad','count(listaDispositivo.idLista) listas','empresa.nombre');
		$options['group'] = array("Dispositivo.idDispositivo");
		$options['joins'] = array(
				array('table' => 'listaDispositivo',
						//'alias' => 'listad',
						'type' => 'LEFT',
						'conditions' => array(
								'Dispositivo.idDispositivo = listaDispositivo.idDispositivo',
						)
				),
				array('table' => 'empresa',
						'type' => 'LEFT',
						'conditions' => array(
								'Dispositivo.idEmpresa = empresa.idEmpresa',
						)
				)
		);
		$this->Dispositivo->recursive = 0;
		$this->set('dispositivos', $this->Dispositivo->find('all',$options));
		$this->render('listadoDispositivos', 'admin');
	}
	
	public function listadodispositivosempresa($id = null){
		$dispositivoC = new DispositivosController();
		$dispositivoC->ConstructClasses();
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$empresaC->Empresa->id = $id;
	
		$options['fields'] = array('Dispositivo.idDispositivo','Dispositivo.descripcion','Dispositivo.idEmpresa');
		$options['conditions'] = array("Dispositivo.idEmpresa = '".$id."'");
		$options['order'] = ('Dispositivo.idDispositivo');
		$resultado = $dispositivoC->Dispositivo->find('all',$options);
		
		$this->set('dispositivos',$resultado);
		$resultado2 = $empresaC->Empresa->find('all',array('conditions'=>'idEmpresa = '.$id));
		$this->set('empresa',$resultado2);
		$this->render('listadodispositivosempresa', 'admin');
	}
	
	public function deleteDispositivosEmpresas($idDispositivo = null){
		$this->loadModel('ListaDispositivo');
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$dispositivoC->Dispositivo->id = $idDispositivo;
	
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$resultado =$this->ListaDispositivo->find("all", array('conditions'=>"idDispositivo ='".$idDispositivo."'"));
		if(count( $resultado) > 0){
			foreach( $resultado as $listaDispositivo){
				$this->deleteListaDispositivoIdLista($listaDispositivo['ListaDispositivo']['id']);
			}
		}
		
		$resultado = $dispositivoC->Dispositivo->find('all',array('conditions'=>"idDispositivo = '".$idDispositivo."'"));
		if ($resultado == 0) {
			$this->Session->setFlash(__('El dispositivo no existe.'));
		}else{
			$this->request->data['Dispositivo']['idEmpresa'] = '';
			if ($dispositivoC->Dispositivo->save($this->request->data)) {
			//if ($eUsuariosC->EmpresaUsuario->delete()){
				$this->Session->setFlash(__('El dispositivo ha sido desvinculado de la empresa.'),'info');
				//$this->redirect(array('action' => 'listadoEmpresasUsuarios'));
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('El dispositivo no ha podido ser desvinculado de la empresa.'));
			}
		}
	}
	
	public function asignarDispositivo($id = null){
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$empresaC->Empresa->id = $id;
	
		$options['fields'] = array('Dispositivo.idDispositivo','Dispositivo.descripcion','Dispositivo.idEmpresa');
		$options['conditions'] = array("Dispositivo.idEmpresa = 0");
		$options['order'] = array('Dispositivo.idDispositivo');
		
		$resultado = $dispositivoC->Dispositivo->find('all',$options);
		$this->set('dispositivos',$resultado);
		$resultado2 = $empresaC->Empresa->find('all',array('conditions'=>'idEmpresa = '.$id));
		$this->set('empresa',$resultado2);
		$this->render('asignarDispositivo', 'admin');
	}
	
	public function asignarDispositivoEmpresa($idDispositivo = null,$idEmpresa = null){
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$dispositivoC->Dispositivo->id = $idDispositivo;
	
		if ($this->request->is('post')) {
				
			$resultado = $dispositivoC->Dispositivo->find("all", array('conditions' => "idDispositivo = '".$idDispositivo."' and idEmpresa = 0 "));
			if(count($resultado) != 0){
				$this->request->data['Dispositivo']['idEmpresa'] = $idEmpresa;
				//$dispositivoC->Dispositivo->idEmpresa = $idEmpresa;
				if ($dispositivoC->Dispositivo->save($this->request->data)) {
					$resultado = $dispositivoC->Dispositivo->find("all", array('conditions' => "idDispositivo = '".$idDispositivo."' and idEmpresa =".$idEmpresa." "));
					if(count($resultado) > 0){
						$this->Session->setFlash(__('El dispositivo ha sido asignado a la empresa.','info'));
						$this->redirect(array('action' => 'asignarDispositivo',$idEmpresa));
					}else{
						$this->Session->setFlash(__('El dispositivo no ha podido asignarse. Por favor, intentalo de nuevo1.'));
					}
				} else {
					$this->Session->setFlash(__('El dispositivo no ha podido asignarse. Por favor, intentalo de nuevo2.'));
				}
			}else{
				$this->Session->setFlash(__('El dispositivo ya esta asignado a una empresa.'),'error');
				//$this->redirect(array('action' => '../Adm/addUsuario'));
			}
				
		}
		$this->redirect($this->referer());
		$this->render("asignarDispositivo", 'admin');
	}
	
	public function addReproductor(){
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$this->set('empresas',$empresaC->Empresa->find('all'));
		
		if ($this->request->is('post')) {
				if (Trim($this->request->data['Dispositivo']['idDispositivo'] != '') && Trim($this->request->data['Dispositivo']['descripcion'] != '') && Trim($this->request->data['Dispositivo']['idEmpresa'] != ''))  {
					$resultado = $dispositivoC->Dispositivo->find("all", array('conditions' => "idDispositivo = '".$this->request->data['Dispositivo']['idDispositivo']."'"));
					if(count($resultado) == 0){
						//$this->request->data['Dispositivo']['timestamp'] = time();
						$this->request->data['Dispositivo']['idCalendario'] = 0;
						$this->request->data['Dispositivo']['mute'] = 0;
						$this->request->data['Dispositivo']['disco'] = 0;
						$this->request->data['Dispositivo']['alto'] = 0;
						$this->request->data['Dispositivo']['ancho'] = 0;
						$this->request->data['Dispositivo']['play'] = 0;
						$this->request->data['Dispositivo']['timestamp'] = DboSource::expression('NOW()');
					
						$fCaducidad = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 1 month"));
						$this->request->data['Dispositivo']['caducidad'] = $fCaducidad;
						
						if ($dispositivoC->Dispositivo->save($this->request->data)) {
							$this->Session->setFlash(__('El dispositivo ha sido guardado.'));
							$this->redirect(array('action' => 'listadoDispositivos'));
						} else {
							$this->Session->setFlash(__('El dispositivo no ha podido guardarse. Por favor, intentalo de nuevo.'));
						}
					}else{
						$this->Session->setFlash(__('El dispositivo ya existe.'),'error');
					}
				}else{
					$this->Session->setFlash('Debes rellenar todos los campos.', 'error');
				}
			
		}
		$this->render("addReproductor", 'admin');	
	}
	
	public function editarReproductor($idDispositivo = null){
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$dispositivoC->Dispositivo->id = $idDispositivo;
		$reproductorsC = new ReproductorsController();
		$reproductorsC->constructClasses();
		$empresaC = new EmpresasController();
		$empresaC->constructClasses();
		$this->set('empresas',$empresaC->Empresa->find('all'));
		
		$resultado = $dispositivoC->Dispositivo->find("all", array('conditions'=> "idDispositivo = '".$idDispositivo."'"));
		if(count($resultado) == 0){
			throw new NotFoundException(__('Invalid empresa'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($dispositivoC->Dispositivo->save($this->request->data)) {
				/*if ($this->request->data['Dispositivo']['acepta_terceros'] == 0){
					$reproductorsC->removeListasTerceros($idDispositivo);
				}*/
				$this->Session->setFlash(__('Los datos han sido actualizados.'), 'info');
				$this->redirect(array('controller'=>'adm','action' => 'listadoDispositivos'));
			} else {
				$this->Session->setFlash(__('Los datos no han podido guardarse. Por favor, intentalo de nuevo.'));
			}
		}
		$this->request->data = $dispositivoC->Dispositivo->read(null, $idDispositivo);
		$this->set('dispositivos',$dispositivoC->Dispositivo->read(null,$idDispositivo));

		$this->render("editarReproductor", 'admin');
	}

	public function desvincularReproductor($idDispositivo = null){
		$this->loadModel('Dispositivo');
		$this->Dispositivo->id = $idDispositivo;
		$this->loadModel('ListaDispositivo');
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->Dispositivo->exists()) {
			throw new NotFoundException(__('Invalid dispositivo'));
		}
		
		
		$resultado =$this->ListaDispositivo->find("all", array('conditions'=>"idDispositivo ='".$idDispositivo."'"));
		if(count( $resultado) > 0){
			foreach( $resultado as $listaDispositivo){
				$this->deleteListaDispositivoIdLista($listaDispositivo['ListaDispositivo']['id']);
			}
		}
		
		
		$this->request->data['Dispositivo']['idEmpresa'] = 0;
				
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Dispositivo->save($this->request->data)) {
				$this->Session->setFlash(__('El dispositivo ha sido desvinculado de la empresa.'), 'info');
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('El dispositivo no ha podido ser desvinculado de la empresa. Por favor, intentalo de nuevo.'));
			}
		}
	}
	
	public function deleteReproductor($idDispositivo = null) {
		$this->loadModel('Dispositivo');
		$this->Dispositivo->id = $idDispositivo;
		$this->loadModel('ListaDispositivo');

		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->Dispositivo->exists()) {
			throw new NotFoundException(__('Invalid dispositivo'));
		}
		
		$resultado =$this->ListaDispositivo->find("all", array('conditions'=>"idDispositivo ='".$idDispositivo."'"));
		if(count( $resultado) > 0){
			foreach( $resultado as $listaDispositivo){
				$this->deleteListaDispositivoIdLista($listaDispositivo['ListaDispositivo']['id']);
			}
		}
		
		$resultado = $this->Dispositivo->find('all',array('conditions'=>"idDispositivo = '".$idDispositivo."'"));
		if ($resultado == 0) {
			$this->Session->setFlash(__('El dispositivo no existe.'));
		}else{
			if ($this->Dispositivo->delete()){
				$this->Session->setFlash(__('El dispositivo ha sido eliminado correctamente.'));
				//$this->redirect(array('action' => 'listadoEmpresasUsuarios'));
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('El dispositivo no ha podido ser eliminado.'));
			}
		}
	}
	
	public function listadoListasDispositivo($idDispositivo = null){
		$dispositivoC = new DispositivosController();
		$dispositivoC->ConstructClasses();
		$dispositivoC->Dispositivo->id = $idDispositivo;
		$dispositivoC->loadModel('Listum');
		//$listaDispositivoC = new ListaDispositivosController();
		
		$optionsL['fields'] = array('listaDispositivo.activa', 'Listum.idLista', 'listaDispositivo.idDispositivo', 'Listum.descripcion', 'listaDispositivo.id','Listum.mute','listaDispositivo.tipo_relacion','count(distinct listaVideo.id) videos');
		$optionsL['conditions'] = array("listaDispositivo.idDispositivo = '".$idDispositivo."'");
		$optionsL['group'] = array('listaDispositivo.id');
		$optionsL['joins'] = array(
	
				array('table' => 'listaDispositivo',
	
						'type' => 'left',
						'conditions' => array(
								'Listum.idLista = listaDispositivo.idLista'
						)
				),
				array('table' => 'listaVideo',
							
						'type' => 'left',
						'conditions' => array(
								'listaVideo.idLista = Listum.idLista'
						)
				)
					
		);
		$listas = $dispositivoC->Listum->find("all", $optionsL);
		$this->set('listas', $listas);
	
	
		$dispositivoC->Dispositivo->id = $idDispositivo;
		if (!$dispositivoC->Dispositivo->exists()) {
			throw new NotFoundException(__('Dispositivo inválido.'));
		}
		$this->set('dispositivo', $dispositivoC->Dispositivo->read(null, $idDispositivo));
		
		//$resultado = $empresaC->Empresa->find('all',array('conditions'=>'idEmpresa = '.$id));
		//$this->set('empresa',$resultado2);
		$this->render('listadoListasDispositivo', 'admin');
	}
	
	public function addLista($idDispositivo = null) {
		$listadC = new ListaDispositivosController();
		$listadC->constructClasses();
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$dispositivoC->Dispositivo->id = $idDispositivo;
		$dispositivoC->loadModel('Listum');
		$resultado = $dispositivoC->Dispositivo->find('all',array('conditions'=>"idDispositivo = '".$idDispositivo."'"));
		$this->set('dispositivos',$resultado);
		
		if ($this->request->is('post')) {
			$listadC->ListaDispositivo->create();
			if (Trim($this->request->data['Listum']['descripcion'] != '')) {
				//$idLista = $this->request->data['listaDispositivo']['idLista'];
				$this->request->data['Listum']['idEmpresa'] = $resultado[0]['Dispositivo']['idEmpresa'];
				$this->request->data['Listum']['mute'] = 0;
				$this->request->data['Listum']['timestamp'] = DboSource::expression('NOW()');
				if ($dispositivoC->Listum->save($this->request->data)) {
					$user = $this->Session->read('Auth');
					$this->request->data['ListaDispositivo']['idLista'] = $dispositivoC->Listum->id;
					$this->request->data['ListaDispositivo']['idUsuario'] = $user['User']['id'];
					$this->request->data['ListaDispositivo']['idDispositivo'] = $idDispositivo;
					$this->request->data['ListaDispositivo']['activa'] = 0;
					$this->request->data['ListaDispositivo']['timestamp'] = $dispositivoC->Listum->timestamp;
					if ($listadC->ListaDispositivo->save($this->request->data)) {
						$this->Session->setFlash(__('La lista se ha creado y asignado.'),'info');
						$this->redirect(array('action' => 'listadoListasDispositivo',$idDispositivo));
					}else{
						$this->Session->setFlash(__('La lista no ha podido asignarse. Por favor, intentalo de nuevo.'));
					}				
				}else{
					$this->Session->setFlash(__('La lista no ha podido crearse. Por favor, intentalo de nuevo.'));
				}
			}else{
				$this->Session->setFlash('Debes introducir un nombre.', 'error');
			}		
		}
		$this->render("addLista", 'admin');
		
	}	

	public function asignarLista($idDispositivo = null){
		$this->loadModel('Dispositivo');
		$this->Dispositivo->id = $idDispositivo;
		$this->loadModel('ListaDispositivo');
		$this->loadModel('Listum');
		
		$resultado = $this->Dispositivo->read(null,$idDispositivo);
		$this->set('tercerosDispositivo',$resultado['Dispositivo']['acepta_terceros']);
		$resultado3 = $this->ListaDispositivo->find('all',array('conditions'=>'idDispositivo = '.$idDispositivo." and tipo_relacion = 'terceros'"));
		$this->set('tercerosLista',count($resultado3));

		$options['fields'] = array('idLista','descripcion');
		$options['conditions'] = array("idEmpresa = '".$resultado['Dispositivo']['idEmpresa']."'");/*' and idLista NOT IN (SELECT `ListaDispositivo`.`idLista` FROM `ListaDispositivo` WHERE `listaDispositivo`.`idEmpresa`= '".$resultado['Dispositivo']['idEmpresa']."')");*/
		$options['order'] = ('idLista');
		
		$resultado2 = $this->Listum->find('all',$options);
		
		$this->set('listas',$resultado2);
		$this->set('dispositivo',$resultado);
		$this->render('asignarLista', 'admin');
		
	}
	
	public function asignarListaDispositivo(){
		$this->loadModel('ListaDispositivo');
		
		if ($this->request->is('post')) {
			$user = $this->Session->read('Auth');
			
			$this->request->data['ListaDispositivo']['idLista'] = $this->request->data['idLista'];
			$this->request->data['ListaDispositivo']['idDispositivo'] = $this->request->data['idDispositivo'];
			$this->request->data['ListaDispositivo']['idUsuario'] = $user['User']['id'];
			$this->request->data['ListaDispositivo']['activa'] = '0';
			switch($this->request->data['tipoLista']) {
				case 0:
					$this->request->data['ListaDispositivo']['tipo_relacion'] = 'basica';
					break;
				case 1:
					$this->request->data['ListaDispositivo']['tipo_relacion'] = 'terceros';
					break;
				default:
					CakeLog::write('debug', "Se ha generado una ListaDispositivo con tipoLista nulo.");
					$this->request->data['ListaDispositivo']['tipo_relacion'] = 'basica';
					break;
			}
			if ($this->ListaDispositivo->save($this->request->data)) {
				$this->Session->setFlash(__('La lista ha sido asignada al dispositivo.'),'info');
				return new CakeResponse( array( 'body' => json_encode(array('status'=>true) ) ) );
				//$this->redirect(array('action' => 'listadolistasdispositivo',$idDispositivo));
			} else {
				$this->Session->setFlash(__('La lista no ha podido asignarse. Por favor, intentalo de nuevo.'));
				return new CakeResponse( array( 'body' => json_encode(array('status'=>false) ) ) );
			}
			
		}
		//$this->redirect($this->referer());
		$this->render("asignarLista", 'admin');
		
	}
	
	public function desvincularListaDispositivo($id = null,$idDispositivo = null){
		$this->loadModel('ListaDispositivo');
		$this->ListaDispositivo->id = $id;
			
		if($this->request->is("POST")){
			$resultado = $this->ListaDispositivo->find('all',array('conditions'=>'id = '.$id));
			if ($resultado == 0) {
				$this->Session->setFlash(__('La listaDispositivo no existe.'));
			}else{
				if ($this->ListaDispositivo->delete()){
					$this->Session->setFlash(__('Se ha desvinculado correctamente.'),'info');
					$this->redirect(array('action' => 'listadolistasdispositivo',$idDispositivo));	
				}else{
					$this->Session->setFlash(__('No se ha podido desvincular.'));
				}
			}
			
			//$this->redirect(array('action'=>'view',$idDispositivo));
		}
	}
		
	
	public function listadoVideosLista($idLista = null,$idDispositivo = null){
		$videosC = new VideosController();
		$videosC->ConstructClasses();
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$dispositivoC->Dispositivo->id = $idDispositivo;
		$dispositivoC->loadModel('Listum');
		if($this->request->is('post') && $this->request->data['chk_llista'] != 0){
			$idLista = $this->request->data['chk_llista'];
		}	
			$optionsL['fields'] = array('Listum.idLista', 'listaDispositivo.idDispositivo', 'Listum.descripcion', 'listaDispositivo.id');
			$optionsL['conditions'] = array("listaDispositivo.idDispositivo = '".$idDispositivo."' and listaDispositivo.idLista =".$idLista);
			$optionsL['group'] = array('listaDispositivo.id');
			$optionsL['joins'] = array(
					array('table' => 'listaDispositivo',
			
							'type' => 'left',
							'conditions' => array(
									'Listum.idLista = listaDispositivo.idLista'
							)
					)
			);
			$listas = $dispositivoC->Listum->find("all", $optionsL);
			$this->set('listas', $listas);
		
			$options['fields'] = array('listaVideo.id','listaVideo.posicion','idVideo','fotograma','descripcion','url','name','mute','time','estado','count(distinct lv.idLista) listas', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
			$options['group'] = array('listaVideo.id');
			$options['order'] = array('listaVideo.posicion');
			$options['conditions'] = array("listaVideo.idLista =".$idLista );
			$options['joins'] = array(
					array('table' => 'listaVideo',
							'type' => 'left',
							'conditions' => array(
									'Video.idVideo = listaVideo.idVideo',
							)
					),
					array('table' => 'listaDispositivo',
							'type' => 'left',
							'conditions' => array(
									'listaVideo.idLista = listaDispositivo.idLista'
							)
					),
					array('table' => 'lista',
							'type' => 'left',
							'conditions' => array(
									'listaVideo.idLista = lista.idLista'
							)
					),
					array('table' => 'listaVideo',
							'alias' => 'lv',
							'type' => 'left',
							'conditions' => array(
									'listaVideo.idVideo = lv.idVideo'
							)
					)
			);
			$videos = $videosC->Video->find("all", $options);
			$this->set('videos', $videos);
			$dispositivos = $dispositivoC->Dispositivo->find("all",array('conditions' => "idDispositivo='".$idDispositivo."'"));
			$this->set('dispositivos',$dispositivos);
			$this->render('listadoVideosLista', 'admin');
	}
	
	public function deleteListaIdReproductor($idDispositivo = null,$idLista = null) {
		$this->LoadModel('Listum');
		$this->Listum->id = $idLista;
		$this->LoadModel('ListaVideo');
		$this->LoadModel('ListaDispositivo');
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->Listum->exists()) {
			throw new NotFoundException(__('Invalid Lista'));
		}
		$resultado =$this->ListaVideo->find("all", array('conditions'=>'idLista ='.$idLista));
		if(count( $resultado) > 0){
			foreach( $resultado as $listaVideo){
				$this->deleteListaVideoIdLista($listaVideo['ListaVideo']['id']);
			}
		}
		$resultado =$this->ListaDispositivo->find("all", array('conditions'=>'idLista ='.$idLista));
		if(count( $resultado) > 0){
			foreach( $resultado as $listaDispositivo){
				$this->deleteListaDispositivoIdLista($listaDispositivo['ListaDispositivo']['id']);
			}
		}
		$resultado = $this->Listum->find('all',array('conditions'=>'idLista = '.$idLista));
		if ($resultado == 0) {
			$this->Session->setFlash(__('La lista no existe.'));
		}else{
			if ($this->Listum->delete()){
				$this->Session->setFlash(__('La lista ha sido eliminada correctamente.'));
				//$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('La lista no ha podido ser eliminada.'));
				//$this->redirect($this->referer());
			}
		}
		
	}
	
	public function deleteLista($idDispositivo = null,$idLista = null) {
		$this->LoadModel('Listum');
		$this->Listum->id = $idLista;
		$this->LoadModel('ListaVideo');
		$this->LoadModel('ListaDispositivo');
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->Listum->exists()) {
			throw new NotFoundException(__('Invalid Lista'));
		}
		$resultado =$this->ListaVideo->find("all", array('conditions'=>'idLista ='.$idLista));
		if(count( $resultado) > 0){
			foreach( $resultado as $listaVideo){
				$this->deleteListaVideoIdLista($listaVideo['ListaVideo']['id']);
			}
		}
		$resultado =$this->ListaDispositivo->find("all", array('conditions'=>'idLista ='.$idLista));
		if(count( $resultado) > 0){
		foreach( $resultado as $listaDispositivo){
				$this->deleteListaDispositivoIdLista($listaDispositivo['ListaDispositivo']['id']);
			}
		}
		$resultado = $this->Listum->find('all',array('conditions'=>'idLista = '.$idLista));
		if ($resultado == 0) {
			$this->Session->setFlash(__('La lista no existe.'));
		}else{
			if ($this->Listum->delete()){
				$this->Session->setFlash(__('La lista ha sido eliminada correctamente.'));
				$this->redirect(array('action' => 'listadolistasdispositivo',$idDispositivo));
				//$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('La lista no ha podido ser eliminada.'));
				$this->redirect($this->referer());
			}	
		}
	}
	
	public function deleteListaVideoIdLista($idListaVideo = null) {
		$this->LoadModel('ListaVideo');
		$this->ListaVideo->id = $idListaVideo;
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->ListaVideo->exists()) {
			throw new NotFoundException(__('Invalid ListaVideo'));
		}
		$resultado = $this->ListaVideo->find('all',array('conditions'=>'id = '.$idListaVideo));
		if ($resultado == 0) {
			$this->Session->setFlash(__('La ListaVideo no existe.'));
		}else{
			if ($this->ListaVideo->delete()){
				$this->Session->setFlash(__('La ListaVideo ha sido eliminada correctamente.'));
				//$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('La ListaVideo no ha podido ser eliminada.'));
				//$this->redirect($this->referer());
			}
		}
	}
	
	public function deleteListaDispositivoIdLista($idListaDispositivo = null) {
		$this->LoadModel('ListaDispositivo');
		$this->ListaDispositivo->id = $idListaDispositivo;
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->ListaDispositivo->exists()) {
			throw new NotFoundException(__('Invalid ListaDispositivo'));
		}
		$resultado = $this->ListaDispositivo->find('all',array('conditions'=>'id = '.$idListaDispositivo));
		if ($resultado == 0) {
			$this->Session->setFlash(__('La ListaDispositivo no existe.'));
		}else{
			if ($this->ListaDispositivo->delete()){
				$this->Session->setFlash(__('La ListaDispositivo ha sido eliminada correctamente.'));
				//$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('La ListaDispositivo no ha podido ser eliminada.'));
				//$this->redirect($this->referer());
			}
		}
	}
	
	public function deleteListaVideo($idListaVideo = null) {
		$listavC = new ListaVideosController();
		$listavC->constructClasses();
		$listavC->ListaVideo->id = $idListaVideo;
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$listavC->ListaVideo->exists()) {
			throw new NotFoundException(__('Invalid ListaVideo'));
		}
		$resultado = $listavC->ListaVideo->find('all',array('conditions'=>'id = '.$idListaVideo));
		if ($resultado == 0) {
			$this->Session->setFlash(__('Este video no existe en la lista.'));
		}else{
			if ($listavC->ListaVideo->delete()){
				$this->Session->setFlash(__('El video ha sido eliminado correctamente de la lista.'));
				//$this->redirect(array('action' => 'listadoEmpresasUsuarios'));
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('El video no ha podido ser eliminado de la lista.'));
			}
		}
	}
	
	public function VistaVideos($id = null,$idLista = null,$idDispositivo = null) {
		$videosC = new VideosController();
		$videosC->constructClasses();
		$videosC->Video->id = $id;
		$dispositivoC = new DispositivosController();
		$dispositivoC->constructClasses();
		$dispositivoC->Dispositivo->id = $idDispositivo;
		
		if (!$videosC->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($videosC->Video->save($this->request->data)) {
				$this->Session->setFlash(__('El video ha sido guardado.'),'info');
				$this->redirect($this->referer());
				//$this->redirect(array('action' => 'listadoVideosLista/',$idLista,$idDispositivo));
	
			} else {
				$this->Session->setFlash(__('El video no ha podido guardarse. Por favor, intentalo de nuevo.'),'info');
				$this->redirect($this->referer());
				//$this->redirect(array('action' => 'listadoVideosLista/',$idLista,$idDispositivo));
			}
		}
		$this->set('idLista',$idLista);
		$this->set('idDispositivo',$idDispositivo);
		$this->set('video', $videosC->Video->read(null, $id));
		$this->render('VistaVideos','admin');
	}
	
	public function asignarVideo($idLista = null,$idDispositivo = null){
		$videosC = new VideosController();
		$videosC->constructClasses();
		$listadC = new ListaDispositivosController();
		$listadC->constructClasses();
		
		$options2['fields'] = array('ListaDispositivo.idLista','dispositivo.idDispositivo','dispositivo.idEmpresa','lista.descripcion');
		$options2['conditions'] = array("ListaDispositivo.idLista = '".$idLista."'");
		$options2['joins'] = array(
				array('table' => 'dispositivo',
						'type' => 'left',
						'conditions' => array(
								'ListaDispositivo.idDispositivo = dispositivo.idDispositivo',		
						)
				),
				array('table' => 'lista',
						'type' => 'left',
						'conditions' => array(
								'ListaDispositivo.idLista = lista.idLista',
						)
				)
		);
		$resultado2 = $listadC->ListaDispositivo->find('all',$options2);
		$this->set('listaDispositivos',$resultado2);
		
		$options['fields'] = array('Video.idVideo','Video.descripcion','Video.idEmpresa','empresa.nombre');
		$options['conditions'] = array('Video.idEmpresa = '.$resultado2[0]['dispositivo']['idEmpresa']);
		$options['joins'] = array(
				array('table' => 'empresa',
						'type' => 'left',
						'conditions' => array(
								'empresa.idEmpresa = Video.idEmpresa',
						)
				)
		);
		$options['order'] = ('Video.idVideo');
		$resultado = $videosC->Video->find('all',$options);
		$this->set('videos',$resultado);
		
		$this->render('asignarVideo', 'admin');
		
	}
	public function asignarVideoLista($idVideo = null,$idLista = null,$idDispositivo = null){
		$listavC = new ListaVideosController();
		$listavC->constructClasses();

		if ($this->request->is('post')) {
			
			//$resultado = $listavC->ListaVideo->find("all", array('conditions' => "idVideo = '".$idVideo."' and idLista ='".$idLista."'"));
			//if(count($resultado) == 0){
				$user = $this->Session->read('Auth');
				$this->request->data['ListaVideo']['idVideo'] = $idVideo;
				$this->request->data['ListaVideo']['idLista'] = $idLista;
				//$this->request->data['ListaVideo']['timestamp'] = time();
				
				$options['fields'] = array('max(posicion) posicion');
				$options['conditions'] = array('ListaVideo.idLista = '.$idLista);
				$resultado =$listavC->ListaVideo->find("all", $options);
				if(count( $resultado) > 0){
					$this->request->data['ListaVideo']['posicion'] = $resultado[0][0]['posicion'] + 1;
				}else{
					$this->request->data['ListaVideo']['posicion'] = 1;
				}
				
				$this->request->data['ListaVideo']['idUsuario'] = $user['User']['id'];
				if ($listavC->ListaVideo->save($this->request->data)) {
					$resultado = $listavC->ListaVideo->find("all", array('conditions' => "idVideo = '".$idVideo."' and idLista ='".$idLista."'"));
					if(count($resultado) > 0){
						$id = $resultado[0]['ListaVideo']['id'];
	
						$this->Session->setFlash(__('El video ha sido asignado a la lista.'),'info');
						$this->redirect(array('action' => 'asignarVideo',$idLista,$idDispositivo));
					}else{
						$this->Session->setFlash(__('El video no ha podido asignarse. Por favor, intentalo de nuevo.'));
					}
				} else {
					$this->Session->setFlash(__('El video no ha podido asignarse. Por favor, intentalo de nuevo.'));
				}
			/*}else{
				$this->Session->setFlash(__('El video ya esta asignado a la lista.'),'error');
				//$this->redirect(array('action' => '../Adm/addUsuario'));
			}*/
			
		}
		$this->redirect($this->referer());
		$this->render("asignarVideo", 'admin');
	}
	
	public function listadoConsejos(){
		$this->loadModel('Consejo');
		$options['fields'] = array('idConsejo','descripcion','idUsuario','users.username','situacion','created','idAsunto');
		$options['group'] = array('idAsunto');
		$options['conditions'] = array("idConsejo IN (SELECT MIN(idConsejo) FROM `consejo` GROUP BY idAsunto)");
		$options['joins'] = array(
				array('table' => 'users',			
						'type' => 'left',
						'conditions' => array(
								'users.id = Consejo.idUsuario',
									
						)
				)
		);
		$options['order'] = ('idAsunto');
		$this->set('consejos',$this->Consejo->find('all',$options));
		
		
		$options2['fields'] = array('idAsunto','count(distinct idConsejo) nMensajes');
		$options2['group'] = array('idAsunto');
		$options2['order'] = ('idAsunto');
		
		$this->set('cuentaMensajes',$this->Consejo->find('all',$options2));
		
		$options3['fields'] = array('idAsunto','created');
		$options3['group'] = array('idAsunto');
		$options3['conditions'] = array("idConsejo IN (SELECT MAX(idConsejo) FROM `consejo` GROUP BY idAsunto)");
		
		$this->set('ultMensajes',$this->Consejo->find('all',$options3));
		
		$this->render('listadoConsejos','admin');
		
	}
	
	public function listadoAsunto($idAsunto = null){
		$this->loadModel('Consejo');
		$options['fields'] = array('idConsejo','descripcion','idUsuario','users.username','situacion','created','idAsunto');
		$options['conditions'] = array('idAsunto ='.$idAsunto);
		$options['joins'] = array(
				array('table' => 'users',			
						'type' => 'left',
						'conditions' => array(
								'users.id = Consejo.idUsuario',
									
						)
				)
		);
		$options['order'] = ('idAsunto,idConsejo');
		$this->set('consejos',$this->Consejo->find('all',$options));
		
		if ($this->request->is('post')) {
				
			$user = $this->Session->read('Auth');
			$this->request->data['Consejo1']['idUsuario'] = $user['User']['id'];
			$this->request->data['Consejo1']['page'] = $this->referer();
			$this->request->data['Consejo1']['idAsunto'] = $idAsunto;
			//$this->request->data['Consejo']['descripcion'] = 'Abc';
			//$consejo = $this->Consejo->read(null,$idConsejo);
			//$situacion = $consejo['Consejo']['situacion'];
			//$this->request->data['Consejo']['situacion'] = $situacion;
			$options['fields'] = array('situacion');
			$options['conditions'] = array('idAsunto ='.$idAsunto); 
			$options['order'] = ('idConsejo');
			$resultado =$this->Consejo->find("all", $options);
			if(count($resultado) > 0){
				$this->request->data['Consejo1']['situacion'] = $resultado[0]['Consejo']['situacion'];
			}else{
				$this->request->data['Consejo1']['situacion'] = 1;
			}
			//$this->request->data['Consejo']['idMensaje'] = 1;
			$this->request->data['Consejo'] = $this->request->data['Consejo1'];
			if ($this->Consejo->save($this->request->data)) {
				$this->Session->setFlash(__('Respuesta enviada.'),'info');
				 /*
		         * Mandar mail de con el mensaje
		         */
		        $resultado = $this->Consejo->find('all',array('conditions'=>'idAsunto= '.$idAsunto));
		       	$idUsuario = $resultado[0]['Consejo']['idUsuario'];
		       	
		       	$userC = new UsersController();
				$userC->constructClasses();
				$usuario = $userC->User->read(null,$idUsuario);



		        $email = new CakeEmail('default');
		        $email->sender('info@whadtv.com', 'WhadTV');
				$email->from(array('info@whadtv.com' => 'WhadTV'));

				//$email->template('layout');
				$email->to($usuario['User']['username']);
				$email->subject('Nuevo mensaje en WhadTV');
				$email->emailFormat('html');
				$email->viewVars(array('mensajes' => $resultado));
				$email->template('mensaje');
				$email->send();
				$this->redirect(array('action' => 'listadoAsunto/'.$idAsunto));
			} else {
				$this->Session->setFlash(__('La respuesta no ha enviarse. Por favor, intentalo de nuevo.'),'error');
			}
		}
		
	}
	
	public function situacionAsunto($idAsunto= null){
		$this->loadModel('Consejo');
		
		$resultado = $this->Consejo->find('all',array('conditions'=>'idAsunto= '.$idAsunto));
		if(count($resultado) > 0){
			foreach($resultado as $situacionConsejo){
				$this->situacionConsejo($situacionConsejo['Consejo']['idConsejo']);
			}
		}
		$this->redirect(array('action' => 'listadoConsejos'));
		
	}
	
	public function situacionConsejo($idConsejo = null){
		$this->loadModel('Consejo');
		$this->Consejo->id = $idConsejo;
		$this->request->data = $this->Consejo->read(null,$idConsejo);
		$situacion = $this->request->data['Consejo']['situacion'];
		CakeLog::write("debug", "Cambiando situacion de consejo:".$situacion);
		
		if ($situacion == "leido") {
			$situacion = "noleido";
		}else{
			$situacion = "leido";	
		}
		CakeLog::write("debug", "Nueva sutuación:".$situacion);
		$this->request->data['Consejo']['situacion'] = $situacion;
		if ($this->Consejo->save($this->request->data)) {
			$this->Session->setFlash(__('La situacion ha sido actualizada.'), 'info');
		} else {
			$this->Session->setFlash(__('La situacion no ha podido actualizarse. Por favor, intentalo de nuevo.'));
		}
	}

	public function listadoActualizacionDispositivos(){
		$this->loadModel('ActualizacionDispositivo');
		$options['fields'] = array('id','idUsuario','users.username','idReproductor','dispositivo.descripcion','max(fsolicitud) fsolicitud','max(fentrega) fentrega','max(situacion) situacion','observaciones', 'count(ActualizacionDispositivo.id) cantidad');
		$options['group'] = array('idReproductor');
		$options['joins'] = array(
				array('table' => 'dispositivo',			
						'type' => 'left',
						'conditions' => array(
								'dispositivo.idDispositivo = ActualizacionDispositivo.idReproductor',
									
						)
				),
				array('table' => 'users',
						'type' => 'left',
						'conditions' => array(
							'users.id = ActualizacionDispositivo.idUsuario'
						)
				)
		);
		$options['order'] = ('idReproductor ASC');
		CakeLog::write("debug", "Antes de realiar la consulta");
		$this->set('actualizacionDispositivos',$this->ActualizacionDispositivo->find('all',$options));
		
		$this->render('listadoActualizacionDispositivos','admin');
		
	}

	public function listadoActualizacionDispositivo($idReproductor = null){
		$this->loadModel('ActualizacionDispositivo');
		$this->ActualizacionDispositivo->idReproductor = $idReproductor;
		$options['fields'] = array('id','idUsuario','users.username','idReproductor','dispositivo.descripcion','fsolicitud','fentrega','contenido','situacion','observaciones');
		$options['conditions'] = array("ActualizacionDispositivo.idReproductor ='".$idReproductor."'");
		$options['joins'] = array(
				array('table' => 'dispositivo',			
						'type' => 'left',
						'conditions' => array(
								'dispositivo.idDispositivo = ActualizacionDispositivo.idReproductor',
									
						)
				),
				array('table' => 'users',
						'type' => 'left',
						'conditions' => array(
							'users.id = ActualizacionDispositivo.idUsuario'
						)
				)
		);
		$options['order'] = ('id ASC');
		$this->set('actualizacionDispositivos',$this->ActualizacionDispositivo->find('all',$options));

		/*$resultado = $this->ActualizacionDispositivo->find('all',$options);
		foreach ($resultado as $res) {
			//print_r("A".$res['ActualizacionDispositivo']['contenido']."\n");

			$contenido = json_decode($res['ActualizacionDispositivo']['contenido'],true);
			
			$mute = ($contenido['mute'] != false) ? 'true' : 'false';
			$caducidad = date('d/m/Y',$contenido['caducidad']);
			$dataDispositivo = "idDispositivo: ".$contenido['idDispositivo']." Mute: ".$mute." F.caducidad: ".$caducidad." Disco: ".$contenido['disco']." Play: ".$contenido['play'];
			if (is_array($contenido['listas'])){
				foreach( $contenido['listas'] as $lista ){
					$mute = ($lista['mute']) ? 'true' : 'false';
					$activa = ($lista['activa']) ? 'true' : 'false';
					$dataLista = "idLista: ".$lista['idLista']." Mute: ".$mute." Activa: ".$activa;
					if (is_array($lista['videos'])){
						foreach ( $lista['videos'] as $video){
							$mute = ($video['mute']) ? 'true' : 'false';
							$dataVideo = "idVideo: ".$video['idVideo']." Mute: ".$mute." Name: ".$video['name']." Time: ".$video['time']." Tipo: ".$video['tipo']." URL: ".$video['url'];
							$dataLista = $dataLista."\n".$dataVideo;
						}
					}
					$dataDispositivo = $dataDispositivo."\n".$dataLista;
				}
			}
			$res['ActualizacionDispositivo']['contenidoOrganizado'] = explode($contenido);
		}
		$resultado = $res;
		$this->set('actualizacionDispositivos',$resultado);
		*/
		$this->render('listadoActualizacionDispositivo','admin');
		
	}
	
	public function listadoAgenciasEmpresa($idEmpresa = null){
		$this->loadModel('Agencia');
		$this->loadModel('AgenciaUsuario');
		$this->loadModel('Empresa');

		$options['fields'] = array('Agencia.id','Agencia.idAgente','Agencia.idCliente','Agencia.nivel','empresa.nombre','count(distinct agenciaUsuario.idUsuario) usuarios');
		$options['group'] = array('Agencia.id');
		$options['conditions'] = array('Agencia.idCliente ='.$idEmpresa);
		$options['order'] = array('empresa.nombre DESC');
		$options['joins'] = array(
				array('table' => 'empresa',			
						'type' => 'left',
						'conditions' => array(
								'empresa.idEmpresa = Agencia.idAgente',
									
						)
				),
				array('table' => 'agenciaUsuario',			
						'type' => 'left',
						'conditions' => array(
								'agenciaUsuario.idAgencia = Agencia.id',
									
						)
				)
		);
		
		$this->set('agencias',$this->Agencia->find('all',$options));
		$this->set('empresa',$this->Empresa->read(null,$idEmpresa));
		$this->render('listadoAgenciasEmpresa','admin');
	}

	public function asignarAgencia($idEmpresa = null){
		$this->loadModel('Empresa');
		
		$options['fields'] = array('Empresa.idEmpresa','Empresa.nombre');
		$options['conditions'] = array("Empresa.idEmpresa NOT IN (SELECT `agencia`.`idAgente` FROM `agencia` WHERE `agencia`.`idCliente`= '".$idEmpresa."') and Empresa.idEmpresa != '".$idEmpresa."'");
		$options['order'] = ('Empresa.idEmpresa');
		
		$this->set('agencias',$this->Empresa->find('all',$options));
		$this->set('empresa',$this->Empresa->read(null,$idEmpresa));
		
		$this->render('asignarAgencia', 'admin');
	}

	public function asignarAgenciaEmpresa($idEmpresa = null, $idAgente = null){
		$this->LoadModel('Agencia');
		if ($this->request->is('post')) {
			
			$resultado = $this->Agencia->find("all", array('conditions' => "idCliente = '".$idEmpresa."' and idAgente ='".$idAgente."'"));
			if(count($resultado) == 0){
				$this->request->data['Agencia']['idCliente'] = $idEmpresa;
				$this->request->data['Agencia']['idAgente'] = $idAgente;
				$this->request->data['Agencia']['nivel'] = 0;
				if ($this->Agencia->save($this->request->data)) {
					$resultado = $this->Agencia->find("all", array('conditions' => "idCliente = '".$idEmpresa."' and idAgente ='".$idAgente."'"));
					if(count($resultado) > 0){
						$this->Session->setFlash(__('La Agencia ha sido asignada a la empresa.'),'info');
						$this->redirect(array('action' => 'listadoAgenciasEmpresa',$idEmpresa));
					}else{
						$this->Session->setFlash(__('La Agencia no ha podido asignarse. Por favor, intentalo de nuevo.'));
					}
				} else {
					$this->Session->setFlash(__('La Agencia no ha podido asignarse. Por favor, intentalo de nuevo.'));
				}
			}else{
				$this->Session->setFlash(__('La Agencia ya esta asignado a la empresa.'),'error');
			}
			
		}
		$this->redirect($this->referer());
		$this->render("asignarAgencia", 'admin');
	}

	public function deleteAgencia($id = null){
		$this->loadModel('Agencia');
		$this->Agencia->id = $id;
		$this->loadModel('AgenciaUsuario');
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->Agencia->exists()) {
			throw new NotFoundException(__('Invalid Agencia'));
		}
		$resultado = $this->Agencia->find('all',array('conditions'=>'id = '.$id));
		if ($resultado == 0) {
			$this->Session->setFlash(__('Esta Agencia no existe en la empresa.'));
		}else{
			$resultado = $this->AgenciaUsuario->find("all", array('conditions'=>'idAgencia ='.$id));
			if(count( $resultado) > 0){
				foreach( $resultado as $agenciaUsuario){
					$this->deleteAgenciaUsuarioId($agenciaUsuario['AgenciaUsuario']['id']);
				}
			}
			if ($this->Agencia->delete()){
				$this->Session->setFlash(__('La Agencia ha sido eliminada correctamente de la empresa.'),'info');
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('La Agencia no ha podido ser eliminado de la empresa.'));
			}
		}
	}

	public function deleteAgenciaUsuarioId($id = null){
		$this->LoadModel('AgenciaUsuario');
		$this->AgenciaUsuario->id = $id;
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->AgenciaUsuario->exists()) {
			throw new NotFoundException(__('Invalid AgenciaUsuario'));
		}
		$resultado = $this->AgenciaUsuario->find('all',array('conditions'=>'id = '.$id));
		if ($resultado == 0) {
			$this->Session->setFlash(__('La AgenciaUsuario no existe.'));
		}else{
			if ($this->AgenciaUsuario->delete()){
				$this->Session->setFlash(__('La AgenciaUsuario ha sido eliminada correctamente.'),'info');
			}else{
				$this->Session->setFlash(__('La AgenciaUsuario no ha podido ser eliminada.'));
			}
		}
	}

	public function listadoAgenciaUsuarios($id = null){
		$this->loadModel('Agencia');
		$this->loadModel('AgenciaUsuario');
		$this->loadModel('Empresa');

		$options['fields'] = array('AgenciaUsuario.id','AgenciaUsuario.idAgencia','AgenciaUsuario.idUsuario','AgenciaUsuario.nivel','users.username');
		$options['conditions'] = array('AgenciaUsuario.idAgencia ='.$id);
		$options['order'] = array('users.username DESC');
		$options['joins'] = array(
				array('table' => 'users',			
						'type' => 'left',
						'conditions' => array(
								'users.id = AgenciaUsuario.idUsuario',
									
						)
				)
		);
		
		$agencia = $this->Agencia->read(null,$id);
		$this->set('agencia',$agencia);
		$this->set('users',$this->AgenciaUsuario->find('all',$options));
		$this->set('empresa',$this->Empresa->read(null,$agencia['Agencia']['idAgente']));
		$this->render('listadoAgenciaUsuarios','admin');
	}

	public function deleteAgenciaUsuario($id = null){
		$this->loadModel('AgenciaUsuario');
		$this->AgenciaUsuario->id = $id;
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		if (!$this->AgenciaUsuario->exists()) {
			throw new NotFoundException(__('Invalid AgenciaUsuario'));
		}
		$resultado = $this->AgenciaUsuario->find('all',array('conditions'=>'id = '.$id));
		if ($resultado == 0) {
			$this->Session->setFlash(__('Esta usuario no existe en la Agencia.'));
		}else{
			if($this->AgenciaUsuario->delete()){
				$this->Session->setFlash(__('El usuario ha sido eliminado correctamente de la Agencia.'),'info');
				$this->redirect($this->referer());
			}else{
				$this->Session->setFlash(__('El usuario no ha podido ser eliminado de la Agencia.'));
			}
		}
	}

	public function asignarAgenciaUsuarios($id = null){
		$this->loadModel('Agencia');
		$this->loadModel('AgenciaUsuario');
		$this->loadModel('Empresa');
		$this->loadModel('Usuarios');

		$agencia = $this->Agencia->read(null,$id);
		$this->set('agencia',$agencia);

		$options['fields'] = array('Usuarios.id','Usuarios.username');
		$options['conditions'] = array("empresaUsuario.idEmpresa =".$agencia['Agencia']['idAgente']." 
									and Usuarios.id NOT IN (SELECT `agenciaUsuario`.`idUsuario` FROM `agenciaUsuario` 
															left JOIN `GestVideo`.`agencia` ON (`agenciaUsuario`.`idAgencia` = `agencia`.`id`) 
															WHERE `agencia`.`id`= '".$id."')");
		$options['order'] = array('Usuarios.username DESC');
		$options['joins'] = array(
				array('table' => 'empresaUsuario',			
						'type' => 'left',
						'conditions' => array(
								'empresaUsuario.idUsuario = Usuarios.id',
									
						)
				)
		);
		
		$this->set('users',$this->Usuarios->find('all',$options));
		$this->set('empresa',$this->Empresa->read(null,$agencia['Agencia']['idAgente']));
		$this->render('asignarAgenciaUsuarios','admin');
	}

	public function asignarAgenciaUsuario($idAgencia = null,$idUsuario = null){
		$this->LoadModel('AgenciaUsuario');
		if ($this->request->is('post')) {
			
			$resultado = $this->AgenciaUsuario->find("all", array('conditions' => "idAgencia = '".$idAgencia."' and idUsuario ='".$idUsuario."'"));
			if(count($resultado) == 0){
				$this->request->data['AgenciaUsuario']['idAgencia'] = $idAgencia;
				$this->request->data['AgenciaUsuario']['idUsuario'] = $idUsuario;
				$this->request->data['AgenciaUsuario']['nivel'] = 0;
				if ($this->AgenciaUsuario->save($this->request->data)) {
					$resultado = $this->AgenciaUsuario->find("all", array('conditions' => "idAgencia = '".$idAgencia."' and idUsuario ='".$idUsuario."'"));
					if(count($resultado) > 0){
						$this->Session->setFlash(__('El usuario ha sido asignado a la Agencia.'),'info');
						$this->redirect(array('action' => 'listadoAgenciaUsuarios',$idAgencia));
					}else{
						$this->Session->setFlash(__('El usuario no ha podido asignarse. Por favor, intentalo de nuevo.'));
					}
				} else {
					$this->Session->setFlash(__('El usuario no ha podido asignarse. Por favor, intentalo de nuevo.'));
				}
			}else{
				$this->Session->setFlash(__('El usuario ya esta asignado a la empresa.'),'error');
			}
			
		}
		$this->redirect($this->referer());
		$this->render("asignarAgenciaUsuarios", 'admin');
	}

	/**
	 * delete method
	 *
	 * @param string $id
	 * @return void
	 */
	/*public function deleteUser($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$userC = new UsersController();
		$userC->constructClasses();
		$userC->User->id = $id;
		if (!$userC->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$userC->User->read();
		$eUsuariosC = new EmpresaUsuariosController();
		$eUsuariosC->constructClasses();
		$resultado = $eUsuariosC->EmpresaUsuario->find('all',array('conditios'=>'idUsuario = '.$id));
		if(count($resultado  == 1)){
			$resultado2 = $eUsuariosC->EmpresaUsuario->find('all', array('conditions'=>'idEmpresa ='. $resultado[0]['EmpresaUsuario']['idEmpresa']));
			if(count($resultado2 == 1)){
				$this->set('empresa',$resultado[0]);
				$this->render('avisoDelete','loged');
			}
			
		}
		//print_r( $userC->User );
		if ($userC->User->delete()) {
				
			$lista = new ListaVideosController();
			$lista->constructClasses();
			$lista->ListaVideo->deleteAll('idVideo = '.$id);
				
			$this->Session->setFlash(__('Video deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Video was not deleted'));
		$this->redirect(array('action' => 'index'));
	}*/
	
	/*
	 * Esta función elimina una empresa y todo lo relacionado con ella exceptuando la información administrativa necesaria para 
	 * recuperar facturas.
	 * 
	 */
	public function deleteTotal(){
		//
	}
	
	public function deleteVideos(){
		if ($this->request->is('post')) {
			$videosC = new VideosController();
			$videosC->constructClasses();
			foreach($this->request->data['chec'] as $video){
				$videosC->Video->id = $video;
				$listavC = new ListaVideosController();
				$listavC->constructClasses();
				$videosC->Video->read();
				$videosC->eliminarArchivo( $videosC->Video->data['Video']['url'] );
				$videosC->eliminarArchivo( 'img/'.$videosC->Video->data['Video']['fotograma']);
				if ($videosC->Video->delete()) {
					$listavC->ListaVideo->deleteAll('idVideo = '.$video);
					
					$this->Session->setFlash(__('El video ha sido eliminado correctamente.'), 'info');
				}else{
					$this->Session->setFlash(__('El video no ha sido eliminado.Por favor, inténtalo de nuevo'));
				}
					
			}
			$this->redirect("listadoVideos");
		}
		$this->loadModel('Video');
		
		$resultado = $this->Video->find('all',null);
		$this->set('videos', $resultado);
		
	}

	public function procesarVideo($id){
		
		$videosC = new VideosController();
		$videosC->constructClasses();
		$test = $videosC->testFiles($id);
		$this->set('test', $test);
		$this->set('id', $id);
		$this->render('procesar_video', 'empty');
	}

	public function resizeFotograma($id){
		$videosC = new VideosController();
		$videosC->constructClasses();
		//$contenido = $videosC->Video->read(null,$id);
		$videosC->thumbnail( $id );
		//return new CakeResponse( array( 'body' => 'Enviado' ) );
	}



/* Gestión de APKs
 *
 */

public function listadoApks()
{
	$this->loadModel('Apk');
	$resultado = $this->Apk->find( 'all' );
	$this->set( 'apks' , $resultado );
	$this->render('listado_apks', 'admin');

}

}

	
	

?>
