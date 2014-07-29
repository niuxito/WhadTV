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
		<div title="Mensajes" class="btn st_msg"><?php echo $this->Html->image("px_tr.gif"); ?></div>
		<?php 
		foreach ($cuentaMensajes as $cuentaMensaje){
			if ($cuentaMensaje['Consejo']['idAsunto'] == $consejo['Consejo']['idAsunto']){ ?>
				<span class="inf"><?php echo $cuentaMensaje[0]['nMensajes']; ?></span>
			<?php }
		}
		?>
		<td><?php echo h($consejo['Consejo']['idConsejo']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link(h($consejo['Consejo']['descripcion']), array('action' => 'listadoAsunto', $consejo['Consejo']['idAsunto']), array('title'=>'Ver mensajes del asunto')); ?>&nbsp;</td>
				
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="acciones">
	<h3><?php echo __('Nuevo Consejo'); ?></h3>
	<ul>
		<div class="forms">
			<?php echo $this->Form->create('Consejo1'); ?>			
			<label for="user" class="fld fmdm">
				<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'placeholder'=>'Me gustaría que whadtv pudiera hacer...', 'label'=>false, 'div'=>false)); ?>
			</label>
			<?php echo $this->Form->submit('Enviar',array('class'=>'btn up', 'name'=>'submit_ok', 'escape'=>false, 'div'=>false)); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</ul>
</div>
<?php /*
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'index'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
*/ ?>