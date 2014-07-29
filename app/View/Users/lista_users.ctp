 <div class="users index">
	<h2><?php echo __('Users');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('Nombre');?></th>
			<th><?php echo $this->Paginator->sort('grupo');?></th>
			<th><?php echo $this->Paginator->sort('password');?></th>
			
	</tr>
	<?php
	$i = 0;
	foreach ($users as $video): ?>
	<tr>
		<td><?php echo h($video['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($video['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($video['User']['grupo']); ?>&nbsp;</td>
		<td><?php echo h($video['User']['password']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
