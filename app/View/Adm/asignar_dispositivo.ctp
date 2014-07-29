<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">

<h1>Asignar dispositivos a : <b><?php echo h($empresa[0]['Empresa']['Nombre']); ?></b></h1>

</div>

<div class="box_list st_emp">

<div class="mlist grn">
	<ul cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($dispositivos as $disp): ?>
	<li>
		<td><?php echo h($disp['Dispositivo']['idDispositivo']); ?>&nbsp;</td>
		<td><?php echo h($disp['Dispositivo']['descripcion']); ?>&nbsp;</td>
		<div class="ops">
			<td><?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'asignarDispositivoEmpresa' , $disp['Dispositivo']['idDispositivo'] , $empresa[0]['Empresa']['idEmpresa']),array('title'=>'Asignar dispositivo a la empresa','escape'=>false, 'class'=>'btn st_add_g') ,__('¿Deseas asignar este dispositivo a la empresa?')); ?></td>
		</div>
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadodispositivosempresa', $empresa[0]['Empresa']['idEmpresa']), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
		<!--<li><?php  echo $this->Html->link('Volver', 'javascript:history.back()', array('class'=>'btn up', 'div'=>false, 'name'=>'Volver'));?></li>-->
	</ul>
</div>