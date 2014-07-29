<?php echo $this->Session->flash(); ?>
<div class=" forms">
	<H1>Empresa: <?php echo h($empresas[0]['Empresa']['Nombre']); ?></H1>
	
	<H2>Usuario: <?php echo h($users[0]['User']['username']); ?></H2>
		
	<div id=pass class=form>	
		<h3>Gestionar permisos</h3>
	<?php echo $this->Form->create('EmpresaUsuario');	?>
	
	
	<!--<?php echo $this->Form->select('perfil', array( 'Opciones'=>array( '0'=>'Ninguno', '1'=>'Lectura','2'=>'Subir datos'),'empty'=>'(Introduce un valor)',  array('div'=> false))); ?>
	<?php echo $this->Form->select('perfil', array('0'=>'Ninguno', '1'=>'Lectura','2'=>'Subir datos')); ?>-->
	
	
	<?php echo $this->Form->select('perfil',array('0'=>'Ninguno', '1'=>'Lectura','2'=>'Subir datos'),array('empty' => false)); ?>
	
	<!--<select name="data[empresaUsuario][perfil]" id="perfil_empresaUsuario">
	<option value="0">Ninguno</option>
	<option value="1">Lectura</option>
	<option value="2">Subir datos</option>
	</select>-->
	
	<!--<label for="perfil_empresaUsuario" class="fld fmdm ini" >
		<h3>Nivel</h3>
		<select size="1" name "perfil_empusu" value="data[EmpresaUsuario][perfil]">
		<option value = 0>Ninguno</option>
		<option value = 1>Lectura</option>
		<option value = 2>Subir datos</option>
		</select>  
	</label>-->
	
	<!--<label for="titol_empresa" class="fld fmdm ini">
		<h3>Nueva Contraseña</h3>
		<?php echo $this->Form->input('password', array('class'=>'inpt', 'label'=>false, 'type'=>'password')); ?>
	</label>
	<label for="titol_empresa" class="fld fmdm ini">
		<h3>Repetir Nueva Contraseña</h3>
		<?php echo $this->Form->input('cpassword', array('class'=>'inpt', 'label'=>false, 'type'=>'password')); ?>
	</label>-->
			
			
		
	<div class="box_btns">
	<?php echo $this->Form->submit("Cambiar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>
	</div>
	
	<?php echo $this->Form->end();?>
	</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadousuariosempresa/', $empresas[0]['Empresa']['idEmpresa']), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>