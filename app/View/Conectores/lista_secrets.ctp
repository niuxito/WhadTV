<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">

<h1>Listado de Secretos</h1>

</div>


<!-- # llistat de consells # -->

<div class="box_list st_emp">

<div class="mlist grn">
	<ul cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($secrets as $secret): ?>
	<li>
		<span class="inf">
			<ul>Fecha Creación: <?php echo h($secret['ConectorSecret']['fecha_creacion']); ?>&nbsp;</ul>
			<!--<ul>Código Id: <?php //echo h($secret['ConectorSecret']['codigo']); ?>&nbsp;</ul>-->
		</span>
		<!--<div title="Secretos" class="btn st_msg"><?php //echo $this->Html->image("px_tr.gif"); ?></div>
		<span class="inf"><?php //echo $secret[0]['cantidad']; ?></span>-->
		<span class="selm"><?php echo h($secret['ConectorSecret']['clave']); ?>&nbsp;</span>
		<!--<span ><?php //echo $this->Html->link(h($secret['ConectorSecret']['descripcion']), array('action' => 'editarSecret', $secret['Conector']['id']), array('title'=>'Gestionar Secretos','class'=>'selm1')); ?>&nbsp;</span>-->
		<div class="ops">
			<?php 	if( $secret['ConectorSecret']['estado'] == "0"){
						echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'cambiarEstadoConectorSecret', $secret['ConectorSecret']['id'], $secret['ConectorSecret']['estado']),array('title'=>'Deshabilitar secreto','escape'=>false, 'class'=>'btn st_pass') ,__('¿Estás seguro de que deseas deshabilitar este secreto?'));
					}else{
						echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'cambiarEstadoConectorSecret', $secret['ConectorSecret']['id'], $secret['ConectorSecret']['estado']),array('title'=>'Habilitar secreto','escape'=>false, 'class'=>'btn st_fail') ,__('¿Estás seguro de que deseas habilitar este secreto?'));
					}
			?>
			<?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'deleteConectorSecret', $secret['ConectorSecret']['id']),array('title'=>'Eliminar secreto','escape'=>false, 'class'=>'btn st_del') ,__('¿Estás seguro de que deseas eliminar este secreto?')); ?>
		
		</div>
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="acciones">
	<!--<h3><?php //echo __('Nuevo Secreto'); ?></h3>-->
	<h3></h3>
	<ul>
		<div class="forms">
			<?php echo $this->Form->create('ConectorSecret'); ?>			
			<?php echo $this->Form->submit('Crear nuevo secreto',array('class'=>'btn up', 'name'=>'submit_ok', 'escape'=>false, 'div'=>false)); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</ul>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listaConectores', $empresa), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>