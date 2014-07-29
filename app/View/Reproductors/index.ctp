<?php echo $this->Session->flash(); ?>

<!-- # nom empresa i opcions # -->
<div id="listado" class="subwrap">
<div  class="box_ops brd_bx st_disp">

<h1>Todo<input class="search" placeholder="" maxlength="30" />
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    Acciones <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu" role="menu">
	    <li><a href="#" onClick="openSubWin('Reproductors/asignar',700,300,2,'Añadir un nuevo reproductor');return false" title="Añadir Reproductor">Añadir reproductor</a></li>
	    <li><a href="#" onClick="openSubWin('Reproductors/crear',700,400,2,'Añadir un nuevo reproductor web');return false" title="Añadir Reproductor web">Crear reproductor web</a></li>
	  </ul>
	</div>

</h1>

</div>



<!-- # llistat de dispositivos # -->

<div class="box_disp list">
<!--<div class="elm add">

	<a class="lbr" href="#" onClick="openSubWin('Reproductors/asignar',700,300,2,'Añadir un nuevo reproductor');return false" title="Añadir Reproductor"><img src="img/icons/ico_pantalla_list_add.png" /><br /><i>Añadir reproductor</i></a>
</div>
<div class="elm add">

	<a class="lbr" href="#" onClick="openSubWin('Reproductors/crear',700,300,2,'Añadir un nuevo reproductor');return false" title="Añadir Reproductor"><img src="img/icons/ico_pantalla_web.png" /><br /><i>Crear reproductor web</i></a>
</div>-->


<!--  Comprar un dispositivo -->
<!-- <div class="elm add">
	<?php //echo $this->Html->link(
			//$this->Html->image("icons/ico_pantalla_shop.png")."</br>Comprar reproductor" , 
			//array('controller'=>'compras','action'=>'whadtv'),array('class'=>'lbr', 'escape'=>false)); ?>
</div> -->
<div id="sortable" class="slist"> <!-- sortable -->
<?php
	$i = 0;
	$d = 0;
	foreach ($dispositivos as $dispositivo): ?>
	
	<div class="elm nw_dx <?php if(strtotime($dispositivo['Reproductor']['caducidad']) <= time()){ echo 'red'; } ?>">

	<a class="dsp" href="reproductors/view/<?php echo $dispositivo['Reproductor']['idDispositivo'] ?>"><img src="img/px_tr.gif" />
		<span class="vers"><?php echo h($dispositivo['Reproductor']['version']); ?></span>
		
		<span class='selm'><?php echo h($dispositivo['Reproductor']['descripcion']); ?></span>

		<span class="selm1 hidden"><?php echo $dispositivo['Reproductor']['idDispositivo'] ?></span>
		<!-- <span class="usge"><b>35<i>%</i></b><span class="barr"><span class="prct" style="width:35%"></span></span></span>-->
	</a>
	<div class="alrts">
		<a class="btn st_rfsh push" href="#" title="Sincronizar vídeos" id="<?php echo $dispositivo['Reproductor']['idDispositivo'] ?>" op="sendActualizar"><img src="img/px_tr.gif" /></a>
	</div>
	<div class="ops">
		<?php if( $dispositivo['Reproductor']['play'] == 1){ ?>
			<a class="btn st_stop push" href="#" title="Apagar dispositiu" id="<?php echo $dispositivo['Reproductor']['idDispositivo'] ?>" op="sendDetener" ><img src="img/px_tr.gif" /></a>
		<?php }else{ ?>
			<a class="btn st_play push" href="#" title="Activar dispositiu" id="<?php echo $dispositivo['Reproductor']['idDispositivo'] ?>"  op="sendReproducir" ><img src="img/px_tr.gif" /></a>
			
		<?php } ?>
		<?php if( $dispositivo['Reproductor']['mute'] == 0){ ?>
			<a class="btn st_sond" id="<?php echo h($dispositivo['Reproductor']['idDispositivo']); ?>" title="Apagar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<?php }else{ ?>
			<a class="btn st_sonf" id="<?php echo h($dispositivo['Reproductor']['idDispositivo']); ?>" title="Activar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<?php } ?>
		<?php echo $this->Html->link($this->Html->image('px_tr.gif'),array('action'=>'view', $dispositivo['Reproductor']['idDispositivo']), array('class'=>'btn st_list', 'escape'=>false));?>
		<span class="inf"><?php echo $dispositivo['0']['listas']?></span>
		<?php  echo $this->Form->postLink(
			$this->Html->image("px_tr.gif"),
			 array('action' => 'delete', $dispositivo['Reproductor']['idDispositivo']),
	    	array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar reproductor'),
	    	 __('¿Desea eliminar de su lista el reproductor  '. h($dispositivo['Reproductor']['descripcion']) .' realmente?'));?>
		</div>
	
	
	
		
	</div>
	
							
							
				 
	
<?php endforeach; ?>
</div>







</div><!-- /box_vid -->
</div><!-- /listado -->

<?php echo $this->Html->script('list'); ?>
<?php echo $this->Html->css('bootstrap.min'); ?>
<?php echo $this->Html->script('bootstrap.min'); ?>
<?php 
	echo ( isset($demo) && $demo == 0 ) 
	? '<script type="text/javascript">var demo = true;</script>'
	: '<script type="text/javascript">var demo = false;</script>'
?>






