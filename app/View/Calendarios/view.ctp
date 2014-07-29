<div class="calendarios view">
<h2><?php  echo __('Calendario');?></h2>
	<dl>
		<dt><?php echo __('IdCalendario'); ?></dt>
		<dd>
			<?php echo h($calendario['Calendario']['idCalendario']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('IdUsuario'); ?></dt>
		<dd>
			<?php echo h($calendario['Calendario']['idUsuario']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Timestamp'); ?></dt>
		<dd>
			<?php echo h($calendario['Calendario']['timestamp']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Calendario'), array('action' => 'edit', $calendario['Calendario']['idCalendario'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Calendario'), array('action' => 'delete', $calendario['Calendario']['idCalendario']), null, __('Are you sure you want to delete # %s?', $calendario['Calendario']['idCalendario'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendarios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendario'), array('action' => 'add')); ?> </li>
	</ul>
</div>
