<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">

<h1>Asignar listas a : <b><?php echo h($dispositivo['Dispositivo']['descripcion']); ?></b></h1>
<div class="ops">

	<div class="fld st_chg">

	<select name="chk_llista" class="tipoLista" value="">
	<option selected disabled value=0>Tipo de lista</option>
	<option value=0>Básica</option>
	<?php if ($tercerosDispositivo[0] == 1 && $tercerosLista == 0){
		echo "<option value=1>Terceros</option>";
	} ?>
	</select>

	</div>

</div><!-- /ops -->

</div>

<div class="box_list st_emp">

<div class="mlist grn">
	<ul cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($listas as $lista): ?>
	<li>
		<td><?php echo h($lista['Listum']['idLista']); ?>&nbsp;</td>
		<td><?php echo h($lista['Listum']['descripcion']); ?>&nbsp;</td>
		<div class="ops">
			<td>
				<div title="Asignar lista al dispositivo" href="#" class="btn st_add_g asignarLista" idLista="<?php echo $lista['Listum']['idLista'];?>" idDispositivo="<?php echo $dispositivo['Dispositivo']['idDispositivo'];?>"><?php echo $this->Html->image("px_tr.gif"); ?></div>
				<!--<?php //echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'asignarListaDispositivo' , $lista['Listum']['idLista'] , $dispositivo['Dispositivo']['idDispositivo']),array('title'=>'Asignar lista al dispositivo','escape'=>false, 'class'=>'btn st_add_g') ,__('¿Deseas asignar esta lista al dispositivo?')); ?>-->
			</td>
		</div>
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadolistasdispositivo', $dispositivo['Dispositivo']['idDispositivo']), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
		<!--<li><?php  echo $this->Html->link('Volver', 'javascript:history.back()', array('class'=>'btn', 'div'=>false, 'name'=>'Volver'));?></li>-->
	</ul>
</div>