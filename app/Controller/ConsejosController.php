<?php
App::uses('AppController', 'Controller');
/**
 * Videos Controller
 *
 * @property Video $Video
 * 
 */
class ConsejosController extends AppController {
		public $components = array('DebugKit.Toolbar','RequestHandler', 'Auth');

		public function index(){
			/*$this->Consejo->recursive = 0;
			$this->set('Consejos', $this->Consejo->find('all'));*/
			$this->listadoConsejos();

		}

		public function add(){
			if ($this->request->is('post')) {
				$this->Consejo->create();

				$user = $this->Session->read('Auth');
				$this->request->data['Consejo']['idUsuario'] = $user['User']['id'];
				$this->request->data['Consejo']['page'] = $this->referer();
				
				$options['fields'] = array('max(idAsunto)idAsunto');
				$resultado =$this->Consejo->find("all", $options);
				if(count( $resultado) > 0){
					$this->request->data['Consejo']['idAsunto'] = $resultado[0][0]['idAsunto'] + 1;
				}else{
					$this->request->data['Consejo']['idAsunto'] = 1;
				}
				if ($this->Consejo->save($this->request->data)) {
					$this->Session->setFlash(__('Tu consejo ha sido enviado, lo tendremos en cuenta.'),'info');
					$this->redirect($this->referer());
				} else {
					$this->Session->setFlash(__('El consejo no ha podido guardarse. Por favor, intentalo de nuevo.'),'error');
				}
			}
		}
		
		public function cuentaConsejos($idUsuario = null){
			$options['fields'] = array('count(idAsunto)cuenta');

			$options['conditions'] = array( "idAsunto in (select idAsunto from consejo co where co.idUsuario = ".$idUsuario.") and   situacion = 'noleido' and idUsuario !=".$idUsuario);
			$resultado1 =$this->Consejo->find("all", $options);

			$options['conditions'] = array('idUsuario = '.$idUsuario );
			$resultado2 =$this->Consejo->find("all", $options);

			$resultado = array('total' => $resultado2[0][0]['cuenta'], 'noleidos'=>$resultado1[0][0]['cuenta']);
			return $resultado;
		}
		
		public function listadoConsejos($idUsuario = null){
			if($idUsuario == null){
				$user = $this->Session->read('Auth');
				$idUsuario = $user['User']['id'];
			}
			$options['fields'] = array('idConsejo','descripcion','idUsuario','users.username','situacion','created','idAsunto');
			$options['group'] = array('idAsunto');
			$options['conditions'] = array("idUsuario = ".$idUsuario." and idConsejo IN (SELECT MIN(idConsejo) FROM `consejo` GROUP BY idAsunto)");
			$options['joins'] = array(
					array('table' => 'users',			
							'type' => 'left',
							'conditions' => array(
									'users.id = Consejo.idUsuario',
										
							)
					)
			);
			$options['order'] = ('situacion desc,idAsunto');
			$this->set('consejos',$this->Consejo->find('all',$options));
			
			
			$options2['fields'] = array('idAsunto','count(distinct idConsejo) nMensajes');
			$options2['group'] = array('idAsunto');
			$options2['order'] = ('idAsunto');
			
			$this->set('cuentaMensajes',$this->Consejo->find('all',$options2));
			
			if ($this->request->is('post')) {
				$user = $this->Session->read('Auth');
				$this->request->data['Consejo1']['idUsuario'] = $user['User']['id'];
				$this->request->data['Consejo1']['page'] = $this->referer();
				$optionsMxid['fields'] = array('max(idAsunto)idAsunto');
				$resultadoMxid =$this->Consejo->find("all", $optionsMxid);
				if(count( $resultadoMxid) > 0){
					$this->request->data['Consejo1']['idAsunto'] = $resultadoMxid[0][0]['idAsunto'] + 1;
				}else{
					$this->request->data['Consejo1']['idAsunto'] = 1;
				}
				$this->request->data['Consejo'] = $this->request->data['Consejo1'];
				if ($this->Consejo->save($this->request->data)) {
					$this->Session->setFlash(__('Tu consejo ha sido enviado, lo tendremos en cuenta.'), 'info');
					$this->redirect(array('action' => 'listadoConsejos/'.$idUsuario));
				} else {
					$this->Session->setFlash(__('El consejo no ha podido guardarse. Por favor, intentalo de nuevo.'), 'error');
				}
			}
			
			$this->render('listadoConsejos','admin');
		
		}
		
		public function listadoAsunto($idAsunto = null){
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
			$options['order'] = ('idConsejo');
			$mensajes = $this->Consejo->find('all',$options);
			$this->set('consejos', $mensajes);
			$this->marcarComoLeido($mensajes);
			$this->Consejo->id = "";


			if ($this->request->is('post')) {
				$user = $this->Session->read('Auth');
				$this->request->data['Consejo1']['idUsuario'] = $user['User']['id'];
				$this->request->data['Consejo1']['page'] = $this->referer();
				$this->request->data['Consejo1']['idAsunto'] = $idAsunto;
				$options['fields'] = array('situacion');
				$options['conditions'] = array('idAsunto ='.$idAsunto); 
				$options['order'] = ('idConsejo');
				$resultado =$this->Consejo->find("all", $options);
				if(count($resultado) > 0){
					$this->request->data['Consejo1']['situacion'] = $resultado[0]['Consejo']['situacion'];
				}else{
					$this->request->data['Consejo1']['situacion'] = 1;
				}
				$this->request->data['Consejo'] = $this->request->data['Consejo1'];
				if ($this->Consejo->save($this->request->data)) {
					$this->Session->setFlash(__('Respuesta enviada.'),'info');
					$this->redirect(array('action' => 'listadoAsunto/'.$idAsunto));
				} else {
					$this->Session->setFlash(__('La respuesta no ha podido guardarse. Por favor, intentalo de nuevo.'),'error');
				}
			}
			$this->render('listado_asunto', 'loged');
		
		}

		public function marcarComoLeido($mensajes){
			$user = $this->Session->read('Auth');
			foreach ($mensajes as $mensaje){
				$this->Consejo->id = $mensaje['Consejo']['idConsejo'];
				if($mensaje['Consejo']['idUsuario'] != $user['User']['id'] && $mensaje['Consejo']['situacion'] == 'noleido'){
					$data['Consejo']['situacion'] = 'leido';
					if($this->Consejo->save($data)){
						$this->Session->setFlash(__('Leido'), 'info');
					}
				}
			}

		}
}
