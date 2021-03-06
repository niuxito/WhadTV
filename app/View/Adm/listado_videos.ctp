<?php echo $this->Session->flash(); ?>
<?php echo $this->Html->script('list'); ?>

<div id="listado" class="sub_wrap">
	<div class="box_ops brd_bx st_list">
		<h1>
			Listado de videos
			<input class="search" placeholder="" />
		</h1>
		<div class="ops">
			<?php echo $this->Form->create('Adm',array('action'=>'../adm/listadoVideos'));?>
			<div class="fld st_chg">
				<select class="ind" name="chk_empresa" value=""
				onFocus="jQ(this).removeClass('ind');jQ('option[rel=ini]', this).html('');"
				onBlur ="jQ(this).addClass('ind');jQ('option[rel=ini]', this).html('Cambiar de Empresa');"
				onChange="this.form.submit();"
				>
					<option selected disabled>Cambiar de Empresa</option>
					<option value=0>Ver todo</option>
					<?php
						$i = 0;
						foreach ($empresas as $empresa): ?>
						<option 
							id=<?php echo $empresa['Empresa']['idEmpresa']; ?> 
							class="empresa" 
							value=<?php echo $empresa['Empresa']['idEmpresa']; ?>
							<?php if( $empresaC[0]['Empresa']['idEmpresa'] == $empresa['Empresa']['idEmpresa'] ) {
								echo "selected";
							} ?>
							>
							<?php echo h($empresa['Empresa']['Nombre']); ?>
						</option>
						<?php endforeach; ?>
				</select>
			</div>
			<?php echo $this->Form->end(); ?>
		</div><!-- /ops -->
	</div><!-- /box_ops -->

	<div class="box_vid list">
		<div class="elm_mov addvideo" pos="0">
			<div class="elm" pos="0">
				<a class="prv" href="adm/addVideoImagen" onClick="openSubWin(directorio+'/adm/addVideoImagen',700,500,2,'Añadir nuevo video: ');return false" title="Añadir video"><?php echo $this->Html->image("icons/ico_video_add.jpg"); ?><br /><i>Añadir nuevo vídeo</i></a>
			</div> <!-- /elm -->
		</div><!-- /elm_mov -->

		<div class="elm_mov delVideos" pos="1">
			<div class="elm" pos="0">
				<a class="prv" href="adm/deleteVideos" onClick="openSubWin(directorio+'/adm/deleteVideos',700,400,2,'Añadir nuevo video: ');return false" title="Eliminar videos"><?php echo $this->Html->image("icons/ico_video_brossa.jpg"); ?><br /><i>Eliminar videos</i></a>
			</div> <!-- /elm -->
		</div><!-- /elm_mov -->
		<div class="slist">
			<?php
			$i = 0;
			foreach ($videos as $video): ?>
			<div class="elm_mov" id="<?php echo $video['Video']['idVideo']; ?>" pos="<?php echo $video['listaVideo']['posicion']; ?>" listaId="<?php echo trim($video['listaVideo']['id']) ?>">
				<div class="elm" >
					
					<!--<div class="prv" onClick="whadtv_insert_video(<?php echo $video['Video']['idVideo']; ?>)" id="<?php echo $video['Video']['idVideo']; ?>">-->
					<a class="prv" href="editarVideo/<?php echo $video['Video']['idVideo']; ?>" onClick="openSubWin(directorio+'/adm/editarVideo/<?php echo $video['Video']['idVideo']; ?>',700,550,2,'Ver contenido: ');return false" title="Ver contenido">
						<?php if( $video['Video']['estado'] == "procesado"){
							 echo $this->Html->image(h($video['Video']['fotograma'])).'<span class="selm">'.  h($video['Video']['descripcion']).'</span>'.'&nbsp <u>'.h($video['Video']['time']).'"</u>';?></a>
						<?php  }else{
							 echo $this->Html->image("icons/ico_video_process.jpg").'<span class="selm">'.  h($video['Video']['descripcion']).'</span>';?></a>
						<?php	}?>
					</a>
						
					
					<div class="ops">
						<li>
							<a class="btn st_proc" href="adm/procesarVideo" onClick="openSubWin(directorio+'/adm/procesarVideo/<?php echo $video['Video']['idVideo']; ?>',700,450,2,'Procesar: ');return false" title="Ver contenido">
								<?php echo $this->Html->image('px_tr.gif') ?>
							</a>
							<!--<?php //echo $this->Form->postLink($this->Html->image('px_tr.gif'),array('action'=>'procesarVideo',$video['Video']['idVideo']),array('title'=>'Procesar Video','escape'=>false, 'class'=>'btn st_proc') ,__('¿Estás seguro de que deseas procesar este video?')); ?>-->
						</li>
						<!--<li><?php echo $this->Form->postLink($this->Html->image('px_tr.gif'),array('action'=>'revisarVideoEmpresa',$video['Video']['idVideo'],$video['Video']['idEmpresa']),array('title'=>'Prueba','escape'=>false, 'class'=>'btn st_proc') ,__('¿Prueba?')); ?></li>-->
						<div title="<?php echo "F.Alta: ".h($video['Video']['timestamp']); ?>" class="btn st_date"><?php echo $this->Html->image("px_tr.gif"); ?></div>
				
						<li><?php echo $this->Form->postLink($this->Html->image('px_tr.gif'),array('action'=>'deleteVideo',$video['Video']['idVideo']),array('title'=>'Eliminar Video','escape'=>false, 'class'=>'btn st_delt') ,__('¿Estás seguro de que deseas eliminar este video?')); ?></li>
					
					</div> <!--  ops -->
				
				</div> <!-- elm -->
			</div> <!--  elm_mov -->	
			<?php endforeach; ?>
		</div>

	</div> <!-- /box_vid -->
</div><!-- /sub_wrap -->

	
