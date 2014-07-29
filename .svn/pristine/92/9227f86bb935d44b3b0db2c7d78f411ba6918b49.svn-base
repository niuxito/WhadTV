<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_edit">

<h1>Editar Lista</h1>

<div class="ops">

<!-- tornar -->

<div class="fld icon st_cancel"><?php echo $this->Html->link($this->Html->image("px_tr.gif"), array('controller'=>'videos', 'action'=>'index'), array('escape'=>false, 'title'=>'Cancelar edición')); ?></div>

</div>

</div>


<!-- # formulari # -->

<div class="forms">

<?php echo $this->Form->create('Listum');?>

<label for="titol_empresa" class="fld left mdm ini">
	<h3>Nombre de la lista:</h3>
	<?php echo $this->Form->hidden('idLista');?>
	<?php echo $this->Form->input('Nombre', 
			array('class'=>'inpt', 'type'=>'text', 'name'=>'data[Listum][descripcion]', 'value'=>$this->request->data['Listum']['descripcion'], 'label'=>false, 'maxlength'=>40)); ?>

</label>

<div class="box_btns">
<?php echo $this->Html->link("Eliminar lista", array( 'action' => 'delete', $this->request->data['Listum']['idLista']),array('class'=>'btn'), __("¿Estás seguro de querer eliminar la lista '". $this->request->data['Listum']['descripcion']."'?")); ?>

<?php echo $this->Form->submit("Modificar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>

</div><!-- /box_btns -->

<?php echo $this->Form->end();?>

</div><!-- /forms -->
