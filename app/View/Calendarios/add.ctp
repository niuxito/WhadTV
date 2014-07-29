<div class="calendarios form">
<?php echo $this->Form->create('Calendario');?>
	<fieldset>
		<legend><?php echo __('Add Calendario'); ?></legend>
	<?php
		echo $this->Form->input('idUsuario');
		echo $this->Form->input('timestamp');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Calendarios'), array('action' => 'index'));?></li>
	</ul>
</div>
