<!--<?php echo $this->Html->script('empresas'); ?>
<?php echo $this->Html->css('empresas'); ?>-->
<div class="empresas index">
	<h2><?php echo __('Empresas');?></h2>
	<table cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($empresas as $empresa): ?>
	<tr>
		<td><?php echo $this->Html->link($empresa['Empresa']['idEmpresa'], array('action' => 'panel', $empresa['Empresa']['idEmpresa'])); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['nombre']); ?>&nbsp;</td>
		<td><a><?php echo $this->Html->image(<?php echo $empresa['Empresa']['url'], array('class'=>'logo', 'id'=>'$empresa['Empresa']['idEmpresa']', 'width'=>'80', 'height'=>'80') ); ?>
		<!--<img id="<?php echo $empresa['Empresa']['idEmpresa']; ?>" class="logo" src="/GestVideo/<?php echo $empresa['Empresa']['url']; ?>"  width="80" height="80" ></img>--></a></td>
		
		<td class="actions">
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $empresa['Empresa']['idEmpresa']), null, __('Are you sure you want to delete # %s?', $empresa['Empresa']['idEmpresa'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Empresa'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Panel de control'), array('action' => 'panel')); ?></li>
	</ul>
</div>
<!--section id="formAddLogo">
	<?php echo $this->Form->create('Logo', array('url' => '/Empresas/cambiarLogo', 'type' => 'file')); ?>
	<fieldset>
	<?php
		echo $this->Form->hidden('idEmpresa');
		echo $this->Form->file('Document'); ?>
		(Nota: El fichero no puede pesar más de 32 MB." )
	  
	
	
	</fieldset>
	<?php echo $this->Form->end(__('Submit'));?>
</section>-->

