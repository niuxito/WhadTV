<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'ListaVideos');

//App::import('Controller', 'S3');
//App::import('Lib', 'Socket_Beanstalk');
//require_once CAKE_CORE_INCLUDE_PATH.'/davidpersson-beanstalk/src/Socket/Beanstalk.php';
require_once CAKE_CORE_INCLUDE_PATH.'/beanstalk-1.2.1/src/BeanStalk.class.php';

/**
 * Videos Controller
 *
 * @property Video $Video
 * 
 */
class VideosController extends AppController {
	//Componentes
	public $components = array('Process', 'DebugKit.Toolbar','RequestHandler', 'Auth');
	
	
	
	function beforeFilter(){
		
		parent::beforeFilter();
		$this->Auth->allow('procesado');
		$this->Auth->allow('video');
		$this->Auth->allow('updateVideoJson');
		$this->Auth->allow('updateFotogramaJson');
		$this->Auth->allow('updateVideoJsonPlusHTML5');
		$this->Auth->allow('updateImageJson');
		parent::testAuth();
	}


	public function ejecutar($pila, $mensaje){
		 $beanstalk = BeanStalk::open( 
		 	array(
		        'servers'       => array( 	( defined( 'BEANSTALK_HOST' ) ) ? BEANSTALK_HOST.':11300' : '0.0.0.0:11300' ),
		        'select'        => 'random peek'
    		)
    	);
		 
		 // 'servers'       => array( '192.168.1.2:11300' ),
		 //var_dump($beanstalk);
		 $pilas = null;
		 $beanstalk->list_tubes( $pilas );
		 var_dump( $pilas );
		if( !empty( $pilas ) ){
		    CakeLog::write( "debug", "Conectado a beanstalk" );
		    // As in the protocol doc.
		    $beanstalk->use_tube( $pila );
		    CakeLog::write( "debug", "Enlazada la pila" );
		    
		    
		    // As in the protocol doc.
		    $cadena = serialize( $mensaje );
		    $beanstalk->put( 0, 0, 120, $cadena ); 
		    CakeLog::write( "debug", "Mensaje enviado" );
	     }else{
	     	CakeLog::write( "debug", "No se ha conectado con la cola" );
	     }
	}

	public function lanzar(){

		$this->ejecutar("html5Convert",  array('rutaIn'=>'rutain', 'alto'=>'alto', 'ancho'=>'ancho', 'rutaOut'=>'rutaout'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->cargarListas();
		$this->cargarTodosVideos();
		$this->loadModel('Reproductor');
		$rep_web = $this->Reproductor->getReproductoresWeb( 70 );
		$this->set('reproductores_web', $rep_web);
		//$this->set('videos', $videos);
		$this->render('index', 'loged');
	}

	
	
	public function videosxlista($idLista = null){
		if($this->request->is('post') && $this->request->data['chk_llista'] != 0){
			$idLista = $this->request->data['chk_llista'];
		}
			if(!is_null($idLista)){ 
		
			$idEmpresa = $this->getIdEmpresa();
			$options['fields'] = array('listaVideo.id','listaVideo.posicion','idVideo','fotograma','descripcion','url','name','mute','time','estado','count(distinct lv.idLista) listas', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
			$options['group'] = array('listaVideo.id');
			$options['order'] = array('listaVideo.posicion');
			$options['conditions'] = array("Video.idEmpresa = '".$idEmpresa."'", "listaVideo.idLista =".$idLista );
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
			$videos = $this->Video->find("all", $options);
			$this->set('videos', $videos);
			$this->cargarListas();
			$this->cargarLista($idLista);
			$this->render('index', 'loged');
		}else{
			//$this->render('index', 'loged');
			$this->redirect(array('action'=>'index'));
		}
	}
	
	public function getIdEmpresa(){
		$idEmpresa = $this->Session->read("Empresa.Empresa.idEmpresa");
		if(is_null ($idEmpresa) ){
			$this->redirect(array('controller'=>'empresas', 'action'=>'selectEmpresa'));
		}

		//$idEmpresa = $empresa['Empresa']['idEmpresa'];
		return $idEmpresa;
	}
	
	public function cargarListas(){
		$idEmpresa = $this->getIdEmpresa();
		$this->loadModel('Listum');
		$optionsL['conditions'] = array("idEmpresa = ".$idEmpresa);
		$lista = $this->Listum->find("all", $optionsL);
		$this->set('listas', $lista);
	}
	
	public function cargarLista($idLista){
		$idEmpresa = $this->getIdEmpresa();
		$this->loadModel('Listum');
		$optionsL['conditions'] = array("idEmpresa = ".$idEmpresa, 'idLista='.$idLista);
		$lista = $this->Listum->find("all", $optionsL);
		$this->set('listaC', $lista);
	}
	
	public function todos($idLista){
		$this->cargarTodosVideos();
		$this->set('lista', $idLista);
		$this->render('todos','empty');
	}
	
	public function cargarTodosVideos(){
		$idEmpresa = $this->getIdEmpresa();
		$videos = $this->Video->cargarTodosVideos( $idEmpresa );
		$this->set('videos', $videos);
	}
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null, $orientacion = "Horizontal") {
		$this->Video->id = $id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Video->save($this->request->data)) {
				$this->Session->setFlash(__('El video ha sido guardado.'),'info');
				
			} else {
				$this->Session->setFlash(__('El video no ha podido guardarse. Por favor, intentalo de nuevo.'),'info');
			}
		}
		$resultado = $this->Video->read(null, $id);
		$formatos = json_decode($resultado['Video']['url'],1);
		$parametros = array(
			'time' 			=> $resultado['Video']['time'],
			'orientacion' 	=> $orientacion,
			'size'			=> '720x1080'	
		);
		$resultado['Video']['formatos'] = $this->getVideoUrl($formatos, $parametros, $resultado['Video']['tipo']);
		$this->set('video', $resultado);
		$this->render('view','popup');
	}


