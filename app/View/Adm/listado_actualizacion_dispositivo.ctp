<?php echo $this->Session->flash(); ?>

<div class="box_ops brd_bx st_empr">

<h1>Listado de Actualizaciones de 
	 <b><?php echo h($actualizacionDispositivos[0]['dispositivo']['descripcion']); ?></b>
</h1>

</div>


<!-- # llistat de actualitzacións de dispositiu # -->

<div class="box_list st_emp">

	<div class="mlist grn">
		<ul cellpadding="0" cellspacing="0">
		
			<?php
			$i = 0;
			foreach ($actualizacionDispositivos as $actualizacionDispositivo): ?>
				<li>
					<!--<span class="btn inf"><ul><?php //echo h($consejo['users']['username']); ?>&nbsp;</ul>
					<ul>F.Últ.Msg; 
					<?php //foreach ($ultMensajes as $ultMensaje){
						//if ($ultMensaje['Consejo']['idAsunto'] == $consejo['Consejo']['idAsunto']){
							//echo $ultMensaje['Consejo']['created'];
						//}
					//} ?>
					</ul>
					</span>
					-->
					<span class="inf">
						<ul>Fecha Solicitud: 
							<?php echo h($actualizacionDispositivo['ActualizacionDispositivo']['fsolicitud']); ?>&nbsp;</ul>
						<ul>Fecha Entrega: 
							<?php echo h($actualizacionDispositivo['ActualizacionDispositivo']['fentrega']); ?>&nbsp;</ul>
					</span>
					
					<!--<td><?php //echo h($actualizacionDispositivo['ActualizacionDispositivo']['id']); ?>&nbsp;</td>-->
					<div title=<?php echo $actualizacionDispositivo['users']['username']; ?> class="btn st_usu"><?php echo $this->Html->image("px_tr.gif"); ?></div>

					<?php 
						$contenido = json_decode($actualizacionDispositivo['ActualizacionDispositivo']['contenido'],true);  
						$mute = ($contenido['mute'] != false) ? 'true' : 'false';
						$caducidad = date('d/m/Y',$contenido['caducidad']);
						$dataDispositivo = "idDispositivo: ".$contenido['idDispositivo']." Mute: ".$mute." F.caducidad: ".$caducidad." Disco: ".$contenido['disco']." Play: ".$contenido['play'];
						if (is_array($contenido['listas'])){
							foreach( $contenido['listas'] as $lista ){
								$mute = ($lista['mute']) ? 'true' : 'false';
								$activa = ($lista['activa']) ? 'true' : 'false';
								$dataLista = "idLista: ".$lista['idLista']." Mute: ".$mute." Activa: ".$activa;
								if (is_array($lista['videos'])){
									foreach ( $lista['videos'] as $video){
										$mute = ($video['mute']) ? 'true' : 'false';
										$dataVideo = "idVideo: ".$video['idVideo']." Mute: ".$mute." Name: ".$video['name']." Time: ".$video['time']." Tipo: ".$video['tipo']." URL: ".$video['url'];
										$dataLista = $dataLista."</br>".$dataVideo;
									}
								}
								$dataDispositivo = $dataDispositivo."</br>".$dataLista;
							}
						}
						//echo $dataDispositivo ;
					?>
					<div title="<?php echo $dataDispositivo; ?>" class="btn st_msg tip"><?php echo $this->Html->image("px_tr.gif"); ?>

					
					<div class="state_cnt">
						<span class="state">
							<?php echo 'Situación: ';
								switch ( $actualizacionDispositivo['ActualizacionDispositivo']['situacion'] ) { 
								case 'pendiente': 
									echo 'Pendiente';
									break;
								case 'error':
									echo 'Error';
									//Mostrar error;
									break;
								case 'caducado':
									echo 'Caducado';
									break;
								case 'ok':
									echo 'OK';
									break;
							} ?>
						</span>
					
					
						<?php if ($actualizacionDispositivo['ActualizacionDispositivo']['observaciones'] != ''){
							?><span class="obs">Observaciones: <?php echo h($actualizacionDispositivo['ActualizacionDispositivo']['observaciones']); ?>&nbsp;</span>
						<?php 
						}
						?>
					</div> <!-- /div state_cnt -->
				</li>
			<?php endforeach; ?>
		</ul>
		
	</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoActualizacionDispositivos'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
