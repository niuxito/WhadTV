<div class="box_list list">
	<?php echo $this->Html->script('jquery-1.8.2.min'); ?>
	<?php echo $this->Html->script('whadtv'); ?>
	<?php echo $this->Html->script('plug/nivo-slider/jquery.nivo.slider.pack'); ?>
	<?php echo $this->Html->css('plug/nivo-slider/themes/light/light'); ?>
	<?php echo $this->Html->css('plug/nivo-slider/nivo-slider'); ?>

	<?php foreach($datos as $dato){ ?>
		<div class="vlist">
			<h2><b>Listas en Empresa: <?php echo $dato['Empresa']['Nombre']; ?></b></h2>
			<input type=hidden value="<?php echo $dispositivo; ?>"/>
			<?php echo $this->Session->flash(); ?>
			<?php
				$i =0;
				foreach ($dato['listas'] as $lista){ ?>
				<?php $i++; ?>
				<div class="elm" id="bx_vid_<?php echo $i; ?>">
					<?php 
						echo $this->Html->link(
						 $this->Html->image('px_tr.gif').h($lista['Listum']['descripcion']), 
						array('action'=>'asignarLista',$dispositivo,$tipo,$lista['Listum']['idLista']),
						array('class'=>'lst', 'onClick'=>'whadtv_insert_video('.$lista["Listum"]["idLista"].')', 'escape'=>false) 
					); ?>
					
				</div>

			<?php } ?>
		</div><!-- /vlist -->
	<?php } ?>

	<div class="box_btns">
	</div>
</div><!-- /box_info -->

<!--<script type="text/javascript">
	function whadtv_insert_video (a) {
		jQ('#bx_vid_'+a).fadeOut(300);
	}
</script>-->