<?php echo $this->Html->script('empresas'); ?>
<?php echo $this->Html->css('empresas'); ?>
<div class="empresas index">
	<h2><?php echo __('Empresas');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('idEmpresa');?></th>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th><?php echo $this->Paginator->sort('Logo');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($empresas as $empresa): ?>
	<tr>
		<td><?php echo $this->Html->link($empresa['Empresa']['idEmpresa'], array('action' => 'edit', $empresa['Empresa']['idEmpresa'])); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['nombre']); ?>&nbsp;</td>
		<td>
		<a><?php echo $this->Html->image( $empresa['Empresa']['url'], array('class'=>'logo', 'id'=>$empresa['Empresa']['idEmpresa'], 'width'=>'80', 'height'=>'80') ); ?>
		<!--<img id="<?php echo $empresa['Empresa']['idEmpresa']; ?>" class="logo" src="/GestVideo/<?php echo $empresa['Empresa']['url']; ?>"  width="80" height="80" ></img>--></a></td>
		
		<td class="actions">
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $empresa['Empresa']['idEmpresa']), null, __('Are you sure you want to delete # %s?', $empresa['Empresa']['idEmpresa'])); ?>
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
		<li><?php echo $this->Html->link(__('New Empresa'), array('action' => 'add')); ?></li>
	</ul>
</div>
<section id="formAddLogo">
	<?php echo $this->Form->create('Logo', array('url' => '/Empresas/cambiarLogo', 'type' => 'file')); ?>
	<fieldset>
	<?php
		echo $this->Form->hidden('idEmpresa');
		echo $this->Form->file('Document'); ?>
		(Nota: El fichero no puede pesar más de 32 MB." )
	  
	
	
	</fieldset>
	<?php echo $this->Form->end(__('Submit'));?>
</section>
