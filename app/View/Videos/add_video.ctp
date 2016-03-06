<?php echo $this->Html->css('tipTip'); ?>
<?php echo $this->Html->css("fileinput.min");?>
<?php echo $this->Html->script("jquery.form"); ?>
<?php echo $this->Html->script('jquery.tipTip.minified'); ?>
<?php echo $this->Html->script("uploadFile");?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Añadir nuevo contenido</h4>
</div>

<?php echo $this->Form->create('Video', array('type' => 'file', 'action'=>'addFile'));?>

<div class="modal-body">
   <div class="forms">
		<div class="col-xs-12">
			<?php echo $this->Form->file('Document', array('class'=>'form-control file-input',	 'label'=>'Contenido', 'div'=>false)); ?>
		</div>

		<div class="col-xs-12">
			<?php echo $this->Form->input('descripcion', array('class'=>'form-control', 'type'=>'text', 'label'=>'Nombre', 'div'=>false)); ?>
		</div>


		<!--
		<label for="titol_empresa" class="fld fmdm ini">
		<h3>Tiempo:</h3>
		<?php //echo $this->Form->input('tiempo', array('class'=>'inpt', 'type'=>'range', 'label'=>false, 'div'=>false, 'min'=>'1', 'max'=>MAX_IMAGE_TIME, 'onchange'=>"rangevalue.value=value+' segundos'", 'value'=>INIT_IMAGE_TIME)); ?>
		<output id="rangevalue"><?php //echo INIT_IMAGE_TIME;?> segundos</output>

		</label>
		-->
		<?php echo $this->Form->hidden('timestamp');?>

		<!-- Si existe más de una lista -->
		
		<?php if( isset($show_listas) && $show_listas ){ ?>
	
			<div class="col-xs-12">
				<label>Lista</label>
				<?php echo $this->Form->select('listas', array($listas), array('class'=>'chosen-select col-lg-12','label' => 'Listas', 'data-placeholder' =>"Seleccione una lista")); ?>
			</div>
			<div class="col-xs-12" id="selector_miniaturas">
				<!-- selector sobre miniaturas -->
			</div>
		<?php } ?>
	</div>
</div>

<div class="modal-footer">
	<?php echo $this->Form->submit("Agregar", array('class'=>'btn up btn-primary', 'div'=>false, 'name'=>'submit_ok')); ?>
</div>

<?php echo $this->Form->end();?>

<?php echo $this->Html->script('bootstrap.min'); ?>

<script>
	jQ(".file-input").fileinput({'showUpload':false, 'previewFileType':'any'});
	contenido_listas = false;
	jQ.get(directorio+'/Lista/getListas', function(data){
		contenido_listas = JSON.parse(data);
		generarSelectores();
		
		jQ('#VideoListas').change(function(){
			console.log(jQ(this).val());
			jQ('.selector').hide();
			jQ('#selector_'+jQ(this).val()).show();

			

			jQ('.selector').hover(function(){
				console.log(this);
				arrow = '#arrow_'+jQ(this).attr('id');
				jQ(arrow).show();
				jQ('#selector_miniaturas').mousemove(function(event){
					console.log( event.pageX- (getOffset( this ).left + 17) );
					jQ(arrow).css('left', event.pageX - (getOffset( this ).left + 17));
				});

			}, function(){
				jQ('#selector_miniaturas').off('mousemove');
			});
		});
	});
	
	function generarSelectores(){
		var selector = document.getElementById('selector_miniaturas');
		if( selector == undefined){
			return;
		}
		
		for(var lista_i in contenido_listas) {

			var div = document.createElement("DIV");
			div.setAttribute('id', 'selector_'+lista_i);
			div.setAttribute('class', 'col-xs-12 selector');
			div.setAttribute('style', 'display: none');
			selector.appendChild(div);

			//Elemento flotante que sigue al raton
			var arrow = document.createElement("DIV");
			arrow.setAttribute('id', 'arrow_selector_'+lista_i);
			arrow.setAttribute('class', 'arrow');
			arrow.setAttribute('style', 'display: none');
			div.appendChild(arrow);


			if(typeof contenido_listas[lista_i].contenido === 'undefined'){
				continue;
			}

			lista_length = contenido_listas[lista_i].contenido.length;
			for(cont_i=0; cont_i < lista_length; cont_i++){

				var img = document.createElement("IMG");
				img.src = contenido_listas[lista_i].contenido[cont_i];
				//img.setAttribute()
				div.appendChild(img);

				var div_sel = document.createElement("DIV");
				div_sel.setAttribute('id', ''+cont_i);
				div_sel.setAttribute('class', 'objeto_sel');
				div_sel.setAttribute('style', 'width: 1px');
				div.appendChild(div_sel);

			}
			
		}
		
	}

	function getOffset( el ) {
	    var _x = 0;
	    var _y = 0;
	    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
	        _x += el.offsetLeft - el.scrollLeft;
	        _y += el.offsetTop - el.scrollTop;
	        el = el.offsetParent;
	    }
	    return { top: _y, left: _x };
	}
	
</script>