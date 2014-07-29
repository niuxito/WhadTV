<div class="empresaUsuarios index">
	<h2><?php echo __('Empresa Usuarios');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('idEmpresa');?></th>
			<th><?php echo $this->Paginator->sort('IdUsuario');?></th>
			<th><?php echo $this->Paginator->sort('perfil');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($empresaUsuarios as $empresaUsuario): ?>
	<tr>
		<td><?php echo h($empresaUsuario['EmpresaUsuario']['idEmpresa']); ?>&nbsp;</td>
		<td><?php echo h($empresaUsuario['EmpresaUsuario']['IdUsuario']); ?>&nbsp;</td>
		<td><?php echo h($empresaUsuario['EmpresaUsuario']['perfil']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $empresaUsuario['EmpresaUsuario']['idEmpresa'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $empresaUsuario['EmpresaUsuario']['idEmpresa'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $empresaUsuario['EmpresaUsuario']['idEmpresa']), null, __('Are you sure you want to delete # %s?', $empresaUsuario['EmpresaUsuario']['idEmpresa'])); ?>
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
		<li><?php echo $this->Html->link(__('New Empresa Usuario'), array('action' => 'add')); ?></li>
	</ul>
</div>
