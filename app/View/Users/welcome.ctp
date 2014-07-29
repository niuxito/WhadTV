<?php
	echo "Bienvenido a WhadTV.";
	?>
	<div class="mlist grn">
	<ul>
		<li>
			<?php echo $this->Html->link(__('Comprar un WhadTV'), array('controller'=>'compras','action'=>'whadtv')); ?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Activar tu WhadTV'), array('controller'=>'dispositivos','action'=>'asignar')); ?>
		</li>
	</ul>
	</div>

