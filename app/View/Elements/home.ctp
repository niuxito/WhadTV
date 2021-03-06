<?php 
  $user = $this->Session->read("Auth");
  if( isset( $user['User'] ) && strpos( "#", $this->request->action ) === FALSE ) {
?>
  <!-- <meta http-equiv="refresh" content="0; url=<?php echo DIRECTORIO; ?>/users/login" /> -->
<?php
  }
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description"        content="WhadTV es la herramienta perfecta para gestionar tu publicidad en Digital Signage" >
<meta name="keywords"           content="Digital Signage, pantalla, publicidad" >
<meta name="author"             content="Alexis Parron">
<meta name="viewport"           content="width=device-width, initial-scale=1.0">  
<link rel="SHORTCUT ICON" href="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/img/favicon.ico" />
<!--<link rel="SHORTCUT ICON" href="<?php echo DIRECTORIO; ?>/img/whadtv.ico" />-->

<title>WhadTV - Inicio</title>
<!-- CSS file links -->
<?php
   echo $this->MyHtml->css('bootstrap.min');
   echo $this->MyHtml->css('style');
   echo $this->MyHtml->css('jquery.bxslider');
   echo $this->MyHtml->css('lightbox');
   echo $this->MyHtml->css('responsive');
   echo $this->MyHtml->css('home');
   echo $this->element('config');
?>


</head>

