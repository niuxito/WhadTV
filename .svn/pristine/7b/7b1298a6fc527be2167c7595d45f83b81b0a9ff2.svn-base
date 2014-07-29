<div class="box_pop st_disp">

<!--h2 class="st_vid"><img src="_test/vid_1.jpg">Listas de reproducción:<br /><b>Video test 1</b></h2-->

<div class="mlist">

<ul>

<?php
	if( !is_null( $dispositivos ) ){
 	$i = 0;
  	foreach ( $dispositivos as $dispositivo ): ?>
	<li>
		<?php echo $this->Html->link(__($dispositivo['dispositivo']['descripcion']),array('controller'=>'dispositivos', 'action'=>'view', $dispositivo['dispositivo']['idDispositivo']), array('class'=>'titl')); ?>
		<div class="ops">
			<?php echo $this->Html->link(
				$this->Html->image(
					"px_tr.gif"), 
					array('controller'=>'dispositivos', 'action'=>'view', $dispositivo['dispositivo']['idDispositivo']), 
					array('class'=>'btn st_list', 'title'=>'Número de listas asociadas', 'escape'=>false) ); ?>
			<!-- <a class="btn st_list" href="#" onClick="openSubWin('index_dispositius_pop.htm',700,300,2,'Listas de dispositivos de: <b>Video test 1</b>');return false" title="Dispositivos"><?php echo $this->Html->image(
					"px_tr.gif"); ?></a>-->
			<?php if( $dispositivo[0]['videos'] != 0 ){ ?>
				<span class="inf"><?php echo $dispositivo[0]['listas']; ?></span>
				<?php }else{ ?>
					<span class="inf alrt">0</span>
				<?php } ?>
				<!-- <?php echo $this->Html->link(
				$this->Html->image(
					"px_tr.gif"), 
					array('controller'=>'dispositivo', 'action'=>'view', $dispositivo['Dispositivo']['idDispositivo']), 
					array('class'=>'btn st_vido', 'title'=>'Número de vídeos asociados', 'escape'=>false) ); ?>
			
			<?php if( $dispositivo[0]['videos'] != 0 ){ ?>
				<span class="inf"><?php echo $dispositivo[0]['videos']; ?></span>
				<?php }else{ ?>
					<span class="inf alrt">0</span>
				<?php } ?>
			<a class="btn st_delt" href="#" title="Eliminar de la lista" onClick="if (confirm('¿Desea eliminar el vídeo de la lista?')) return true; else return false;">
				<?php echo $this->Html->image(
					"px_tr.gif"); ?>
			</a>-->
		</div>
	</li>
<?php 
	endforeach;
	} 
?>



</ul>

</div><!-- /mlist -->

