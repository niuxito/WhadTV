<?php echo $this->Session->flash(); ?>
<div class="box_ops">
<?php echo $this->element('config'); ?>
<?php echo $this->Html->css("general_pop"); ?>
<?php echo $this->Html->script("jquery.form"); ?>
<?php echo $this->Html->script("jquery-ui-1.9.1.custom.min");?>
<script type="text/javascript">
function funcionP(event)
{
	
	var pregunta=confirm("¿Estas seguro de modificar los datos?");
	if (pregunta){
		
		//alert('pregunta es si');
	}else{
		event.preventDefault();
		//alert('pregunta es no');
	}

}
</script>
<!-- if(!userSubmitted) -->
<!-- visualització vídeo -->

<div class="box_view st_vido">
<div class="box_cntnt">
<?php if( $video['Video']['tipo'] == 'video'){ ?>
	<video  width="300" height="200"  controls >
	 	<source type="video/mp4" src="<?php echo $video['Video']['formatos']['h264'];?>"></source>
		<source type="video/webm" src="<?php echo $video['Video']['formatos']['webm'];?>"></source>
		<!-- <source type="video/ogg" src="../<?php //echo $video['Video']['url'];?>"></source>-->
		<!-- <source type="video/x-matroska; codecs="theora, vorbis"' src="../<?php //echo $video['Video']['url'];?>"></source>-->
	</video>
<?php }elseif( $video['Video']['tipo'] == 'imagen' ){ ?>
	<img src="<?php echo $video['Video']['formatos']['720p']; ?>" >
<?php } ?>
</div>
<!-- <div class="box_cntnt"><img src="_test/vid_1.jpg" width="540" heigh="480" /></div> --> 

</div>



<!-- # formulari # -->

<div class="forms">



<?php echo $this->Form->create('Video');?>

<label for="fld_1" class="fld left mdm">
	<h3>Título del vídeo:<span class="obl">*</span></h3>
	<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'label'=>false, 'value'=>$video['Video']['descripcion'], 'maxlength'=>30));?>
</label>

<div class="msg lft min">
	Por favor, introduce un texto que no contenga más de 60 carácteres.
</div>

<?php if( $video['Video']['tipo'] == 'imagen'){ ?>
	<label for="titol_empresa" class="fld fmdm ini">
	<h3>Tiempo:</h3>
	<?php echo $this->Form->input('time', array('class'=>'inpt', 'type'=>'range', 'label'=>false, 'div'=>false, 'min'=>'1', 'max'=>MAX_IMAGE_TIME, 'onchange'=>"rangevalue.value=value+' segundos'", 'value'=>$video['Video']['time'])); ?>
	<output id="rangevalue"><?php echo $video['Video']['time'];?> segundos</output>

	</label>
<?php } ?>

<label for="idEmpresa" class="fld fmdm ini">
	<h3>Empresa</h3>
	<select size="1" name="data[Video][idEmpresa]">
	<?php
	foreach($empresas as $empresa){ ?>
		 <!--echo "<option value=".$empresa['Empresa']['idEmpresa'].">".$empresa['Empresa']['Nombre']."</option>";-->
		
		 <option value=<?php echo $empresa['Empresa']['idEmpresa']; ?>
			<?php if( $empresa['Empresa']['idEmpresa'] == $video['Video']['idEmpresa'] ) {
			echo "selected";
			} ?>
		>
			<?php echo $empresa['Empresa']['Nombre']; ?>
		</option>
		<?php
	}
	?>
	</select> 
</label>

<div class="gnr_inf">Los campos con <b>*</b> son obligatorios</div>

	<div class="box_btns">
		<button class="btn up" onclick="funcionP(event)">Modificar</button>
		<!--<button class="btn up" onClick="if(confirm('¿Desea realizar los cambios?'))
		alter('ab');
		else alert('No procesa!')" value ="prueba"  ></button>-->
		
		
		
		<!--<button class="btn up" onClick=<?php $var_r = 'funcionP()'?> >PRuebas</button>-->
		<!--<input class="btn up" onclick="if (funcionP() == true) { submit }" type ="submit" name="submit_ok" value="Modificar" />-->
		
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoVideos'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
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