<!-- # formulari # -->
<?php echo $this->Html->css('cake.forms'); ?>
<?php echo $this->Html->css('general_pop'); ?>
<!--<link href="css/cake.forms.css" rel="stylesheet" type="text/css" />
<link href="css/general_pop.css?v=1" rel="stylesheet" type="text/css" />-->
<div class="forms">



<?php echo $this->Form->create('Reproductor',array('action'=>'asignar')); ?>

<label for="fld_1" class="fld left mdm">
<h3>Nombre del reproductor:<span class="obl">*</span></h3>
<?php echo $this->Form->input("descripcion",array('class'=>'inpt', 'label'=>false, 'maxlength'=>30)); ?>
<!--<input id="fld_1" class="inpt" type="text" name="[Dispositivo][descripcion]" value="" />-->
</label>

<div class="msg lft min">
Por favor, introduce un texto que no contenga más de 60 caracteres.
</div>

<label for="fld_2" class="fld left mdm">
<h3>ID del reproductor:<span class="obl">*</span></h3>
<?php echo $this->Form->input("id",array('class'=>'inpt', 'label'=>false, 'maxlength'=>90)); ?>
<!--<input id="fld_2" class="inpt" type="text" name="[Dispositivo][id]" value="" />-->
</label>

<div class="msg lft min">
Indica aquí el ID propio del reproductor contratado.
</div>

<div class="gnr_inf">Los campos con <b>*</b> son obligatorios</div>


<div class="box_btns">
<?php echo $this->Html->link('Cancelar', $this->request->referer(), array('class'=>'btn','type'=>'submit', 'onClick'=>'window.parent.closeSubWin();'));?>
<!--  <input class="btn" type="submit" name="submit_ok" value="Cancelar"
	onClick="window.parent.closeSubWin();"
/>-->

<input class="btn up" type="submit" name="submit_ok" value="+ Añadir" />

</div><!-- /box_btns -->

<?php echo $this->Form->end(); ?>

</div><!-- /forms -->

