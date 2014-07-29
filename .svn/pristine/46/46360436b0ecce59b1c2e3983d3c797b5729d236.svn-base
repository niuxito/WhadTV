<div class="configuracions form">
<?php echo $this->Form->create('Configuracion'); ?>
	<fieldset>
		<legend><?php echo __('Edit Configuracion'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('Nombre');
		echo $this->Form->input('Valor');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Configuracion.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Configuracion.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Configuracions'), array('action' => 'index')); ?></li>
	</ul>
</div>
