<?php echo $this->Session->flash(); ?>
<div class="forms">

<h1>Crear nueva empresa:</h1>
<?php echo $this->Form->create('Empresa');?>
	<label name="nombre_emp" class="fld fmdm ini">
		<h3>Nombre</h3>
		<?php echo $this->Form->input('Nombre', array('class'=>'inpt', 'label'=>false, 'type'=>'text')); ?>
	</label>
	
	<li><?php echo $this->Form->submit(__('Crear'), array('class'=>'btn up', 'div'=>false));?></li>
	<?php echo $this->Form->end();?>
</div>

<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoempresas'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
