<div class="empresaUsuarios form">
<?php echo $this->Form->create('EmpresaUsuario');?>
	<fieldset>
		<legend><?php echo __('Edit Empresa Usuario'); ?></legend>
	<?php
		echo $this->Form->input('idEmpresa');
		echo $this->Form->input('IdUsuario');
		echo $this->Form->input('perfil');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('EmpresaUsuario.idEmpresa')), null, __('Are you sure you want to delete # %s?', $this->Form->value('EmpresaUsuario.idEmpresa'))); ?></li>
		<li><?php echo $this->Html->link(__('List Empresa Usuarios'), array('action' => 'index'));?></li>
	</ul>
</div>
