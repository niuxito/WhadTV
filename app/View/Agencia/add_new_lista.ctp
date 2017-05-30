<div class="box_ops brd_bx st_edit">
	<div class="forms">
		<?php echo $this->Form->create('Listum');?>
		<label for="fld_1" class="fld left mdm">
			<h3>Nombre de la nueva lista:<span class="obl">*</span></h3>
			<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'type'=>'text', 'label'=>false)); ?>
		</label>
		<div class="msg lft min">
			Por favor, introduce un texto que no contenga más de 60 caracteres.
		</div>
		<div class="gnr_inf">Los campos con <b>*</b> son obligatorios</div>
		<div class="box_btns">
			<?php echo $this->Form->submit("Crear lista", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>
		</div><!-- /box_btns -->
		<?php echo $this->Form->end();?>
	</div><!-- /forms -->
</div>