<div class="listaDispositivos form">
<?php echo $this->Form->create('ListaDispositivo');?>
	<fieldset>
		<legend><?php echo __('Edit Lista Dispositivo'); ?></legend>
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ListaDispositivo.idLista')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ListaDispositivo.idLista'))); ?></li>
		<li><?php echo $this->Html->link(__('List Lista Dispositivos'), array('action' => 'index'));?></li>
	</ul>
</div>
