<div class="users index">
	<h2><?php echo __('Users');?></h2>
	<table cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?></td>
		
		
	</tr>
<?php endforeach; ?>
	</table>
	
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Panel de control'), array('action' => '../Empresas/panel')); ?></li>
		<li><?php echo $this->Html->link(__('Invitar'), array('action' => 'invitar')); ?></li>
		<li><?php echo $this->Html->link(__('Salir'), array('action' => '../Users/logout')); ?></li>
		
	</ul>
</div>