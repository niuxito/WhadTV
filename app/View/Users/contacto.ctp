<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_edit">

<h1>Formulario de contacto</h1>

<div class="ops">

<!-- tornar -->

<div class="fld icon st_cancel">
	<?php echo $this->Html->link($this->Html->image("px_tr.gif"), array('controller'=>'videos', 'action'=>'index'), array('escape'=>false, 'title'=>'Cancelar contacto')); ?>
</div>

</div>

</div>



<!-- # formulari # -->

<div class="forms">


<form action="#" method="post">

<label for="fld_1" class="fld fmdm">
<h3>Nombre completo:<span class="obl">*</span></h3>
<input id="fld_1" class="inpt" type="text" name="nombre" value="" />
</label>

<label for="fld_2" class="fld nbl block">
<h3>Correo electrónico:<span class="obl">*</span></h3>
<input id="fld_2" class="inpt" type="text" name="mail" value="" />
</label>

<label for="fld_3" class="fld min block">
<h3>Teléfono de contacto:<span class="obl">*</span></h3>
<input id="fld_3" class="inpt" type="text" name="tel" value="" />
</label>


<label for="fld_5" class="fld fmdm">
<h3>Razón:<span class="obl">*</span></h3>
<textarea id="fld_5" class="inpt" name="texto"></textarea>
</label>


<div class="gnr_inf">Los campos con <b>*</b> son obligatorios</div>


<div class="box_btns">

<input class="btn up" type="submit" name="submit_ok" value="Enviar formulario &raquo;" />

</div><!-- /box_btns -->

</form>

</div><!-- /forms -->