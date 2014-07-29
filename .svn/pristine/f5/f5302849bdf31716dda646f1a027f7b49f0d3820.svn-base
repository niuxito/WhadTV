<div class="listaDispositivos index">
	<h2><?php echo __('Lista Dispositivos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('idLista');?></th>
			<th><?php echo $this->Paginator->sort('idVideo');?></th>
			<th><?php echo $this->Paginator->sort('posicion');?></th>
			<th><?php echo $this->Paginator->sort('idUsuario');?></th>
			<th><?php echo $this->Paginator->sort('timestamp');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($listaDispositivos as $listaDispositivo): ?>
	<tr>
		<td><?php echo h($listaDispositivo['ListaDispositivo']['idLista']); ?>&nbsp;</td>
		<td><?php echo h($listaDispositivo['ListaDispositivo']['idVideo']); ?>&nbsp;</td>
		<td><?php echo h($listaDispositivo['ListaDispositivo']['posicion']); ?>&nbsp;</td>
		<td><?php echo h($listaDispositivo['ListaDispositivo']['idUsuario']); ?>&nbsp;</td>
		<td><?php echo h($listaDispositivo['ListaDispositivo']['timestamp']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $listaDispositivo['ListaDispositivo']['idLista'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $listaDispositivo['ListaDispositivo']['idLista'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $listaDispositivo['ListaDispositivo']['idLista']), null, __('Are you sure you want to delete # %s?', $listaDispositivo['ListaDispositivo']['idLista'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Lista Dispositivo'), array('action' => 'add')); ?></li>
	</ul>
</div>
