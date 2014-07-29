






<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_disp">

<h1>Todo</h1>

</div>


<!-- # llistat de dispositivos # -->

<div class="box_disp list">
<div class="elm add">

	<a class="lbr" href="#" onClick="openSubWin('Dispositivos/asignar',700,300,2,'Añadir un nuevo dispositivo');return false" title="Listas de reproducción"><img src="img/icons/ico_pantalla_list_add.png" /><br /><i>Añadir dispositivo</i></a>
</div>

<!--  Comprar un dispositivo -->
<!-- <div class="elm add">
	<?php //echo $this->Html->link(
			$this->Html->image("icons/ico_pantalla_shop.png")."</br>Comprar dispositivo" , 
			array('controller'=>'compras','action'=>'whadtv'),array('class'=>'lbr', 'escape'=>false)); ?>
</div>  -->
<?php
	$i = 0;
	$d = 0;
	foreach ($dispositivos as $dispositivo): ?>
	
	<div class="elm red">

	<a class="dsp" href="dispositivos/view/<?php echo $dispositivo['Dispositivo']['idDispositivo'] ?>"><img src="img/px_tr.gif" /><br /><?php echo h($dispositivo['Dispositivo']['descripcion']); ?><!-- <span class="usge"><b>35<i>%</i></b><span class="barr"><span class="prct" style="width:35%"></span></span></span>--></a>
	<div class="alrts">
		<a class="btn st_rfsh push" href="#" title="Sincronizar vídeos" id="<?php echo $dispositivo['Dispositivo']['idDispositivo'] ?>" op="sendActualizar"><img src="img/px_tr.gif" /></a>
	</div>
	<div class="ops">
		<?php if( $dispositivo['Dispositivo']['play'] == 1){ ?>
			<a class="btn st_stop push" href="#" title="Detener reproductor" id="<?php echo $dispositivo['Dispositivo']['idDispositivo'] ?>" op="sendDetener" ><img src="img/px_tr.gif" /></a>
		<?php }else{ ?>
			<a class="btn st_play push" href="#" title="Activar reproductor" id="<?php echo $dispositivo['Dispositivo']['idDispositivo'] ?>"  op="sendReproducir" ><img src="img/px_tr.gif" /></a>
			
		<?php } ?>
		<?php if( $dispositivo['Dispositivo']['mute'] == 0){ ?>
			<a class="btn st_sond" id="<?php echo h($dispositivo['Dispositivo']['idDispositivo']); ?>" title="Apagar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<?php }else{ ?>
			<a class="btn st_sonf" id="<?php echo h($dispositivo['Dispositivo']['idDispositivo']); ?>" title="Activar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<?php } ?>
		<?php echo $this->Html->link($this->Html->image('px_tr.gif'),array('action'=>'view', $dispositivo['Dispositivo']['idDispositivo']), array('class'=>'btn st_list', 'escape'=>false));?>
		<span class="inf"><?php echo $dispositivo['0']['listas']?></span>
		<?php  echo $this->Form->postLink(
			$this->Html->image("px_tr.gif"),
			 array('action' => 'delete', $dispositivo['Dispositivo']['idDispositivo']),
	    	array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar reproductor'),
	    	 __('¿Desea eliminar de su lista el reproductor  '. h($dispositivo['Dispositivo']['descripcion']) .' realmente?'));?>
		</div>
	
	
	
		
	</div>
	
							
							
				 
	
<?php endforeach; ?>








</div><!-- /box_vid -->









