<?php echo $this->Session->flash(); ?>
<div class=" forms">

	<H2><?php echo h($dispositivos['Dispositivo']['descripcion']); ?></H2>
		
	<div id=pass class=form>	
		<h1>Cambiar Descripción</h1>
	<?php echo $this->Form->create('Dispositivo');	?>
	<label for="descrip_rep" class="fld fmdm ini">
		<h3>Descripción</h3>
		<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'label'=>false, 'type'=>'text')); ?>
	</label>
	
	<label for="caducidad_disp" class="fld fmdm ini">
		<h3>Fecha Caducidad</h3>
		<?php echo $this->Form->input('caducidad',array( 'label'=>false, 'type'=>'date')); ?>
	</label>
	

	<label for="publi_terceros" class="fld fmdm ini">
		<h3>Publicidad de Terceros permitida:</h3>
		<select size="1" name="data[Dispositivo][acepta_terceros]">
		<option <?php if($dispositivos['Dispositivo']['acepta_terceros'] == 1){echo "selected "; } ?> value = 1>Si</option>
		<option <?php if($dispositivos['Dispositivo']['acepta_terceros'] != 1){echo "selected "; } ?>value = 0>No</option>
		</select> 
	</label>
	<?php if ($dispositivos['Dispositivo']['idEmpresa'] == 0 ){ ?>
		<label for="idEmpresa" class="fld fmdm ini">
			<h3>Empresa</h3>
			<select size="1" name="data[Dispositivo][idEmpresa]">
			<option value="0">Desvinculado</option>
			<?php
			foreach($empresas as $empresa){ ?>
			 	<option value=<?php echo $empresa['Empresa']['idEmpresa']; ?>
					<?php if( $empresa['Empresa']['idEmpresa'] == $dispositivos['Dispositivo']['idEmpresa'] ) {
						echo "selected";
					} ?>
				>
					<?php echo $empresa['Empresa']['Nombre']; ?>
				</option>
			<?php }
				
			?>
				
			</select>  
		</label>
	<?php } ?>

	<label for="visible" class="fld fmdm ini">
		<h3>Visible:</h3>
		<select size="1" name="data[Dispositivo][visible]">
		<option <?php if($dispositivos['Dispositivo']['visible'] == 1){echo "selected "; } ?> value = 1>Si</option>
		<option <?php if($dispositivos['Dispositivo']['visible'] != 1){echo "selected "; } ?>value = 0>No</option>
		</select> 
	</label>
	<div class="box_btns">
	<?php echo $this->Form->submit("Cambiar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>
	</div>
	
	<?php echo $this->Form->end();?>
	</div>
</div>
<?php if ($dispositivos['Dispositivo']['idEmpresa'] != 0 ){ ?>		
	<div class="box_btns">
			<td>
			<?php echo $this->Form->postLink('Desvincular dispositivo de empresa',
			    array('action' => 'desvincularReproductor', $dispositivos['Dispositivo']['idDispositivo']),
			    array('confirm' => __('¿Estás seguro de que deseas desvincular el dispositivo de esta empresa?'))
			)?>
			</td>
	</div>
<?php } ?>
<div class="box_btns">
		
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoDispositivos'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>