<body>

  <?php //var_dump($this->request); ?>
	<!-- Header Start -->
     <header class="navbar navbar-default navbar-fixed-top">
      	<div class="container">
        	<div class="navbar-header">
          		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
          		</button>
          		<a class="navbar-brand" href="#"></a>
        	</div>
        	<div class="navbar-collapse collapse">
          		<ul class="nav navbar-nav navbar-right">
            		<li class="current"><a href="#sliderAnchor">Inicio</a></li>
            		
            		<li><a href="#howItWorksAnchor">Cómo funciona</a></li>
            		<li><a href="#pricingAnchor">Precios</a></li>
                <li><a href="#contactAnchor" style="padding-right:0px;">Contacto</a></li>
                <li><a href="#loginAnchor">Accede</a></li>
          		</ul>
        	</div><!--/.navbar-collapse -->
      </div><!-- END Container -->
    </header><!-- END Header -->
    <!-- Slider Start -->
    <a class="anchor" id="sliderAnchor"></a>
    <section class="jumbotron">
    	<div class="container">

         <ul class="slides" style="display:none;">
            <li>
            <div class="col-lg-6">
              <img id="iphoneBlack" class="img-responsive" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/iphoneBlackWhadTV.png" alt="iphone" />
              <img id="iphoneWhite" class="img-responsive" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/iphoneWhiteWhadTV.png" alt="iphone" />
            </div>
        		<div class="col-lg-6 slideText">
          		<h1><span>Pruebalo</span> sin compromiso</h1>
          		<p>WhadTV es la herramienta perfecta para gestionar tu publicidad digital offline.</p>
              <a class="button" href="<?php echo DIRECTORIO; ?>/users/register" >Registrate gratis!! </a>
      		  </div>
          </li>
        </ul>

    	</div><!-- END Container -->

      <div class="sliderControls">
          <span id="slider-prev"></span>
          <span id="slider-next"></span>
        </div>

    </section><!-- END Slider -->

    <!-- sub-slider message Start -->
    <section id="subSliderMessage">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2>WhadTV: más cerca de sus clientes </h2>
            <p> Obten la atención de tus clientes en el punto de venta ayudandoles a tomar decisiones enfocadas en tu marca </p>
          </div>
        </div>
      </div><!-- END container -->
    </section><!-- END Sub-slider message -->

    
    <a class="anchor" id="loginAnchor"></a>
    <!-- Start Login box -->
    <section id="promoBox">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h4>Accede a tu cuenta</h4>
          </div>
          <div class="col-lg-10">
            <?php echo $this->Form->create('User', array('action' => 'login')); ?>
                  <div class="control-group error">
                    <div class="controls">
                      <input type="email" name="data[User][username]" id="emailInput" placeholder="Tu email" value="">
                       <input type="password" name="data[User][password]" id="passInput" placeholder="Tu password" value="">
                      <input type="submit" id="subscribeButton" class="login" value="Accede">
                      <span class="help-inline hide">Please correct the error</span>
                    </div>
                  </div>

            <?php echo $this->Form->end(); ?>
          </div>

        </div><!-- END Row -->
      </div><!-- END container -->
    </section><!-- END Promo box -->

    <!-- Start How It Works -->
    <a class="anchor" id="howItWorksAnchor"></a>
    <section id="features">
      <div class="container">
        <div class="row"><div class="col-lg-12"><h3>Cómo funciona</h3></div><div class="col-lg-12"><img class="dividerWide" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/divider.png" alt=""></div></div>
        <div class="row">
          <div class="col-lg-4 featureItem">
            <div class="featureIcon" id="centralizadoIcon"></div>
            <h4>Centralizado</h4>
            <p>Podrás controlar todos los reproductores <span>WhadTV</span> de un vistazo. Tendrás todo el contenido on-line y organizado. </p>
            <!--<p><a class="btn btn-default" href="#">View details &raquo;</a></p>-->
          </div>
          <div class="col-lg-4 featureItem">
            <div class="featureIcon" id="sencilloIcon"></div>
            <h4>Sencillo</h4>
            <p> Publicar una imagen, asignarla a una lista de reproducción y actualizar el reproductor. Con pocos pasos puedes resolver de forma intuitiva todas las gestiones en la plataforma web. </p>
            <!--<p><a class="btn btn-default" href="#">View details &raquo;</a></p>-->
         </div>
          <div class="col-lg-4 featureItem">
            <div class="featureIcon" id="dinamicoIcon"></div>
            <h4>Dinámico</h4>
            <p>Nuestro objetivo es ser accesible a todas las empresas. Queremos que pruebes <span>WhadTV</span> y nos digas que quieres, para mejorar y darte siempre lo que necesitas. </p>
            <!--<p><a class="btn btn-default" href="#">View details &raquo;</a></p>-->
          </div>
        </div><!-- END Row -->
      </div><!-- END Container -->
    </section><!-- END Features -->
    <section id="howItWorks">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 howItWorksGraphic">
            <img class="iphoneSmall" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/contenido.png" alt="iphone" />
            <img class="dividerHalf" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/dividerHalf.png" alt="divider" />
          </div>
          <div class="col-lg-6">
            <h4>Publica tus archivos deesde <span>cualquier lugar</span>, en <span> cualquier momento </span></h4><br/>
            <p>Publica tanto imagenes como video o contenido Html5 en tus pantallas desde tu PC, tablet o smartphone, a traves de la web. Puedes elegir el tiempo de reproducción de cada imagen. Realiza fotografias con tu smartphone y publicalas al instante. Podrás crear una composición con las imágenes que ya tengas en la plataforma e incluso utilizar plantillas predefinidas. </p>
          </div>
        </div><!-- END Row -->
        <div class="transition1"></div>
        <div class="row">
          <div class="col-lg-6">
            <h4>Elige donde  <span>mostrar tu marca.</span></h4><br/>
            <p>Puedes agrupar el contenido por lugares, por temas, por horas de reproducción, eres libre de elegir como. Genera tantas listas como necesites y conectalas con los reproductores.</p>
          </div>
          <div class="col-lg-6 howItWorksGraphic">
            <img class="iphoneSmall" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/donde.png" alt="donde" />
            <img class="dividerHalf" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/dividerHalf.png" alt="divider" />
          </div>
        </div><!-- END Row -->
        <div class="transition2"></div>
        <div class="row">
          <div class="col-lg-6 howItWorksGraphic">
            <img class="iphoneSmall" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/world.png" alt="iphone" />
            <img class="dividerHalf" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/dividerHalf.png" alt="divider" />
          </div>
          <div class="col-lg-6">
            <h4><span>Muestra</span> tu marca a todos.</h4><br/>
            <p>Reproduce tus archivos en la pantalla de un PC, en un televisor, una tablet o un videowall. Puedes encender y apagar los reproductores y actualizar su contenido desde la web en cuestión de segundos.</p>
          </div>
        </div><!-- END Row -->
      </div><!-- END Container -->
    </section><!-- END How It Works -->

    <!-- Start Pricing -->
    <a class="anchor" id="pricingAnchor"></a>
    <section id="pricing">
      <div class="container">
        <div class="row"><div class="col-lg-12"><h3>Precios</h3></div><div class="col-lg-12"><img class="dividerWide" src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/divider.png" alt=""></div></div>
          <div class="row">

          <div class="col-lg-4">
            <div class="pricingTable">
              <div class="pricingHeader"><h1>PRUEBA* | ONLINE</h1></div>
              <div class="triangleWhite"><img src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/triangleWhite.png" alt="triangle" /></div>
              <div class="priceAmount"><h2>0€ | 10€/<span>mes</span></h2></div>
              <ul>
                <li>Reproducción online</li>
                <li>100MB | 2GB almacenamiento web</li>
                <li>Reproducción de Video</li>
                <li>Reproducción de Imágenes</li>
                <li>1 lista  | 10 listas de reproducción</li>
                <li>Publicidad de terceros</li>
                
              </ul>
            <div class="buttonContainer"><a href="<?php echo DIRECTORIO; ?>/users/register" class="buttonSmall">Pruebalo</a></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="pricingTable">
              <div class="pricingHeader"><h1>STANDARD</h1></div>
              <div class="triangleWhite"><img src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/triangleWhite.png" alt="triangle" /></div>
              <div class="priceAmount"><h2><span>desde</span> 30€/<span>mes</span></h2></div>
              <ul>
                <li>Reproducción on/offline</li>
                <li>5GB almacenamiento web</li>
                <li>Reproducción de Video</li>
                <li>Reproducción de Imágenes</li>
                <li>500 listas de reproducción</li>
                <li>Programación de cambios</li>
                <li>Multiusuario</li>
              </ul>
             <!-- <div class="buttonContainer"><a href="#" class="buttonSmall">Purchase</a></div>-->
            </div>
          </div>

          <div class="col-lg-4">
            <div class="pricingTable">
              <div class="pricingHeader"><h1>ANDROID</h1></div>
              <div class="triangleWhite"><img src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/triangleWhite.png" alt="triangle" /></div>
              <div class="priceAmount"><h2><span>desde</span> 50€/<span>mes</span></h2></div>
              <ul>
                <li>Reproducción on/offline</li>
                <li>5GB almacenamiento</li>
                <li>2GB almacenamiento local</li>
                <li>Reproducción de Video</li>
                <li>Reproducción de Imágenes</li>
                <li>500 listas de reproducción</li>
                <li>Programación de cambios</li>
                <li>Multiusuario</li>
              </ul>
             <!-- <div class="buttonContainer"><a href="#" class="buttonSmall">Purchase</a></div>-->
            </div>
          </div>
          * Las pruebas tienen una duración de 15 dias desde el alta del usuario.</br>  
          ** Todos los precios son por reproductor, consultar para volumen superior a 5 unidades.
        </div><!-- END Row -->
      </div><!-- END Container -->
    </section><!-- END Pricing -->

   

    <!-- Start Contact -->
    <section id="contact" >
      <a class="anchor" id="contactAnchor"></a>
      <div class="container">
        <div class="row"><div class="col-lg-12"><h3>Contacta con nosotros</h3></div></div>
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2">
            <p></p>
            <!-- Start contact form -->
            <?php echo $this->Form->create('User', array('action' => 'contacto')); ?>
              <input type="text" name="nombre" placeholder="Tu nombre" class="contactInput" id="contactInputName" />
              <input type="text" name="tel" placeholder="Tu telefono" class="contactInput" id="contactInputName" />
              <input type="text" name="mail" placeholder="Tu email" class="contactInput" id="contactInputEmail" style="margin-right:0px" /><br/>
              <textarea name="texto" placeholder="Lo que quieres decirnos..." class="contactMessage"></textarea>
              <input id="sendMensaje" type="submit" name="submit" value="Enviar mensaje" class="buttonSmall mens" />
            <?php echo $this->Form->end(); ?>
            <!-- END Contact form -->
          </div>
        </div><!-- END Row -->
      </div><!-- END Container -->
    </section><!-- END Contact -->

    <footer>
      <div class="container" itemscope itemtype="http://data-vocabulary.org/Organization">
        <div class="row">
          <div class="col-lg-4 about">
            <a href="#" class="logoDark" itemprop="logo"></a><br/><br/>
            <p>Estamos en las redes sociales, siguenos para poder informarte de nuestras novedades.</p>
            <ul class="socialIcons">
              <li><a href="https://www.facebook.com/Whadtv" class="fbIcon" target="_blank"></a></li>
              <li><a href="https://twitter.com/WhadtTV" class="twitterIcon" target="_blank"></a></li>
              <!--<li><a href="#" class="googleIcon" target="_blank"></a></li>
              <li><a href="#" class="flickrIcon" target="_blank"></a></li>-->
            </ul>
          </div>
          
          <div class="col-lg-4 contact">
            <h4>Información de contacto de <span itemprop="name">WhadTV</span></h4>
            <p>Ponte en contacto con nosotros para resolver cualquier duda.</p>
            <ul>
              <li itemprop="tel"><img src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/icons/footerPhone.png" alt="phone icon" />+34 661037428</li>
              <li itemprop="email"><img src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/icons/footerPin.png" alt="pin icon" /><a href="#">info@whadtv.com</a></li>
              <!--<li><img src="images/icons/footerMail.png" alt="mail icon" />Calle Dean Sanfeliu 32-</li>-->
            </ul>
          </div>
        </div><!-- END Row -->
      </div><!-- END Container -->
    </footer><!-- END Footer -->
    
