











<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_disp">

<h1><?php echo $this->Html->link(__("Todo"), array('controller'=>'dispositivos', 'action'=>'index') );?> <?php echo h($dispositivo['Dispositivo']['descripcion']); ?>
<a class="btn up" onClick="openSubWin(directorio+'/Reproductor/index/dispositivo/<?php echo $dispositivo['Dispositivo']['idDispositivo']; ?>',700,500,2,'Previsualizar reproducción');return false" title="Vista previa">Previsualizar</a>
</h1>


<div class="ops">

<form action="#">

<!-- tria d'empresa -->

<div class="fld st_chg">

<select class="ind" name="chk_empresa" value=""
	onFocus="jQ(this).removeClass('ind');jQ('option[rel=ini]', this).html('');"
	onBlur ="jQ(this).addClass('ind');jQ('option[rel=ini]', this).html('Cambiar de dispositivo');"
	onChange="this.form.submit();"
>
<option rel='ini'>Cambiar de dispositivo</option>
<option>Todos</option>
<option>Dispositivo #1</option>
<option>Dispositivo #2</option>
</select>

</div>

<!-- editar empresa -->

<div class="fld icon st_edit"><a href="index_editar_dispositivo.htm" title="Editar dispositivo"><?php echo $this->Html->image('px_tr.gif'); ?></a></div>

</form>

</div>

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
<div class="elm add">

<a class="lbr" href="#" onClick="openSubWin('../addLista/<?php echo h($dispositivo['Dispositivo']['idDispositivo']); ?>',700,300,2,'Añadir listas al dispositivo <?php echo h($dispositivo['Dispositivo']['idDispositivo']); ?>');return false" title="Listas de reproducción">
	<?php echo $this->Html->image('icons/ico_list_g_add2.png'); ?><br /><i>Añadir una nueva lista</i>
</a>

</div>
<?php
	$i = 0;
	$d = 0;
	foreach ($listas as $lista): ?>
		<div class="elm">
		<?php echo $this->Html->link(
				$this->Html->image('px_tr.gif').'<br />'.h($lista['Listum']['descripcion']), 
				array('controller'=>'videos','action'=>'videosxlista', h($lista['Listum']['idLista'])), 
				array('class'=>'lst','escape'=>false)); 
		?>
		<!-- <a class="lst" href="index_dispositiu_llista.htm"><?php echo $this->Html->image('px_tr.gif'); ?><br /><?php echo h($lista['Listum']['descripcion']); ?></a> -->
		<div class="ops">
			<?php if( $lista['listaDispositivo']['activa'] == 1){ ?>
				<a class="btn st_stop " href="#" title="Apagar dispositiu" id="<?php echo h($lista['listaDispositivo']['id']) ?>" op="sendDetener" ><?php echo $this->Html->image('px_tr.gif'); ?></a>
			<?php }else{ ?>
				<a class="btn st_play" href="#" title="Activar dispositiu" id="<?php echo h($lista['listaDispositivo']['id']) ?>"  op="sendReproducir" ><?php echo $this->Html->image('px_tr.gif'); ?></a>
				
			<?php } ?>
			<?php if( $lista['Listum']['mute'] == 0){ ?>
				<a class="btn st_sond" id="<?php echo h($lista['Listum']['idLista']); ?>" title="Apagar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
			<?php }else{ ?>
				<a class="btn st_sonf" id="<?php echo h($lista['Listum']['idLista']); ?>" title="Activar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
			<?php } ?>
			<?php echo $this->Html->link(
				$this->Html->image('px_tr.gif'), 
				array('controller'=>'videos','action'=>'videosxlista', h($lista['Listum']['idLista'])), 
				array('class'=>'btn st_vido','escape'=>false)); 
			?>
			<span class="inf"><?php echo $lista[0]['videos']; ?></span>
			
		<?php  echo $this->Form->postLink(
			$this->Html->image("px_tr.gif"),
			 array('action' => 'deleteLista', h($dispositivo['Dispositivo']['idDispositivo']), h($lista['Listum']['idLista'])),
	    	array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar lista'),
	    	 __('¿Desea eliminar la lista '. h($lista['Listum']['descripcion']) .' del reproductor realmente?'));
		?>
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

