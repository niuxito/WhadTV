<?php
App::uses('AppController', 'Controller');
App::import('Controller', 'Empresas');
/**
 * Conectores Controller
 *
 * @property Empresa $Empresa
 */
class ConectoresController extends AppController {
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
		//$this->redirect(array('controller'=>'Videos', 'action'=>'index'));
	}

	public function listaConectores($idEmpresa = null){
		$this->loadModel('Conector');
		$options['fields'] = array('Conector.id','Conector.idEmpresa','Conector.descripcion','Conector.estado','Conector.fecha_creacion','Conector.codigo','count(conectorSecret.id) cantidad');
		$options['group'] = array('Conector.id');
		$options['conditions'] = array("idEmpresa = ".$idEmpresa);
		$options['joins'] = array(
				array('table' => 'conectorSecret',			
						'type' => 'left',
						'conditions' => array(
								'conectorSecret.idConector = Conector.id',
									
						)
				)
		);
		$options['order'] = ('Conector.id');
		$this->set('conectores',$this->Conector->find('all',$options));

		if ($this->request->is('post')) {
			$this->request->data['Conector']['idEmpresa'] = $idEmpresa;
			$this->request->data['Conector']['fecha_creacion'] =  DboSource::expression('NOW()');
			
			$optionsMxid['fields'] = array('max(id)id');
			$resultadoMxid =$this->Conector->find("all", $optionsMxid);
			if(count( $resultadoMxid) > 0){
				$id = $resultadoMxid[0][0]['id'] + 1;
			}else{
				$id = 1;
			}
			$this->request->data['Conector']['codigo'] = 'CON'.$id.'EMP'.$idEmpresa.'FC'.date('y').date('m').date('d');
			if ($this->Conector->save($this->request->data)) {
				$this->Session->setFlash(__('El conector se ha creado.'), 'info');
				$this->redirect(array('action' => 'listaConectores/'.$idEmpresa));
			} else {
				$this->Session->setFlash(__('El conector no ha podido crearse. Por favor, intentalo de nuevo.'), 'error');
			}
		}

		$this->set('empresa',$idEmpresa);
		$this->render('listaConectores','loged');
	
	}
	
	/**
	* delete method
	*
	* @param string $id
	* @return void
	*/

	public function deleteConector($idConector = null){
		$this->loadModel('Conector');
		$this->loadModel('ConectorSecret');
		$this->Conector->id = $idConector;
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		$resultado =$this->ConectorSecret->find("all", array('conditions'=>'idConector='.$idConector));
		if(count($resultado) > 0){
			foreach($resultado as $conectorSecret){
				$this->deleteConectorSecret($conectorSecret['ConectorSecret']['id'], false);
			}
		}

		$resultado = $this->Conector->find('all',array('conditions'=>'id = '.$idConector));
		if ($resultado == 0) {
			$this->Session->setFlash(__('El conector no existe en esta empresa.'), 'error');
		}else{
			if ($this->Conector->delete()){
				$this->Session->setFlash(__('El conector ha sido eliminado correctamente en la empresa.'), 'info');
			}else{
				$this->Session->setFlash(__('El conector no ha podido ser eliminado en la empresa.'), 'error');
			}
		}
		$this->redirect($this->referer());
	}
	
	public function cambiarEstadoConector($idConector = null, $estado = null){
		$this->loadModel('Conector');
		$this->Conector->id = $idConector;

		if ($estado == '0'){
			$estado = '1';
		}else{
			$estado = '0';
		}
		$this->request->data['Conector'][ 'estado' ] = $estado;
		if ($this->Conector->save($this->request->data)) {
			$this->Session->setFlash(__('El estado del conector ha sido cambiado.'),'info');
		} else {
			$this->Session->setFlash(__('El estado del conector no se ha podido cambiar correctamente.'), 'error');
		}
		$this->redirect($this->referer());		
	}

	public function listaSecrets($idEmpresa = null, $idConector = null){
		// Palabra clave - WhadTVConector
		$claveWord = 'WhadTVConector';
		//$this->loadModel('Conector');
		$this->loadModel('ConectorSecret');
		$options['conditions'] = array("idConector = ".$idConector);
		$options['order'] = ('id');
		$this->set('secrets',$this->ConectorSecret->find('all',$options));

		if ($this->request->is('post')) {
			//$fecha_creacion = DboSource::expression('NOW()');
			ini_set('date.timezone', 'Europe/Madrid');  
			$fecha_creacion = date('Y-m-d H:i:s');
			$this->request->data['ConectorSecret']['idConector'] = $idConector;
			$this->request->data['ConectorSecret']['fecha_creacion'] = $fecha_creacion;
			
			$optionsMxid['fields'] = array('max(id)id');
			$optionsMxid['conditions'] = array("idConector = ".$idConector);
			$resultadoMxid =$this->ConectorSecret->find("all", $optionsMxid);
			if(count( $resultadoMxid) > 0){
				$id = $resultadoMxid[0][0]['id'] + 1;
			}else{
				$id = 1;
			}

			$this->request->data['ConectorSecret']['clave'] = md5($claveWord.$idConector.$id.$fecha_creacion);
			if ($this->ConectorSecret->save($this->request->data)) {
				$this->Session->setFlash(__('El secreto se ha creado.'), 'info');
				$this->redirect(array('action' => 'listaSecrets/',$idEmpresa, $idConector));
			} else {
				$this->Session->setFlash(__('El secreto no ha podido crearse. Por favor, intentalo de nuevo.'), 'error');
			}
		}

		$this->set('empresa',$idEmpresa);
		$this->set('conector',$idConector);
		$this->render('listaSecrets','loged');
	
	}


	public function deleteConectorSecret($idSecret = null, $refresh = true){
		$this->loadModel('ConectorSecret');
		$this->ConectorSecret->id = $idSecret;
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$resultado = $this->ConectorSecret->find('all',array('conditions'=>'id = '.$idSecret));
		if ($resultado == 0) {
			$this->Session->setFlash(__('El secreto no existe en este conector.'), 'error');
		}else{
			if ($this->ConectorSecret->delete()){
				$this->Session->setFlash(__('El secreto ha sido eliminado correctamente del conector.'), 'info');
			}else{
				$this->Session->setFlash(__('El secreto no ha podido ser eliminado del conector.'), 'error');
			}
		}
		if ($refresh){
			$this->redirect($this->referer());
		}
	}

	public function cambiarEstadoConectorSecret($idConectorSecret = null, $estado = null){
		$this->loadModel('ConectorSecret');
		$this->ConectorSecret->id = $idConectorSecret;

		if ($estado == '0'){
			$estado = '1';
		}else{
			$estado = '0';
		}
		$this->request->data['ConectorSecret'][ 'estado' ] = $estado;
		if ($this->ConectorSecret->save($this->request->data)) {
			$this->Session->setFlash(__('El estado del secreto ha sido cambiado.'),'info');
		} else {
			$this->Session->setFlash(__('El estado del secreto no se ha podido cambiar correctamente.'), 'error');
		}
		$this->redirect($this->referer());		
	}

}
