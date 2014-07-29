<?php echo $this->Session->flash(); ?>
<div class="box_pop st_vid">
	<?php echo $this->element('config'); ?>
	<?php echo $this->Html->css("general_pop")?>	
	<?php echo $this->Html->script("jquery.form"); ?>
	<?php echo $this->Html->script("jquery-ui-1.9.1.custom.min");?>
	<!-- visualització vídeo -->
	
	<div class="box_view st_vido">
		<div class="box_cntnt">
			<video  width="300" height="200"  controls >
			 	<source type="video/mp4" src="http://<?php echo $config[0]['Configuracion']['Valor'].$config[1]['Configuracion']['Valor']; ?>/<?php echo $video['Video']['url'];?>.mp4"></source>
				<source type="video/webm" src="http://<?php echo $config[0]['Configuracion']['Valor'].$config[1]['Configuracion']['Valor']; ?>/<?php echo $video['Video']['url'];?>.webm"></source>
			</video>
		</div>
	</div>
	
	
	
	<!-- # formulari # -->
	
	<div class="forms">
	
		<?php echo $this->Form->create('Video');?>
		
		
		<label for="fld_1" class="fld left mdm">
			<h3>Título del vídeo:<span class="obl">*</span></h3>
			<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'label'=>false, 'value'=>$video['Video']['descripcion']));?>
		</label>
		
		<div class="msg lft min">
			Por favor, introduce un texto que no contenga más de 60 carácteres.
		</div>
		
		<div class="gnr_inf">Los campos con <b>*</b> son obligatorios</div>
		
		
		<div class="box_btns">
		
			<?php /*<div class="box_btns">
				<ul>
					<!--<?php  echo $this->Html->link('Cancelar', 'javascript:history.back()', array('class'=>'btn', 'type'=>'submit'));?>-->
					<!--<li><?php  echo $this->Html->link('Volver', 'javascript:history.back()', array('class'=>'btn', 'div'=>false, 'name'=>'Volver'));?></li>-->
					<!--<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadovideoslista',$idLista,$idDispositivo), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>-->
				</ul>
			</div>
			*/ ?>
		
			<input class="btn up" type="submit" name="submit_ok" value="Modificar" />
		
		</div><!-- /box_btns -->
		
		<?php echo $this->Form->end();?>
	
	</div><!-- /forms -->
</div>

<script>

jQ('form').ajaxForm(
		{
			target : '#myResultsDiv',
			beforeSubmit : function(formData, jqForm,
					options) {
				jQ(".progress").show();
			},
			uploadProgress : function(event, position,
					total, percentComplete) {
				var percentVal = percentComplete + '%';
				if (percentVal != '100%') {
					jQ('.bar').width(percentVal);
					jQ('.percent').html(percentVal);
					jQ('#status').html("Cargando...");
				} else {
					jQ('#status').html("Cargado");
					jQ(".progress").hide();
					closeSubWin();
				}
			},
			/*
			 * success: function (responseText, statusText,
			 * xhr){ window.location.reload(); },
			 */
			complete : function(responseText, statusText,
					xhr) {
				window.location.reload();
			}

		});</script>