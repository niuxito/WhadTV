<div class="lista view">


<?php echo $this->Html->script('listas'); ?>
<h2><?php  echo __('Listum');?></h2>
	<dl>
		<dt><?php echo __('IdLista'); ?></dt>
		<dd id="idLista">
			<?php echo h($listum['Listum']['idLista']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($listum['Listum']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('IdUsuario'); ?></dt>
		<dd>
			<?php echo h($listum['Listum']['idUsuario']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Timestamp'); ?></dt>
		<dd>
			<?php echo h($listum['Listum']['timestamp']); ?>
			&nbsp;
		</dd>
		
	</dl>
	
</div>
<table id="tablaVideos"><tr><td/></tr></table>
<div id="pager"></div> 
  <div id=p></div>
  <input type="button" id="ed1" value="Añadir" />
  <input type="button" id="sved1" value="Eliminar" />
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Listum'), array('action' => 'edit', $listum['Listum']['idLista'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Listum'), array('action' => 'delete', $listum['Listum']['idLista']), null, __('Are you sure you want to delete # %s?', $listum['Listum']['idLista'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Lista'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Listum'), array('action' => 'add')); ?> </li>
	</ul>
</div>