<!-- JavaScript file links -->
<?php
  echo $this->MyHtml->script('jquery');
  echo $this->MyHtml->script('bootstrap.min');
  echo $this->MyHtml->script('jquery.bxslider.min');
  echo $this->MyHtml->script('tabs');
  echo $this->MyHtml->script('lightbox-2.6.min');
  echo $this->MyHtml->script('jquery.scrollTo');
  echo $this->MyHtml->script('jquery.nav');
  echo $this->MyHtml->script('jquery.form');
  echo $this->MyHtml->script('login');
?>

<script>
  "use strict";
  // ACTIVATE BXSLIDER (for slider section)
  $(document).ready(function(){
    $('.slides').fadeIn().bxSlider({
      
      pager: false,
      nextText: '<img src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/nextButton.png" alt="slider next" />',
      prevText: '<img src="<?php echo defined( 'STATIC_CONTENT' ) ? STATIC_CONTENT : DIRECTORIO; ?>/images/prevButton.png" alt="slider prev" />',
      // triggers slider animations on slide change
      onSlideBefore: function(){
        $('.jumbotron img').addClass("fadeInReallyFast"); 
        $('.jumbotron h1').addClass("fadeInFast");  
        $('.jumbotron p').addClass("fadeInMed"); 
        $('.jumbotron .button').addClass("fadeInSlow"); 
        $('.jumbotron .buttonSmall').addClass("fadeInSlow"); 
        $('#emailInputSlider').addClass("fadeInSlow"); 

        setTimeout (function(){
        $('.jumbotron img').removeClass("fadeInReallyFast"); 
        $('.jumbotron h1').removeClass("fadeInFast");  
        $('.jumbotron p').removeClass("fadeInMed"); 
        $('.jumbotron .button').removeClass("fadeInSlow"); 
        $('.jumbotron .buttonSmall').removeClass("fadeInSlow"); 
        $('#emailInputSlider').removeClass("fadeInSlow"); 
        }, 1400);
      }
    });

    //Triggers slider animations on page load
    $(document).ready(function() {
        $('.jumbotron img').toggleClass("fadeInReallyFast"); 
        $('.jumbotron h1').toggleClass("fadeInFast"); 
        $('.jumbotron p').toggleClass("fadeInMed"); 
        $('.jumbotron .button').toggleClass("fadeInSlow"); 
        $('.jumbotron .buttonSmall').toggleClass("fadeInSlow"); 
        $('#emailInputSlider').toggleClass("fadeInSlow"); 

        setTimeout (function(){
        $('.jumbotron img').removeClass("fadeInReallyFast"); 
        $('.jumbotron h1').removeClass("fadeInFast");  
        $('.jumbotron p').removeClass("fadeInMed"); 
        $('.jumbotron .button').removeClass("fadeInSlow"); 
        $('.jumbotron .buttonSmall').removeClass("fadeInSlow"); 
        $('#emailInputSlider').removeClass("fadeInSlow"); 
        }, 1400);
    });

    //activate second bxslider (for testimonials section)
    $('.slides2').bxSlider({
      auto: true,
      controls: false,
      speed: 1500
    });
    });


// ACTIVATE ONE PAGE NAV 
$(document).ready(function() {
    $('.nav.navbar-nav.navbar-right').onePageNav();
});
</script>

<script>
"use strict";
// SCREENSHOT IMAGE HOVERS
$('.image').mouseover(function()
{
    $(".overlay", this).stop(true, true).fadeIn();
}); 

$('.image').mouseout(function()
{
    $(".overlay", this).stop(true, true).fadeOut();
}); 
</script>

</body>
</html>
