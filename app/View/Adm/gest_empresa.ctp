<?php echo $this->Session->flash(); ?>
<h1>Gestión empresa: <b><?php echo h($this->request->data['Empresa']['Nombre']); ?></b></h1>

<div class="forms">

<?php echo $this->Form->create('Empresa');?>

<label for="titol_empresa" class="fld fmdm ini">
<h3>Nombre de la empresa:</h3>
<?php echo $this->Form->input('Nombre', array('class'=>'inpt', 'type'=>'text', 'label'=>false)); ?>

</label>

<div class="box_btns">
<?php echo $this->Form->submit("Modificar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>

</div><!-- /box_btns -->

<?php echo $this->Form->end();?>
<div class="sep"></div>
<div>
	<?php echo $this->Html->image($this->request->data['Empresa']['url'], array('width'=>'100'));?>
	
	<?php echo $this->Form->create('Empresa', array('url' => array('controller' => 'adm' , 'action' => 'cambiarLogoEmpresa' , 'type'=>'file'))); ?>
	
	<label for="fld_7" class="fld left">
	<h3>Logotipo:</h3>
	<?php
		echo $this->Form->hidden('idEmpresa');
		echo $this->Form->file('Document', array('class'=>'inpt')); ?>
		
	  
	
	
	</label>
	<div class="msg lft min">
	Nota: El fichero no puede pesar más de 32 MB."
	</div>
	<div class="box_btns">
	<?php echo $this->Form->submit("Enviar Logo", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>
	</div>
	
	<?php echo $this->Form->end();?>
</div>

</div>



<!--<div class="acciones">
<h1>Empresa: <b><?php echo h($empresa['Empresa']['Nombre']); ?></b></h1>
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
	<li><?php echo $this->Html->link(__('Asignar usuario'), array('action' => 'asignarUsuario',$empresa['Empresa']['idEmpresa'])); ?></li>
	<li><?php echo $this->Html->link(__('Asignar dispositivo'), array('action' => 'asignarDispositivo')); ?></li>	
	</ul>
</div>-->
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoEmpresas'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>