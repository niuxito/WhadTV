<?php 
App::import('Controller', 'Users');
App::import('Controller', 'EmpresaUsuarios');
App::import('Controller', 'Videos');

class CartelesController extends AppController{

	public $components = array('DebugKit.Toolbar','RequestHandler', 'Auth');
	
	public function beforeFilter(){
		parent::beforeFilter();
	}

	public function clearCache(){
		Cache::clear(false);
	}

	public function index(){
		$this->render('index', 'empty');
	}

	/**
	 * addCartel method
	 *
	 * @return void
	 */
	public function addCartel() {
		
	}

	public function addImage(){

	}

	public function getMyImages(){
		$empresa = $this->Session->read('Empresa');
		$id = $empresa['Empresa']['idEmpresa'];
		$videosC = new VideosController();
		$videosC->constructClasses();
		$imagenes = $videosC->getImagesByEmpresa($id);

		
		$newImagenes = array();
		$i =0;
		foreach( $imagenes as $imagen){
			
			$archivoExpandido = explode(".", $imagen['Video']['name']);
			$extension = array_pop($archivoExpandido);
			$json_url = json_decode( $imagen['Video']['url'], 1 ); 
			if( array_key_exists( 'img', $json_url ) ){
				$newImagen = array(
					'url_fotograma' => $imagen['Video']['fotograma'],
					'url' 			=> $json_url['img'],
					'width'			=> 160,
					'height'		=> 90,
					'title'			=>$imagen['Video']['descripcion'],
					'id'			=> "img".$imagen['Video']['idVideo'],
					'pos'			=>++$i
				);
				array_push($newImagenes, $newImagen);
			}

		}

		return new CakeResponse( array( 'body' => json_encode($newImagenes) ) );
	}

}

?>