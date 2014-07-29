<div class="videos form">
<?php echo $this->Form->create('Video');?>
	<fieldset>
		<legend><?php echo __('Edit Video'); ?></legend>
	<?php
		echo $this->Form->hidden('idVideo');
		echo $this->Form->hidden('idUsuario');
		echo $this->Form->input('descripcion');
		echo $this->Form->hidden('timestamp');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Video.idVideo')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Video.idVideo'))); ?></li>
		<li><?php echo $this->Html->link(__('List Videos'), array('action' => 'index'));?></li>
	</ul>
</div>
