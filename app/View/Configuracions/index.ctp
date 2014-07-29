<div class="configuracions index">
	<h2><?php echo __('Configuracions'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('Valor'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($configuracions as $configuracion): ?>
	<tr>
		<td><?php echo h($configuracion['Configuracion']['id']); ?>&nbsp;</td>
		<td><?php echo h($configuracion['Configuracion']['Nombre']); ?>&nbsp;</td>
		<td><?php echo h($configuracion['Configuracion']['Valor']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $configuracion['Configuracion']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $configuracion['Configuracion']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $configuracion['Configuracion']['id']), null, __('Are you sure you want to delete # %s?', $configuracion['Configuracion']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Configuracion'), array('action' => 'add')); ?></li>
	</ul>
</div>
