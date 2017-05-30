<?php echo $this->Session->flash(); ?>
<?php echo $this->Html->script('agencia/listadoReproductores'); ?>
<!-- # Nombre de Empresa y opciones # -->
<div class="box_ops brd_bx st_disp">
	<h1>Todo</h1>
	<div class="ops">
		<?php echo $this->Form->create(array('action'=>'view'));?>
			<!-- # Selección de Empresas # -->
			<div class="fld st_chg">Empresa a gestionar: 
				<select class="ind empAgencia" id="empAgencia" name="empAgencia" value="" >
				</select>
			</div>
		</form>
	</div>
</div>

<!-- # Listado de reproductores # -->
<div class="box_disp list">
	<div class="elm add">
		<a class="lbr" href="#" onClick="openSubWin('asignarReproductor',700,300,2,'Añadir un nuevo reproductor');return false" title="Añadir Reproductor"><img src="<?php echo DIRECTORIO; ?>/img/icons/ico_pantalla_list_add.png" /><br /><i>Añadir Reproductor</i></a>
	</div>
</div><!-- /box_vid -->