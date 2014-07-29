<?php echo $this->Session->flash(); ?>
<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_disp">

<h1>Listas en: <b><?php echo h($dispositivo['Dispositivo']['descripcion']); ?></b></h1>

</div>


<!-- # llistat de vídeos # -->

<div class="box_list list">


<!-- avís sincronitzar -->
<!-- 
<div class="elm msg alrt">
<p class="top"><b>Atención:</b> se han realizado modificaciones en el dispositivo que aún no se han hecho efectivas.</p>
<p class="btm"><a class="lbtn up st_updt" href="#">Sincronizar</a> <a class="lbtn dwn" href="#">Desacer</a></p>
</div>
 -->

<!-- avís sincronitzant-se -->
<!-- 
<div class="elm msg alrt">
<p class="prc top"><img src="img/icons/ico_refresh_anim_h22.gif" /> <b>30</b><i>%</i></p>
<p><b>Atención:</b> este dispositivo se está sincronizando.</p>
<p class="btm"><a class="lbtn dwn" href="#">Detener</a></p>
</div>
 -->

<!-- llistes -->
<?php
	$i = 0;
	$d = 0;
	foreach ($listas as $lista): ?>
		<div class="elm">
		<?php 	if ($lista['listaDispositivo']['tipo_relacion'] == 'terceros'){
					echo $this->Html->link(
					$this->Html->image('px_tr.gif').'<br />'.h($lista['Listum']['descripcion']), 
					array('action'=>'listadoVideosLista', h($lista['Listum']['idLista']), h($dispositivo['Dispositivo']['idDispositivo'])), 
					array('class'=> 'lst ter','escape'=>false));
				}else{
					echo $this->Html->link(
					$this->Html->image('px_tr.gif').'<br />'.h($lista['Listum']['descripcion']), 
					array('action'=>'listadoVideosLista', h($lista['Listum']['idLista']), h($dispositivo['Dispositivo']['idDispositivo'])), 
					array('class'=> 'lst','escape'=>false));
				};
		?>
		<!-- <a class="lst" href="index_dispositiu_llista.htm"><?php echo $this->Html->image('px_tr.gif'); ?><br /><?php echo h($lista['Listum']['descripcion']); ?></a> -->
		<div class="ops">
			<!--
			<?php if( $lista['listaDispositivo']['activa'] == 1){ ?>
				<a class="btn st_stop " href="#" title="Apagar lista" id="<?php echo h($lista['listaDispositivo']['id']) ?>" op="sendDetener" ><?php echo $this->Html->image('px_tr.gif'); ?></a>
			<?php }else{ ?>
				<a class="btn st_play" href="#" title="Activar lista" id="<?php echo h($lista['listaDispositivo']['id']) ?>"  op="sendReproducir" ><?php echo $this->Html->image('px_tr.gif'); ?></a>
				
			<?php } ?>
			-->
			<?php if( $lista['Listum']['mute'] == 0){ ?>
				<a class="btn st_sond" id="<?php echo h($lista['Listum']['idLista']); ?>" title="Apagar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
			<?php }else{ ?>
				<a class="btn st_sonf" id="<?php echo h($lista['Listum']['idLista']); ?>" title="Activar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
			<?php } ?>
			<?php echo $this->Html->link(
				$this->Html->image('px_tr.gif'), 
				array('action'=>'listadoVideosLista', h($lista['Listum']['idLista']), h($dispositivo['Dispositivo']['idDispositivo'])), 
				array('class'=>'btn st_vido','escape'=>false)); 
			?>
			<span class="inf"><?php echo $lista[0]['videos']; ?></span>
			
		<!--<?php echo $this->Form->postLink($this->Html->image("px_tr.gif"),array('action' => 'deleteLista',h($dispositivo['Dispositivo']['idDispositivo']),h($lista['Listum']['idLista'])),array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar lista'),__('¿Desea eliminar la lista '. h($lista['Listum']['descripcion']) .' del reproductor realmente?'));?>-->
		<?php echo $this->Form->postLink($this->Html->image("px_tr.gif"),array('action' => 'desvincularListaDispositivo',$lista['listaDispositivo']['id'],$dispositivo['Dispositivo']['idDispositivo']),array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar lista'),__('¿Desea realmente desvincular la lista '. h($lista['Listum']['descripcion']) .'?')); ?>
		
			<!-- <a class="btn st_delt" href="#" title="Eliminar vídeo" onClick="if (confirm('Hoy no toca eliminar nada, ¿no?')) return false; else return false;"><?php echo $this->Html->image('px_tr.gif'); ?></a>-->
		
			<!--<a class="btn st_vido" href="index_dispositiu.htm" title="Vídeos en ejecución"><img src="img/px_tr.gif" /></a><span class="inf"><?php echo h($dispositivo[0]['videos']); ?></span>
			<a class="btn st_delt" href="#" title="Eliminar vídeo" onClick="if (confirm('¿Desea eliminar el dispositivo realmente?')) return true; else return false;"><?php echo $this->Html->image('px_tr.gif'); ?></a>
			-->
		</div>
		<!--<div class="ops">
		<a class="btn st_play" href="#" title="Vídeos en ejecución"><?php echo $this->Html->image('px_tr.gif'); ?></a>
		<a class="btn st_sond" href="#" title="Apagar audio"><?php echo $this->Html->image('px_tr.gif'); ?></a>
		<a class="btn st_vido" href="index_dispositiu_llista.htm" title="Número de vídeos asociados"><?php echo $this->Html->image('px_tr.gif'); ?></a><span class="inf">3</span>
		<a class="btn st_delt" href="#" title="Eliminar vídeo" onClick="if (confirm('¿Desea eliminar el vídeo del dispositivo realmente?')) return true; else return false;"><?php echo $this->Html->image('px_tr.gif'); ?></a>
		</div>-->
		
		</div>
<?php endforeach; ?>

<!--<div class="elm">

<a class="lst" href="index_dispositiu_llista.htm"><?php echo $this->Html->image('px_tr.gif'); ?><br />Llista de reproducció #2</a>

<div class="ops">
<a class="btn st_stop" href="#" title="Vídeos en ejecución"><?php echo $this->Html->image('px_tr.gif'); ?></a>
<a class="btn st_sonf" href="#" title="Activar audio"><?php echo $this->Html->image('px_tr.gif'); ?></a>
<a class="btn st_vido" href="index_dispositiu_llista.htm" title="Número de vídeos asociados"><?php echo $this->Html->image('px_tr.gif'); ?></a><span class="inf">8</span>
<a class="btn st_delt" href="#" title="Eliminar vídeo" onClick="if (confirm('¿Desea eliminar el vídeo del dispositivo realmente?')) return true; else return false;">	</a>
</div>

</div>-->






</div><!-- /box_vid -->

<div class="box_btns">
	<!--<h3><?php echo __('Acciones'); ?></h3>-->
	<ul>
		<li><?php echo $this->Html->link(__('Volver'), array('action' => 'listadoDispositivos'), array('class'=>'btn', 'div'=>false, 'name'=>'Volver')); ?></li>
	</ul>
</div>

<div class="acciones">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Crear Lista'), array('action' => 'addLista',$dispositivo['Dispositivo']['idDispositivo'])); ?></li>
		<li><?php echo $this->Html->link(__('Asignar Listas a Dispositivo'), array('action'=> 'asignarLista',$dispositivo['Dispositivo']['idDispositivo'])); ?></li>
	</ul>
</div>
