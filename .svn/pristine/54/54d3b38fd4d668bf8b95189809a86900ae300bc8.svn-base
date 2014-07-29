
<div class="box_list list">
<?php echo $this->Html->script('jquery-1.8.2.min'); ?>
<?php echo $this->Html->script('whadtv'); ?>
<?php echo $this->Html->script('plug/nivo-slider/jquery.nivo.slider.pack'); ?>
<?php echo $this->Html->css('general');  ?>
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
			array('controller'=>'dispositivos', 'action'=>'addlista',$dispositivo,$lista['Listum']['idLista']),
			array('class'=>'lst', 'onClick'=>'whadtv_insert_video($lista["Listum"]["idLista"])', 'escape'=>false)
		); ?>
		<!--<a class="prv" href="<?php echo $dispositivo; ?>/<?php echo $lista['Listum']['idLista']; ?>" id="<?php echo $lista['Listum']['idLista']; ?>"  onClick="whadtv_insert_video(<?php echo $lista['Listum']['idLista']; ?>)">
			<?php echo $this->Html->image('px_tr.gif'); ?><br /><?php echo h($lista['Listum']['descripcion']); ?>
		</a>-->
	</div>

<?php endforeach; ?>


<!--<div class="elm" id="bx_vid_2"><a class="prv" href="#" onClick="whadtv_insert_video(2)"><?php echo $this->Html->image('px_tr.gif'); ?><br />Video test 2 <u>10':15"</u></a></div>

<div class="elm" id="bx_vid_3"><a class="prv" href="#" onClick="whadtv_insert_video(3)"><?php echo $this->Html->image('px_tr.gif'); ?><br />Video test 3 <u>10':15"</u></a></div>

<div class="elm" id="bx_vid_4"><a class="prv" href="#" onClick="whadtv_insert_video(4)"><?php echo $this->Html->image('px_tr.gif'); ?><br />Video test 4 del metal a saco paco <u>10':15"</u></a></div>

<div class="elm" id="bx_vid_5"><a class="prv" href="#" onClick="whadtv_insert_video(5)"><?php echo $this->Html->image('px_tr.gif'); ?><br />Video test 5 <br />prova <u>10':15"</u></a></div>

<div class="elm" id="bx_vid_6"><a class="prv" href="#" onClick="whadtv_insert_video(6)"><?php echo $this->Html->image('px_tr.gif'); ?><br />Video test 6 <u>10':15"</u></a></div>

<div class="elm" id="bx_vid_7"><a class="prv" href="#" onClick="whadtv_insert_video(7)"><?php echo $this->Html->image('px_tr.gif'); ?><br />Video test 7 <u>10':15"</u></a></div>

<div class="elm" id="bx_vid_8"><a class="prv" href="#" onClick="whadtv_insert_video(8)"><?php echo $this->Html->image('px_tr.gif'); ?><br />Video test 8 del metal a saco paco <u>10':15"</u></a></div>
-->
</div><!-- /vlist -->

<div class="box_btns">
<!--<a class="btn" onClick="openSubWin('index_editar_formulari_video_pop.htm',700,300,0,'Añadir nuevo vídeo');return false">+ Subir un nuevo vídeo</a>
<a class="btn up" onClick="closeSubWin();return false;">Terminar</a>-->
</div>

</div><!-- /box_info -->

<script type="text/javascript">//<![CDATA[



	function whadtv_insert_video (a) {

		jQ('#bx_vid_'+a).fadeOut(300);

		//alert("Insertem video "+a+". La forma fàcil és per GET reescrivint el window.parent.location per exemple...");
		

		closeSubWin(); return false;
	}

//]]></script>