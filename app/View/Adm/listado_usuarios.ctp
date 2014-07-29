<?php echo $this->Session->flash(); ?>
<?php echo $this->Html->script('list'); ?>
<div id="listado">
<div class="box_ops brd_bx st_empr">


<h1>
	Listado de usuarios 
	<!-- Search input -->
	<input class="search" placeholder="" />
</h1>

<!-- # llistat de vídeos # -->

<div class="box_list st_emp">

<div class="mlist grn">
	
	<ul class="slist" cellpadding="0" cellspacing="0">
		<?php
		$i = 0;
		foreach ($users as $user): ?>
			<li <?php if($user['User']['nivel'] == 100 || $user['User']['welcome'] == 0){echo 'class="inact"'; }?>>
				<span class="selm"><?php echo h($user['User']['id']); ?>&nbsp;</span>
				<span ><?php echo $this->Html->link(h($user['User']['username']), array('action' => 'editarUsuario', $user['User']['id']), array('title'=>'Modificar contraseña','class'=>'selm1')); ?>&nbsp;</span>
				<span class="inf">
					<ul>Último Acceso: <?php echo h($user['User']['timestampLAcceso']); ?>&nbsp;</ul>
					<ul>Fecha Alta: <?php echo h($user['User']['timestampCreacion']); ?>&nbsp;</ul>
				</span>
				
				<div class="ops">
					<?php echo $this->Html->Link($this->Html->image('px_tr.gif'), array('action'=>'listadoempresasusuarios', $user['User']['id']), array('title'=>'Empresas', 'escape'=>false, 'class'=>'btn st_emp')); ?>
					<span class="inf"><?php echo $user['0']['empresas']; ?></span>
					<?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'deleteUsuario', $user['User']['id']),array('title'=>'Eliminar usuario','escape'=>false, 'class'=>'btn st_del') ,__('¿Estás seguro de que deseas eliminar este usuario?')); ?>
				
				</div>
				
			</li>
		<?php endforeach; ?>
	</ul>
	
</div>
</div>
</div><!-- #listado -->
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'index'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
<div class="acciones">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nuevo usuario'), array('action' => 'addUsuario')); ?></li>
	</ul>
</div>
<!--<script>
	/*var options = {
    	valueNames: ['mail', 'iduser']
	};
	console.log("cargando lista");
	var usersList = new List('users', options);
	console.log(usersList);*/
//hackerList.add( { name: 'Jonas', city:'Berlin' } );
</script>-->
