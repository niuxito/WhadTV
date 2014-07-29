<div class="calendarioVideos form">
<?php echo $this->Form->create('CalendarioVideo');?>
	<fieldset>
		<legend><?php echo __('Edit Calendario Video'); ?></legend>
	<?php
		echo $this->Form->input('idCalendario');
		echo $this->Form->input('idVideo');
		echo $this->Form->input('fechaReproduccion');
		echo $this->Form->input('idUsuario');
		echo $this->Form->input('timestamp');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CalendarioVideo.idCalendario')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CalendarioVideo.idCalendario'))); ?></li>
		<li><?php echo $this->Html->link(__('List Calendario Videos'), array('action' => 'index'));?></li>
	</ul>
</div>
