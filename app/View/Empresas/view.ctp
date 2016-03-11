<div class="empresas view">
<h2><?php  echo __('Empresa');?></h2>
	<dl>
		<dt><?php echo __('IdEmpresa'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['idEmpresa']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('nombre'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($empresa['Empresa']['url']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Empresa'), array('action' => 'edit', $empresa['Empresa']['idEmpresa'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Empresa'), array('action' => 'delete', $empresa['Empresa']['idEmpresa']), null, __('Are you sure you want to delete # %s?', $empresa['Empresa']['idEmpresa'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Empresas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Empresa'), array('action' => 'add')); ?> </li>
	</ul>
</div>
