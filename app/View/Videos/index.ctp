<?php	
		//echo $this->Html->css('jquery-ui-1.10.3/jquery-ui.min');
		echo $this->Html->css('bootstrap.min');
		//echo $this->Html->css('whadtv');
		
?>

<?php echo $this->Session->flash(); ?>

<!-- # nom llista i opcions # -->

<div id="listado" class="sub_wrap">
	<div class="box_ops brd_bx st_list">

<h1>
<?php 
	if(isset( $listaC ) ){ ?>
	<?php echo $this->Html->link(__('Todo'), array('controller'=>'videos','action'=>'index'));?>
		
	<?php
		
		
		


		 echo h($listaC[0]['Listum']['descripcion']); ?>
		 <input id="lista" type=hidden value="<?php echo h($listaC[0]['Listum']['idLista']); ?>"/>
		<!--<a class="btn up" onClick="openSubWin(directorio+'/Reproductor/index/lista/<?php //echo $listaC[0]['Listum']['idLista']; ?>',700,500,2,'Previsualizar reproducción');return false" title="Vista previa">Previsualizar</a>-->
	<?php }else{?>
	Todo
	<!-- Search input -->
	<input class="search" placeholder="" maxlength="30" />
	<?php } ?>
	<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    Acciones <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
  	<?php if(!isset( $listaC ) ){ ?>
  	
    	<li>
    		<a class="lbr add_content" datas-toggle="modal" data-target="#myModal">
				<i>Añadir nuevo contenido</i>
			</a>
    		<!--<a href="#" onClick="openSubWin(directorio+'/videos/addVideo',700,420,2,'Añadir nuevo contenido: ');return false" title="Añadir video">Añadir nuevo contenido</a>-->
    	</li>
    <?php }else{ ?>
    	<li><a href="#" onClick="openSubWin(directorio+'/Reproductors/updatedispositivos/<?php echo h($listaC[0]['Listum']['idLista']); ?>',790,425,2,'Actualizar dispositivos vinculados');return false">Actualizar reproductores</a></li>
    <?php } ?>
  </ul>
</div>
</h1>

<div class="ops">


	

		<?php echo $this->Form->create(array('action'=>'videosxlista'));?>

		<div class="fld icon st_add">
			<a href="#" onClick="openSubWin(directorio+'/Lista/add',700,225,2,'Crear una nueva lista');return false" title="Crear lista nueva"><?php echo $this->Html->image("px_tr.gif"); ?></a>
		</div>

		<!-- tria -->

		<div class="fld st_chg">

		<select class="ind" name="chk_llista" value=""
			onFocus="jQ(this).removeClass('ind');jQ('option[rel=ini]', this).html('');"
			onBlur ="jQ(this).addClass('ind');jQ('option[rel=ini]', this).html('Cambiar de lista');"
			onChange="this.form.submit();"
		>
		<!--<option rel='ini' >Cambiar de lista</option>-->
		<option selected disabled>Cambiar de lista</option>
		<option  value=0>Ver todo</option>
		<?php
			foreach ($listas as $lista): ?>
			<option 
				id=<?php echo $lista['Listum']['idLista']; ?> 
				class="lista" 
				value=<?php echo $lista['Listum']['idLista']; ?>
				<?php if( isset( $listaC ) && $listaC[0]['Listum']['idLista'] == $lista['Listum']['idLista'] ) {
				echo "selected";
				} ?>
			>
				<?php echo h($lista['Listum']['descripcion']); ?>
				</option>
			
			<?php endforeach; ?>
		</select>

		</div>

		<!-- editar llista -->


			<?php  if( isset( $listaC ) ){ ?>
			<div class="fld icon st_edit">
			<?php echo $this->Html->link($this->Html->image("px_tr.gif"), 
					array('controller'=>'Lista', 'action'=>'edit',$listaC[0]['Listum']['idLista'] ), 
					array('title'=>'Editar nombre', 'escape'=>false)); 
				?>
				
			</div>
				<?php }	?>
					
			<!--  <a href="index_editar_nombre_lista.htm" title="Editar nombre"><?php echo $this->Html->image("px_tr.gif"); ?></a>-->

		<?php echo $this->Form->end(); ?>

	</div><!-- /ops -->

	</div><!-- /box_ops -->


<div class="box_vid list">

<!--  # MENSAJES -->

	<?php echo $this->Session->flash(); ?>


