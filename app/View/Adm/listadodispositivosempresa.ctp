<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">

<h1>Dispositivos en: <b><?php echo h($empresa[0]['Empresa']['nombre']); ?></b></h1>

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
		<!--<td><?php echo $this->Html->Link(h($disp['Dispositivo']['username']), array('action' => 'gestUsuario', $user['empresaUsuario']['id'], $user['User']['id'] , $empresa[0]['Empresa']['idEmpresa']), array('title'=>'Gestionar permisos')); ?>&nbsp;</td>-->
		<div class="ops">
			<td><?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'deleteDispositivosEmpresas' , $disp['Dispositivo']['idDispositivo']),array('title'=>'Desvincular el dispositivo de esta empresa','escape'=>false, 'class'=>'btn st_del') ,__('¿Estás seguro de que deseas desvincular el dispositivo de esta empresa?')); ?></td>
		</div>
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoEmpresas', $empresa[0]['Empresa']['idEmpresa']), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
<div class="acciones">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Asignar dispositivo'), array('action' => 'asignarDispositivo',$empresa[0]['Empresa']['idEmpresa'])); ?></li>
	</ul>
</div>