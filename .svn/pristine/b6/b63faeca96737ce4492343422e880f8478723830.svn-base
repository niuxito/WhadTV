<?php echo $this->Session->flash(); ?>
<?php echo $this->Html->script('agencia/listadoVideos'); ?>
<script type="text/javascript">
	var controller 	= "<?php echo strtolower($this->request['controller']); ?>";
	var action		= "<?php echo strtolower($this->request['action']); ?>";
</script>
<div id="listado" class="sub_wrap">
	<div class="box_ops brd_bx st_list">
		<h1 id="titleEmpresa"></h1>
			<?php 	echo $this->Html->script('jquery-ui-1.10.3/jquery-ui.min');
					echo $this->Html->script('ordenacion');
					echo $this->Html->script('jquery-ui-1.10.3/jquery.ui.draggable.min');
					echo $this->Html->script('jquery-ui-1.10.3/jquery.ui.sortable.min');
					echo $this->Html->css('jquery-ui-1.10.3/jquery-ui.min');
					echo $this->Html->css('whadtv');					
			?>
		<div class="ops">
			<?php echo $this->Form->create(array('action'=>'listadoVideos'));?>
			<div class="fld st_chg">Empresa: 
				<select class="ind listEmpresas" id="listEmpresas" name="listEmpresas" value="">
				</select>
			</div>
			<?php echo $this->Form->end(); ?>
		</div><!-- /ops -->
	</div><!-- /box_ops -->
	<div class="box_vid list">
		<div class="elm_mov addvideo" id="elm_addvideo">
			<div class="elm" pos="0">
				<a class="prv" href="#" onClick="openSubWin(directorio+'/agencia/addVideo',700,370,2,'Añadir nuevo contenido: ');return false" title="Añadir video"><img src="<?php echo DIRECTORIO; ?>/img/icons/ico_video_add.jpg" /><br /><i>Añadir nuevo contenido</i></a>
			</div> <!-- /elm -->	
		</div>
		<div id="sortable" class="slist"> <!-- sortable -->
		</div> <!-- /sortable -->
	</div> <!-- /box_vid -->
</div>

