<!-- selector -->
<?php echo $this->Html->script("jquery.form"); ?>
<?php echo $this->Html->script('updateDispositivos'); ?>
<div class="forms">

<form action="#" class="disp">

<label for="fld_1" class="fld ini line">
<span class="title">Dispositivo:</span>
<input id="fld_1" class="inpt min" type="text" name="fld_1" value="" />
</label>

 <label for="fld_2" class="fld line">
<span class="title">Estado:</span>
<select class="inpt" name="fld_2" value="">
<option rel='ini'>Todos</option>
<option>Por actualizas</option>
<option>Actualizados</option>
</select>
</label>

</form>

</div><!-- /forms -->


<!-- llista-->


<div class="box_pop st_disp noSpTp">

<!--h2 class="st_vid"><img src="_test/vid_1.jpg">Listas de reproducción:<br /><b>Video test 1</b></h2-->

<?php echo $this->Form->create('updatedispositivos')?>

<div class="mlist check">
<ul>
<?php foreach($dispositivos as $dispositivo){ ?>

<li class="ini"><input type="checkbox" name="chec[]" value="<?php echo h($dispositivo['Dispositivo']['idDispositivo'])?>"><a class="titl" href="index_llista.htm"><?php echo h($dispositivo['Dispositivo']['descripcion'])?></a>
	<div class="ops">
	<ol>
	<li class="min"><span class="ico refrsh"><?php echo $this->Html->image('px_tr.gif')?></span></li>
	</ol>
	</div>
</li>
	
<?php }?>

</ul>

</div><!-- /mlist -->
<div class="box_btns">
<?php echo $this->Form->submit("Actualizar dispositivos seleccionados", array('class'=>'btn up'))?>
</div><!-- <a class="btn up" href="#">Actualizar dispositivos seleccionados</a></div>-->

</form>

</div><!-- /box_info -->