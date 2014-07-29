<?php echo $this->Html->script('empresas'); ?>
<?php echo $this->Html->css('empresas'); ?>
<div class="empresa">
<div id=header>
<?php 
	$data = $this->Session->read('Auth');
	echo $this->Html->link($data['User']['username'], array('action' => '../users/edit'));
 ?>
 </div>
 <div>
 <table cellpadding="0" cellspacing="0">
	
	
	<tr>
		<td><?php echo $this->Html->link($empresa['Empresa']['idEmpresa'], array('action' => 'edit', $empresa['Empresa']['idEmpresa'])); ?>&nbsp;</td>
		<td><?php echo h($empresa['Empresa']['Nombre']); ?>&nbsp;</td>
		<td><a><img id="<?php echo $empresa['Empresa']['idEmpresa']; ?>" class="logo" src="/GestVideo/<?php echo $empresa['Empresa']['url']; ?>"  width="80" height="80" ></img></a></td>
		
		<td class="actions">
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $empresa['Empresa']['idEmpresa']), null, __('Are you sure you want to delete # %s?', $empresa['Empresa']['idEmpresa'])); ?>
		</td>
	</tr>

	</table>
</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Contenido'), array('action' => '../Videos')); ?></li>
		<li><?php echo $this->Html->link(__('Dispositivos'), array('action' => '../Dispositivos')); ?></li>
		<li><?php echo $this->Html->link(__('Lista de usuarios'), array('action' => '../users/lista')); ?></li>
		<li><?php echo $this->Html->link(__('Asignar dispositivo'), array('action' => 'adddisp')); ?></li>
		<li><?php echo $this->Html->link(__('Salir'), array('action' => '../Users/logout')); ?></li>
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
