<?php

App::uses('Component', 'Controller');
require_once CAKE_CORE_INCLUDE_PATH.'/beanstalk-1.2.1/src/BeanStalk.class.php';

class ProcessComponent extends Component {

/*
	Tres formas diferentes de crear un proceso:
	- Beanstalk
	- SQL
	- Directo

*/
	public $method;

	public function __construct( ComponentCollection $collection, $settings = array() )
	{
		parent::__construct( $collection, $settings );
	}

	public function setMethod( $method = null )
	{
		( !is_null( $method ) ) ? $this->method = $method : false;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function sendProcess( $parametros = null)
	{
		if( $this->method == "directo" ){
			CakeLog::write('debug', 'Se va a enviar el proceso por metodo directo');
			$data_string = json_encode( $parametros );
			$ch = curl_init( ( defined( 'PROCESS_SERVER' ) ) ? PROCESS_SERVER : 'http://localhost/GestVideoworkers/' );
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_string );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/json',                                                                                
			    'Content-Length: ' . strlen( $data_string ) )  
			); 
			var_dump($ch);                                                                                                                   
			$result = curl_exec( $ch );
			echo "Resultado =".PHP_EOL;
			
			CakeLog::write('debug', 'Resultado:'.print_r( $result, 1 ));
			return new CakeResponse( array( 'body' =>  json_encode($result) ) );
		}elseif( $this->method == "beanstalk" ){

			$data_string = json_encode( $parametros );
			$this->ejecutar( 'html5Convert', $parametros );
		}
	}


	public function ejecutar($pila, $mensaje){
		 $beanstalk = BeanStalk::open( 
		 	array(
		        'servers'       => array( 	( defined( BEANSTALK_HOST ) ) ? BEANSTALK_HOST : '127.0.0.1:11300' ),
		        'select'        => 'random peek'
    		)
    	);
		 
		 // 'servers'       => array( '192.168.1.2:11300' ),
		 //var_dump($beanstalk);
		 $pilas = null;

		 $beanstalk->list_tubes( $pilas );
		 CakeLog::write('debug', 'Lista de pilas impresa...');
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
}
