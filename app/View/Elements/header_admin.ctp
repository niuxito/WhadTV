<div id="smenu">
	<ul>
		<li><?php echo $this->Html->link(__('Home'), array('controller'=>'adm', 'action' => 'index')); ?></li>
		<li <?php if( strtolower($this->request->action) == "ListadoVideos" ) { echo 'class="ini up"';} ?>><?php echo $this->Html->link(__('Contenido'), array('controller'=>'adm', 'action' => 'ListadoVideos')); ?></li>
		<li <?php if( strtolower($this->request->action) == "ListadoDispositivos" ) { echo 'class="ini up"';} ?>><?php echo $this->Html->link(__('Dispositivos'), array('controller'=>'adm', 'action' => 'ListadoDispositivos')); ?></li>
		<?php if ($empresa['agencia']['clientes'] > 0 ){
				echo '<li> '.$this->Html->link(__('Agencia'), array('controller'=>'agencia','action' => 'ListadoReproductores')).'</li>';
		} ?>
		<li> <?php echo $this->Html->link(__('General'), array('controller'=>'Videos','action' => 'index')); ?></li>
	</ul>
</div><!-- /smenu -->