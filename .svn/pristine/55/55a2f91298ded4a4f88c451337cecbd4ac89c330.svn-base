
<?php echo $this->Html->script("jquery.form"); ?>
<?php echo $this->Html->script('programaciones');?>

<script type="text/javascript">	var idListaDispositivo = <?php echo $idListaDispositivo; ?></script>

<div class="box_pop">

<!--h2 class="st_vid"><img src="_test/vid_1.jpg">Listas de reproducción:<br /><b>Video test 1</b></h2-->

<div class="mlist">

<ul>

<?php
	if( !is_null( $programaciones ) ){
 	
  		foreach ( $programaciones as $programa ){
?>
		<?php echo $this->element('programa', array('programa'=>$programa));?>
	
<?php 
		}
	} 
?>



</ul>

</div><!-- /mlist -->

<div class="box_btns">
	
	<a class="btn" href="#" id="addbtn" title="Lista"><?php echo $this->Html->image(
					"px_tr.gif"); ?>+Añadir programación</a>
			
	<!-- <a class="btn" href="#">Añadir lista</a></div> -->

</div><!-- /box_info -->