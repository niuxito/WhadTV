<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">

<h1>Usuarios en Agencia: <b><?php echo h($empresa['Empresa']['Nombre']); ?></b></h1>

</div>

<div class="box_list st_emp">

<div class="mlist grn">
	<ul cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($users as $user): ?>
	<li>
		<td><?php echo h($user['AgenciaUsuario']['idUsuario']); ?>&nbsp;</td>
		<td><?php echo h($user['users']['username']); ?>&nbsp;</td>
		<div class="ops">
			<td><?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'deleteAgenciaUsuario' , $user['AgenciaUsuario']['id']),array('title'=>'Quitar el usuario de esta Agencia','escape'=>false, 'class'=>'btn st_del') ,__('¿Estás seguro de que deseas quitar el usuario de esta Agencia?')); ?></td>
		</div>
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoagenciasempresa', $agencia['Agencia']['idCliente']), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
<div class="acciones">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Asignar usuario a Agencia'), array('action' => 'asignarAgenciaUsuarios',$agencia['Agencia']['id'])); ?></li>
	</ul>
</div>