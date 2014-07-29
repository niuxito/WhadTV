<div class=" forms">

	
	<H2><?php echo __($this->request->data['User']['username']); ?></H2>
	
	<?php if ($this->request->data['User']['normas'] == 0){ ?>
		<div id=pass class=form>	
		<h1>Condiciones Legales </h1>
		<?php echo $this->Form->create('User');	?>
		
		<label>
			<?php echo $this->Form->checkbox('normas');
			?> Al pulsar sobre el botón Aceptar Normas, aceptas nuestras 
			<?php echo	$this->Html->link('Condiciones', array('controller'=>'pages','action'=>'legal'),array('target'=>'_blank')) ?>
							, y que has leido y entendido nuestra Política de uso de datos.
			
		</label>
		
		<div class="box_btns">
			<?php echo $this->Form->submit("Aceptar Normas", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>
		</div>
		<?php echo $this->Form->end();?>
		</div>
	<?php }else{ ?>
		<div id=pass class=form>	
			<h1>Cambiar password</h1>
		<?php echo $this->Form->create('User');	?>
		<label for="titol_empresa" class="fld fmdm ini">
			<h3>Contraseña actual</h3>
			<?php echo $this->Form->hidden('username'); ?>
			<?php echo $this->Form->input('oldPass', array('class'=>'inpt', 'label'=>false, 'type'=>'password')); ?>
		</label>
		<label for="titol_empresa" class="fld fmdm ini">
			<h3>Nueva Contraseña</h3>
			<?php echo $this->Form->input('password', array('class'=>'inpt', 'label'=>false, 'type'=>'password')); ?>
		</label>
		<label for="titol_empresa" class="fld fmdm ini">
			<h3>Repetir Nueva Contraseña</h3>
			<?php echo $this->Form->input('cpassword', array('class'=>'inpt', 'label'=>false, 'type'=>'password')); ?>
		</label>
		
		<div class="box_btns">
		<?php echo $this->Form->submit("Cambiar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>
		</div>
		
		<?php echo $this->Form->end();?>
		</div>
	<?php } ?>
</div>


<!-- <div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		
		<li><?php echo $this->Html->link(__('Lista de Empresas'), array('action' => '../Empresas/lista'));?></li>
		<li><?php echo $this->Html->link(__('Crear Empresa'), array('action' => '../Empresas/add'));?></li>
		
		<li><?php echo $this->Html->link(__('Salir'), array('action' => '../Users/logout')); ?></li>
	</ul>
</div> -->
