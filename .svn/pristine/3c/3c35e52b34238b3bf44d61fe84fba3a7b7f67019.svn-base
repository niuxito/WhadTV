<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">

<h1>Asignar videos a : <b><?php echo h($listaDispositivos[0]['lista']['descripcion']); ?></b></h1>

</div>

<div class="box_list st_emp">

<div class="mlist grn">
	<ul cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($videos as $video): ?>
	<li>
		<td><?php echo h($video['Video']['idVideo']); ?>&nbsp;</td>
		<td><?php echo h($video['Video']['descripcion']); ?>&nbsp;</td>
		<div class="ops">
			<td><?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'asignarVideoLista' , $video['Video']['idVideo'] , $listaDispositivos[0]['ListaDispositivo']['idLista'],$listaDispositivos[0]['dispositivo']['idDispositivo']),array('title'=>'Asignar video a la lista','escape'=>false, 'class'=>'btn st_add_g') ,__('¿Deseas asignar este video a la lista?')); ?></td>
		</div>
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoVideosLista', $listaDispositivos[0]['ListaDispositivo']['idLista'],$listaDispositivos[0]['dispositivo']['idDispositivo']), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
		<!--<li><?php  echo $this->Html->link('Volver', 'javascript:history.back()', array('class'=>'btn up', 'div'=>false, 'name'=>'Volver'));?></li>-->
	</ul>
</div>