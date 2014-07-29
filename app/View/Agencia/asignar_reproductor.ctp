<!-- # Formulario # -->
<?php echo $this->Html->css('cake.forms'); ?>
<?php echo $this->Html->css('general_pop'); ?>
<div class="forms">



<?php echo $this->Form->create('Agencia'); ?>

<label for="fld_1" class="fld left mdm">
<h3>Nombre del reproductor:<span class="obl">*</span></h3>
<?php echo $this->Form->input("descripcion",array('class'=>'inpt', 'label'=>false)); ?>
</label>

<div class="msg lft min">
Por favor, introduce un texto que no contenga más de 60 caracteres.
</div>

<label for="fld_2" class="fld left mdm">
<h3>ID del reproductor:<span class="obl">*</span></h3>
<?php echo $this->Form->input("idDispositivo",array('class'=>'inpt', 'label'=>false)); ?>
</label>

<div class="msg lft min">
Indica aquí el ID propio del reproductor contratado.
</div>

<label for="fld_3" class="fld left mdm">
<h3>Empresa:<span class="obl">*</span></h3>
	<select size="1" name="data[Agencia][idEmpresa]">
	<?php
	foreach($empresas as $empresa){
		 echo "<option value=".$empresa['Empresa']['idEmpresa'].">".$empresa['Empresa']['Nombre']."</option>";
	}
	?>
	</select>  
</label>

<div class="msg lft min">
Indica la empresa a la que vas a asignar el reprodutor.
</div>

<div class="gnr_inf">Los campos con <b>*</b> son obligatorios</div>


<div class="box_btns">
<?php //echo $this->Html->link('Cancelar', $this->request->referer() , array('class'=>'btn','type'=>'submit', 'onClick'=>'window.parent.closeSubWin();'));?>

<input class="btn up" type="submit" name="submit_ok" value="+ Añadir" />

</div><!-- /box_btns -->

<?php echo $this->Form->end(); ?>

</div><!-- /forms -->

