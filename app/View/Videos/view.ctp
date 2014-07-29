<div class="box_pop">
<?php echo $this->element('config'); ?>
<?php echo $this->Html->css("general_pop")?>	
<?php echo $this->Html->script("jquery.form"); ?>
<?php echo $this->Html->script("jquery-ui-1.9.1.custom.min");?>
<!-- visualització vídeo -->

<div class="box_view st_vido">
<div class="box_cntnt">
<?php if( $video['Video']['tipo'] == 'video'){ ?>
	<video  width="300" height="200"  controls >
		<source type="video/webm" src="<?php echo $video['Video']['formatos']['webm'];?>"></source>
	 	<source type="video/mp4" src="<?php echo $video['Video']['formatos']['h264'];?>"></source>
	</video>
<?php }elseif( $video['Video']['tipo'] == 'imagen' ){ ?>
	<img src="<?php echo $video['Video']['formatos']['720p']; ?>" >
<?php } ?>
</div>

</div>



<!-- # formulari # -->

<div class="forms">



<?php echo $this->Form->create('Video');?>


<label for="fld_1" class="fld left mdm">
	<h3>Título del contenido:<span class="obl">*</span></h3>
	<?php echo $this->Form->input('descripcion', array(
		'class'=>'inpt', 'label'=>false, 'value'=>$video['Video']['descripcion'], 'maxlength'=>30
	) );?>

</label>
<div class="msg lft min">
Por favor, introduce un texto que no contenga más de 30 carácteres.
</div>
<?php if( $video['Video']['tipo'] == 'imagen'){ ?>
	<label for="titol_empresa" class="fld fmdm ini">
	<h3>Tiempo:</h3>
	<?php echo $this->Form->input('time', array('class'=>'inpt', 'type'=>'range', 'label'=>false, 'div'=>false, 'min'=>'1', 'max'=>MAX_IMAGE_TIME, 'onchange'=>"rangevalue.value=value+' segundos'", 'value'=>$video['Video']['time'])); ?>
	<output id="rangevalue"><?php echo $video['Video']['time'];?> segundos</output>

	</label>
<?php } ?>






<div class="gnr_inf">Los campos con <b>*</b> son obligatorios</div>


<div class="box_btns">


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
			complete : function(responseText, statusText,
					xhr) {
				window.location.reload();
			}

		});</script>