<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">
	<h1>Asignar Agencias a : <b><?php echo h($empresa['Empresa']['Nombre']); ?></b></h1>
</div>

<div class="box_list st_emp">
	<div class="mlist grn">
		<ul cellpadding="0" cellspacing="0">
			<?php
			$i = 0;
			foreach ($agencias as $agencia): ?>
				<li>
					<td><?php echo h($agencia['Empresa']['idEmpresa']); ?>&nbsp;</td>
					<td><?php echo h($agencia['Empresa']['Nombre']); ?>&nbsp;</td>
					<div class="ops">
						<td><?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'asignarAgenciaEmpresa' , $empresa['Empresa']['idEmpresa'] , $agencia['Empresa']['idEmpresa']),array('title'=>'Asignar Agencia a la empresa','escape'=>false, 'class'=>'btn st_add_g') ,__('¿Deseas asignar esta Agencia a la empresa?')); ?></td>
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