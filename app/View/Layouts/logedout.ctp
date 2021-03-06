<?php
header("Content-Type: text/event-stream\n\n");
?><?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('whadtv', 'WhadTV');

$title_for_layout = __d('WhadTV', 'Tu marca everywhere');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width"> 
	<link rel="SHORTCUT ICON" href="<?php echo DIRECTORIO; ?>/img/whadtv.ico" />
	<?php echo $this->Html->charset(); ?>
	
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
		<?php if($this->request['action'] == "contacto"){ 
			echo "- Contacto";
		}elseif(count($this->request['pass']) > 0 && $this->request['pass'][0] == "legal"){
			echo "- Aviso Legal";
		}
		?>
	</title>
		<?php echo $this->Html->css('general');  ?>
		<?php echo $this->Html->css('plug/nivo-slider/themes/light/light'); ?>
		<?php echo $this->Html->css('plug/nivo-slider/nivo-slider'); ?>
		
		<?php echo $this->Html->script('jquery-1.8.2.min'); ?>
		<?php //echo $this->Html->css('cake.generic'); ?>
		 
		<?php echo $this->Html->script('whadtv'); ?>
		<?php echo $this->Html->script('plug/nivo-slider/jquery.nivo.slider.pack'); ?>
		<?php echo $this->element('config');?>
		
		
		<meta name="google-site-verification" content="JCrKY2r-YJEBMiS2LvHsehpY1WnPQboy5KwRkvqFcL4" />
</head>
<body id="home" class="pg_login">


<div name="top" class="nm-ie8-bug">&nbsp;</div>

<div id="contnr">


		
		
		
<!----------------------------------- ## Cabecera ## ---------------------------------------------------->


<div id="head">

<div class="wrap">

<div id="logo">
<?php echo $this->Html->link($this->Html->image('logo_whadtv_2.png'), array('controller'=>'videos','action'=>'index'),array('class'=>'png', 'escape'=>false)); ?>
<!--<a href="./"><img class="png" src="/GestVideo/img/logo_whadtv_2.png"></a>-->
</div>
<div id="clam">tu marca everywhere</div>



<!-- # MENÚ GENERAL # -->

<div id="menu">
<ul>
<?php if( $this->request['action'] == "contacto" ){ ?>
	<li class="ini"><?php echo $this->Html->link(__('Bienvenida'), array('controller'=>'users','action'=>'login')); ?></li>
	<li class="txt fnl">Contactar</li>
<?php }elseif($this->request['action'] == 'display'){ ?>
	<?php if($this->request['pass'][0] == 'home'){?>
		<li class="ini txt">Bienvenida</li>
		<li class="fnl"><?php echo $this->Html->link(__('Contactar'), array('controller'=>'users','action'=>'contacto')); ?></li>
	<?php }else{ ?>
		<li class="ini"><?php echo $this->Html->link(__('Bienvenida'), array('controller'=>'users','action'=>'login')); ?></li>
		<li class="fnl"><?php echo $this->Html->link(__('Contactar'), array('controller'=>'users','action'=>'contacto')); ?></li>
	<?php  } ?>
<?php }else{ ?>
	<li class="ini txt">Bienvenida</li>
	<li class="fnl"><?php //echo $this->Html->link(__('Contactar'), array('controller'=>'users','action'=>'contacto')); ?><a href="https://whadtv.com/#contact">Contactar</a></li>
	
	
	
<?php } ?>
</ul>
</div><!-- /menu -->






</div><!-- /wrap -->

</div><!-- /head -->

<!----------------------------------- ## Contenedor central ## ---------------------------------------------------->


<div id="contnt" class="logedout">

<div class="wrap">
<?php echo $this->Session->flash(); ?>


<?php echo $content_for_layout; ?>

</div><!-- /wrap -->

</div>  <!-- /contnt -->




<!--------------------------------------- ## Cierre ## ------------------------------------------------------------>



<?php echo $this->element('footer');?>



</div><!-- /contnr -->




<!-- /ppup -->



	
<script type="text/javascript">//<![CDATA[

	/*

	########################
	### Adequació footer ###
	########################

	*/

	var zd_rs=0;
	function ftrPst() {
		var fb=jQ('#contnr').height(), fw=jQ(window).height();
		if (fb!=fw) {
			var h=jQ('#contnt').height()+(fw-fb), t=h+'px', w=jQ('#contnt .wrap'); jQ('#content').css({ 'min-height': t, 'height': t });
			if (w.height()<h) w.height(h); else w.height('100%');
			if (jQ('#bnrPrtd').length) {
				//var i=parseInt((h-600)/2); if (i>0) jQ('#bnrPrtd').css({ 'margin-top': i+'px' });
			}
		};
	}

	jQ(document).ready(function(){
		jQ(window).resize(function(){ if(!zd_rs){ zd_rs=1; setTimeout("ftrPst();zd_rs=0;", 100); } });
		ftrPst();
	});

//]]></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', ua]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>




</body>

</html>
