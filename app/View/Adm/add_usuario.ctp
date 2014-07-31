<?php echo $this->Session->flash(); ?>
<div class="forms">

<h1>Añadir nuevo usuario:</h1>
<?php echo $this->Form->create('User');?>
	<label name="username" class="fld fmdm ini">
		<h3>Nombre</h3>
		<?php echo $this->Form->input('username', array('class'=>'inpt', 'label'=>false, 'type'=>'text')); ?>
	</label>
	<label for="password_user" class="fld fmdm ini">
		<h3>Contraseña</h3>
		<?php echo $this->Form->input('password', array('class'=>'inpt', 'label'=>false, 'type'=>'password')); ?>
	</label>
	<label for="cpassword_user" class="fld fmdm ini">
		<h3>Repetir Contraseña</h3>
		<?php echo $this->Form->input('cpassword', array('class'=>'inpt', 'label'=>false, 'type'=>'password')); ?>
	</label>
	<label for="nivel_user" class="fld fmdm ini">
		<h3>Nivel</h3>
		<select size="1" name="data[User][nivel]">
		<option selected value = 100>No activado</option>
		<option value = 1>Activado</option>
		</select>  
	</label>
	<label for="welcome_user" class="fld fmdm ini">
		<h3>Tutorial bienvenida</h3>
		<select size="1" name="data[User][welcome]">
		<option selected value = 1>Visto</option>
		<option value = 0>No visto</option>
		</select>
		
	</label>
	<li><?php echo $this->Form->submit(__('Añadir'), array('class'=>'btn up', 'div'=>false));?></li>
	<?php echo $this->Form->end();?>
</div>

<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadousuarios'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
