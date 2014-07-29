<div id="smenu">
	<ul>
		<li <?php if( strtolower($this->request->controller) == "videos" ) { echo 'class="ini up"';} ?>><?php echo $this->Html->link(__('Contenido'), array('controller'=>'videos', 'action' => 'index')); ?></li>
		<li <?php if( strtolower($this->request->controller) == "reproductors" ) { echo 'class="ini up"';} ?>><?php echo $this->Html->link(__('Reproductores'), array('controller'=>'reproductors', 'action' => 'index')); ?></li>
		<?php if ($empresa['agencia']['clientes'] > 0 ){
				echo '<li> '.$this->Html->link(__('Agencia'), array('controller'=>'agencia','action' => 'ListadoReproductores')).'</li>';
			}
			if(isset($user['User']['nivel']) && $user['User']['nivel'] ==  0 ){
				echo '<li> '.$this->Html->link(__('Administrador'), array('controller'=>'adm','action' => 'index')).'</li>';
			} ?>	
	</ul>
	<?php if(isset($empresa)){ ?>
		<div id="emprs">

		<h1>
			<?php echo $empresa['Empresa']['Nombre']; ?>
		</h1>

		<div class="ops">

		<!-- tria d'empresa -->
		<div class="fld icon st_chg"><?php echo $this->Html->link($this->Html->image("px_tr.gif"), array('controller'=>'Empresas', 'action'=>'selectEmpresa'), array('title'=>"Cambiar empresa", 'escape'=>false)); ?></div>

		<!-- editar empresa -->
		<div class="fld icon st_edit">
			<?php echo $this->Html->link( $this->Html->image("px_tr.gif") , array('controller'=>'empresas', 'action'=>'edit', $empresa['Empresa']['idEmpresa'] ), array( 'title'=>'Editar empresa', 'escape'=>false)); ?>
		</div>


		</div><!-- /ops -->

		</div><!-- /empresa -->
	<?php } ?>
</div><!-- /smenu -->