<div class="calendarios form">
<?php echo $this->Form->create('Calendario');?>
	<fieldset>
		<legend><?php echo __('Edit Calendario'); ?></legend>
	<?php
		echo $this->Form->input('idCalendario');
		echo $this->Form->input('idUsuario');
		echo $this->Form->input('timestamp');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Calendario.idCalendario')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Calendario.idCalendario'))); ?></li>
		<li><?php echo $this->Html->link(__('List Calendarios'), array('action' => 'index'));?></li>
	</ul>
</div>
