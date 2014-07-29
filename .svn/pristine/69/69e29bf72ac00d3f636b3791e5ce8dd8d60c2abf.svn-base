<div id="footer" class="navbar navbar-fixed-bottom">

<div class="wrap">


<div class="left">

<ul>
<li class="ini">&copy; whadtv</li>
<li><a href=""><?php echo	$this->Html->link('Condiciones legales', array('controller'=>'pages','action'=>'legal'),array('target'=>'_blank')) ?></a></li>
<li><a href=""><?php echo	$this->Html->link('FAQ', array('controller'=>'pages','action'=>'faq'),array('target'=>'_blank')) ?></a></li>
<li><?php echo $this->Html->link(__('Contactar'), array('controller'=>'users','action'=>'contacto')); ?></li>
</ul>

</div>

<div class="right">
	<?php
	$user = $this->Session->read('Auth');
	if( isset($user['User'])){
		if ($cuentaConsejos['total'] > 0 ){ 
			echo $this->Html->link(__('Mensajes'), array('controller'=>'Consejos','action'=>'listadoConsejos',$user['User']['id']),array('class'=>'inf'));
			if($cuentaConsejos['noleidos'] > 0){
				echo "<span class='globo inf alrts'>".$cuentaConsejos['noleidos']."</span>";
			}
		}else{
			echo $this->element('consejo');
		}
	} ?>
</div>

</div><!-- /wrap -->

</div><!-- /footer -->