<?php echo $this->Session->flash(); ?>
<?php echo $this->Html->css('bootstrap.min'); ?>
<?php echo $this->Html->script('bootstrap.min'); ?>
<?php echo $this->Html->script('apk'); ?>

<div class="box_ops brd_bx st_empr">
<h1>
	Listado de Apks

	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    Acciones <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu" role="menu">
	    <li><a href="#" class="lbr rep_link"  data-toggle="modal" data-target="#myModal">Subir Apk<!--onClick="openSubWin('Reproductors/asignar',700,300,2,'Añadir un nuevo reproductor');return false" title="Añadir Apk">Subir Apk<--></a></li>
	  </ul>
	</div>
</h1>

<div class="box_list st_emp">

<div class="mlist grn">
	
	<ul class="slist" cellpadding="0" cellspacing="0">
		<?php 
		$i = 0;
		foreach ($apks as $apk): ?>
			<li>
				<span class="inf">
					<ul>Fecha Alta: <?php echo h($apk['Apk']['timestamp']); ?>&nbsp;</ul>
				</span>
				<div title="NºActualizaciones" class="btn st_msg"><?php echo $this->Html->image("px_tr.gif"); ?></div>
		<span class="inf"><?php echo $apk['Apk']['descargas']; ?></span>
				<span ><?php echo $this->Html->link(h($apk['Apk']['version']), array('action' => 'editarApk', $apk['Apk']['id']) )?></span>

				<div class="ops">
					<?php //echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'changeStateApk', $apk['Apk']['id']),array('title'=>'Cambiar estado','escape'=>false, 'class'=>'btn st_del') ,__('¿Estás seguro de que deseas eliminar esta Agencia?')); ?>
					<?php echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('controller' => 'apks', 'action'=>'changeStateApk', $apk['Apk']['id']),array('title'=>'Cambiar estado','escape'=>false, 'class'=>( $apk['Apk']['activa'] == 0 ) ? 'btn st_play' : 'btn st_stop') ); ?>
				
				</div>
				
			</li>
		<?php endforeach; ?>
	</ul>
	
</div>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoEmpresas'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Subir Apk</h4>
      </div>
      <div class="modal-body">
      	<div class="forms">
      	<?php echo $this->Form->create('Apk', array('type' => 'file', 'action'=>'newVersion'));?>

			<label for="version" class="fld fmdm ini">
				<h3>Versión:</h3>
				<?php echo $this->Form->input('version', array('class'=>'inpt', 'type'=>'text', 'label'=>false, 'maxLength'=>'30')); ?>
			</label>
			<label for="changeLog" class="fld fmdm ini">
				<h3>Notas:</h3>
				<?php echo $this->Form->input('changeLog', array('class'=>'inpt', 'type'=>'textarea', 'label'=>false)); ?>
			</label>
			<label for="fld_7" class="fld left">
			<h3>Fichero:</h3>
			<?php
					echo $this->Form->file('apk', array('class'=>'inpt apk_input')); ?>
			</label>
			<div class="msg btm">
				Por favor, el fichero debe ser un Apk válido y no debe superar los <b>20</b>MBytes.
				<br>
				* El contenido puede tardar unos minutos en estar disponible.
			</div>
			<div class="box_btns">
			<?php echo $this->Form->submit("Agregar", array('class'=>'btn up', 'div'=>false, 'name'=>'submit_ok')); ?>

			</div><!-- /box_btns -->

			<?php echo $this->Form->end();?>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->