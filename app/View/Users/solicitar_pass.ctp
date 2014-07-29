<?php
	echo $this->Session->flash('auth');
	echo $this->Form->create('User', array('action' => 'enviarSolicitudPass'));
	echo $this->Form->input('username');
	echo $this->Form->end('Enviar solicitud');
	
?>