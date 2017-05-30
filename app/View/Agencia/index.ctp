<?php echo $this->Session->flash(); ?>
<!-- # nom empresa i opcions # -->
<div class="box_ops brd_bx st_disp">
	<h1><?php echo $this->Html->link(__("Todo"), array('controller'=>'reproductors', 'action'=>'index') );?> <?php echo h($dispositivo['Reproductor']['descripcion']); ?>
	<a class="btn up" onClick="openSubWin(directorio+'/Reproductor/index/dispositivo/<?php echo $dispositivo['Reproductor']['idDispositivo']; ?>',700,500,2,'Previsualizar reproducción');return false" title="Vista previa">Previsualizar</a>
	</h1>
	<div class="ops">
		<?php echo $this->Form->create(array('action'=>'view'));?>
			<!-- tria d'empresa -->
			<div class="fld st_chg">
				<select class="ind" name="chk_reproductor" value=""
					onFocus="jQ(this).removeClass('ind');jQ('option[rel=ini]', this).html('');"
					onBlur ="jQ(this).addClass('ind');jQ('option[rel=ini]', this).html('Cambiar de reproductor');"
					onChange="this.form.submit();"
				>
				<?php
					$i = 0;
					foreach ($dispositivos as $disp): ?>
					<option 
						id=<?php echo $disp['Reproductor']['idDispositivo']; ?> 
						class="lista" 
						value=<?php echo $disp['Reproductor']['idDispositivo']; ?>
						<?php if( isset( $dispositivo ) && $dispositivo['Reproductor']['idDispositivo'] == $disp['Reproductor']['idDispositivo'] ) {
						echo "selected";
						} ?>
					>
						<?php echo h($disp['Reproductor']['descripcion']); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<!-- editar empresa -->
			<div class="fld icon st_edit">
				<?php echo $this->Html->link($this->Html->image('px_tr.gif'), array('action'=>'edit', $dispositivo['Reproductor']['idDispositivo']), array('escape'=>false)); ?>
			</div>
		</form>
	</div>

</div>