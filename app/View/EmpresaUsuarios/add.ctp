<div class="empresaUsuarios form">
<?php echo $this->Form->create('EmpresaUsuario');?>
	<fieldset>
		<legend><?php echo __('Add Empresa Usuario'); ?></legend>
	<?php
		echo $this->Form->input('IdUsuario');
		echo $this->Form->input('perfil');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Empresa Usuarios'), array('action' => 'index'));?></li>
	</ul>
</div>
