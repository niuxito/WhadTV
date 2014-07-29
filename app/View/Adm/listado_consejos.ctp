<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">

<h1>Listado de consejos</h1>

</div>


<!-- # llistat de consells # -->

<div class="box_list st_emp">

<div class="mlist grn">
	<ul cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($consejos as $consejo): ?>
	<li>
		<span class="btn inf"><ul><?php echo h($consejo['users']['username']); ?>&nbsp;</ul>
		<ul>F.Últ.Msg; 
		<?php foreach ($ultMensajes as $ultMensaje){
			if ($ultMensaje['Consejo']['idAsunto'] == $consejo['Consejo']['idAsunto']){
				echo $ultMensaje['Consejo']['created'];
			}
		} ?>
		</ul>
		</span>

				
		<!--<div title="<?php echo h($consejo['users']['username']); ?>" class="btn st_usu"><?php echo $this->Html->image("px_tr.gif"); ?></div>-->
		<div title="Mensajes" class="btn st_msg"><?php echo $this->Html->image("px_tr.gif"); ?></div>
		<?php 
		foreach ($cuentaMensajes as $cuentaMensaje){
			if ($cuentaMensaje['Consejo']['idAsunto'] == $consejo['Consejo']['idAsunto']){ ?>
				<span class="inf"><?php echo $cuentaMensaje[0]['nMensajes']; ?></span>
				<!--<span class="inf" title="Mensajes"><?php echo $cuentaMensaje['Consejo']['idAsunto']; ?></span>-->
				<!--<span class="inf"><?php echo $cuentaMensaje['Consejo']['nMensajes'] ?></span>-->
			<?php }
		}
		?>
		<?php if($consejo['Consejo']['situacion']== 0){ ?>
			<div title="<?php echo 'Situación Procesada'; ?>" class="btn st_add_g"><?php echo $this->Html->image("px_tr.gif"); ?></div>
		<?php }else{ ?>
			<div title="<?php echo 'Situación No Procesada'; ?>" class="btn st_del"><?php echo $this->Html->image("px_tr.gif"); ?></div>
		<?php } ?>
		<td><?php echo h($consejo['Consejo']['idConsejo']); ?>&nbsp;</td>
		<!--<td><?php echo $this->Html->link(h($consejo['Consejo']['descripcion']), array('action' => 'editarConsejo', $consejo['Consejo']['idConsejo']), array('title'=>'Modificar consejo')); ?>&nbsp;</td>-->
		<!--<td><?php echo h($consejo['Consejo']['descripcion']);?>&nbsp;</td>-->
		<td><?php echo $this->Html->link(h($consejo['Consejo']['descripcion']), array('action' => 'listadoAsunto', $consejo['Consejo']['idAsunto']), array('title'=>'Ver mensajes del asunto')); ?>&nbsp;</td>
				
		<div class="ops">
			<?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'situacionAsunto', $consejo['Consejo']['idAsunto']),array('title'=>'Cambiar la situación de este consejo','escape'=>false, 'class'=>'btn st_rfsh' ) ,__('¿Estás seguro de que cambiar la situacion de este consejo?')); ?>
		</div
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'index'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
