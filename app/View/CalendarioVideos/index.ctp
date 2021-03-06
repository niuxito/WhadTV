<div class="calendarioVideos index">
	<h2><?php echo __('Calendario Videos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('idCalendario');?></th>
			<th><?php echo $this->Paginator->sort('idVideo');?></th>
			<th><?php echo $this->Paginator->sort('fechaReproduccion');?></th>
			<th><?php echo $this->Paginator->sort('idUsuario');?></th>
			<th><?php echo $this->Paginator->sort('timestamp');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($calendarioVideos as $calendarioVideo): ?>
	<tr>
		<td><?php echo h($calendarioVideo['CalendarioVideo']['idCalendario']); ?>&nbsp;</td>
		<td><?php echo h($calendarioVideo['CalendarioVideo']['idVideo']); ?>&nbsp;</td>
		<td><?php echo h($calendarioVideo['CalendarioVideo']['fechaReproduccion']); ?>&nbsp;</td>
		<td><?php echo h($calendarioVideo['CalendarioVideo']['idUsuario']); ?>&nbsp;</td>
		<td><?php echo h($calendarioVideo['CalendarioVideo']['timestamp']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $calendarioVideo['CalendarioVideo']['idCalendario'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $calendarioVideo['CalendarioVideo']['idCalendario'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $calendarioVideo['CalendarioVideo']['idCalendario']), null, __('Are you sure you want to delete # %s?', $calendarioVideo['CalendarioVideo']['idCalendario'])); ?>
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
		<li><?php echo $this->Html->link(__('New Calendario Video'), array('action' => 'add')); ?></li>
	</ul>
</div>
