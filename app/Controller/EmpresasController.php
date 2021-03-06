<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'EmpresaUsuarios');
/**
 * Empresas Controller
 *
 * @property Empresa $Empresa
 */
class EmpresasController extends AppController {
var $components = array('Auth','DebugKit.Toolbar', 'RequestHandler', 'Session');
var $helpers = array("Session");


	public function beforeFilter(){
		parent::beforeFilter();
		parent::testAuth();
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
		
		$this->Empresa->recursive = 0;
		$this->set('empresas', $this->paginate());
		$this->render("index", 'loged');
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Empresa->id = $id;
		if (!$this->Empresa->exists()) {
			//throw new NotFoundException(__('Invalid empresa'));
			$this->redirect(array('action'=> 'Empresas/selectEmpresa'));
		}else{
			$this->set('empresa', $this->Empresa->read(null, $id));
			$this->render("view", 'loged');
		}
	}
/**
 * selectEmpresa method
 */
	
	public function selectEmpresa(){
		$data = $this->Session->read("Auth");
		$id = $data['User']['id'];
		$options['fields'] = array('idEmpresa','nombre','b.perfil','url', 'b.idUsuario', 'b.id', 'count(distinct d.idDispositivo) dispositivos', 'count(distinct l.idLista) listas', 'count(distinct v.idVideo) videos');
		$options['group'] = array('idEmpresa');
		$options['joins'] = array(
		    array('table' => 'empresaUsuario',
		        'alias' 		=> 'b',
		        'type' 			=> '',
		        'conditions' 	=> array(
		            'Empresa.idEmpresa = b.idEmpresa',
		    		"b.idUsuario = '".$id."'"
		        )
		    ),
		    array('table' 		=> 'dispositivo',
		    	  'alias' 		=> 'd',
		    	  'type' 		=> 'left',
		    	  'conditions'	=> 'Empresa.idEmpresa = d.idEmpresa'
		    ),
		    array('table'		=> 'lista',
		    	  'alias'		=> 'l',
		    	  'type'		=> 'left',
		    	  'conditions'	=> array(
		    		'Empresa.idEmpresa = l.idEmpresa'
		    		)
		    ),
		    array('table'		=> 'video',
		    	  'alias'		=> 'v',
		    	  'type'		=> 'left',
		    	  'conditions'	=> array(
		    		'Empresa.idEmpresa = v.idEmpresa'
		    		)
		    )

		    
		);
		
    	$empresas = $this->Empresa->find("all", $options);
    	$this->set("empresas", $empresas);
    	$this->render("selectEmpresa", 'loged');
	}
	
	
	public function panel($id = null){
		$user = $this->Session->read("Auth");
		$idUsuario = $user['User']['id'];
		if( !is_null( $id ) ){
			$EmpresaUsuarios = new EmpresaUsuariosController();
			$EmpresaUsuarios->constructClasses();
			$resultado = $EmpresaUsuarios->EmpresaUsuario->find("all", array('conditions' => array( "idUsuario = '".$idUsuario."'", "idEmpresa = '".$id."'" )));
			if( count( $resultado ) > 0 ){
				$this->cargarEmpresa($id);
				//$resultado = $this->Empresa->find("all", array('conditions' => array("idEmpresa = '".$id."'" )));
				
				//$this->Session->write("Empresa", $resultado[0] );
			}
		}
		$empresa = $this->Session->read("Empresa");
		$this->Empresa->id = $empresa['Empresa']['idEmpresa'];
		$this->set("empresa", $this->Empresa->read(null, $empresa['Empresa']['idEmpresa']));
		if( $this->demoWebPasada() ){
			$this->redirect(array('controller'=>'videos','action'=>'index'));
		}else{
			$this->set('demo', true);
			$this->redirect(array('controller'=>'reproductors','action'=>'index'));
	   	}
		//$this->redirect('../Videos');
	}
	
/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		if ($this->request->is('post')) {
			$resultado = $this->Empresa->find("all", array('conditions' => "nombre = '".$this->request->data['Empresa']['Nombre']."'"));
			if( count( $resultado ) == 0){
				$this->Empresa->create();
				if ($this->Empresa->save($this->request->data)) {
					$user = $this->Session->read("Auth");
					$id = $user['User']['id'];
					
					$EmpresaUsuarios = new EmpresaUsuariosController();
					$EmpresaUsuarios->constructClasses();	
					$data = array('idEmpresa' => $this->Empresa->id, 'idUsuario' => $id, 'perfil' => '2');
									       	
					$EmpresaUsuarios->addRegistro($data);
					
					
					
					
					$this->Session->setFlash(__('La empresa ha sido guardada.'));
					$this->redirect(array('action' => 'lista'));
				} else {
					$this->Session->setFlash(__('La empresa no ha podido guardarse. Por favor, intentalo de nuevo.'));
				}
			}else{
				$this->Session->setFlash(__('Ya existe una empresa con ese nombre.'));
			}
		}
	}

	public function addEmpresa($data = null) {
		
			$this->Empresa->create();
			if ($this->Empresa->save($data)) {
				return $this->Empresa->find("all", array('conditions' => "nombre = '".$data['Nombre']."'"));
			} else {
				return null;
			}
		//}
	}
