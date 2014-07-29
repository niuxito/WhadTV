<?php echo $this->Session->flash(); ?>
<div class="forms">

<h1>Crear nuevo dispositivo:</h1>
<?php echo $this->Form->create('Dispositivo');?>
	<label name="idDispositivo" class="fld fmdm ini">
		<h3>ID Dispositivo</h3>
		<?php echo $this->Form->input('idDispositivo', array('class'=>'inpt', 'label'=>false, 'type'=>'text')); ?>
	</label>
	<label name="descripcion" class="fld fmdm ini">
		<h3>Descripción</h3>
		<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'label'=>false, 'type'=>'text')); ?>
	</label>
	<!--<label for="idEmpresa" class="fld fmdm ini">
		<h3>Empresa</h3> 
		<?php echo $this->Form->input('idEmpresa', array('class'=>'inpt', 'label'=>false, 'type'=>'text')); ?>
	</label>-->
	<label for="idEmpresa" class="fld fmdm ini">
		<h3>Empresa</h3>
		<select size="1" name="data[Dispositivo][idEmpresa]">
		<?php
		foreach($empresas as $empresa){
			 echo "<option value=".$empresa['Empresa']['idEmpresa'].">".$empresa['Empresa']['Nombre']."</option>";
		}
		?>
		</select>  
	</label>
	
	<li><?php echo $this->Form->submit(__('Añadir'), array('class'=>'btn up', 'div'=>false));?></li>
	<?php echo $this->Form->end();?>
</div>

<div class="box_btns">
	<!--<h3><?php echo __('Acciones'); ?></h3>-->
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoDispositivos'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>