<div class="dispositivos form">
<?php echo $this->Form->create('Dispositivo');?>
	<fieldset>
		<legend><?php echo __('Edit Dispositivo'); ?></legend>
	<?php
		echo $this->Form->input('idDispositivo');
		//echo $this->Form->input('idCalendario');
		//echo $this->Form->input('idUsuario');
		echo $this->Form->input('descripcion');
		//echo $this->Form->input('latitud');
		//echo $this->Form->input('longitud');
		//echo $this->Form->input('caducidad');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Dispositivo.idDispositivo')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Dispositivo.idDispositivo'))); ?></li>
		<li><?php echo $this->Html->link(__('List Dispositivos'), array('action' => 'index'));?></li>
	</ul>
</div>
