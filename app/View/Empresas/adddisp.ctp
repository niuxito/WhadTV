<div class="form">
<?php echo $this->Form->create("Dispositivo", array("controller" => "Dispositivos", "action" => "asignar")); ?>
<fieldset>
	<?php echo $this->Form->input("id"); ?>



</fieldset>
<?php echo $this->Form->end("Submit"); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Empresa.idEmpresa')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Empresa.idEmpresa'))); ?></li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Salir'), array('action' => '../Users/logout')); ?></li>
	</ul>
</div>