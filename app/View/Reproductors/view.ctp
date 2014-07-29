<!-- # nom empresa i opcions # -->
<?php echo $this->Html->css('bootstrap.min'); ?>
<div class="box_ops brd_bx st_disp">

<h1><?php echo $this->Html->link(__("Todo"), array('controller'=>'reproductors', 'action'=>'index') );?> <?php echo h($dispositivo['Reproductor']['descripcion']); ?>

<!--<a class="btn up" onClick="openSubWin(directorio+'/Reproductor/index/dispositivo/<?php //echo $dispositivo['Reproductor']['idDispositivo']; ?>',700,500,2,'Previsualizar reproducción');return false" title="Vista previa">Previsualizar</a>-->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    Acciones <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu" role="menu">
	    <li><a href="#" onClick="openSubWin(directorio+'/reproductors/addLista/<?php echo h($dispositivo['Reproductor']['idDispositivo']); ?>',700,300,2,'Añadir listas al dispositivo <?php echo h($dispositivo['Reproductor']['idDispositivo']); ?>');return false" title="Listas de reproducción">Añadir una lista</a></li>
	    <li><a class="lbr rep_link"  data-toggle="modal" data-target="#myModal">
			<i>Ver link del reproductor</i>
			</a>
		</li>
		<li><a class="lbr rep_link"  data-toggle="modal" data-target="#myModal">
			<i>Renovar suscripción</i>
			</a>
		</li>
	    <!--<li><a href="renovarReproductor/<?php //echo  h($dispositivo['Reproductor']['idDispositivo']); ?>" title="Renovar suscripción">Renovar suscripción</a></li>-->
	  </ul>
	</div>
</h1>


<div class="ops">

<?php echo $this->Form->create(array('action'=>'view'));?>

<!-- tria d'empresa -->

<div class="fld st_chg">

	<select class="ind" name="chk_reproductor" value=""
		onFocus="jQ(this).removeClass('ind');jQ('option[rel=ini]', this).html('');"
		onBlur ="jQ(this).addClass('ind');jQ('option[rel=ini]', this).html('Cambiar de dispositivo');"
		onChange="this.form.submit();"
	>
	
	<?php
			$i = 0;
			foreach ($dispositivos as $disp): ?>
			<option 
				id=<?php echo $disp['Reproductor']['idDispositivo']; ?> 
				class="lista" 
				value=<?php echo $disp['Reproductor']['idDispositivo']; ?>
				<?php if( isset( $dispositivo ) && $dispositivo['Reproductor']['idDispositivo'] == $disp['Reproductor']['idDispositivo'] ) {
				echo "selected";
				} ?>
			>
				<?php echo h($disp['Reproductor']['descripcion']); ?>
				</option>
			
			<?php endforeach; ?>
	</select>

</div>

<!-- editar empresa -->

<div class="fld icon st_edit">
	<!--<a href="index_editar_dispositivo.htm" title="Editar dispositivo"><?php echo $this->Html->image('px_tr.gif'); ?></a>-->
	<?php echo $this->Html->link($this->Html->image('px_tr.gif'), array('action'=>'edit', $dispositivo['Reproductor']['idDispositivo']), array('escape'=>false)); ?>
</div>

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
<p class="prc top"><?php //echo $this->Html->image('icons/ico_refresh_anim_h22.gif'); ?><!-- <b>30</b><i>%</i>--><!--</p>
<p><b>Atención:</b> este dispositivo se está sincronizando.</p>
<p class="btm"><a class="lbtn dwn" href="#">Detener</a></p>
</div>
 -->

<!-- llistes -->
<!--<div class="elm add">
	<a class="lbr" href="#" onClick="openSubWin('../addLista/<?php //echo h($dispositivo['Reproductor']['idDispositivo']); ?>',700,300,2,'Añadir listas al dispositivo <?php //echo h($dispositivo['Reproductor']['idDispositivo']); ?>');return false" title="Listas de reproducción">
		<?php //echo $this->Html->image('icons/ico_list_g_add2.png'); ?><br /><i>Añadir una nueva lista</i>
	</a>
</div>

<div class="elm add">
	<a class="lbr rep_link"  data-toggle="modal" data-target="#myModal">
	<?php //echo $this->Html->image('icons/ico_pantalla_list.png'); ?><br /><i>Ver link del reproductor</i>
	</a>
</div>

<div class="elm add <?php //if(strtotime($dispositivo['Reproductor']['caducidad']) <= time()){ echo 'red'; } ?>">

<a class="lbr" href="renovarReproductor/<?php //echo  h($dispositivo['Reproductor']['idDispositivo']); ?>" title="Renovar dispositivo">
	<?php //echo $this->Html->image('icons/ico_pantalla_renov.png'); ?>
	<?php //(echo $this->Html->link(
				//$this->Html->image('icons/ico_pantalla_renov.png'), 
				//array('action'=>'renovarReproductor', h($dispositivo['Reproductor']['idDispositivo'])), 
				//array('escape'=>false),__('¿Desea renovar el Dispositivo ?')); 
		?>
	<br><i>Renovar suscripción</i><br>
	<?php //if(strtotime($dispositivo['Reproductor']['caducidad']) <= time()){
			//echo "Caducado el ";
		//}else{
			//echo "Caduca el";
		//}
	?>
	<b>
		<?php //echo date('d-m-Y',strtotime($dispositivo['Reproductor']['caducidad'])); ?>
	</b>
</a>

</div>-->
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
					<a class="btn st_sond" href="#" id="<?php echo h($lista['Listum']['idLista']); ?>" title="Apagar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
				<?php }else{ ?>
					<a class="btn st_sonf" href="#" id="<?php echo h($lista['Listum']['idLista']); ?>" title="Activar audio"  ><?php echo $this->Html->image("px_tr.gif"); ?></a>
				<?php } ?>
				<?php echo $this->Html->link(
					$this->Html->image('px_tr.gif'), 
					array('controller'=>'videos','action'=>'videosxlista', h($lista['Listum']['idLista'])), 
					array('class'=>'btn st_vido','escape'=>false)); 
				?>
				<span class="inf"><?php echo $lista[0]['videos']; ?></span>
				<a class="btn st_timer" href="#" onClick="openSubWin('<?php echo $this->Html->url("/",true); ?>programacions/listarprogramas/<?php echo h($lista['listaDispositivo']['id']); ?>',700,300,2,'Programación de: <b><?php echo h($lista['Listum']['descripcion']); ?> en <?php echo h($dispositivo['Reproductor']['descripcion']); ?></b>');return false" title="Programaciones"><?php echo $this->Html->image("px_tr.gif"); ?></a>
			<?php  echo $this->Form->postLink(
				$this->Html->image("px_tr.gif"),
				 array('action' => 'deleteLista', h($dispositivo['Reproductor']['idDispositivo']), h($lista['Listum']['idLista'])),
		    	array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar lista'),
		    	 __('¿Desea eliminar la lista '. h($lista['Listum']['descripcion']) .' del reproductor realmente?'));
			?>
			
			</div>
		</div>
<?php endforeach; ?>



</div><!-- /box_vid -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Enlace de Reproductor</h4>
      </div>
      <div class="modal-body">
      	<p>Copia este enlace y pégalo en un navegador para comenzar a reproducir.</p>
        <input type="text" class="form-control input-lg" id="rep_url" value="<?php echo WEB_PLAYER_URL.'?id='.$dispositivo['Reproductor']['idDispositivo'];?>" onclick="this.select();">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php echo $this->Html->script('bootstrap.min'); ?>