<div id="sortable" class="slist"> <!-- sortable -->
<?php
	if( count($videos) > 0){
	foreach ($videos as $video): ?>
	<div class="elm_mov" id="<?php echo $video['Video']['idVideo']; ?>" pos="<?php echo $video['listaVideo']['posicion']; ?>" listaId="<?php echo trim($video['listaVideo']['id']) ?>">
	<div class="elm nw_dx" >
		
	
		<a class="prv" href="Videos/view/<?php echo $video['Video']['idVideo']; ?>" onClick="openSubWin(directorio+'/videos/view/<?php echo $video['Video']['idVideo']; ?>',700,500,2,'Ver contenido: ');return false" title="Ver contenido">
		<?php if( $video['Video']['estado'] == "procesado"){
			 	echo $this->Html->image(h($video['Video']['fotograma'])).
			 	  	 "<span class='selm'>".h($video['Video']['descripcion'])."</span>";
			 	if($video['Video']['time'] != ""){
			 		echo '&nbsp <u>'.h($video['Video']['time']).'"</u>';
				}		?>
		</a>
		<?php  }else{
				 	echo $this->Html->image("icons/ico_video_process.jpg")."<span class='selm'>".h($video['Video']['descripcion'])."</span>";
				 	if($video['Video']['time'] != ""){
				 		echo '&nbsp <u>'.h($video['Video']['time']).'"</u>';
					}?></a>
		<?php	}?>
		</a>
		

	<?php 
			if(isset( $listaC ) ){ ?>		
				<div class="alrts st_mov" title="Mover orden del vídeo"> 
				</div>
		<?php } ?>
	<div class="ops">
	<?php if( $video['Video']['estado'] == "procesado"){?>
		<?php if( $video['Video']['mute'] == 0){ ?>
			<a class="btn st_sond" id="<?php echo h($video['Video']['idVideo']); ?>" title="Apagar audio"><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<?php }else{ ?>
			<a class="btn st_sonf" id="<?php echo h($video['Video']['idVideo']); ?>" title="Activar audio"><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<?php } ?>
		<a class="btn st_list" href="#" onClick="openSubWin('<?php echo $this->Html->url("/",true); ?>/Videos/listasxvideo/<?php echo h($video['Video']['idVideo']); ?>',700,300,2,'Listas de reproducción de: <b><?php echo h($video['Video']['descripcion']); ?></b>');return false" title="Listas de reproducción"><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<span class="inf"><?php echo $video['0']['listas']; ?></span>
		<a class="btn st_disp" href="#" onClick="openSubWin('<?php echo $this->Html->url("/",true); ?>/Videos/dispositivosxvideo/<?php echo h($video['Video']['idVideo']); ?>',700,300,2,'Reproductores de: <b><?php echo h($video['Video']['descripcion']); ?></b>');return false" title="Reproductores"><?php echo $this->Html->image("px_tr.gif"); ?></a>
		<span class="inf"><?php echo $video['0']['dispositivos']; ?></span>
		
		<?php if( isset( $listaC )){
				echo $this->Form->postLink(
				$this->Html->image("px_tr.gif"),
				 array('controller'=>'ListaVideos', 'action' => 'delete', $video['listaVideo']['id'], $listaC[0]['Listum']['idLista']),
		    	array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar video'),
		    	 __('¿Desea eliminar el vídeo '. h($video['Video']['descripcion']) .' realmente?'));
			}else{
			 	echo $this->Form->postLink(
				$this->Html->image("px_tr.gif"),
				 array('action' => 'delete', $video['Video']['idVideo']),
		    	array('escape' => false, 'class'=>'btn st_delt', 'title'=>'Eliminar video'),
		    	 __('¿Desea eliminar el vídeo '. h($video['Video']['descripcion']) .' realmente?'));
	    	 } ?>
    <?php }else{?>
    	<div class="stat">Procesando...</div>
    <?php }?>
    	 
	
	</div> <!--  ops -->
	
	</div> <!-- elm -->
	</div> <!--  elm_mov -->
		
		
<?php endforeach; ?>
<?php 	}elseif( !isset( $listaC ) ){
			echo $this->element('videos_empty');
		}
?>
</div> <!-- /sortable -->




</div> <!-- /sub_wrap -->
</div><!-- /box_vid -->

<!-- Modal div -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php 
	if(isset( $listaC ) ){ ?>
<!--

	## Caixa oculta de selecció de vídeos ##

-->
<div id="box_add_video" class="box_adds st_video"><div class="bx_head"><h4>Por favor, arrastre los vídeos deseados hasta su posición en la lista.</h4><!--<div class="bx_close"></div>--></div><div class="bx_cntnt"></div></div>








<!--

	## Events ##

-->
<script type="text/javascript">//<![CDATA[

function wtv_openAdds () {

	jQ('#elm_add_videos').fadeOut(200);

	jQ('#contnt').addClass('box_part_add');
	jQ('#footer').addClass('noSep');

	jQ('#box_add_video .bx_cntnt').html('');
	jQ.get(directorio+'/videos/todos/<?php echo $listaC[0]['Listum']['idLista']; ?>', function(e){
			//console.log(e);
			jQ('#box_add_video .bx_cntnt').html(e);
			jQ('#box_add_video .bx_cntnt .vlist').find('.elm').addClass('draggable');
			jQ('#box_add_video .bx_cntnt .vlist .elm').mousedown(function() {
				jQ(this).addClass('move');
			});
			jQ('#box_add_video .bx_cntnt .vlist .elm').mouseup(function() {
				jQ(this).removeClass('move');
			});
			jQ(".draggable").draggable({
				connectToSortable: "#sortable",
				appendTo:"body",
				revert:true,
				helper:"clone",
				stack: ".elm.move"
			});
			cargarSortable();
			cargarDraggable();
			//	cargarDrops();
		jQ('#box_add_video .bx_cntnt .box_pop').width(jQ('#box_add_video .bx_cntnt .vlist').width());
		jQ('.addvl').closest('.elm').hide();
	});

	jQ('#box_add_video').fadeIn(300);

	ftrPst();


}

	

//]]></script>




<?php } 

	//echo $this->Html->script('jquery.min');
	echo $this->Html->script('jquery-ui-1.10.3/jquery-ui.min');
	echo $this->Html->script('ordenacion');
	echo $this->Html->script('jquery-ui-1.10.3/jquery.ui.draggable.min');
	echo $this->Html->script('jquery-ui-1.10.3/jquery.ui.sortable.min');
	echo $this->Html->script("jquery.ui.touch-punch.min"); 
	echo $this->Html->script('whadtv');
	echo $this->Html->script('list');
	echo $this->Html->script("fileinput.min");
	echo $this->Html->script('bootstrap.min');
 ?>

 <?php 
	if(isset( $listaC ) ){ ?>
		<script type="text/javascript">jQ(document).ready(function(){wtv_openAdds();});</script>
<?php }?>

