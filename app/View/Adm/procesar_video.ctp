

<!-- # llistat de consells # -->

<div class="box_list st_emp">

<div class="mlist grn">
	<ul cellpadding="0" cellspacing="0">
	
		<?php
	
		foreach ($test as $formato => $estado): ?>
			<li><a href="../videos/processVideo/<?php echo $id; ?>/crt_<?php echo $formato; ?>" target="_blank">
				<?php echo $formato .' : ';
				if($estado === false){
					echo 'No procesado';
				}elseif($estado === true){
					echo 'Procesado correctamente';

				} ?>
			</a>
			</li>
		

		<?php endforeach; ?>
		<li><a href="../videos/processImageAsVideo/<?php echo $id; ?>/crt_img2video" target="_blank">Convertir a Video</a></li>
		<li>
			<a href="resizeFotograma/<?php echo $id; ?>" target="_blank">
				<?php echo 'tamaño del Fotograma' .' : ';//.$test['fotogramaSize']; ?>
			</a>
		</li>
		<li>
			<a href="../videos/processImage/<?php echo $id; ?>/crt_image" target="_blank">
				<?php echo '720p' .' : ';//.$test['fotogramaSize']; ?>
			</a>
		</li>
		
	</ul>
</div>
</div>