<?php echo $this->Session->flash(); ?>
<div class=" forms">

		
		<!--<H2><?php echo __($this->request->data['User']['username']); ?></H2>-->
		
		<H2><?php echo h($users['Users']['username']); ?></H2>
		
	<div id=pass class=form>	
		<h1>Cambiar password</h1>
	<?php echo $this->Form->create('User');	?>
	<label for="titol_empresa" class="fld fmdm ini">
		<h3>Nueva Contraseña</h3>
		<?php echo $this->Form->input('password', array('class'=>'inpt', 'label'=>false, 'type'=>'password')); ?>
	</label>
	<label for="titol_empresa" class="fld fmdm ini">
		<h3>Repetir Nueva Contraseña</h3>
		<?php echo $this->Form->input('cpassword', array('class'=>'inpt', 'label'=>false, 'type'=>'password')); ?>
	</label>
	<label for="nivel_user" class="fld fmdm ini">
		<h3>Nivel</h3>
		<select size="1" name="data[User][nivel]">
		<option <?php if($users['Users']['nivel'] == 100){echo "selected "; } ?> value = 100>No activado</option>
		<option <?php if($users['Users']['nivel'] != 100){echo "selected "; } ?>value = 1>Activado</option>
		</select> 
		
		<!--<?php echo $this->Form->input('nivel', array('class'=>'inpt', 'label'=>false, 'type'=>'text')); ?>-->
	</label>
	<label for="welcome_user" class="fld fmdm ini">
		<h3>Tutorial bienvenida</h3>
		<select size="1" name="data[User][welcome]">
		<option <?php if($users['Users']['welcome'] == 1){echo "selected "; } ?> value = 1>Visto</option>
		<option <?php if($users['Users']['welcome'] == 0){echo "selected "; } ?>value = 0>No visto</option>
		</select>
		<!--<?php echo $this->Form->input('welcome', array('class'=>'inpt', 'label'=>false, 'type'=>'text')); ?>-->
	</label>		
			
		
	<div class="box_btns">
	<?php echo $this->Form->submit("Cambiar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>
	</div>
	
	<?php echo $this->Form->end();?>
	</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoUsuarios'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
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
