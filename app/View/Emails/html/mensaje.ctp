<link href="http://whadtv.com/css/mail.css?v=1" rel="stylesheet" type="text/css" />
<a name="top" class="nm-ie8-bug">&nbsp;</a>

<div id="contnr">


<!----------------------------------- ## Cabecera ## ---------------------------------------------------->


<div id="head">

<div class="wrap">

<div id="logo"><a href="http://whadtv.com"><img class="png" src="http://whadtv.com/img/logo_whadtv_2.png" /></a></div>

<div id="clam">tu marca everywhere!</div>












</div><!-- /wrap -->

</div><!-- /head -->




<!----------------------------------- ## Contenedor central ## ---------------------------------------------------->




<div id="contnt">
<div class="wrap">

<h1>Mensajes:</h1>

<?php 
	foreach($mensajes as $mensaje){
?>
		<p><?php echo $mensaje['Consejo']['descripcion']; ?> </p>
		_______________________________________
<?php
	}

?>






</div><!-- /box_vid -->
<p>Atentamente,<br/>el equipo de WhadTV</p>




</div><!-- /wrap -->

</div><!-- /contnt -->





<!--------------------------------------- ## Cierre ## ------------------------------------------------------------>




<div id="footer">

<div class="wrap">


<div class="left">

<ul>
<li class="ini">&copy; whadtv</li>
<li><a href="http://whadtv.com/pages/legal">condiciones lagales</a></li>
<li><a href="http://whadtv.com/users/contacto">contacto</a></li>
</ul>

</div>

</div><!-- /wrap -->

</div><!-- /footer -->



</div><!-- /contnr -->