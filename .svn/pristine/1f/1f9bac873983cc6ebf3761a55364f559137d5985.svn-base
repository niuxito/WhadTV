
<div class="box_pop">

<!--h2 class="st_vid"><img src="_test/vid_1.jpg">Listas de reproducción:<br /><b>Video test 1</b></h2-->

<div class="mlist">

<ul>

<?php
	if( !is_null( $listas ) ){
 	$i = 0;
  	foreach ( $listas as $lista ): ?>
	<li>
		<?php echo $this->Html->link(__($lista['lista']['descripcion']),array('controller'=>'videos', 'action'=>'videosxlista', $lista['lista']['idLista']), array('class'=>'titl')); ?><!--  <a class="titl" href="index_llista.htm"><?php echo $lista['lista']['descripcion']; ?></a>-->
		<div class="ops">
			<?php echo $this->Html->link(
				$this->Html->image(
					"px_tr.gif"), 
					array('controller'=>'videos', 'action'=>'videosxlista', $lista['lista']['idLista']), 
					array('class'=>'btn st_vido', 'title'=>'Número de vídeos asociados', 'escape'=>false) ); ?>
			<!--<a class="btn st_vido" href="index_llista.htm" title="Número de vídeos asociados">
				<img src="img/px_tr.gif" />
			</a>-->
			<?php if( $lista[0]['videos'] != 0 ){ ?>
				<span class="inf"><?php echo $lista[0]['videos']; ?></span>
				<?php }else{ ?>
					<span class="inf alrt">0</span>
				<?php } ?>
			<a class="btn st_disp" href="#" onClick="openSubWin(directorio+'/Videos/dispositivosxlista/<?php echo $lista['lista']['idLista'];?>/<?php echo $idVideo;?>',700,300,2,'Listas de dispositivos de: <b><?php echo $lista['lista']['descripcion'];?></b>');return false" title="Dispositivos">
			<?php echo $this->Html->image("px_tr.gif"); ?>
			</a>
			<?php if( $lista[0]['videos'] != 0 ){ ?>
				<span class="inf"><?php echo $lista[0]['dispositivos']; ?></span>
				<?php }else{ ?>
					<span class="inf alrt">0</span>
				<?php } ?>
			<!--<a class="btn st_delt" href="#" title="Eliminar de la lista" onClick="if (confirm('¿Desea eliminar el vídeo de la lista?')) return true; else return false;">
				<?php echo $this->Html->image(
					"px_tr.gif"); ?>
			</a>
			<?php //echo $this->Form->postLink(

				//$this->Html->image("px_tr.gif"),
				// array('controller'=>'ListaVideos', 'action' => 'delete', $lista['ListaVideo']['id'], $lista['lista']['idLista']),
		    	//array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar video'),
		    	// __('¿Desea eliminar el vídeo '. h($video['Video']['descripcion']) .' de la lista '.$lista['lista']['descripcion'].' realmente?'));
		   	?>-->
		</div>
	</li>
<?php 
	endforeach;
	} 
?>



</ul>

</div><!-- /mlist -->

<div class="box_btns">
	
	<a class="btn" href="#" onClick="openSubWin('<?php echo DIRECTORIO; ?>/Lista/add',700,300,2,'Añadir lista de reproducción:');return false" title="Lista"><?php echo $this->Html->image(
					"px_tr.gif"); ?>+Añadir lista</a>
			
	<!-- <a class="btn" href="#">Añadir lista</a></div> -->

</div><!-- /box_info -->