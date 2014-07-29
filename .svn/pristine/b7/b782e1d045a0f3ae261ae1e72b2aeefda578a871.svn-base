<!--<?php echo $this->Html->css('register'); ?>-->
<div class="box_ops brd_bx st_edit">

<h1>Formulario de registro</h1>

<div class="ops">

<!-- tornar -->

<div class="fld icon st_cancel">
	<?php echo $this->Html->link($this->Html->image("px_tr.gif"), array('controller'=>'videos', 'action'=>'index'), array('escape'=>false, 'title'=>'Cancelar contacto')); ?>
</div>

</div>

</div>
<div id="registro" class="forms">
	<?php
		echo $this->Session->flash('default');
	?>
	
	<?php echo $this->Form->create('User', array('action' => 'register')); ?>
		
	<label for="user" class="fld fmdm">
	<h3>Nombre de empresa:<span class="obl">*</span></h3>
		<?php	echo $this->Form->input('empresa'	, array('label' => false, 'class'=>'inpt')); ?>
	</label>
	
	<label for="user" class="fld fmdm">
	<h3>Correo electrónico:<span class="obl">*</span></h3>
		<?php	echo $this->Form->input('username' , array('label' => false, 'class'=>'inpt')); ?>
	</label>
	
	<label for="user" class="fld fmdm">
	<h3>Contraseña:<span class="obl">*</span></h3>
		<?php echo $this->Form->input('password', array('label' => false, 'class'=>'inpt' )); ?>
	</label>
	
	<label for="user" class="fld fmdm">
	<h3>Repita contraseña:<span class="obl">*</span></h3>
		<?php	echo $this->Form->input('cpassword', array('label' => false, 'type'=>'password', 'class'=>'inpt'));?>
	</label>	
	<label>
		<?php echo $this->Form->checkbox('normas');
		?> Al pulsar sobre el botón Enviar registro, acepta nuestras 
		<?php echo	$this->Html->link('Condiciones', array('controller'=>'pages','action'=>'legal'),array('target'=>'_blank')) ?>
						, y que ha leido y entendido nuestra Política de uso de datos
		
	</label>
	<div class="gnr_inf">Los campos con <b>*</b> son obligatorios</div>
	<div class="box_btns">
		
		<?php echo $this->Form->submit('Enviar registro &raquo;', array('class'=>'btn up', 'name'=>'submit_ok', 'escape'=>false, 'div'=>false))?>
		<?php echo $this->Html->link(__('&laquo Volver'), array('action' => 'login'), array('class'=>'btn', 'div'=>false, 'escape'=>false)); ?>
		
	
	</div>
	<?php echo $this->Form->end(); ?>
</div>

<div id=noticias></div>