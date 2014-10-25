


<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_edit">

<h1>Editar empresa</h1>

<div class="ops">

<!-- tornar -->

<div class="fld icon st_cancel"><?php echo $this->Html->link($this->Html->image("px_tr.gif"), array('controller'=>'videos', 'action'=>'index'), array('escape'=>false, 'title'=>'Cancelar edición')); ?></div>

</div>

</div>



<!-- # formulari # -->

<div class="forms">

<?php echo $this->Form->create('Empresa');?>

<label for="titol_empresa" class="fld fmdm ini">
<h3>Nombre de la empresa:</h3>
<?php echo $this->Form->input('Nombre', array('class'=>'inpt', 'type'=>'text', 'label'=>false, 'maxlength'=>80)); ?>


</label>

<div class="box_btns">
<?php $empresa = $this->Session->read('Empresa'); ?>
<?php echo $this->Html->link(__('Conectores'), array('controller'=>'conectores', 'action' => 'listaConectores', $empresa['Empresa']['idEmpresa']), array('class'=>'btn up', 'div'=>false, 'name'=>'Conectores')); ?>
<?php echo $this->Form->button("Eliminar empresa", array('class'=>'btn', 'action' => 'delete', $this->Form->value('Empresa.idEmpresa')),null, __('Are you sure you want to delete # %s?', $this->Form->value('Empresa.idEmpresa'))); ?>
<?php echo $this->Form->submit("Modificar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>

</div><!-- /box_btns -->

<?php echo $this->Form->end();?>
<div class="sep"></div>
<div>
	<?php $empresa = $this->Session->read('Empresa');
		if( $empresa['Empresa']['url'] != ""){
			echo $this->Html->image($empresa['Empresa']['url'], array('width'=>'100'));
		}
		?>
<?php ?>
	<?php echo $this->Form->create('Empresa', array('action'=>'cambiarLogo', 'type'=>'file')); ?>
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

</div><!-- /forms -->