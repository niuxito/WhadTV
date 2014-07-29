<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_empr">

<h1>Resumen</h1>

</div>


<!-- # llistat de vídeos # -->

<div class="box_list st_emp">

<div class="mlist grn">

<ul>
<li>Usuarios:
<?php
	echo $this->Html->link($resumen['usuarios']['total'], array('action'=>'listadoUsuarios'));
?>
<div class="ops">
	<a class="btn st_vido">Activos:</a>
	<span class="inf"><?php
	echo $resumen['usuarios']['activos'];
	?>
	</span>
	<a class="btn st_vido">Activados:</a>
	<span class="inf"><?php
	echo $resumen['usuarios']['activados'];
	?>
	</span>
</li>
<li>Empresas:
<?php
	echo $this->Html->link($resumen['empresas']['total'], array('action'=>'listadoEmpresas'));
?>
</li>
<li>Videos:
<?php
	echo $this->Html->link($resumen['videos']['total'], array('action'=>'listadoVideos'));
?>
</li>
<li>Dispositivos:
<?php
	echo $this->Html->link($resumen['dispositivos']['total'], array('action'=>'listadoDispositivos'));
?>
</li>
<li>Actualizaciones Dispositivos:
<?php
	echo $this->Html->link($resumen['actualizacionDispositivos']['total'], array('action'=>'listadoActualizacionDispositivos'));
?>
<div class="ops">
	<a class="btn st_vido">Caducados:</a>
	<span class="inf"><?php
	echo $resumen['dispositivos']['caducados'];
	?>
	</span>
	
</li>
</li>
<li>Consejos:
<?php
	echo $this->Html->link($resumen['consejos']['total'], array('action'=>'listadoConsejos'));
?>
</li>
<li>Apks:
<?php
	echo $this->Html->link( _( 'Gestión de Apks' ), array( 'action'=>'listadoApks' ) );
?>
</li>
</li>
<li>
<?php
	echo $this->Html->link(h("Limpiar Cache"), array('action'=>'clearCache'));
?>
</li>



</ul>

</div><!-- /mlist -->



</div><!-- /box_info -->