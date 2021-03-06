<?php
header("Content-Type: text/event-stream\n\n");
?>
<?php
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
<!-- Admin Layout -->
<head>
<meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width"> 
<link rel="SHORTCUT ICON" href="<?php echo DIRECTORIO; ?>/img/whadtv.ico" />
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	

		<?php //echo $this->Html->script('jquery-1.8.2.min'); ?>
		<?php echo $this->element('config');?>
		<?php echo $this->Html->script('adm'); ?>
		<?php echo $this->Html->css('tipTip'); ?>
		<?php echo $this->Html->script('jquery.tipTip.minified'); ?>
		
		
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

<?php echo $this->Html->css('cake.forms'); ?>
<?php echo $this->Html->css('general');  ?>
<!--<link href="/css/general.css?v=1" rel="stylesheet" type="text/css" />-->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<?php //((echo $this->Html->script('jquery-1.8.2.min'); ?>
<?php echo $this->Html->script('whadtv.js'); ?>

<!----------------------------------- ## Cabecera ## ---------------------------------------------------->




<?php echo $this->element('header');?>


<!----------------------------------- ## Contenedor central ## ---------------------------------------------------->


<div id="contnt">

<div class="wrap">


<?php echo $content_for_layout; ?>

</div><!-- /wrap -->

</div><!-- /contnt -->

<!--------------------------------------- ## Cierre ## ------------------------------------------------------------>


<?php echo $this->element('footer');?>


</div><!-- /contnr -->




<!-- /ppup -->









</body>

</html>
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
	});

//]]></script>

