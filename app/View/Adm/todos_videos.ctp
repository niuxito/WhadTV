<div class="box_pop st_vid">

<!--h2 class="st_vid"><img src="_test/vid_1.jpg">Listas de reproducción:<br /><b>Video test 1</b></h2-->

<div class="vlist">

<?php foreach( $videos as $video ): ?>

<div class="elm" id="<?php echo $video['Video']['idVideo']; ?>">
	
	<div class="prv" onClick="whadtv_insert_video(<?php echo $video['Video']['idVideo']; ?>)" id="<?php echo $video['Video']['idVideo']; ?>">
			<?php echo $this->Html->image($video['Video']['fotograma']); ?><br /><?php echo $video['Video']['descripcion']; ?>
	</div>
</div>

<?php endforeach; ?>


</div><!-- /vlist -->

<div class="box_btns">
<!--<a class="btn" onClick="openSubWin('index_editar_formulari_video_pop.htm',700,300,0,'Añadir nuevo vídeo');return false">+ Subir un nuevo vídeo</a>
<a class="btn up" onClick="closeSubWin();return false;">Terminar</a>-->
</div>

</div><!-- /box_info -->

<script type="text/javascript">//<![CDATA[



	
	
	/*function crearVideoBox(){
		<div class="prv" onClick="whadtv_insert_video(<?php echo $video['Video']['idVideo']; ?>)" id="<?php echo $video['Video']['idVideo']; ?>">
			<?php echo $this->Html->image("vid_1.jpg"); ?><br /><?php echo $video['Video']['descripcion']; ?>
	</div>
	}*/

//]]></script>