<div class="Consejos index">
	<h2><?php echo __('Consejos');?></h2>
	<table cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($Consejos as $Consejo): ?>
	<tr>
		<td><?php echo h($Consejo['Consejo']['idConsejo']); ?>&nbsp;</td>
		<td><?php echo h($Consejo['Consejo']['idUsuario']); ?>&nbsp;</td>
		<td><?php echo h($Consejo['Consejo']['descripcion']); ?>&nbsp;</td>

		<td><?php echo h($Consejo['Consejo']['created']); ?>&nbsp;</td>
		<td><?php echo h($Consejo['Consejo']['page']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $Consejo['Consejo']['idConsejo'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $Consejo['Consejo']['idConsejo'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $Consejo['Consejo']['idConsejo']), null, __('Are you sure you want to delete # %s?', $Consejo['Consejo']['idConsejo'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
</div>
