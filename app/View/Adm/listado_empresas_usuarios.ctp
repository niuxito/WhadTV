<?php echo $this->Session->flash(); ?>
<!--<?php echo $this->Form->create('EmpresaUsuario');?>-->
<div class="box_ops brd_bx st_empr">
<h1>Listado de empresas de: <b><?php echo h($user[0]['User']['username']); ?></b></h1>
</div>
<div class="box_list st_emp">
	<div class="mlist grn">
		<ul cellpadding="0" cellspacing="0">
			<?php
			$i = 0;
			foreach ($empresas as $emp): ?>
			<li>
				<td><?php echo h($emp['Empresa']['idEmpresa']); ?>&nbsp;</td>
				<td><?php echo h($emp['Empresa']['Nombre']); ?>&nbsp;</td>
				<div class="ops">
					<?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'deleteEmpresasUsuarios', $emp['empresaUsuario']['id']),array('title'=>'Dar de baja en esta empresa','escape'=>false, 'class'=>'btn st_del') ,__('¿Estás seguro de que deseas dar de baja al usuario en esta empresa?')); ?>
					<!--<span class="inf"><?php echo $empusu['0']['empresas']; ?></span>-->
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="box_btns">
		<ul>
			<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadousuarios'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
		</ul>
	</div>
</div>
