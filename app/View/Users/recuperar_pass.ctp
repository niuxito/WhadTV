<?php
	echo $this->Session->flash('auth');
	echo $this->Form->create('User', array('action' => 'cambiarPassword'));
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->input('repassword');
	echo $this->Form->hidden('random', array('value'=>$random));
	echo $this->Form->end('Cambiar');
?>