	public function getVideoUrl( $formatos, $parametros, $tipo )
	{
		if( $tipo == 'video' ){
			$urls = array(
				'webm' => ( isset( $formatos[$parametros['time']][$parametros['orientacion']][$parametros['size']]['webm'] ) ) ? $formatos[$parametros['time']][$parametros['orientacion']][$parametros['size']]['webm'] : false ,
				'h264' => ( isset( $formatos[$parametros['time']][$parametros['orientacion']][$parametros['size']]['h264'] ) ) ? $formatos[$parametros['time']][$parametros['orientacion']][$parametros['size']]['h264'] : false ,
			);
		}elseif( $tipo == 'imagen' ){
			$urls = array(
				'720p' => ( isset( $formatos['imgs'][$parametros['orientacion']]['720p'] ) ) ? $formatos['imgs'][$parametros['orientacion']]['720p'] : false 
			);
		}else{
			$urls = false;
		}
		return $urls;
	}
	
/**
 * mute method
 * 
 * @return void
 */	
	public function mute(){
			$this->Video->id = $this->request->data['id'];
			$this->request->data['Video']['mute'] = $this->request->data['mute'];
			if ($this->Video->save($this->request->data)) {
				$this->Session->setFlash(__('La lista ha sido guardada.'));
				$this->redirect(array('action' => 'index'));
			}else{
				$this->redirect(array('action' => 'index'));
			}
			
		
	}
/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Video->id = $id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Video->save($this->request->data)) {
				$this->Session->setFlash(__('El video ha sido guardado.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El video no ha podido guardarse. Por favor, intentalo de nuevo.'));
			}
		} else {
			$this->request->data = $this->Video->read(null, $id);
		}
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
		$this->Video->id = $id;
		if (!$this->Video->exists()) {
			throw new NotFoundException(__('Invalid video'));
		}
		$this->Video->read();
		
		//print_r( $this->Video );
		$this->eliminarArchivo( $this->Video->data['Video']['url'] );
		$this->eliminarArchivo( 'img/'.$this->Video->data['Video']['fotograma']);
		if ($this->Video->delete()) {
			
			$lista = new ListaVideosController();
			$lista->constructClasses();
			$lista->ListaVideo->deleteAll('ListaVideo.idVideo = '.$id);
			
			$this->Session->setFlash(__('El video ha sido eliminado.'), 'info');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('El video no ha sido eliminado.'));
		$this->redirect(array('action' => 'index'));
	}
	
	function eliminarArchivo( $ruta ){
		App::uses('File', 'Utility');
		$file = new File( WWW_ROOT.$ruta );
		//print_r( $file->path  );
		if( $file->delete( ) ){
			CakeLog::write('debug', 'El fichero que se encontraba en la ruta: '.$ruta.' ha sido eliminado');
		}
	}
	private function add(){
		$empresa = $this->Session->read("Empresa");
		$idEmpresa = $empresa['Empresa']['idEmpresa'];
		$this->request->data['Video']['idEmpresa'] = $idEmpresa;
		$this->Video->create();
		if(array_key_exists('Document', $this->data['Video']) || array_key_exists('cartel', $this->data['Video'])){
			$this->request->data['Video']['estado'] = 'sin procesar';
			$this->request->data['Video']['timestamp'] = time();
			if ($this->Video->save($this->request->data)) {
				return true;
			}
		}else{
			$this->Session->setFlash(__('El fichero no se ha añadido, es posible que sea demasiado grande.'), 'info');
			$this->redirect(array('action' => 'index'));
		}
		
	}
	/**
	 * addVideo method
	 *
	 * @return void
	 */
	public function addVideo() {
		if ($this->request->is('post')) {
			CakeLog::write('debug','Se ha identificado un video');
			$fileOK = $this->uploadVideo('img/files', $this->request->data['Video']['Document']);
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

				if ($this->Video->save($this->request->data)) {
					$video = $this->Video->read(null, null);
					//$this->set('elvideo', $resultado);
					$this->processVideo(
						$video['Video']['idVideo'],
						'crt_mp4',
						HOST.DIRECTORIO."/videos/updateVideoJsonPlusHTML5/".$video['Video']['idVideo']
					);
					CakeLog::write('debug','El fichero con nombre '.$this->request->data['Video']['Document']['name'].' ha sido almacenado con el id: '.$this->Video->id);
					$this->Session->setFlash(__('El video ha llegado correctamente, va ser procesado por nuestros servidores.'), 'info');
					return new 	CakeResponse(array('body' => json_encode( $video) ) );
		
				} else {
					$this->Session->setFlash(__('El video no ha podido guardarse. Por favor, intentalo de nuevo.'));
					$this->redirect(array('action' => 'index'));
				}

			}else{
				$this->redirect(array('action' => 'index'));
			}
			
		}else{
			$this->loadModel('Listum');
			$listas = $this->Listum->getListasByEmpresa($this->Session->read('Empresa.Empresa.idEmpresa'));
			$new_listas = array();
			foreach($listas as $lista){
				$new_listas[$lista['Listum']['idLista']] = $lista['Listum']['descripcion'];
			}
			if( count($listas) > 1){
				$this->set('show_listas', true);
			}
			$this->set('listas', $new_listas);
		}
	}
	


	/**
	 * addFile method
	 *
	 * @return void
	 */
	public function addFile() 
	{
		$this->autoRender = false;
		if ($this->request->is('post')) {

			if($this->add()){
				$video_type = array('video/quicktime', 'video/avi','video/mp4', 'application/x-shockwave-flash', 'video/x-ms-wmv', 'video/webm','video/x-flv');
				$image_type = array('image/gif','image/jpeg','image/pjpeg','image/png','image/jpg', 'image/png'); 
				$imagenOk = $this->validarTipoFichero($this->request->data['Video']['Document'], $image_type);
				if( $imagenOk ){
					$this->addImagen();
					return 'ok';
				}else{
					$videoOk = $this->validarTipoFichero($this->request->data['Video']['Document'], $video_type);
					if( $videoOk ){
						$this->addVideo();
						return 'ok';
					}
				}

			}
		}
	}

	/**
	 * addImagen method
	 *
	 * @return void
	 */
	public function addImagen() 
	{
		CakeLog::write('debug','Se ha identificado una imagen');
		$fileOK = $this->uploadImagen('img/files', $this->request->data['Video']['Document']);
			
		if(!is_null($fileOK) && (( !array_key_exists("errors", $fileOK)) || (count( $fileOK['errors'] ) == 0 ))){
				
			$this->request->data['Video']['name'] = $fileOK['name'];
			//$this->request->data['Video'][ 'url' ] = json_encode( array( "img" => $fileOK[ 'urls' ][0] ) );
			$this->request->data['Video'][ 'url' ] = json_encode( array( "img" => FULL_BASE_URL.DIRECTORIO.'/'.$fileOK['rutas']['URLArchivo']  ) );
			$this->request->data['Video']['fotograma'] = str_replace("img/","",$fileOK['rutas']['fotograma']);
			$this->request->data['Video']['time'] = isset($this->request->data['Video']['tiempo']) ? $this->request->data['Video']['tiempo'] : 5;
			$this->request->data['Video']['estado'] = 'sin procesar';
			$this->request->data['Video']['timestamp'] = $this->Video->getDataSource()->expression('NOW()');
			$this->request->data['Video']['tipo'] = "imagen";

			if( $this->Video->save( $this->request->data ) ) {

				//$this->Session->setFlash(__('The video has been saved'), 'info');
				//$resultado =$this->Video->find('all', array('conditions'=>array("url ='".$this->request->data['Video'][ 'url' ]."'")));
				$video = $this->Video->read(null, null);
				//$this->set('elvideo', $resultado);
				$this->processImage(
					$video['Video']['idVideo'],
					'crt_image'
					//"https://".HOST.DIRECTORIO."/videos/updateVideoJsonPlusHTML5/".$video['Video']['idVideo']
				);
				$this->processImage(
					$video['Video']['idVideo'],
					'crt_image_max',
					array('h' =>90, 'w' => 160),
					HOST.DIRECTORIO."/videos/updateFotogramaJson/".$video['Video']['idVideo']
				);
				//$this->generarVideosDesdeImagen($fileOK['rutas'], $this->request->data['Video']['tiempo'], $resultado[0]['Video']['idVideo']);
				//CakeLog::write('debug','El fichero con nombre '.$this->request->data['Video']['Document']['name'].' ha sido almacenado con el id: '.$video['Video']['idVideo']);
				//$this->redirect(array('action' => 'index'));
				return new 	CakeResponse(array('body' => json_encode( $video) ) );

			} else {

				$this->Session->setFlash(__('La imagen no ha sido guardada, prueba de nuevo.'));
				$this->redirect(array('action' => 'index'));

			}

		}else{
			//$this->Session->setFlash(__('Este formato de video no está soportado'));
			$this->redirect(array('action' => 'index'));
		}

			$this->redirect(array('action' => 'index'));
	
	}
	
	/**
	 * addCartel method
	 *
	 * @return void
	 */
	public function addCartel() {
		if ($this->request->is('post')) {
			if($this->add()){

				$fileOK = $this->uploadCartel('img/files', $this->request->data['Video']['cartel']);
				//print_r($fileOK);
				if(!is_null($fileOK) && (( !array_key_exists("errors", $fileOK)) || (count( $fileOK['errors'] ) == 0 ))){
					//CakeLog::write("debug", "El fichero se ha insertado correctamente, procedemos a guardar los datos ");
					//CakeLog::write("Comando", "url del fotograma: ".print_r($fileOK));
					$this->request->data['Video']['name'] = $fileOK['name'];
					$this->request->data['Video'][ 'url' ] = json_encode( array( "img" => FULL_BASE_URL.DIRECTORIO.'/'.$fileOK['rutas']['URLArchivo']  ) );
					$this->request->data['Video']['fotograma'] = str_replace("img/","",$fileOK['rutas']['fotograma']);
					$this->request->data['Video']['time'] = $this->request->data['Video']['tiempo'];
					$this->request->data['Video']['estado'] = 'sin procesar';
					$this->request->data['Video']['timestamp'] = DboSource::expression('NOW()');
					$this->request->data['Video']['tipo'] = "imagen";
					//$this->request->data['Video']['']
					//CakeLog::write("Comando", "url del fotograma: ".$this->request->data['Video']['fotograma']);
	
					if ($this->Video->save($this->request->data)) {
						$this->Session->setFlash(__('El cartel ha sido guardado'), 'info');
						$resultado =$this->Video->find('all', array('conditions'=>array("url ='".$this->request->data['Video'][ 'url' ]."'")));
						$this->set('elvideo', $resultado);
						$video = $this->Video->read(null, null);
						//$this->generarVideosDesdeImagen($fileOK['rutas'], $this->request->data['Video']['time'], $resultado[0]['Video']['idVideo']);
						$this->processImage(
							$video['Video']['idVideo'],
							'crt_image'
							//"https://".HOST.DIRECTORIO."/videos/updateVideoJsonPlusHTML5/".$video['Video']['idVideo']
						);
						$this->processImage(
							$video['Video']['idVideo'],
							'crt_image_max',
							array('h' =>90, 'w' => 160),
							HOST.DIRECTORIO."/videos/updateFotogramaJson/".$video['Video']['idVideo']
						);
						//CakeLog::write('debug','El fichero con nombre '.$this->request->data['Video']['Document']['name'].' ha sido almacenado con el id: '.$this->Video->id);
						//$this->redirect(array('action' => 'index'));
						$this->redirect(array('controller'=>'carteles', 'action'=>'index'));
					} else {
						$this->Session->setFlash(__('El cartel no ha sido guardado, prueba de nuevo.'));
						//$this->redirect(array('action' => 'index'));
						$this->redirect(array('controller'=>'carteles', 'action'=>'index'));
					}
	
				}else{
					$this->Session->setFlash(__('Error al guardar el cartel, prueba de nuevo.'));
					//$this->redirect(array('action' => 'index'));
					$this->redirect(array('controller'=>'carteles', 'action'=>'index'));
				}
			}
		}
	}

	
	function generarDirectorio($folder, $itemId){
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
		return array('URLAbsoluta'=> $folder_url, 'URLRelativa' => $rel_url);
	}
	
	function validarTipoFichero($file, $permitted){
		
		// assume filetype is false
		$typeOK = false;
		// check filetype is ok
		foreach($permitted as $type) {
			if($type == $file['type']) {
				$typeOK = true;
				break;
			}
		}
		return $typeOK;
	}
	
	function ficheroCorrecto($file, $permitted){
		$typeOK = $this->validarTipoFichero($file, $permitted);
		switch($file['error']) {
			case 0:
				if($typeOK){
					return true;
				}
				break;
			case 1:
				$this->Session->setFlash("El fichero excede el tamaño permitido.", 'info');
				CakeLog::write('debug', "El fichero excede del tamaño permitido");
			
				break;
			case 2:
				$this->Session->setFlash("El fichero excede el tamaño permitido.", 'info');
				CakeLog::write('debug', "El fichero excede del tamaño permitido");
				break;
			case 3:
				// an error occured
				$this->Session->setFlash("Se ha producido un error al guardar el fichero.", 'error');
				CakeLog::write('debug', "Codigo de error: 3. Se ha producido un error al guardar el fichero");
				//$result['errors'][] = "Error uploading $filename. Please try again.";
				break;
				
			case 7:
				CakeLog::write('error', 'No se ha escrito el fichero en el disco');
				CakeLog::write('debug', "Codigo de error: 7. Se ha producido un error al guardar el fichero");
				$this->Session->setFlash("Estamos teniendo un problema en el servidor, agradecemos tu paciencia.", 'error');
					
			default:
				// an error occured
				CakeLog::write('debug', " Se ha producido un error no controlado al guardar el fichero");
				$this->Session->setFlash("Estamos teniendo un problema en el servidor, agradecemos tu paciencia.", 'error');
				break;
			
		}
		return false;
	}
	
	function prepararRuta($file, $ruta){
		$archivoExpandido = explode(".", $file['name']);
		$ruta['extension'] = array_pop($archivoExpandido);
		$nombreArchivo = implode(".",$archivoExpandido);
		$hashedfilename = md5( $nombreArchivo );
		if(!file_exists($ruta['URLAbsoluta'].'/'.$hashedfilename.'.'.$ruta['extension'])) {
			$ruta['nombreArchivo'] = $hashedfilename;		
		}else{
			ini_set('date.timezone', 'Europe/Madrid');
			$ahora = date('Y-m-d-His');
			$nombreArchivo = str_replace(" ", "_", $nombreArchivo);
			$nombreArchivo = str_replace(";", "_", $nombreArchivo);
			$nombreArchivo = str_replace("á", "a", $nombreArchivo);
			$nombreArchivo = str_replace("é", "e", $nombreArchivo);
			$nombreArchivo = str_replace("í", "i", $nombreArchivo);
			$nombreArchivo = str_replace("ó", "o", $nombreArchivo);
			$nombreArchivo = str_replace("ú", "u", $nombreArchivo);
			$nombreArchivo = str_replace("ñ", "ny", $nombreArchivo);
			$nombreArchivo = str_replace("(", "[", $nombreArchivo);
			$nombreArchivo = str_replace(")", "]", $nombreArchivo);
				
			$ruta['nombreArchivo'] = $ahora.$nombreArchivo;
		}
		
		$ruta['URLArchivo'] = $ruta['URLRelativa'].'/'.$ruta['nombreArchivo'].'.'.$ruta['extension'];
		$ruta['URLArchivoSinExtension'] = $ruta['URLRelativa'].'/'.$ruta['nombreArchivo'];
		$ruta['URL_WEB'] = HOST.DIRECTORIO."/".$ruta['URLArchivo'];
		return $ruta;
	}
	
	/**
	 * @TODO Asegurar que la extensión del fichero no coincide con las conversiones para evitar bloqueos en ffmpeg
	 * @param unknown_type $ruta
	 */
	function generarVideos($ruta, $id){
		$empresa = $this->Session->read('Empresa');
		$empresaId = $empresa['Empresa']['idEmpresa'];
		$medidas = $this->getMaxAltoAnchoDispositivos($empresaId);
		$rutaIn = $ruta['URLAbsoluta'].'.'.$ruta['extension'];
		
		$resultado = $this->formato(
				$ruta['URLRelativa'].'/'.$ruta['nombreArchivo'].'.'.$ruta['extension'], 
				$ruta['URLRelativa'].'/'.$ruta['nombreArchivo'], 
				$medidas['ancho'],
				$medidas['alto'],
				//$ruta['URLRelativa'].'/fotogramas/'.$ruta['nombreArchivo'],
				$ruta['fotograma'],
				$id
				);
		if($resultado == 0){
			CakeLog::write("debug", "Conversiónes completadas");
			return false;
		}else{
			return false;
		}
		
	}
	
	
	/**
	 * @TODO Asegurar que la extensión del fichero no coincide con las conversiones para evitar bloqueos en ffmpeg
	 * @param unknown_type $ruta
	 */
	function generarVideosDesdeImagen($ruta, $tiempo, $id){
		$empresa = $this->Session->read('Empresa');
		$empresaId = $empresa['Empresa']['idEmpresa'];
		$medidas = $this->getMaxAltoAnchoDispositivos($empresaId);
		$rutaIn = $ruta['URLAbsoluta'].'.'.$ruta['extension'];
		$resultado = $this->imagenAVideo(
				$ruta['URLRelativa'].'/'.$ruta['nombreArchivo'].'.'.$ruta['extension'],
				$ruta['URLRelativa'].'/'.$ruta['nombreArchivo'].'.webm',
				$tiempo,
				$medidas['ancho'],
				$medidas['alto'],
				$ruta['fotograma'],
				$id
			);
		if($resultado == 0){
			
			$resultado = $this->formato(
					$ruta['URLAbsoluta'].'/'.$ruta['nombreArchivo'].'.webm',
					$ruta['URLAbsoluta'].'/'.$ruta['nombreArchivo'],
					$medidas['alto'],
					$medidas['ancho']
				);
		}
		
		if($resultado == 0){
			
			CakeLog::write("debug", "Conversiónes completadas");
			return true;
		}else{
			return false;
		}
	
	}
	/*
	 * @TODO Obtener los alto y ancho máximos de los dispositivos de una empresa
	*/
	function getMaxAltoAnchoDispositivos($empresaId){
		return array('alto'=>720, 'ancho'=>1280);
	}
	
	function uploadVideo($folder, $file, $itemId = null){
		CakeLog::write("debug", "Intento de publicación:");
		CakeLog::write("debug", "Video con nombre ".$file['name']." de ".$file['size']." bytes.");
		
		$permitted = array('video/quicktime', 'video/avi','video/mp4', 'application/x-shockwave-flash', 'video/x-ms-wmv', 'video/webm','video/x-flv');
		$result = null;
		$fotograma;
		$directorio = $this->generarDirectorio($folder, $itemId);
		if($this->ficheroCorrecto($file, $permitted)){
			$ruta = $this->prepararRuta($file, $directorio); 
			$ruta['fotograma'] = $ruta['URLRelativa'].'/fotogramas/'.$ruta['nombreArchivo'].".jpg";

			/*
			 *	ACCIONES S3
			 */
			/*
			$s3C = new S3Controller();
			$s3C->constructClasses();
			$empresa = $this->Session->read("Empresa");
			$idEmpresa = $empresa['Empresa']['idEmpresa'];
			$rutaS3 = $s3C->generarRuta('Video', $idEmpresa,  $ruta['nombreArchivo'].'.'.$ruta['extension']);
			$result['S3URL'] = $s3C->saveVideo($file['tmp_name'], $rutaS3);
			*/

			if(move_uploaded_file($file['tmp_name'], $ruta['URLArchivo'])){
				$this->Session->setFlash("Se ha guardado el contenido.",'info');
				CakeLog::write('debug', "El fichero con nombre ".$file['name']." se ha copiado correctamente en ". $ruta['URLArchivo']);
				$result['urls'][] = $ruta['URL_WEB'];
				$result['name'] = $file['name'];
				$result['rutas'] = $ruta;
				
			}else {
					$this->Session->setFlash("Se ha producido un error al guardar el fichero.", 'error');
					CakeLog::write('debug', "No ha podidio insertarse el fichero en su carpeta");
					$result['errors'][] = "Error uploaded $filename. Please try again.";
			}	

		}
		return $result;		 
	}
	
	function uploadImagen($folder, $file, $itemId = null){
		CakeLog::write("debug", "Intento de publicación:");
		CakeLog::write("debug", "Imagen con nombre ".$file['name']." de ".$file['size']." bytes.");
	
		$permitted = array('image/gif','image/jpeg','image/pjpeg','image/png','image/jpg', 'image/png'); 
		$result = null;
		$fotograma;
		$directorio = $this->generarDirectorio($folder, $itemId);

		if($this->ficheroCorrecto($file, $permitted)){
			$ruta = $this->prepararRuta($file, $directorio);
			$ruta['fotograma'] = $ruta['URLRelativa'].'/fotogramas/'.$ruta['nombreArchivo'].'.'.$ruta['extension'];
			
			if(move_uploaded_file($file['tmp_name'], $ruta['URLArchivo'])){
				$this->Session->setFlash("Se ha guardado el contenido.",'info');
				CakeLog::write('debug', "El fichero con nombre ".$file['name']." se ha copiado correctamente en ". $ruta['URLArchivo']);
				
				if(!copy($ruta['URLArchivo'], $ruta['fotograma'])){
					CakeLog::write('debug', "Se ha producido un error copiando la imagen ".$file['name']." a la carpeta fotogramas"); 
				
				}

				$result['urls'][] = $ruta['URL_WEB'];
				$result['name'] = $file['name'];
				$result['rutas'] = $ruta;
				//$result['fotograma'] = $fotograma;
	
			}else {
				$this->Session->setFlash("Se ha producido un error al guardar el fichero.", 'error');
				CakeLog::write('debug', "No ha podidio insertarse el fichero en su carpeta");
				$result['errors'][] = "Error uploaded $filename. Please try again.";
			}
		}

		return $result;
	}

	function uploadCartel($folder, $img, $itemId = null){
		CakeLog::write("debug", "Intento de publicación:");
		CakeLog::write("debug", "Cartel ");
	
		//$permitted = array('image/gif','image/jpeg','image/pjpeg','image/png','image/jpg', 'image/png'); 
		$result = null;
		$fotograma;
		$directorio = $this->generarDirectorio($folder, $itemId);
		$fileArray['name'] = "cartel.jpg";
		$ruta = $this->prepararRuta($fileArray, $directorio);
		$ruta['fotograma'] = $ruta['URLRelativa'].'/fotogramas/'.$ruta['nombreArchivo'].'.'.$ruta['extension'];
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);

						
		if(file_put_contents($ruta['URLArchivo'], $data)){
				$this->Session->setFlash("Se ha guardado el contenido.",'info');
				CakeLog::write('debug', "El fichero con nombre ".$fileArray['name']." se ha copiado correctamente en ". $ruta['URLArchivo']);
				if(!copy($ruta['URLArchivo'], $ruta['fotograma'])){
					CakeLog::write('debug', "Se ha producido un error copiando la imagen ".$file['name']." a la carpeta fotogramas"); 
				
				}

				$result['urls'][] = $ruta['URL_WEB'];
				$result['name'] = $fileArray['name'];
				$result['rutas'] = $ruta;
				//$result['fotograma'] = $fotograma;
	
		}else {
				$this->Session->setFlash("Se ha producido un error al guardar el fichero.", 'error');
				CakeLog::write('debug', "No ha podidio insertarse el fichero en su carpeta");
				$result['errors'][] = "Error uploaded $filename. Please try again.";
		}
		return $result;
	}
	
	//  function uploadFiles($folder, $file, $itemId = null) {  
	 	
	//     // setup dir names absolute and relative  
	//     $folder_url = WWW_ROOT.$folder;  
	//     $rel_url = $folder;  
	      
	//     // create the folder if it does not exist  
	//     if(!is_dir($folder_url)) {  
	//         mkdir($folder_url);  
	//     }  
	          
	//     // if itemId is set create an item folder  
	//     if($itemId) {  
	//         // set new absolute folder  
	//         $folder_url = WWW_ROOT.$folder.'/'.$itemId;   
	//         // set new relative folder  
	//         $rel_url = $folder.'/'.$itemId;  
	//         // create directory  
	//         if(!is_dir($folder_url)) {  
	//             mkdir($folder_url);  
	//         }  
	//     }  
	    
	      
	//     // list of permitted file types, this is only images but documents can be added  
	//     $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png','image/jpg', 'video/quicktime', 'video/avi');  
	//     //print_r($file);
	//     // loop through and deal with the files  
	     
	//         // replace spaces with underscores  
	//        $extension = substr($file['name'], strpos( $file['name'],"."));
	//        //print_r(strpos(".", $file['name']));
	//        $filename = str_replace(' ', '_', $file['name']);  
	//        $hashedfilename = md5( $filename ).$extension;
	//         // assume filetype is false  
	//         $typeOK = false;  
	//         // check filetype is ok  
	//         foreach($permitted as $type) {  
	//             if($type == $file['type']) {  
	//                 $typeOK = true;  
	//                 break;  
	//             }  
	//         }  
	        
	//         // if file type ok upload the file  
	//         if($typeOK) { 
	        	 
	//             // switch based on error code  
	//             switch($file['error']) {  
	//                 case 0:  
	//                 	//echo "cAso 0";
	//                     // check filename already exists  
	//                    $url;
	//                    $finalname;
	//                     if(!file_exists($folder_url.'/'.$hashedfilename)) {  
	//                         // create full filename  
	//                         $full_url = $folder_url.'/'.$hashedfilename;  
	//                         $finalname = $hashedfilename;
	//                         $url = $rel_url.'/'.$hashedfilename;  
	//                         // upload the file  
	//                         //echo $url;
	//                         //$success = move_uploaded_file($file['tmp_name'], $url); 
	//                         //$this->actualizarDimensiones($id, $folder_url, $hashedfilename); 
	                        
	//                          * Ejecutar función de actualización de dimensiones. Esta función 
	//                          * comprobará todos los dispositivos asignados y buscará los ficheros
	//                          * con esas dimensiones, si no existen utilizará el script para 
	//                          * crear los videos con esas dimensiones.
	                         
	//                     } else {  
	//                         // create unique filename and upload file  
	//                         ini_set('date.timezone', 'Europe/Madrid');  
	//                         $now = date('Y-m-d-His');  
	//                         $full_url = $folder_url.'/'.$now.$filename;  
	//                         $url = $rel_url.'/'.$now.$filename;  
	//                         $finalname = $now.$filename;
	//                         //$success = move_uploaded_file($file['tmp_name'], $url);  
	//                     }  
	//                     $success = move_uploaded_file($file['tmp_name'], $url);
	//                     // if upload was successful  
	//                     //echo $success;
	//                     if($success) {  
	//                         // save the url of the file  
	//                         if(strpos($file['type'], 'image') !== false){
	//                     		$url = $this->imagenAVideo($url, $folder_url, $finalname);
	//                         }
	//                         $fotograma = $this->fotograma($url, $folder_url, $finalname);
	//                     	/*
	//                     	 * Si el fichero es una imagen, ejecutar la función de
	//                     	* video sobre la imagen. Una vez creado el video, ejecutar la
	//                     	* función de actualización de dimensiones.
	//                     	*/
	//                         $result['urls'][] = $url;  
	//                         $result['name'] = $filename;
	//                         $result['fotograma'] = $fotograma;
	//                         //print_r($result);
	//                     } else {  
	//                         $result['errors'][] = "Error uploaded $filename. Please try again.";  
	//                     }  
	//                     break;  
	//                 case 3:  
	//                     // an error occured  
	//                     $result['errors'][] = "Error uploading $filename. Please try again.";  
	//                     break;  
	//                 default:  
	//                     // an error occured  
	//                     $result['errors'][] = "System error uploading $filename. Contact webmaster.";  
	//                     break;  
	//             }  
	//         } elseif($file['error'] == 4) {  
	//             // no file was selected for upload  
	//             $result['nofiles'][] = "No file Selected";  
	//         } else {  
	//             // unacceptable file type  
	//             $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png, quickTime, avi";  
	//         }  
	      
	// return $result;  
	// } 
	
	public function actualizarDimensiones($id, $folder_url, $hashedfilename){
		
	}
	
	public function ejecutarComando($script){
		CakeLog::write("debug", $script);
		system($script, $salida);
		//print_r($salida);
		CakeLog::write("Comando", $salida);
		return $salida;
	}
	public function formato($rutaIn, $rutaOut, $alto, $ancho, $rutaFrame, $id){
		//$alto = 300;
		//$ancho = 200;
		//$extension = '.mkv';
		$altoFrame = 160;
		$anchoFrame = 90;
		$frame = 1;
		CakeLog::write('debug', "Se va a mandar un comando a la cola");
		$this->ejecutar("html5Convert", array(

			'rutaIn'=>$rutaIn,
			'alto'=>$alto,
			'ancho'=>$ancho,
			'rutaOut'=>$rutaOut,
			'altoFrame'=>$altoFrame,
			'anchoFrame'=>$anchoFrame,
			'frame'=>$frame,
			'rutaFrame'=>$rutaFrame,
			'idVideo'=> $id
		));
		//$cadenaComando = WWW_ROOT.'scripts/formato.sh '.$rutaIn.' '.$alto.' '.$ancho.' '.$rutaOut;
		//$salida = $this->ejecutarComando($cadenaComando);
		return 1;
	}
	public function fotograma($url, $folder_url, $filename){
		$altoFrame = 160;
		$anchoFrame = 90;
		$frame = 1;
		$extension = '.jpg';
		$cadenaComando = WWW_ROOT.'scripts/fotogramasfvid.sh '.WWW_ROOT.$url.' '.$altoFrame.' '.$anchoFrame.' '.$frame.' '.WWW_ROOT.'img/files/fotogramas/'.$filename.$extension;
		CakeLog::write("debug", $cadenaComando);
		system($cadenaComando, $salida);
		//print_r($salida);
		CakeLog::write("Comando", $salida);
		if(	$salida == 0){
			$url = 'files/fotogramas/'.$filename.$extension;
		}
		//$url = 'files/fotogramas/'.$filename.$extension;
		return $url;
	}
	
	public function imagenAVideo($origen, $destino, $tiempo, $ancho, $alto, $rutaFotograma, $id){
		/*$extension = '.webm';
		$cadenaComando = WWW_ROOT.'scripts/img2vid.sh '.$origen.' '.$tiempo.' '.$destino;
		$resultado = $this->ejecutarComando($cadenaComando);
		return $resultado;*/
		$altoFrame = 160;
		$anchoFrame = 90;
		$frame = 1;
		CakeLog::write('debug', "Se va a mandar un comando a la cola");
		$this->ejecutar("Img2Vid", array(

			'rutaIn'=>$origen,
			'rutaOut'=>$destino,
			'tiempo'=>$tiempo,
			'ancho'=>$ancho,
			'alto'=>$alto,
			'altoFrame'=>$altoFrame,
			'anchoFrame'=>$anchoFrame,
			'frame'=>$frame,
			'rutaFrame'=>$rutaFotograma,
			'idVideo'=>$id
		));
		return 1;
	}

	public function thumbnail($id){
		//$origen, $anchoFrame, $altoFrame, $rutaFotograma){
		/*$extension = '.webm';
		$cadenaComando = WWW_ROOT.'scripts/img2vid.sh '.$origen.' '.$tiempo.' '.$destino;
		$resultado = $this->ejecutarComando($cadenaComando);
		return $resultado;*/
		/*$altoFrame = 160;
		$anchoFrame = 90;
		$frame = 1;
		CakeLog::write('debug', "Se va a mandar un comando a la cola");
		$this->ejecutar("resize", array(

			'rutaIn'=>$origen,
			'altoFrame'=>$altoFrame,
			'anchoFrame'=>$anchoFrame,
			'frame'=>$frame,
			'rutaFrame'=>$rutaFotograma
			
		));

		
		return 1;*/

		$hash = 10;
		$video = $this->Video->read(null, $id);
		//Comprobar si existe antes de continuar

		$urls = json_decode( $video['Video']['url'],1 );
		$parametros = array(
			"task" 			=> ( $video['Video']['tipo'] == 'imagen' ) ? 'crt_image_max' : 'crt_thumb',
			"URL_origen" 	=> ( $video['Video']['tipo'] == 'imagen' ) ? $urls['img'] : $urls['orig'],
			"destino"		=> array(
					"method" 	=> "localStorage",
					"file_name"	=> $this->arreglarNombres( $video['Video']['descripcion'] )
				),
			"medidas"	=> array(
						"h" => 90,
						"w" => 160
					),
			"frame" => 1,	
			"callback" 		=>HOST.DIRECTORIO."/videos/updateFotogramaJson/".$video['Video']['idVideo']."/".$hash
			);
		CakeLog::write( 'debug', $parametros['callback'] );
		//print_r($parametros);
		$this->Process->setMethod( ( defined( 'PROCESS_METHOD' ) ) ? PROCESS_METHOD : 'directo');
		$this->Process->sendProcess( $parametros );
		//return new CakeResponse( array( 'body' =>  ) );
		//$this->set( 'Process', $this->Process->getMethod() );

	}

	public function arreglarNombres($nombre){
		$nombre = str_replace(" ", "_", $nombre );
		$nombre = str_replace(".", "", $nombre );
		$nombre = $this->quitaracentos( $nombre ); 
		return $nombre;
	}
	public function listasxvideo($idVideo){
		$ListaVideos = new ListaVideosController();
		$ListaVideos->constructClasses();
		$options['fields'] = array('lista.idLista');
		$options['group'] = array('lista.idLista');
		$options['conditions'] = array("ListaVideo.idVideo = ".$idVideo);
		$options['joins'] = array(
				array('table' => 'lista',
		
						'type' => 'left',
						'conditions' => array(
								'lista.idLista = ListaVideo.idLista'
						)
				),
				
		);
		$resultado1 = $ListaVideos->ListaVideo->find("all", $options);
		if( count( $resultado1 ) > 0 ){
			$idlistas = "(";
			foreach($resultado1 as $lista){
				$idlistas .= $lista['lista']['idLista'].", ";
			}
			$idlistas = substr($idlistas, 0, strlen($idlistas)-2)." )";
			//Videos que pertenecen a cada lista
			
			$options['fields'] = array('ListaVideo.id', 'lista.idLista', 'lista.descripcion', 'ListaVideo.idVideo','count(distinct ListaVideo.idVideo) videos', 'count(distinct listaDispositivo.idDispositivo) dispositivos');
			$options['group'] = array('ListaVideo.idLista');
			$options['conditions'] = array("ListaVideo.idLista in ".$idlistas);
			$options['joins'] = array(
					array('table' => 'listaDispositivo',
			
							'type' => 'left',
							'conditions' => array(
									'ListaVideo.idLista = listaDispositivo.idLista',
							)
					),
					array('table' => 'lista',
							'type' => 'left',
							'conditions' => array(
									'lista.idLista = ListaVideo.idLista'
							)
					)
			);
			//$options['conditions'] = array('listaVideo.idLista in', arra$resultado[])
			$resultado = $ListaVideos->ListaVideo->find("all", $options);
		}else{
			$resultado = null;
		}
		$this->set("idVideo",$idVideo);
		$this->set("lasotraslistas", $resultado1);
		$this->set('listas', $resultado);
		$this->set('video', $this->Video->read(null, $idVideo));
	}
	
	public function dispositivosxvideo($idVideo){
		$ListaVideos = new ListaVideosController();
		$ListaVideos->constructClasses();
		$options['fields'] = array('idVideo','dispositivo.descripcion','dispositivo.idDispositivo', 'ListaVideo.idVideo','count(distinct ListaVideo.idVideo) videos', 'count(distinct listaDispositivo.idLista) listas');
		$options['group'] = array('dispositivo.idDispositivo');
		$options['conditions'] = array("idVideo = ".$idVideo);
		$options['joins'] = array(
				array('table' => 'listaDispositivo',
						'type' => 'right',
						'conditions' => array(
								'ListaVideo.idLista = listaDispositivo.idLista',
								'ListaVideo.idVideo = '.$idVideo
						)
				),
				array('table' => 'dispositivo',
						'type' => 'right',
						'conditions' => array(
								'dispositivo.idDispositivo = listaDispositivo.idDispositivo'
						)
				)
		);
		$resultado = $ListaVideos->ListaVideo->find("all", $options);
		
		$this->set('dispositivos', $resultado);
	}
	
	public function dispositivosxlista($idLista,$idVideo){
		$ListaVideos = new ListaVideosController();
		$ListaVideos->constructClasses();
		$options['fields'] = array('idLista','dispositivo.descripcion','dispositivo.idDispositivo', 'ListaVideo.idVideo', 'count(distinct listaDispositivo.idLista) listas');
		$options['group'] = array('dispositivo.idDispositivo');
		$options['conditions'] = array("ListaVideo.idLista = ".$idLista);
		$options['joins'] = array(
				array('table' => 'listaDispositivo',
						'type' => 'right',
						'conditions' => array(
								'ListaVideo.idLista = listaDispositivo.idLista',
								'ListaVideo.idVideo = '.$idVideo
						)
				),
				array('table' => 'dispositivo',
						'type' => 'right',
						'conditions' => array(
								'dispositivo.idDispositivo= listaDispositivo.idDispositivo'
						)
				)
	
		);
		$resultado = $ListaVideos->ListaVideo->find("all", $options);
	
		$this->set('dispositivos', $resultado);
	}
	
	public function videoWebm($id) {
		/*
		 *
		*Buscar el video con sus dimensiones al final, si este no existe entregar el original
		*/
		$resultado = $this->Video->read('url', $id);
		if( count( $resultado ) > 0){
			$posicionNombre = strrpos($resultado['Video']['url'], '/',-1);
			$nombreEnServidor = substr($resultado['Video']['url'], $posicionNombre +1 );
			$url = substr($resultado['Video']['url'],0, $posicionNombre );
			$posicionNombre = strrpos($resultado['Video']['url'], '.',-1);
			$extension = "webm";//substr($resultado['Video']['url'], $posicionNombre +1 );
				
			
			
			$this->response->type('video/webm');
			$this->response->file($resultado['Video']['url'].'.'.$extension, array('download' => false, 'name' => 'foo'));
			return $this->response;
		}else{
			return new CakeResponse( array( 'body' => 'No se encuentra' ) );
		}
	
	}
	
	public function videoMp4($id) {
		/*
		 *
		*Buscar el video con sus dimensiones al final, si este no existe entregar el original
		*/
		$resultado = $this->Video->read('url', $id);
		if( count( $resultado ) > 0){
			
			$posicionNombre = strrpos($resultado['Video']['url'], '/',-1);
			$nombreEnServidor = substr($resultado['Video']['url'], $posicionNombre +1 );
			$url = substr($resultado['Video']['url'],0, $posicionNombre );
			$posicionNombre = strrpos($resultado['Video']['url'], '.',-1);
			$extension = "mp4";//substr($resultado['Video']['url'], $posicionNombre +1 );
	
	
			$this->response->file($resultado['Video']['url'].'.'.$extension, array('download' => false, 'name' => 'foo'));
			return $this->response;
		}else{
			return new CakeResponse( array( 'body' => 'No se encuentra' ) );
		}
	
	}
	
	public function red(){
		$this->redirect("http://google.es", 301);
	}

	public function procesado($id){
		$this->Video->id = $id;
		$data['Video']['estado'] = 'procesado';
		if($this->Video->save($data)){
			CakeLog::write("debug"," El video con id ".$id." ha reportado procesado.");
		}else{
			CakeLog::write("debug"," El video con id ".$id." ha reportado procesado pero no ha sucedido un error.");
		}
		//return new CakeResponse( array( 'body' => 'ok' ) );
	}


	public function tiempo($id, $tiempo){
		$this->Video->id = $id;
		$data['Video']['time'] = $tiempo;
		if($this->Video->save($data)){
			CakeLog::write("debug"," El video con id ".$id." ha reportado un tiempo de : ". $tiempo);
		}else{
			CakeLog::write("debug"," El video con id ".$id." ha reportado un tiempo de : ". $tiempo." pero no ha sucedido un error.");
		}
		return new CakeResponse( array( 'body' => 'ok' ) );
	}

	public function testFiles($id){
		$this->Video->id = $id;
		$contenido = $this->Video->read(null, $id);
		$test['mp4'] = file_exists(WWW_ROOT.$contenido['Video']['url'].'.mp4');
		$test['webm'] = file_exists($contenido['Video']['url'].'.webm');
		$test['fotograma'] = file_exists(WWW_ROOT.'img/'.$contenido['Video']['fotograma']);
		if($test['fotograma']){
			$test['fotogramaSize'] = filesize(WWW_ROOT.'img/'.$contenido['Video']['fotograma']);
		}
		//var_dump($test);
		return $test;
		return null;
	}

	public function getImagesByEmpresa($id){
		$opciones['conditions'] = array("tipo = 'imagen' and idEmpresa = ".$id);
		$opciones['order'] = array("idVideo DESC");
		$resultado = $this->Video->find('all', $opciones);
		return $resultado;
	}
	
	public function processVideo($id, $formato, $callback = false, $medidas = array('h'=>720,'w'=>1080))
	{
		$hash = 10;
		$video = $this->Video->read(null, $id);
		//Comprobar si existe antes de continuar

		$urls = json_decode($video['Video']['url'],1);
		if( !array_key_exists( 'orig', $urls ) ){
			if( array_key_exists( 'img', $urls ) ){
				$this->processImageAsVideo( $id, 'crt_img2video', HOST.DIRECTORIO."/videos/updateVideoJsonPlusHTML5/".$id );
			}else{
				return new CakeResponse( array( 'body'=>json_encode( array( '_error'=>'No existe la referencia original' ) ) ) ) ;
			}
		}else{
			$parametros = array(
				"task" 			=> $formato,
				"URL_origen" 	=> $urls['orig'],
				"destino"		=> array(
						"method" 	=> "localStorage",
						"file_name"	=> $this->arreglarNombres( $video['Video']['descripcion'] )
					),
				"medidas"		=> array(
						"h"			=> $medidas['h'],
						"w"			=> $medidas['w']		
					),
				"callback" 		=>( $callback ) ? $callback."/".$hash : HOST.DIRECTORIO."/videos/updateVideoJson/".$id."/".$hash
				);

			$this->Process->setMethod( ( defined( 'PROCESS_METHOD' ) ) ? PROCESS_METHOD : 'directo' );
			$this->Process->sendProcess( $parametros );
		}
		return new CakeResponse( array( 'body' =>  "") );
		


		
	}

	public function processImage( $id, $formato, $size = false, $callback = false )
	{
		$hash = 10;
		$video = $this->Video->read(null, $id);
		//Comprobar si existe antes de continuar
		echo "Procesando imagen".PHP_EOL;
		$urls = json_decode($video['Video']['url'],1);
		$parametros = array(
			"task" 			=> $formato,
			"URL_origen" 	=> $urls['img'],
			"destino"		=> array(
					"method" 	=> "localStorage",
					"file_name"	=> $this->arreglarNombres( $video['Video']['descripcion'] )
			),
			"medidas"	=> array(
					"h" => ( $size ) ? $size['h'] : 720,
					"w" => ( $size ) ? $size['w'] : 1280,
					"q" => 80
			),
			"callback" 		=>( $callback ) ? $callback."/".$hash : HOST.DIRECTORIO."/videos/updateImageJson/".$video['Video']['idVideo']."/".$hash
			);
		CakeLog::write( 'debug', $parametros['callback'] );
		print_r($parametros);
		$this->Process->setMethod( ( defined( 'PROCESS_METHOD' ) ) ? PROCESS_METHOD : 'directo' );
		$this->Process->sendProcess( $parametros );
		return new CakeResponse( array( 'body' =>  "") );
		//$this->set( 'Process', $this->Process->getMethod() );
	}

	public function quitaracentos( $palabra )
	{
		$palabra = str_replace('á', 'a', $palabra);
		$palabra = str_replace('é', 'e', $palabra);
		$palabra = str_replace('í', 'i', $palabra);
		$palabra = str_replace('ó', 'o', $palabra);
		$palabra = str_replace('ú', 'u', $palabra);
		$palabra = str_replace('ñ', 'n', $palabra);

		return $palabra;
	}


	public function processImageAsVideo( $id, $formato, $callback = false )
	{
		$hash = 10;
		$video = $this->Video->read(null, $id);
		//Comprobar si existe antes de continuar

		$urls = json_decode($video['Video']['url'],1);
		$parametros = array(
			"task" 			=> $formato,
			"URL_origen" 	=> $urls['img'],
			"destino"		=> array(
					"tiempo"	=> $video['Video']['time'],
					"method" 	=> "localStorage",
					"file_name"	=> $this->arreglarNombres( $video['Video']['descripcion'] )
				),
			"callback" 		=>( $callback ) ? $callback."/".$hash : HOST.DIRECTORIO."/videos/updateVideoJson/".$video['Video']['idVideo']."/".$hash
			);
		CakeLog::write( 'debug', $parametros['callback'] );
		//print_r($parametros);
		$this->Process->setMethod( ( defined( 'PROCESS_METHOD' ) ) ? PROCESS_METHOD : 'directo' );
		$this->Process->sendProcess( $parametros );
		return new CakeResponse( array( 'body' =>  "") );
		//$this->set( 'Process', $this->Process->getMethod() );


		
	}

	public function processImageAsVideoComplete( $id, $formato )
	{
		$hash = 10;
		$video = $this->Video->read(null, $id);
		//Comprobar si existe antes de continuar

		$urls = json_decode($video['Video']['url'],1);
		$parametros = array(
			"task" 			=> $formato,
			"URL_origen" 	=> $urls['img'],
			"destino"		=> array(
					"tiempo"	=> $video['Video']['time'],
					"method" 	=> "localStorage",
					"file_name"	=> $this->arreglarNombres( $video['Video']['descripcion'] )
				),
			"callback" 		=>HOST.DIRECTORIO."/videos/updateVideoJsonPlusHTML5/".$video['Video']['idVideo']."/".$hash
			);
		CakeLog::write( 'debug', $parametros['callback'] );
		//print_r($parametros);
		$this->Process->setMethod( ( defined( 'PROCESS_METHOD' ) ) ? PROCESS_METHOD : 'directo' );
		$this->Process->sendProcess( $parametros );
		return new CakeResponse( array( 'body' =>  "") );
		//$this->set( 'Process', $this->Process->getMethod() );


		
	}

	public function updateVideoJson( $id, $hash )
	{
		$this->Video->id = $id;
		$data = $this->request->data;
		CakeLog::write('debug', "Ha ejecutado el callback");
		$registro = $this->Video->read(null, $id);
		if( $data['status'] == 'OK' ){
			$info = json_decode( $registro['Video']['url'],1 );
			( !array_key_exists( 'orig', $info ) ) ? $info['orig'] = $data['result_URL'] : false;
			$info[$data['tiempo']]['Horizontal'][$data['dimensiones']['h'].'x'.$data['dimensiones']['w']][$data['formato']] = $data['result_URL'];
			$registro['Video']['url'] = json_encode($info);
			( $registro['Video']['time'] == 0 || $registro['Video']['time'] == "" ) ? $registro['Video']['time'] = $data['tiempo'] : false; 
			( $registro['Video']['estado'] == 'sin procesar') ? $registro['Video']['estado'] = 'procesado' : false;
			$this->Video->save($registro);
			var_dump($info);
		}else{
			echo "ERROR";
		}
		return new CakeResponse( array( 'body' =>  "") );
		
	}

	public function updateImageJson( $id, $hash )
	{
		$this->Video->id = $id;
		$data = $this->request->data;
		echo "Esto es lo que se envia al callback".PHP_EOL;
		print_r( $this->request->data);
		CakeLog::write('debug', "Ha ejecutado el callback");
		$registro = $this->Video->read(null, $id);
		if( $data['status'] == 'OK' ){
			$info = json_decode( $registro['Video']['url'],1 );
			//( !array_key_exists( 'orig', $info ) ) ? $info['orig'] = $data['result_URL'] : false;
			$info['imgs']['Horizontal'][$data['formato']] = $data['result_URL'];
			$registro['Video']['url'] = json_encode($info);
			( $registro['Video']['time'] == 0 || $registro['Video']['time'] == "" ) ? $registro['Video']['time'] = $data['tiempo'] : false; 
			( $registro['Video']['estado'] == 'sin procesar') ? $registro['Video']['estado'] = 'procesado' : false;
			$this->Video->save($registro);
			var_dump($info);
		}else{
			echo "ERROR";
		}
		return new CakeResponse( array( 'body' =>  "") );
		
	}

	public function updateVideoJsonPlusHTML5( $id, $hash )
	{
		$this->Video->id = $id;
		$data = $this->request->data;
		CakeLog::write('debug', "Ha ejecutado el callback");
		$registro = $this->Video->read(null, $id);
		if( $data['status'] == 'OK' ){
			$info = json_decode( $registro['Video']['url'],1 );
			( !array_key_exists( 'orig', $info ) ) ? $info['orig'] = $data['result_URL'] : false;
			$info[$data['tiempo']]['Horizontal'][$data['dimensiones']['h'].'x'.$data['dimensiones']['w']][$data['formato']] = $data['result_URL'];
			$registro['Video']['url'] = json_encode($info);
			( $registro['Video']['time'] == 0 || $registro['Video']['time'] == "" ) ? $registro['Video']['time'] = $data['tiempo'] : false; 
			( $registro['Video']['estado'] == 'sin procesar') ? $registro['Video']['estado'] = 'procesado' : false;
			$this->Video->save($registro);
			var_dump($info);
			$this->processVideo($id, 'crt_webm');
			$this->processVideo($id, 'crt_mp4');
			$this->thumbnail($id);
		}else{
			echo "ERROR";
		}
		return new CakeResponse( array( 'body' =>  "") );

		
	}

	public function updateFotogramaJson( $id, $hash )
	{
		$this->Video->id = $id;
		$data = $this->request->data;
		print_r($data);
		CakeLog::write('debug', "Ha ejecutado el callback");
		$registro = $this->Video->read(null, $id);
		if( $data['status'] == 'OK' ){
			$registro['Video']['fotograma'] = $data['result_URL'];
			$this->Video->save($registro);
			var_dump($data);
		}else{
			echo "ERROR";
		}
		return new CakeResponse( array( 'body' =>  "") );
		
	}

	public function changeURLs()
	{
		$resultado = $this->Video->find('all');
		foreach( $resultado as $video ){
			if( strpos( $video['Video']['url'] ,'"orig"') === false ){
				$name_exploded = explode( '.', $video['Video']['name'] );
				$ext = $name_exploded[count( $name_exploded ) -1];
				$campo = ( $video['Video']['tipo'] == 'imagen' ) ? 'img' : 'orig';
				$info[$campo] = ( strpos($video['Video']['url'], "https://") === false ) ? HOST.DIRECTORIO."/" : "";
				$info[$campo] .= $video['Video']['url'].'.'.$ext;
				$video['Video']['url'] = json_encode( $info );
				$this->Video->id = $video['Video']['id'];
				$this->Video->save($video);

			}
			$variable[] = $info;
		}
		return new CakeResponse( array( 'body' =>  json_encode( $variable ) ) );
	}
}
