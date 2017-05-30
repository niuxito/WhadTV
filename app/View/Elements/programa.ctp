<li id="<?php echo $programa[ 'Programacion' ][ 'id' ]; ?>" class="forms">
	<a href="#" class="btn back " > < </a>
<?php
		echo $this->Form->create( 'Programacion', array( 'action'=>'edit' ) );
		echo $this->Form->hidden( 'id', array( 'value'=>$programa[ 'Programacion' ][ 'id' ] ) );
?>
<?php 		
		if( $programa[ 'Programacion' ][ 'estado' ] == 1 ){ 	
			echo $this->Form->hidden( "estado", array( 'value'=>'1', 'idPrograma'=>h( $programa[ 'Programacion' ][ 'id' ] ) ) );
?>
			<a class="btn st_stop " href="#" title="Apagar dispositiu" id="<?php echo h($programa['Programacion']['id']) ?>" ><!--------CAMBIAR POR INPUT???------------>
<?php
 				echo $this->Html->image('px_tr.gif'); 
?>
			</a>

<?php 
		}else{ 
			echo $this->Form->hidden( "estado", array( 'value'=>'0', 'idPrograma'=>h( $programa[ 'Programacion' ][ 'id' ] ) ) );
?>
			<a class="btn st_play " href="#" estado="0" title="Apagar dispositiu" id="<?php echo h($programa['Programacion']['id']) ?>" >
<?php 
				echo $this->Html->image('px_tr.gif'); 
?>
			</a>
<?php
		} 
?>
		<label for="fecha" class="fld fmdm clndr">
<?php 		
			//echo $this->Form->input('fecha', array('class'=>'inpt', 'type'=>'date', 'label'=>false, 'maxLength'=>'30', 'value'=>$programa['Programacion']['fecha'])); 
?>
		<input class="inpt" name="data[Programacion][fecha]" type="date" value="<?php echo h( $programa[ 'Programacion' ][ 'fecha' ] ); ?>" />
		</label><!-- /fecha -->
		<label for="hora" class="fld fmdm">
<?php 
			$horas = array(
				'0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'
				);
			echo $this->Form->select('hora', $horas,  array('empty'=>false,'class'=>'inpt', 'value'=>$programa['Programacion']['hora']));
?>
		</label><!-- /hora -->
		<label for="minuto" class="fld fmdm">
<?php 
			$minutos = array(
				'0'=>'0','5'=>'5','10'=>'10','15'=>'15','20'=>'20','25'=>'25','30'=>'30','35'=>'35','40'=>'40','45'=>'45','50'=>'50','55'=>'55'
				);
			echo $this->Form->select('minuto', $minutos, array('empty'=> false,'class'=>'inpt','value'=>$programa['Programacion']['minuto']));

?>
		</label><!-- /minutos -->






		<div class="ops">
			<input title="Guardar datos" class="btn up" name="submit_ok" type="submit" value="Programar" />
			<a class="btn st_delt " href="#" title="Borrar programa" id="<?php echo h($programa['Programacion']['id']) ?>" >

<?php 
				echo $this->Html->image('px_tr.gif'); 
?>
			</a><!--/deletePrograma-->
			
			
			
		</div>
<?php 
		echo $this->Form->end();
?>
		


	</li>