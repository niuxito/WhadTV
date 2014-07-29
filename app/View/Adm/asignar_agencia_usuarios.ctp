<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">
	<h1>Asignar usuarios a Agencia: <b><?php echo h($empresa['Empresa']['Nombre']); ?></b></h1>
</div>

<div class="box_list st_emp">
	<div class="mlist grn">
		<ul cellpadding="0" cellspacing="0">
			<?php
			$i = 0;
			foreach ($users as $user): ?>
				<li>
					<td><?php echo h($user['Usuarios']['id']); ?>&nbsp;</td>
					<td><?php echo h($user['Usuarios']['username']); ?>&nbsp;</td>
					<div class="ops">
						<td><?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'asignarAgenciaUsuario' , $agencia['Agencia']['id'], $user['Usuarios']['id'] , $empresa['Empresa']['idEmpresa']),array('title'=>'Asignar usuario a la Agencia','escape'=>false, 'class'=>'btn st_add_g') ,__('¿Deseas asignar este usuario a la Agencia?')); ?></td>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php  echo $this->Html->link('Volver', 'javascript:history.back()', array('class'=>'btn', 'div'=>false, 'name'=>'Volver'));?></li>
	</ul>
</div>