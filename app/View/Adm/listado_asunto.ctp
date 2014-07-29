<?php echo $this->Session->flash(); ?>
<div class="box_ops brd_bx st_empr">

<h1>Listado de mensajes del Asunto</h1>

</div>


<!-- # llistat de consells # -->

<div class="box_list st_emp">

<div class="mlist grn">
	<ul cellpadding="0" cellspacing="0">
	
	<?php
	$i = 0;
	foreach ($consejos as $consejo): ?>
	<li>
		<!--<td><?php echo h($consejo['users']['username']); ?>&nbsp;</td>-->
		<span class="btn inf"><ul><?php echo h($consejo['users']['username']); ?>&nbsp;</ul></span>
		<!--<span class="btn inf"><div title="<?php echo h($consejo['users']['username']); ?>" class="btn st_usu"><?php echo $this->Html->image("px_tr.gif"); ?></div></span>-->
		<td><?php echo h($consejo['Consejo']['idConsejo']); ?>&nbsp;</td>
		<td><?php echo h($consejo['Consejo']['descripcion']);?>&nbsp;</td>
				
		<!--<div class="ops">
			<?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'situacionAsunto', $consejo['Consejo']['idAsunto']),array('title'=>'Cambiar la situación de este consejo','escape'=>false, 'class'=>'btn st_rfsh' ) ,__('¿Estás seguro de que cambiar la situacion de este consejo?')); ?>
		</div>-->
	</li>
<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoConsejos'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
<div class="acciones">
	<h3><?php echo __('Respuesta'); ?></h3>
	<ul>
		<!--<li><?php echo $this->Html->link(__('Responder'), array('action' => 'responderAsunto')); ?></li>-->
			<div class="forms">
			<?php echo $this->Form->create('Consejo1'); ?>
			
			<label for="user" class="fld fmdm">
				<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'placeholder'=>'Al último mensaje...', 'label'=>false, 'div'=>false)); ?>
			</label>
			<?php echo $this->Form->submit('Enviar',array('class'=>'btn up', 'name'=>'submit_ok', 'escape'=>false, 'div'=>false)); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</ul>
</div>
