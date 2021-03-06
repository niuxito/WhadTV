<?php echo $this->Session->flash(); ?>
<?php echo $this->Html->script('list'); ?>
<div id="listado">
<div  class="box_ops brd_bx st_empr">
	<h1>
		Listado de dispositivos
		<!-- Search input -->
		<input class="search" placeholder="" />
	</h1>
</div>




<!-- # llistat de dispositivos # -->

<div  class="box_ops brd_bx st_empr">

<div   class="box_disp list">
	
<div  class="slist">
<?php
	$i = 0;
	$d = 0;
	foreach ($dispositivos as $dispositivo): ?>
	
	<div class="elm">
	<a class="dsp" href="editarReproductor/<?php echo $dispositivo['Dispositivo']['idDispositivo'] ?>"><?php echo $this->Html->image("px_tr.gif"); ?><br /><span class="selm"><?php echo h($dispositivo['Dispositivo']['descripcion'])?></span><br /> F.Alta: <?php echo h($dispositivo['Dispositivo']['timestamp']); ?><br /> F.Cad: <?php echo h($dispositivo['Dispositivo']['caducidad']); ?><!-- <span class="usge"><b>35<i>%</i></b><span class="barr"><span class="prct" style="width:35%"></span></span></span>--></a>	
	<div class="alrts">
		<a class="btn st_rfsh push" href="#" title="Sincronizar vídeos" id="<?php echo $dispositivo['Dispositivo']['idDispositivo'] ?>" op="sendFlush"><?php echo $this->Html->image("px_tr.gif"); ?></a>
	</div>
	<div class="ops">
		<?php if( $dispositivo['Dispositivo']['play'] == 1){ ?>
			<a class="btn st_stop push" href="#" title="Apagar dispositivo" id="<?php echo $dispositivo['Dispositivo']['idDispositivo'] ?>" op="sendDetener" ><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<?php }else{ ?>
			<a class="btn st_play push" href="#" title="Activar dispositivo" id="<?php echo $dispositivo['Dispositivo']['idDispositivo'] ?>"  op="sendReproducir" ><?php echo $this->Html->image("px_tr.gif"); ?></a>
			
		<?php } ?>
		<?php if( $dispositivo['Dispositivo']['mute'] == 0){ ?>
			<a class="btn st_sond" id="<?php echo h($dispositivo['Dispositivo']['idDispositivo']); ?>" title="Apagar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<?php }else{ ?>
			<a class="btn st_sonf" id="<?php echo h($dispositivo['Dispositivo']['idDispositivo']); ?>" title="Activar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<?php } ?>
		<?php echo $this->Html->link($this->Html->image('px_tr.gif'),array('action'=>'listadoListasDispositivo', $dispositivo['Dispositivo']['idDispositivo']), array('class'=>'btn st_list', 'escape'=>false));?>
		<span class="inf"><?php echo $dispositivo['0']['listas']?></span>
		<div title="<?php echo h($dispositivo['empresa']['nombre']); ?>" class="btn st_emp"><?php echo $this->Html->image("px_tr.gif"); ?></div>
		<!--<?php echo $this->Html->link($this->Html->image('px_tr.gif'), array( 'action'=>'' ),array('title'=>h($dispositivo['Empresa']['nombre']),'class'=>'btn st_emp', 'escape'=>false));?>-->
		<!--<span class="inf"><?php echo $dispositivo['0']['empresa']?></span>-->
	
		<?php  echo $this->Form->postLink(
			$this->Html->image("px_tr.gif"),
			 array('action' => 'deleteReproductor', $dispositivo['Dispositivo']['idDispositivo']),
	    	array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar dispositivo'),
	    	 __('¿Desea realmente eliminar el dispositivo '. h($dispositivo['Dispositivo']['descripcion']) .' ?'));?>
		</div>
	
	
	
		
	</div>
	
							
							
				 
	
<?php endforeach; ?>
</div><!--slist-->
</div>
</div>
<div class="box_btns">
	<!--<h3><?php echo __('Acciones'); ?></h3>-->
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'index'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>

<div class="acciones">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Crear Dispositivo'), array('action' => 'addReproductor')); ?></li>
	</ul>
</div>