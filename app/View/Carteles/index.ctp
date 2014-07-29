<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<?php
		
		echo $this->Html->script('kinetic-v4.7.2');		
		echo $this->Html->script('jquery-1.8.2.min');
		echo $this->Html->script("jquery-ui-1.9.1.custom.min");
		echo $this->Html->script('jquery.jcarousel.min');
		echo $this->Html->script('colorPicker');
		echo $this->Html->script('fonts');
		echo $this->Html->script('whadtv');
		
		echo $this->Html->css('colorPicker');
		echo $this->Html->css('skin-tango');
		echo $this->Html->css('cartel');
		echo $this->Html->css('general');
?>

</head>
<body>
	<div id="mnuprincipal" class="mnuprincipal">
		<div class="mnuprincipal opc bg"></div>
		<ul class="opc">
			<li>
				<?php
					echo $this->Html->image(
						"cartel/menu_image.png",
						array(
					 		'name'=>'imagemenu',
					 		'id'=>'menu_image',
					 		'width'=>150,
					 		'height'=>120
					 	)
					);
					?>
				<!--<img id="menu_image" name="imagemenu" src="images/menu_image.png" width="150" height="120">-->
			</li>
			<li>
				<?php
					echo $this->Html->image(
						"cartel/menu_box.png",
						array(
					 		'name'=>'imagemenu',
					 		'id'=>'menu_box',
					 		'width'=>150,
					 		'height'=>120
					 	)
					);
					?>
				<!--<img id="menu_box" name="imagemenu" src="images/menu_box.png" width="150" height="120">-->
				</li>
			<li>
				<?php
					echo $this->Html->image(
						"cartel/menu_text.png",
						array(
					 		'name'=>'imagemenu',
					 		'id'=>'menu_text',
					 		'width'=>150,
					 		'height'=>120
					 	)
					);
					?>
				<!--<img id="menu_text" name="imagemenu" src="images/menu_text.png" width="150" height="120">-->
			</li>
		</ul>
		<a name="ocmenu" id="imagenmnuprincipal" class='farriba'>
			<?php 
				echo $this->Html->image(
					"px_tr.gif",
					array(
						'id'=>'btnimagenmnuprincipal'
					)
				); 
			?>
			<!--
			<?php
				echo $this->Html->image(
					"cartel/mnu_farriba.png"
				);
			?>-->
			<!--<img src="images/mnu_farriba.png">-->
		</a>
		<div class="box_btns">
			<!--<a href="#" id="btn_get_estado" class="btn">Cargar estado</a>
			<a href="#" id="btn_set_estado" class="btn">Guardar estado</a>-->
			<a href="#" id="btn_salvar" class="btn">Generar imágen</a>
			<a href="#" id="btn_cerrar" class="btn">Cerrar</a>
		</div>
	</div>
	
	<div id="idCarousel" class="jcarousel-skin-tango">
		<div class="jcarousel-container jcarousel-container-vertical" style="position: relative; display: block;">
			<div class="jcarousel-container jcarousel-container-vertical bg"></div>
		
			<div class="jcarousel-clip jcarousel-clip-vertical" style="position: relative;">
    			<ul id="mycarousel" class="jcarousel jcarousel-list jcarousel-list-vertical" style="overflow: hidden; position: relative; top: 0px; margin: 0px; padding: 0px; left: 0px; height: 950px;">
            		
                </ul>
            </div>
           	<div class="jcarousel-prev jcarousel-prev-vertical jcarousel-prev-disabled jcarousel-prev-disabled-vertical" disabled="disabled" style="display: block;"></div>
            <div class="jcarousel-next jcarousel-next-vertical" style="display: block;"></div>
        </div>
    </div>

    <div id="idBox" class="mnuOpciones">
		<div class="contenedor contenedor-vertical" >
			<div class="contenedor contenedor-vertical bg"></div>
		
			<div class="pila pila-vertical">
    			<ul>
    				<?php 
						$contbox = 0;
						$colors = array("#00CC00","#FF0000","#1240AB","#FFFF00");  
						for($i=0; $i<=3; $i++){
							$contbox +=1;
							echo '<li class="elemento elemento-vertical" "><div class="box" id="box'.$contbox.'" name="boxbar" style="background-color:'.$colors[$i].';"></div></li>';
						}
						echo '<li class="elemento elemento-vertical" ">';
						echo $this->Html->image(
							"cartel/menu_box_colors.png",
							array(
						 		'name'=>'boxbar',
						 		'id'=>'boxcolor',
						 		'class'=>'box'
						 	)
						);
						echo '</li>';
							//<img src="images/menu_box_colors.png" class="box" id="boxcolor" name="boxbar"></img>
					?>
 				</ul>
            </div>
        </div>
    </div>
	
	<div id="idText" class="mnuOpciones">
		<div class="contenedor contenedor-vertical" >
			<div class="contenedor contenedor-vertical bg"></div>
		
			<div class="pila pila-vertical">
    			<ul>
    				<?php 
						$contbox = 0;
						$fonts = array('Open Sans','Oswald','Droid Sans','Roboto','Droid Serif','Ubuntu','Spirax','Kite One','Bigelow Rules','Prosto One','Parisienne','Kavoon');
						for($i=0; $i<count($fonts); $i++){
							$contbox +=1;
							echo '<li class="elemento elemento-vertical" "><div class="texto" id="font'.$contbox.'" name="textbar" style="font-family:'.$fonts[$i].';">'.$fonts[$i].'</div></li>';
						}
					?>
 				</ul>
            </div>
        </div>
    </div>

	<div id="cantainer" class="divcls">
		<canvas id="cartid" class="cartcls" width="1280" height="720"></canvas>
	</div>

	
	<div id="mnuedit" class="mnuedit">
		<ul class="mnuedit opc">
			<div class="mnuedit opc bg"></div>
			<div id="opcColor" class="color">
				<input type="text" id="cltexto" value="#000000">
			</div>

			<div id="opcFont" class="font">
				<script type="text/javascript">fuentesDropDown();</script>
			</div>
			<div id="opcText" class="text">
				<input type="text" id="msgtexto" class="msgtext">
			</div>
		</ul>
	</div>
<?php
echo $this->Html->script('cartel');
?>

</body>
