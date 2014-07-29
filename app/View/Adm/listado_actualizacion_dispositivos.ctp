<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">

<h1>Listado de Actualizaciones de Dispositivos</h1>

</div>


<!-- # llistat de actualitzacións de dispositius # -->

<div class="box_list st_emp">

<div class="mlist grn">
	<ul cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($actualizacionDispositivos as $actualizacionDispositivo): ?>
	<li>
		
		<span class="inf">
			<ul>Fecha Solicitud: 
				<?php echo h($actualizacionDispositivo['0']['fsolicitud']); ?>&nbsp;</ul>
			<ul>Fecha Entrega: 
				<?php echo h($actualizacionDispositivo['0']['fentrega']); ?>&nbsp;</ul>
		</span>
		<div title=<?php echo $actualizacionDispositivo['users']['username']; ?> class="btn st_usu"><?php echo $this->Html->image("px_tr.gif"); ?></div>
		<div title="NºActualizaciones" class="btn st_msg"><?php echo $this->Html->image("px_tr.gif"); ?></div>
		<span class="inf"><?php echo $actualizacionDispositivo[0]['cantidad']; ?></span>
		<td><?php echo $this->Html->link(h($actualizacionDispositivo['dispositivo']['descripcion']), array('action' => 'listadoActualizacionDispositivo', $actualizacionDispositivo['ActualizacionDispositivo']['idReproductor']), array('title'=>'Ver actualizaciones del dispositivo')); ?>&nbsp;</td>
		<?php echo 'Situacion: '.$actualizacionDispositivo['0']['situacion']; ?>
		
		
		
		
		
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'index'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>