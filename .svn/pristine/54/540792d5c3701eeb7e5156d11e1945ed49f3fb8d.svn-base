<?php echo $this->Session->flash(); ?>
<?php echo $this->Html->script('agencia/vistaReproductor'); ?>
<?php echo $this->Html->script('ordenacion'); ?>

<!--<script type="text/javascript">
	var idEmpresa = <?php //echo $Reproductor['Reproductor']['idEmpresa']; ?>;
	var idReproductor = <?php //echo $Reproductor['Reproductor']['idDispositivo']; ?>;
</script>-->

<div class="box_ops brd_bx st_disp">
	<h1 id="titleRep"></h1>
	<div class="ops">
		<?php echo $this->Form->create(array('action'=>'vistaReproductor')); ?>
			<div class="fld st_chg">
				<select class="ind repEmpresa" id="repEmpresa" name="repEmpresa" value="">
				</select>
			</div>
			<div class="fld icon st_edit" id="editarReproductor">
			</div>
		</form>
	</div>
</div>

<div class="box_list list"></div>

<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'ListadoReproductores'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>