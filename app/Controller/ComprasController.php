<?php
App::uses('AppController', 'Controller');

require_once CAKE_CORE_INCLUDE_PATH.'/stripe-php-1.17.1/lib/Stripe.php';
/**
 * Compras Controller
 *
 * 
 */
class ComprasController extends AppController {
	public $components = array('DebugKit.Toolbar','RequestHandler', 'Session', 'Auth');
	

	function beforeFilter(){
		
		parent::beforeFilter();
		parent::testAuth();
	}

	function generarCargo($tipoRep, $tipoCargo, $id){
		if( $this->request->is('POST')){
			$user = $this->Session->read('Auth');
			$empresa = $this->Session->read('Empresa');
			$extra = json_encode(array('tipoRep'=>$tipoRep, 'tipoCargo'=>$tipoCargo, 'id'=>$id));
			
			$this->request->data['Compra']['idEmpresa'] = $empresa['Empresa']['idEmpresa'];
			$this->request->data['Compra']['idUsuario'] = $user['User']['id'];
			$this->request->data['Compra']['concepto'] = $extra;
			$this->request->data['Compra']['token'] = $this->request->data['stripeToken'];
			$this->request->data['Compra']['tokenType'] = $this->request->data['stripeTokenType'];
			$this->request->data['Compra']['fecha_solicitud'] = DboSource::expression('NOW()');
			$this->request->data['Compra']['ejecutado'] = 0;

			if($this->Compra->save($this->request->data)){
				$this->Compra->id =  $this->Compra->id;

				$stripe = array(
				  "secret_key"      => "sk_test_54FGjjmeoruogUYxSdBKVYcz",
				  "publishable_key" => "pk_test_inKkeI9U0tKFxoIL0NKABOor"
				);

				Stripe::setApiKey($stripe['secret_key']);

				/*$customer = Stripe_Customer::create(array(
				      'email' => $user['User']['username'],
				      'card'  => $this->request->data['Compra']['token']
				));*/

				try {
					$charge = Stripe_Charge::create(array(
					  "amount" => $this->getCost($tipoCargo), // amount in cents, again
					  "currency" => "eur",
					  "card" => $this->request->data['Compra']['token'],
					  "description" => $extra )
					);

					$data['Compra']['ejecutado'] = 1;
					$data['Compra']['fecha_cargo'] = DboSource::expression('NOW()');
					if($this->Compra->save($data)){
						$this->LoadModel( 'Reproductor' );
						$this->Reproductor->id = $id;
						if( $tipoCargo == 'month'){
							$this->Reproductor->incrementarUnMes();
							$this->Session->setFlash(__('El pago se ha efectuado correctamente'), 'info');
						}elseif( $tipoCargo == 'year' ){
							$this->Reproductor->incrementarUnAnyo();
							$this->Session->setFlash(__('El pago se ha efectuado correctamente'), 'info');
						}else{
							CakeLog::write( 'debug', 'El tipo de pago no se conoce para la compra: '.$this->Compra->id );
						}
					}

				} catch(Stripe_CardError $e) {
				  CakeLog::write( "debug", "NO se ha aceptado el pago" );
				}
			}
		}
		$this->redirect( array( 'controller'=>'Reproductors', 'action' => 'index' ) );
	}

	function getCost( $tipo ){
		if( $tipo == "month" ){
			return 1000;
		}elseif( $tipo == "year" ){
			return 10000;
		}else{
			return 0;
		}
	}
	
}
?>