<!--<div id=registro>
	<?php
		//echo $this->Session->flash('default');
		echo $this->Form->create('User', array('action' => 'activar'));
		echo $this->Form->hidden('hashString');
		echo $this->Form->input('password', array('label' => 'Contraseña' ));
		
		echo $this->Form->end('Accede');
		echo '</br>';
		echo $this->Html->link(__('Login'), array('action' => 'login'));
	?>
</div>-->

<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_edit">





<!-- # formulari # -->

<div class="forms">

<?php echo $this->Form->create('User', array('action'=>'activar'));?>

<label for="titol_empresa" class="fld fmdm ini">
<h3>Introduzca la contraseña</h3>
<?php echo $this->Form->input('password', array('class'=>'inpt', 'type'=>'password', 'label'=>false)); ?>


</label>
<!--<?php echo $this->Form->hidden('timestamp');?>-->
<?php echo $this->Form->hidden('hashString'); ?>

<div class="box_btns">
<?php echo $this->Form->submit("Activar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>

</div><!-- /box_btns -->

<?php echo $this->Form->end();?>

</div><!-- /forms -->