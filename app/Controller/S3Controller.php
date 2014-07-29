<?php 
//App::import('Vendor','sdk.class');
require_once CAKE_CORE_INCLUDE_PATH.'/AWSSDK/sdk.class.php';
error_reporting(-1);

class S3Controller extends AppController{

	public static $s3;

	public function listFolders(){
		$s3 = new AmazonS3();
		$s3->disable_ssl_verification();
		$bucket = BUCKET;
		$response = $s3->get_object_list($bucket, array('prefix' => 'contenedores/1'));
		return new CakeResponse( array( 'body' => json_encode($response) ) );
	}

	public function crearEstructura(){
			$s3 = new AmazonS3();
			$s3->disable_ssl_verification();
			$bucket = BUCKET;

				$response = $s3->create_object($bucket, 'contenedores/1/Videos/', array(
    				'body' => 'This is my body text.'
				));
				$response = $s3->create_object($bucket, 'contenedores/1/Imagenes/', array(
    				'body' => 'This is my body text.'
				));
				//return new CakeResponse( array( 'body' => "No existia"  ) );
				return new CakeResponse( array( 'body' => json_encode($response->isOK()) ) );
				
	}

	public function exportarContenido(){
		App::import('Controller', 'Videos');
		$videosC = new VideosController();
		$videosC->constructClasses();
		$options['order'] = 'idEmpresa';
		$contenidos = $videosC->Video->find('all', $options);
		//$contenido = $contenidos[1];
		foreach($contenidos as $contenido){
			$nombreArchivo = str_replace("img/files/","", $contenido['Video']['url']);

			$rutaLocal = WWW_ROOT.$contenido['Video']['url'];
			$rutaSalida = 'contenedores/'.$contenido['Video']['idEmpresa'].'/Video/'.$nombreArchivo;
			$s3 = new AmazonS3();
			$s3->disable_ssl_verification();
			$bucket = BUCKET;
			$response = null;
			//Añadir videos

			//Webm
			$extension = '.webm';
			if(file_exists($rutaLocal.$extension)){
				$response = $s3->create_object($bucket, $rutaSalida.$extension, array(
	    				'fileUpload' => $rutaLocal.$extension,
	    				'acl' => AmazonS3::ACL_PUBLIC
					));
			}


			//mp4
			$extension = '.mp4';
			if(file_exists($rutaLocal.$extension)){
				$response = $s3->create_object($bucket, $rutaSalida.$extension, array(
	    				'fileUpload' => $rutaLocal.$extension,
	    				'acl' => AmazonS3::ACL_PUBLIC
					));
			}

			//Añadir imágenes
			if($contenido['Video']['tipo'] == "imagen"){
				$archivoExpandido = explode(".", $contenido['Video']['name']);
				$extension =  ".".array_pop($archivoExpandido);
				$rutaSalida = 'contenedores/'.$contenido['Video']['idEmpresa'].'/Imagen/'.$nombreArchivo;
				if(file_exists($rutaLocal.$extension)){
					$response = $s3->create_object($bucket, $rutaSalida.$extension, array(
		    				'fileUpload' => $rutaLocal.$extension,
		    				'acl' => AmazonS3::ACL_PUBLIC
						));
				}
			}




		}
		return new CakeResponse( array( 'body' => json_encode($response) ) );




	}

	public function existeEstructura($folder){
		$bucket = BUCKET;
		$s3 = new AmazonS3();
			$s3->disable_ssl_verification();
		$response = $s3->if_object_exists($bucket, 'contenedores/1/');
		print_r($response);
		return $response;

	}

	public function saveVideo($file, $ruta){
			CakeLog::write("S3", "Direcciñon del fichero: ".$file);
			CakeLog::write("S3", "Direccion en S3: ".$ruta);
			$s3 = new AmazonS3();
			$s3->disable_ssl_verification();
			$response = $s3->create_object(BUCKET, $ruta, array(
				'fileUpload'=>$file,
				'acl' => AmazonS3::ACL_PUBLIC
			));
			//CakeLog::write("S3", "Respuessta =  ".$response['Object_URL']);
			if($response->isOK()) {
				CakeLog::write("S3", "Se ha añadido el fichero");
				$url = $s3->get_object_url(BUCKET, $ruta);
				CakeLog::write("S3", "Url: ".$url);
			}else{
				$url = "";
			}
			return $url;
	}


	public function generarRuta($tipo, $idEmpresa, $nombreArchivo){
		$ruta = 'contenedores/'.$idEmpresa.'/'.$tipo.'/'.$nombreArchivo;
		return $ruta;
	} 
}