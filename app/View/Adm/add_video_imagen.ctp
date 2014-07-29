<?php echo $this->Session->flash(); ?>
<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_edit">

<?php echo $this->Html->css("general_pop")?>
<?php echo $this->Html->css('colorpicker/jquery.minicolors'); ?>
<?php echo $this->Html->css('tipTip'); ?>
<?php echo $this->Html->script("jquery.form"); ?>
<?php echo $this->Html->script("jquery-ui-1.9.1.custom.min");?>
<?php echo $this->Html->script("jquery.ui.dialog.min");?>
<?php echo $this->Html->script('colorpicker/jquery.minicolors'); ?>
<?php echo $this->Html->script('jquery.tipTip.minified'); ?>
<?php echo $this->Html->script("uploadFile");?>

<!-- # pestanyes armosses # -->

<div class="pest">

<ul>
<li  class="up"><a href="#" id="pest_video">Vídeo</a></li>
<li><a href="#" id="pest_imagen">Imagen estática</a></li>
</ul>

</div>

<!-- # formulario de video -->

<div id="video">
<!-- # formulari # -->

<div class="forms">

<?php echo $this->Form->create('Video', array('type' => 'file', 'action'=>'../adm/addVideo'));?>

<label for="descripcion" class="fld fmdm ini">
<h3>Nombre del video:</h3>
<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'type'=>'text', 'label'=>false,  'maxLength'=>'30')); ?>


</label>

<label for="idEmpresa" class="fld fmdm ini">
	<h3>Empresa</h3>
	<select size="1" name="data[Video][idEmpresa]">
	<?php
	foreach($empresas as $empresa){
		 echo "<option value=".$empresa['Empresa']['idEmpresa'].">".$empresa['Empresa']['Nombre']."</option>";
	}
	?>
	</select>  
</label>

<?php echo $this->Form->hidden('timestamp');?>
<?php echo $this->Form->hidden('tiempo');?>
<label for="fld_7" class="fld left">
<h3>Contenido:</h3>
<?php
		echo $this->Form->file('Document', array('class'=>'inpt video_input')); ?>
</label>
<div class="msg btm">
	Por favor, el contenido debe ser subido en uno de los formatos 
	<a href="" class="tip"  title="video/quicktime | video/avi | video/mp4 | application/x-shockwave-flash | video/x-ms-wmv | video/webm">permitidos</a> y no deben superar los <b>20</b>MBytes.
	<br>
	* El contenido puede tardar unos minutos en estar disponible.
</div>
<div class="box_btns">
<?php echo $this->Form->submit("Agregar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>

</div><!-- /box_btns -->

<?php echo $this->Form->end();?>

<div class="progress" id="progress">
        <div class="bar" style= "height:10px; background-color: red; width: 0px;"></div >
        <div class="percent">0%</div >
    </div>

    <div id="status" style = "position:relative; top:-20px; left:150px;"></div>
</div><!-- /forms -->
</div>


<!-------------------------------- # formulario de imagen ---------------------------------->

<div id="imagen">

<!-- # formulari # -->

<div class="forms">

<?php echo $this->Form->create('Video', array('type' => 'file', 'action'=>'../adm/addImagen'));?>

<label for="titol_empresa" class="fld fmdm ini">
<h3>Nombre de la imagen:</h3>
<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'type'=>'text', 'label'=>false, 'maxLength'=>'30')); ?>


</label>

<label for="idEmpresa" class="fld fmdm ini">
	<h3>Empresa</h3>
	<select size="1" name="data[Video][idEmpresa]">
	<?php
	foreach($empresas as $empresa){
		 echo "<option value=".$empresa['Empresa']['idEmpresa'].">".$empresa['Empresa']['Nombre']."</option>";
	}
	?>
	</select>  
</label>

<label for="titol_empresa" class="fld fmdm ini">
<h3>Tiempo:</h3>
<?php echo $this->Form->input('tiempo', array('class'=>'inpt', 'type'=>'range', 'label'=>false, 'div'=>false, 'min'=>'1', 'max'=>MAX_IMAGE_TIME, 'onchange'=>"rangevalue.value=value+' segundos'", 'value'=>INIT_IMAGE_TIME)); ?>
<output id="rangevalue"><?php echo INIT_IMAGE_TIME;?> segundos</output>


</label>
<?php echo $this->Form->hidden('timestamp');?>
<label for="fld_7" class="fld left">
<h3>Contenido:</h3>
<?php
		echo $this->Form->file('Document', array('class'=>'inpt img_input')); ?>
</label>
<div class="msg btm">
	Por favor, el contenido debe ser subido en uno de los formatos 
	<a href="" class="tip"  title="image/jpeg | image/gif | image/pjpeg | image/png | image/jpg ">permitidos</a> y no deben superar los <b>20</b>MBytes.
	<br>
	*El contenido puede tardar unos minutos en estar disponible.
</div>
<div class="box_btns">
<?php echo $this->Form->submit("Agregar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>

</div><!-- /box_btns -->

<?php echo $this->Form->end();?>


</div><!-- /forms -->
</div>
</div>