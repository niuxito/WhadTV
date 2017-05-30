<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">
<h1>
	Listado de Agencias para: <b><?php echo h($empresa['Empresa']['Nombre']); ?></b>
</h1>

<div class="box_list st_emp">

<div class="mlist grn">
	
	<ul class="slist" cellpadding="0" cellspacing="0">
		<?php 
		$i = 0;
		foreach ($agencias as $agencia): ?>
			<li>
				<span ><?php echo h($agencia['empresa']['Nombre']); ?>&nbsp;</span>
				<div class="ops">
					<?php echo $this->Html->Link($this->Html->image('px_tr.gif'), array('action'=>'listadoAgenciaUsuarios', $agencia['Agencia']['id']), array('title'=>'Usuarios', 'escape'=>false, 'class'=>'btn st_usu')); ?>
					<span class="inf"><?php echo $agencia[0]['usuarios']; ?></span>
					<?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'deleteAgencia', $agencia['Agencia']['id']),array('title'=>'Eliminar Agencia','escape'=>false, 'class'=>'btn st_del') ,__('¿Estás seguro de que deseas eliminar esta Agencia?')); ?>
				
				</div>
				
			</li>
		<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoEmpresas'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
<div class="acciones">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Asignar Agencia'), array('action' => 'asignarAgencia',$empresa['Empresa']['idEmpresa'])); ?></li>
	</ul>
</div>