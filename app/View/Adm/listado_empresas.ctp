<?php echo $this->Session->flash(); ?>
<?php echo $this->Html->script('list'); ?>
<div id="listado">
<div class="box_ops brd_bx st_empr">

<h1>
	Listado de empresas
	<!-- Search input -->
	<input class="search" placeholder="" />
</h1>

</div>

<!-- # llistat de vídeos # -->

<div class="box_list st_emp">

<div  class="mlist grn">
	<!--<h2><?php echo __('EMPRESAS');?></h2>-->
	<ul class="slist" cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($empresas as $empresa): ?>
	<li>
		<span class="selm"><?php echo h($empresa['Empresa']['idEmpresa']); ?>&nbsp;</span>
		<span ><?php echo $this->Html->link(h($empresa['Empresa']['nombre']), array('action' => 'gestEmpresa', $empresa['Empresa']['idEmpresa']),array('title'=>'Gestionar datos', 'class'=>'selm1')); ?>&nbsp;</span>
		<div class="ops">
		<?php echo $this->Html->Link($this->Html->image('px_tr.gif'), array('action'=>'listadoagenciasempresa', $empresa['Empresa']['idEmpresa']), array('title'=>'Agencias', 'escape'=>false, 'class'=>'btn st_agen')); ?>
		 <span class="inf"><?php echo $empresa['0']['agencias']; ?></span>
		<a class="btn st_vido" href="#" onClick="openSubWin('<?php echo $this->Html->url("/",true); ?>/Adm/videosxempresa/<?php echo h($empresa['Empresa']['idEmpresa']); ?>',700,300,2,'Número de vídeos de: <b><?php echo h($empresa['Empresa']['nombre']); ?></b>');return false" title="Número de vídeos"><?php echo $this->Html->image("px_tr.gif"); ?></a>
		 <span class="inf"><?php echo $empresa['0']['videos']; ?></span>
		<a class="btn st_list" href="#" onClick="openSubWin('<?php echo $this->Html->url("/",true); ?>/Adm/listasxempresa/<?php echo h($empresa['Empresa']['idEmpresa']); ?>',700,300,2,'Listas de reproducción de: <b><?php echo h($empresa['Empresa']['nombre']); ?></b>');return false" title="Listas de reproducción"><?php echo $this->Html->image("px_tr.gif"); ?></a>
		 <span class="inf"><?php echo $empresa['0']['listas']; ?></span>
		<!--<a class="btn st_disp" href="#" onClick="openSubWin('<?php echo $this->Html->url("/",true); ?>/Adm/dispositivosxempresa/<?php echo h($empresa['Empresa']['idEmpresa']); ?>',700,300,2,'Dispositivos de: <b><?php echo h($empresa['Empresa']['nombre']); ?></b>');return false" title="Dispositivos"><?php echo $this->Html->image("px_tr.gif"); ?></a>
		 <span class="inf"><?php echo $empresa['0']['dispositivos']; ?></span>-->
		<?php echo $this->Html->Link($this->Html->image('px_tr.gif'), array('action'=>'listadodispositivosempresa', $empresa['Empresa']['idEmpresa']), array('title'=>'Dispositivos', 'escape'=>false, 'class'=>'btn st_disp')); ?>
		 <span class="inf"><?php echo $empresa['0']['dispositivos']; ?></span>
		<?php echo $this->Html->Link($this->Html->image('px_tr.gif'), array('action'=>'listadousuariosempresa', $empresa['Empresa']['idEmpresa']), array('title'=>'Usuarios', 'escape'=>false, 'class'=>'btn st_usu')); ?>
		 <span class="inf"><?php echo $empresa['0']['usuarios']; ?></span>
 		<div class="ops">
			<?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'deleteEmpresa', $empresa['Empresa']['idEmpresa']),array('title'=>'Dar de baja esta empresa','escape'=>false, 'class'=>'btn st_del') ,__('¿Estás seguro de que deseas dar de baja esta empresa?')); ?>
		</div>
		<!--<?php echo $this->Html->link(
				$this->Html->image('px_tr.gif'), 
				array('controller'=>'videos','action'=>'videosxlista', $empresa['Empresa']['idEmpresa']), 
				array('class'=>'btn st_vido','escape'=>false)); 
			?>
			<span class="inf"><?php echo $empresa[0]['videos']; ?></span><? echo $this->Form->postLink(
			$this->Html->image("px_tr.gif"),
			 array('controller'=>'Empresas', 'action' => 'delete', $empresa['Empresa']['idEmpresa']),
	    	array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar empresa'),
	    	 __('¿Desea eliminar la empresa '. $empresa['Empresa']['nombre'] .' realmente?'));
		?>
		-->
		</div>
		<td class="actions">
			
			<!--<?php //echo $this->Form->postLink(__('Delete'), array('controller'=>'users','action' => 'delete', $empresa['Empresa']['id']), null, __('Are you sure you want to delete # %s?', $empresa['Empresa']['id'])); ?>
		--></td>
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'index'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
</div>

<div class="acciones">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nueva empresa'), array('action' => 'addEmpresa')); ?></li>
	</ul>
</div>