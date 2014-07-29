<div class="lista index">
	<h2><?php echo __('Lista');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('idLista');?></th>
			<th><?php echo $this->Paginator->sort('descripcion');?></th>
			<th><?php echo $this->Paginator->sort('idUsuario');?></th>
			<th><?php echo $this->Paginator->sort('timestamp');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($lista as $listum): ?>
	<tr>
		<td><?php echo h($listum['Listum']['idLista']); ?>&nbsp;</td>
		<td><?php echo h($listum['Listum']['descripcion']); ?>&nbsp;</td>
		<td><?php echo h($listum['Listum']['idUsuario']); ?>&nbsp;</td>
		<td><?php echo h($listum['Listum']['timestamp']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $listum['Listum']['idLista'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $listum['Listum']['idLista'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $listum['Listum']['idLista']), null, __('Are you sure you want to delete # %s?', $listum['Listum']['idLista'])); ?>
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
		<li><?php echo $this->Html->link(__('New Listum'), array('action' => 'add')); ?></li>
	</ul>
</div>
