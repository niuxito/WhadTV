<?php if( isset($demo) && !$demo ){ ?>
<div class="msg_inf rep_web">
	<p>Ahora puedes probar durante 15 días y sin ningún compromiso nuestro reproductor web. Sin instalaciones, sin costes añadidos.</p>
	<h1>¡¡Pruebalo gratis, ahora!!</h1>
</div>
<?php } ?>

<div class="forms">



<?php echo $this->Form->create('Reproductor',array('action'=>'crear')); ?>

<label for="fld_1" class="fld left mdm">
<h3>Nombre del reproductor:<span class="obl">*</span></h3>
<?php echo $this->Form->input("descripcion",array('class'=>'inpt', 'label'=>false, 'maxlength'=>30)); ?>
<!--<input id="fld_1" class="inpt" type="text" name="[Dispositivo][descripcion]" value="" />-->
</label>

<div class="msg lft min">
Por favor, introduce un texto que no contenga más de 60 caracteres.
</div>

<div class="gnr_inf">Los campos con <b>*</b> son obligatorios</div>


<div class="box_btns">
<?php //echo $this->Html->link('Cancelar', null, array('class'=>'btn','type'=>'submit', 'onClick'=>'cancel()'));?>
 <input class="btn" type="cancel" name="submit_ok" value="Cancelar"
	onClick="window.parent.closeSubWin();"
/>

<input class="btn up" type="submit" name="submit_ok" value="+ Añadir" />

</div><!-- /box_btns -->

<?php echo $this->Form->end(); ?>

<?php $empresa = $this->Session->read( 'Empresa' ); ?>
<input type="checkbox" name="demo_web_block" id="demo_web_block" <?php if( $empresa['Empresa']['demo_web_block'] == 1 ){ echo "checked"; } ?> > No volver a mostrar esta ventana.</input>

</div><!-- /forms -->
<script>
	jQ("#demo_web_block").change(function(){
		jQ.post( directorio + "/Empresas/demoWebBlock" );
		window.parent.closeSubWin();
	});
</script
