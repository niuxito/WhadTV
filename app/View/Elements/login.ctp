<!-- CAIXA LOGIN -->

<div id="box_login">

<?php echo $this->Form->create('User', array('action' => 'login')); ?>
<?php echo $this->Session->flash();  ?>
<fieldset>

<label for="inpLogin" class="logn">
<span class="titl">E-mail:</span>
<input id="inpLogin" type="email" name="data[User][username]" maxlength="50" size="20" tabindex="1">
</label>

<label for="inpPass" class="passw">
<span class="titl">Clave:</span>
<input id="inpPass" type="password" name="data[User][password]" maxlength="50" size="20" tabindex="2">
<br>
<!-- <span class="lnk rem"><a href="#">Recordar contraseña</a></span> -->

</label>
<div class=btncnt>
<input type="submit" name="ok_login" id="inpSbmt" value="acceder" class="button submt">
<p>
<?php echo $this->Html->link(__('registrate'), array('controller'=>'users', 'action'=>'register'), array('class'=>'register')); ?>
<!--<a href="" class="register">registrate</a>-->&nbsp gratis!</p>
</div>
<!-- <label for="chk_rem"><input type="checkbox" name="rem_login" id="chk_rem" value="ok">
<span>Recordar usuario</span>
</label>
 -->

</fieldset>

<?php echo $this->Form->end(); ?>

</div><!-- /box_login -->






<div id="bnrPrtd">


<!-- SLIDER -->


<div class="slider-wrapper theme-light">
<div id="slider" class="nivoSlider">
<?php echo $this->Html->image('promos/prtd_bnnr_1.jpg');?>
<?php echo $this->Html->image('promos/prtd_bnnr_2.jpg');?>
<?php echo $this->Html->image('promos/prtd_bnnr_1.jpg', array('data-transition'=>'slideInLeft'));?>
<?php echo $this->Html->image('promos/prtd_bnnr_2.jpg');?>

</div>

<a href="pdfs/dossier_whadtv.pdf" target="_blank" id="dossier">Quieres saber más?</a>

</div>


<script type="text/javascript">//<![CDATA[

   jQ(window).load(function() {
       jQ('#slider').nivoSlider({
           pauseTime: 7000,
           manualAdvance: false,
           controlNav: false,
           directionNav: false,
           lastSlide: function(){
               //jQ('#slider').data('nivoslider').stop();
           }
       });
   });

//]]></script>
<div id="bnrLeft">
<div class="btReg">
<?php echo $this->Html->link(__('Prueba WhadTV ›'), array('controller'=>'users', 'action'=>'register')); ?>

</div>
</div>
</div><!-- /bnrPrtd -->

<!--<div class="whadtv-content">
	<a class="tag left">¿ Tus clientes conocen todos tus productos ?<b>¡¡MUESTRASELOS!!</b></a>
	<a class="tag center">¿ Que hace el televisor de tu bar/restaurante cuando no hay futbol ?<b>¡¡SACALE PARTIDO!!</b></a>
	<a class="tag right">¿ Tus clientes conocen todos tus productos ?</a>

 
</div>-->








