<div class="box_ops brd_bx st_empr">

<h1>Se va a eliminar la empresa: <?php echo $empresa['Empresa']['Descripcion']; ?> y todo el contenido de esta.
¿Estas seguro de quere continuar?</h1>
<?php echo $this->Html->link('Aceptar', array('action' => 'deleteTotal',$empresa['Empresa']['idEmpresa']), array('class'=>'btn up', 'div'=>false, 'escape'=>false));)?>
<?php echo $this->Html->link('Cancelar', array('action' => 'listadoUsuarios'), array('class'=>'btn', 'div'=>false, 'escape'=>false));)?>
</div>