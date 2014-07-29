<div class="listaVideos form">
<?php echo $this->Form->create('ListaVideo');?>
	<fieldset>
		<legend><?php echo __('Add Lista Video'); ?></legend>
	<?php
		echo $this->Form->input('idLista');
		echo $this->Form->input('idVideo');
		echo $this->Form->input('posicion');
		echo $this->Form->input('idUsuario');
		echo $this->Form->input('timestamp');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Lista Videos'), array('action' => 'index'));?></li>
	</ul>
</div>
