<div class="box_pop st_vid">



<div class="vlist">

<?php foreach( $videos as $video ): ?>
	<?php if(isset($video['Video']['fotograma']) && $video['Video']['fotograma'] != "" && $video['Video']['estado'] == "procesado"){ ?>
		<div class="elm" idVideo="<?php echo $video['Video']['idVideo']; ?>">
			
			<!--<div class="prv" onClick="whadtv_insert_video(<?php echo $video['Video']['idVideo']; ?>)" id="<?php echo $video['Video']['idVideo']; ?>">-->
				<div class="prv"  id="<?php echo $video['Video']['idVideo']; ?>">
					<?php echo $this->Html->image($video['Video']['fotograma']); ?><br /><?php echo h($video['Video']['descripcion']); ?>
			</div>
		</div>
	<?php } ?>
<?php endforeach; ?>


</div><!-- /vlist -->

<div class="box_btns">

</div>

</div><!-- /box_info -->