/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Empresa->id = $id;
		if (!$this->Empresa->exists()) {
			throw new NotFoundException(__('Invalid empresa'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$resultado = $this->Empresa->find("all", array('conditions'=> "Nombre = '".$this->data['Empresa']['Nombre']."'"));
			if( count( $resultado ) == 0){
				if ($this->Empresa->save($this->request->data)) {
					$this->recargarEmpresa();
					$this->Session->setFlash(__('Se han cambiado los datos de la empresa exitosamente.'), 'info');
					//$this->redirect(array('controller'=>'videos', 'action'=>'index'));
				} else {
					$this->Session->setFlash(__('Los datos no se han cambiado, prueba de nuevo'), 'error');
				}
			}else{
				$this->Session->setFlash( __("Ya existe una empresa con ese nombre."),'info');			}
		}
			$this->request->data = $this->Empresa->read(null, $id);
			$this->render("edit", 'loged');
		
	}
	
	
	public function cargarEmpresa($id){
		$resultado = $this->Empresa->find("all", array('conditions' => "idEmpresa = '".$id."'"));
		if( count( $resultado ) == 1 ){
			$agencia = $this->cargarAgencia($id);
			$clientes = count($agencia);
			$agencia['clientes'] = $clientes;
			$resultado[0]['agencia'] = $agencia;

			$this->Session->write("Empresa", $resultado[0] );
		}
	}
		
	public function recargarEmpresa(){
		$empresa = $this->Session->read("Empresa");
		//print_r($empresa);
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		$this->cargarEmpresa($idEmpresa);
	}
	
	public function cargarAgencia($idEmpresa = null){
		$user = $this->Session->read('Auth');
		$user['User']['id'];

		$this->loadModel('Agencia');
		$options['fields'] = array('Agencia.id','Agencia.idCliente','empresa.Nombre');
		$options['joins'] = array(
				array('table' => 'agenciaUsuario',			
						'type' => 'left',
						'conditions' => array(
								'agenciaUsuario.idAgencia = Agencia.id',
						)
				),
				array('table' => 'empresa',			
						'type' => 'left',
						'conditions' => array(
								'empresa.idEmpresa = Agencia.idCliente',
						)
				)
		);
		$options['conditions'] = array("Agencia.idAgente = '".$idEmpresa."' and agenciaUsuario.idUsuario ='".$user['User']['id']."'");
		$options['group'] = array('Agencia.idCliente');

		$resultado = $this->Agencia->find('all',$options);

		return $resultado;
	}

	public function lista(){
		$data = $this->Session->read("Auth");
		$id = $data['User']['id'];
		$options['fields'] = array('idEmpresa','nombre','b.perfil','url', 'b.idUsuario', 'b.id');
		$options['joins'] = array(
		    array('table' => 'empresaUsuario',
		        'alias' => 'b',
		        'type' => '',
		        'conditions' => array(
		            'Empresa.idEmpresa = b.idEmpresa',
		    		"b.idUsuario = '".$id."'"
		        )
		    )
		    
		);
		
    	$empresas = $this->Empresa->find("all", $options);
    	$this->set("empresas", $empresas);
    	$this->render("lista", 'loged');
	}
	
	function adddisp(){
		
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Empresa->id = $id;
		if (!$this->Empresa->exists()) {
			throw new NotFoundException(__('Invalid empresa'));
		}
		if ($this->Empresa->delete()) {
			$this->Session->setFlash(__('La empresa ha sido eliminada.'));
			$this->redirect($this->referer());
		}
		$this->Session->setFlash(__('La empresa no se ha eliminado.'));
		$this->redirect($this->referer());
	}
	
	public function cambiarLogo(){
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa["Empresa"]['idEmpresa'];
		//if ($this->request->is('post')) {
			$this->Empresa->id = $idEmpresa;
			//print_r($this->request->data);
			$fileOK = $this->uploadFiles('files', $this->request->data['Empresa']['Document']);
			$this->request->data['Empresa'][ 'url' ] = $fileOK[ 'urls' ][0];
			if ($this->Empresa->save($this->request->data)) {
				$this->Session->setFlash(__('El logo ha sido cambiado'),'info');
				$this->recargarEmpresa();
				
				//$this->redirect(array('action' => 'index'));
				$this->redirect(array('controller'=>'dispositivos', 'action' => 'sendLogo',$idEmpresa));
			} else {
				$this->Session->setFlash(__('El logo no se ha podido guardar correctamente', 'error'));
				$this->redirect($this->referer());
			}
		/*}else{
			$this->Session->setFlash("El protocolo no es correcto", 'error');
			$this->render('edit');
		}*/
	}
	
	function uploadFiles($folder, $file, $itemId = null) {  
	 	
	    // setup dir names absolute and relative  
	    $folder_url = WWW_ROOT.$folder;  
	    $rel_url = $folder;  
	      
	    // create the folder if it does not exist  
	    if(!is_dir($folder_url)) {  
	        mkdir($folder_url);  
	    }  
	          
	    // if itemId is set create an item folder  
	    if($itemId) {  
	        // set new absolute folder  
	        $folder_url = WWW_ROOT.$folder.'/'.$itemId;   
	        // set new relative folder  
	        $rel_url = $folder.'/'.$itemId;  
	        // create directory  
	        if(!is_dir($folder_url)) {  
	            mkdir($folder_url);  
	        }  
	    }  
	      
	    // list of permitted file types, this is only images but documents can be added  
	    $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png','image/jpg');  
	    //print_r($formdata);
	    // loop through and deal with the files  
	     
	        // replace spaces with underscores  
	       $filename = str_replace(' ', '_', $file['name']);  
	       $hashedfilename = md5( $filename );
	        // assume filetype is false  
	        $typeOK = false;  
	        // check filetype is ok  
	        foreach($permitted as $type) {  
	            if($type == $file['type']) {  
	                $typeOK = true;  
	                break;  
	            }  
	        }  
	        
	        // if file type ok upload the file  
	        if($typeOK) { 
	        	 
	            // switch based on error code  
	            switch($file['error']) {  
	                case 0:  
	                    // check filename already exists  
	                    
	                    if(!file_exists($folder_url.'/'.$hashedfilename)) {  
	                        // create full filename  
	                        $full_url = $folder_url.'/'.$hashedfilename;  
	                        $url = $rel_url.'/'.$hashedfilename;  
	                        // upload the file  
	                        $success = move_uploaded_file($file['tmp_name'], "img/".$url);  
	                    } else {  
	                        // create unique filename and upload file  
	                        ini_set('date.timezone', 'Europe/Madrid');  
	                        $now = date('Y-m-d-His');  
	                        $full_url = $folder_url.'/'.$now.$filename;  
	                        $url = $rel_url.'/'.$now.$filename;  
	                        $success = move_uploaded_file($file['tmp_name'], "img/".$url);  
	                    }  
	                    // if upload was successful  
	                    if($success) {  
	                        // save the url of the file  
	                        $result['urls'][] = $url;  
	                        $result['name'] = $filename;
	                    } else {  
	                        $result['errors'][] = "Error uploaded $filename. Please try again.";  
	                    }  
	                    break;  
	                case 3:  
	                    // an error occured  
	                    $result['errors'][] = "Error uploading $filename. Please try again.";  
	                    break;  
	                default:  
	                    // an error occured  
	                    $result['errors'][] = "System error uploading $filename. Contact webmaster.";  
	                    break;  
	            }  
	        } elseif($file['error'] == 4) {  
	            // no file was selected for upload  
	            $result['nofiles'][] = "No file Selected";  
	        } else {  
	            // unacceptable file type  
	            $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";  
	        }  
	      
	return $result;  
	}  

	public function demoWebPasada()
	{
		$empresa = $this->Session->read("Empresa");
		if( $empresa['Empresa']['demo_web'] == 1 ) return 1;

		$this->loadModel('Reproductor');
		$rep_web = $this->Reproductor->getReproductoresWeb( $empresa['Empresa']['idEmpresa']);
		$this->set('reproductores_web', $rep_web);
		if( count( $rep_web ) >  0 ){
			$this->loadModel('Empresa');
			$this->Empresa->id = $empresa['Empresa']['idEmpresa'];
			$this->Empresa->setDemo(true);
			$this->cargarEmpresa($empresa['Empresa']['idEmpresa']);

		   return 1;
		}	
		return 0;

	}

	public function demoWebBloqueada()
	{
		$empresa = $this->Session->read("Empresa");
	 	return $empresa['Empresa']['demo_web_block'];
	}

	public function demoWebBlock(){
		$empresa = $this->Session->read("Empresa");
		$this->Empresa->id = $empresa['Empresa']['idEmpresa'];
		$data['Empresa']['demo_web_block'] = ( $empresa['Empresa']['demo_web_block'] -1 ) * -1;
		if( $this->Empresa->save( $data ) ){
			$this->recargarEmpresa();
			return new CakeResponse( array( 'body' => json_encode( array("OK")) ) );
		}else{
			return new CakeResponse( array( 'body' => json_encode( array("NOT OK")) ) );
		}

	}

}
