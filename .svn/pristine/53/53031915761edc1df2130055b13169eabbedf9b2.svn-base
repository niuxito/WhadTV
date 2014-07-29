<?php echo $this->Session->flash(); ?>
<?php echo $this->Html->script('agencia/videosLista'); ?>
<!-- # nom llista i opcions # -->
<script type="text/javascript">
	var controller 	= "<?php echo strtolower($this->request['controller']); ?>";
	var action		= "<?php echo strtolower($this->request['action']); ?>";
</script>
<div id="listado" class="sub_wrap">
	<div class="box_ops brd_bx st_list">
		<h1 id="titleLista"></h1>
			<?php 	echo $this->Html->script('jquery-ui-1.10.3/jquery-ui.min');
					echo $this->Html->script('ordenacion');
					echo $this->Html->script('jquery-ui-1.10.3/jquery.ui.draggable.min');
					echo $this->Html->script('jquery-ui-1.10.3/jquery.ui.sortable.min');
					echo $this->Html->css('jquery-ui-1.10.3/jquery-ui.min');
					//echo $this->Html->css('list');
					echo $this->Html->css('whadtv');
					
			?>
		<div class="ops">
			<?php echo $this->Form->create(array('action'=>'videosxlista'));?>
			<div class="fld icon st_add" id="addLista">
			</div>
			<div class="fld st_chg">
				<select class="ind listListas" id="lista" name="listListas" value="">
				</select>
			</div>
			<div class="fld icon st_edit" id="editarLista">
			</div>
			<?php echo $this->Form->end(); ?>
		</div><!-- /ops -->
	</div><!-- /box_ops -->
	<div class="box_vid list">
		<?php echo $this->Session->flash(); ?>
		<!--<script type="text/javascript">jQ(document).ready(function(){wtv_openAdds();});</script>-->
		<div class="elm add" id="elm_upd_disp">	
		</div>
		<div id="sortable" class="slist"> <!-- sortable -->
		</div> <!-- /sortable -->
	</div> <!-- /box_vid -->
	<div class="box_btns">
		<ul>
			<li><?php echo $this->Html->link(__('Volver'), array('action' => 'vistaReproductor/'.$idReproductor), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
		</ul>
	</div>
</div><!-- /listado -->
<div id="box_add_video" class="box_adds st_video"><div class="bx_head"><h4>Por favor, arrastre los vídeos deseados hasta su posición en la lista.</h4><div class="bx_close"></div></div><div class="bx_cntnt"></div></div>