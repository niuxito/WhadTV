<div class=" forms">
	<div class='form'>	
			<h1>Editar reproductor</h1>
			<?php echo $this->Form->create('Reproductor');	?>
			<label for="titol_empresa" class="fld fmdm ini">
				<h3>Nombre</h3>
				<?php echo $this->Form->hidden('idDispositivo'); ?>
				<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'label'=>false)); ?>
			</label>
			
			
			<div class="box_btns">
			<?php echo $this->Form->submit("Cambiar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>
			</div>
			
			<?php echo $this->Form->end();?>
		</div>
</div>

<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'vistaReproductor/'.$reproductor['Reproductor']['idDispositivo']), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>