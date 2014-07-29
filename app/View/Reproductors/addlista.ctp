
<div class="box_list list">
<?php echo $this->Html->script('jquery-1.8.2.min'); ?>
<?php echo $this->Html->script('whadtv'); ?>
<?php echo $this->Html->script('plug/nivo-slider/jquery.nivo.slider.pack'); ?>
<?php //echo $this->Html->css('general');  ?>
<?php echo $this->Html->css('plug/nivo-slider/themes/light/light'); ?>
<?php echo $this->Html->css('plug/nivo-slider/nivo-slider'); ?>
<!--h2 class="st_vid"><img src="_test/vid_1.jpg">Listas de reproducción:<br /><b>Video test 1</b></h2-->

<div class="vlist">
<input type=hidden value="<?php echo $dispositivo; ?>"/>
<?php echo $this->Session->flash(); ?>
<?php
	$i =0;
	foreach ($listas as $lista): ?>
	<?php $i++; ?>
	<div class="elm" id="bx_vid_<?php echo $i; ?>">
		<?php echo $this->Html->link(
			 $this->Html->image('px_tr.gif').	 h($lista['Listum']['descripcion']), 
			array('controller'=>'reproductors', 'action'=>'addlista',$dispositivo,$lista['Listum']['idLista']),
			array('class'=>'lst', 'onClick'=>'whadtv_insert_video('.$lista["Listum"]["idLista"].')', 'escape'=>false)
		); ?>
		
	</div>

<?php endforeach; ?>

</div><!-- /vlist -->

<div class="box_btns">
</div>

</div><!-- /box_info -->

<script type="text/javascript">//<![CDATA[



	function whadtv_insert_video (a) {

		jQ('#bx_vid_'+a).fadeOut(300);

		//alert("Insertem video "+a+". La forma fàcil és per GET reescrivint el window.parent.location per exemple...");
		

		//closeSubWin(); return false;
	}

//]]></script>