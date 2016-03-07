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

$cakeDescription = __d('whadtv', 'WHADTV');

$title_for_layout = __d('WhadTV', 'Tu marca everywhere');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Loged eLayout -->
<head>
<meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width"> 
<link rel="SHORTCUT ICON" href="<?php echo DIRECTORIO; ?>/img/whadtv.ico" />
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
		<?php //echo $this->Html->script('jquery-1.8.2.min'); ?>
		
		<?php 
			echo $this->Html->css('bootstrap.min');
			echo $this->Html->css('general');  
		?>
		
		
</head>
<body id="home" class="">

<a name="top" class="nm-ie8-bug">&nbsp;</a>

<div id="contnr">



<link rel="SHORTCUT ICON" href="whadtv.ico" />

<meta name="robots" CONTENT="all">
<meta name="robots" CONTENT="index, follow">
<meta name="Revisit" CONTENT="After 3 days">

<meta name="description" content="">
<meta name="keywords" content="">









<!----------------------------------- ## Cabecera ## ---------------------------------------------------->


<?php echo $this->element('header');?>

<!----------------------------------- ## Contenedor central ## ---------------------------------------------------->




<div id="contnt">

<div class="wrap">
<?php echo $this->Session->flash(); ?>




<?php echo $content_for_layout; ?>

</div><!-- /wrap -->

</div><!-- /contnt -->

<!--------------------------------------- ## Cierre ## ------------------------------------------------------------>




<?php echo $this->element('footer');?>





</div><!-- /contnr -->




<!-- /ppup -->









</body>

</html>

<?php echo $this->Html->css('cake.forms'); ?>
<!--<link href="/css/general.css?v=1" rel="stylesheet" type="text/css" />-->
<?php //echo $this->Html->script('jquery-1.8.2.min'); ?>
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
 -->
<?php 
	echo $this->Html->script('bootstrap.min');
	echo $this->Html->script('whadtv'); ?>

<!--<?php //echo $this->Html->script('plug/nivo-slider/jquery.nivo.slider.pack.js'); ?>-->
<?php echo $this->element('config');?>
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
			var h=jQ('#contnt').height()+(fw-fb), t=h+'px', w=jQ('#contnt .wrap'); jQ('#contnt').css({ 'min-height': t, 'height': t });
			w.height('auto'); if (w.height()<h) w.height(h);
		};
	}

	jQ(document).ready(function(){
		jQ(window).resize(function(){ if(!zd_rs){ zd_rs=1; setTimeout("ftrPst();zd_rs=0;", 100); } });
		ftrPst();
	//	$('.ini.txt').dropdown();
	});

//]]></script>

<script type="text/javascript">

  // var _gaq = _gaq || [];
  // _gaq.push(['_setAccount', ua]);
  // _gaq.push(['_trackPageview']);

  // (function() {
  //   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  //   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  //   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  // })();

</script>



