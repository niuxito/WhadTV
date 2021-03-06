<?php echo $this->Session->flash(); ?>
<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_edit">
<?php echo $this->Html->script("jquery.form"); ?>
<?php //echo $this->Html->script("jquery-1.10.2");?>
<?php //echo $this->Html->script("jquery-ui-1.9.1.custom.min");?>

<?php echo $this->Html->script("uploadFile");?>
<!-------------------------------- # formulario de cartel ---------------------------------->


	<div id="cartel">
	<!-- # formulari # -->
		<div class="forms cartel">
			<!--'controller'=>'Videos',-->
			<?php echo $this->Form->create('Video', 
				array(
					'type' => 'file',
					'controller'=>'Videos', 
					'action'=>'addCartel'
				));?>
			<?php //echo $this->Form->create('Video', array('controller' => 'Videos' , 'action' => 'addCartel' )); ?>
			<div id="colorsContainer">
				<label for="titol_empresa" class="fld fmdm ini">
					<h3>Nombre del cartel:</h3>
					<?php echo $this->Form->input('descripcion', array('class'=>'inpt cartel_input', 'type'=>'text', 'label'=>false, 'maxLength'=>'30')); ?>
				</label>

				<label for="titol_empresa" class="fld fmdm ini">
					<h3>Tiempo:</h3>
					<?php echo $this->Form->input('tiempo', array('class'=>'inpt', 'type'=>'range', 'label'=>false, 'div'=>false, 'min'=>'1', 'max'=>MAX_IMAGE_TIME, 'onchange'=>"rangevalue.value=value+' segundos'", 'value'=>INIT_IMAGE_TIME)); ?>
					<output id="rangevalue"><?php echo INIT_IMAGE_TIME;?> segundos</output>
				</label>

				<?php echo $this->Form->hidden('cartel', array( 'id'=>'contenido_cartel')); ?>
				<?php echo $this->Form->hidden('timestamp');?>
			</div>
			<!--<canvas id="cartel_canvas" width='400' heigh='400'></canvas>-->
			<canvas id="cartel_canvas" width="1280" height="720"></canvas>
			<div class="box_btns">
				<?php echo $this->Form->submit("Guardar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>
			</div><!-- /box_btns -->
			<?php echo $this->Form->end();?>
		</div><!-- /forms -->
	</div>
</div>