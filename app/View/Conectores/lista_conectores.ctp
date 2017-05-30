<?php echo $this->Session->flash(); ?>

<div id="listado" class="subwrap">
	<div  class="box_ops brd_bx st_disp">
		<h1>Todo<input class="search" placeholder="" maxlength="30" /></h1>
	</div>

	<div class="box_disp list">

		<div id="sortable" class="slist"> <!-- sortable -->
		<?php
			foreach ($conectores as $conector): ?>
			
			<div class="elm nw_dx">

				<a class="dsp" title="Código Id: <?php echo $conector['Conector']['codigo']?>" href="../listaSecrets/<?php echo $empresa ?>/<?php echo $conector['Conector']['id'] ?>"><?php echo $this->Html->image("px_tr.gif"); ?>
					<span class='selm'><?php echo h($conector['Conector']['descripcion']); ?></span>
					<!--<span class='selm'><?php //echo h($conector['Conector']['codigo']); ?></span>-->
					<!--<span ><?php //echo $this->Html->link(h($conector['Conector']['descripcion']), array('action' => 'listaSecrets',$empresa, $conector['Conector']['id']), array('title'=>'Gestionar Secretos','class'=>'selm1')); ?>&nbsp;</span>-->
					
					<span class="selm1 hidden"><?php echo $conector['Conector']['id'] ?></span>
					<!-- <span class="usge"><b>35<i>%</i></b><span class="barr"><span class="prct" style="width:35%"></span></span></span>-->
				</a>
				<div class="ops">
					<?php 	if( $conector['Conector']['estado'] == "0"){
								echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'cambiarEstadoConector', $conector['Conector']['id'], $conector['Conector']['estado']),array('title'=>'Deshabilitar conector','escape'=>false, 'class'=>'btn st_pass') ,__('¿Estás seguro de que deseas deshabilitar este conector?'));
							}else{
								echo $this->Form->postLink($this->Html->image('px_tr.gif'), array('action'=>'cambiarEstadoConector', $conector['Conector']['id'], $conector['Conector']['estado']),array('title'=>'Habilitar conector','escape'=>false, 'class'=>'btn st_fail') ,__('¿Estás seguro de que deseas habilitar este conector?'));
							}
					?>

					<?php  echo $this->Form->postLink(
						$this->Html->image("px_tr.gif"),
						 array('action' => 'deleteConector', $conector['Conector']['id']),
				    	array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar conector'),
				    	 __('¿Estás seguro de que deseas eliminar este conector?'));?>
				</div>		
			</div>
				
			<?php endforeach; ?>
		</div>
	</div><!-- /box_vid -->
</div><!-- /listado -->
<div class="acciones">
	<h3><?php echo __('Nuevo Conector'); ?></h3>
	<ul>
		<div class="forms">
			<?php echo $this->Form->create('Conector'); ?>			
			<label for="user" class="fld fmdm">
				<?php echo $this->Form->input('descripcion', array('class'=>'inpt', 'placeholder'=>'Descripción del nuevo Conector', 'label'=>false, 'div'=>false)); ?>
			</label>
			<?php echo $this->Form->submit('Crear',array('class'=>'btn up', 'name'=>'submit_ok', 'escape'=>false, 'div'=>false)); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</ul>
</div>
<div class="box_btns">
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('controller'=>'empresas', 'action' => 'edit', $empresa), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>