<?php echo $this->Session->flash(); ?>

<div class="box_ops st_vid">

<h1>Videos en: <b><?php echo h($listas[0]['Listum']['descripcion']); ?></b></h1>
<?php
	echo $this->Html->script('jquery-ui-1.9.1.custom.min');
	echo $this->Html->css('jquery-ui-1.8.9.custom');
	echo $this->Html->css('whadtv');
	//echo h($listaC[0]['Listum']['descripcion']);		 
?>
<input id="lista" type=hidden value="<?php echo h($listas[0]['Listum']['idLista']); ?>"/>

</div>

<!--<div class="vlist">-->
<div class="box_vid list">
	<?php foreach( $videos as $video ): ?>
	<div class="elm_mov" id="<?php echo $video['Video']['idVideo']; ?>" pos="<?php echo $video['listaVideo']['posicion']; ?>" listaId="<?php echo trim($video['listaVideo']['id']) ?>">
	<div class="elm" id="<?php echo $video['Video']['idVideo']; ?>">
		
		<!--<div class="prv" onClick="whadtv_insert_video(<?php echo $video['Video']['idVideo']; ?>)" id="<?php echo $video['Video']['idVideo']; ?>">
			<?php echo $this->Html->image($video['Video']['fotograma']); ?><br /><?php echo $video['Video']['descripcion']; ?>
		</div>-->
		<!--<?php echo $this->Html->link( 
		$this->Html->image(h($video['Video']['fotograma'])).  h($video['Video']['descripcion']).h($video['Video']['time']), 
		array('controller'=>'Adm','action'=>'VistaVideos', $video['Video']['idVideo'],$listas[0]['Listum']['idLista'],$dispositivos[0]['Dispositivo']['idDispositivo']), 
		array('class'=>'prv', 'escape'=>false) ); ?>
		-->
		<a class="prv" href="Adm/vistaVideos" onClick="openSubWin(directorio+'/Adm/vistaVideos/<?php echo $video['Video']['idVideo']; ?>',700,400,2,'Ver contenido: ');return false" title="Ver contenido">
		<?php if( $video['Video']['estado'] == "procesado"){
			 	echo $this->Html->image(h($video['Video']['fotograma'])).  h($video['Video']['descripcion']).h($video['Video']['time']);?></a>
		<?php  }else{
			 	echo $this->Html->image("icons/ico_video_process.jpg").  h($video['Video']['descripcion']).h($video['Video']['time']);?></a>
		<?php	}?>
		</a>
		<div class="alrts st_mov" title="Mover orden del vídeo"> 
		</div>
		
		<div class="ops">
			<!--<?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'deleteVideo', $video['Video']['idVideo']),array('title'=>'Eliminar Video','escape'=>false, 'class'=>'btn st_del') ,__('¿Estás seguro de que deseas eliminar este video?')); ?>-->
			<?php echo $this->Form->postLink($this->Html->image("px_tr.gif"), array('action' => 'deleteListaVideo', $video['listaVideo']['id']),array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Quitar video de lista'),__('¿Desea realmente quitar el video de '. h($listas[0]['Listum']['descripcion']) .' ?'));?>
		</div>
	</div>
	</div>
	
	
	<?php endforeach; ?>
</div>

<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoListasDispositivo/',$dispositivos[0]['Dispositivo']['idDispositivo']), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>

<div class="acciones">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Añadir video'), array('action' => 'asignarVideo',$listas[0]['Listum']['idLista'],$dispositivos[0]['Dispositivo']['idDispositivo'])); ?></li>
		<li><?php echo $this->Form->postLink('Eliminar Lista',array('action'=>'deleteLista',$dispositivos[0]['Dispositivo']['idDispositivo'],$listas[0]['Listum']['idLista']),array('confirm'=>__('¿Desea realmente eliminar la lista '. h($listas[0]['Listum']['descripcion']) .'?'))); ?></li>
	</ul>
</div>
