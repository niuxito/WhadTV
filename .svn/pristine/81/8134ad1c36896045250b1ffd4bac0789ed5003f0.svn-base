<div id="head">
<div class="wrap">

<div id="logo"><?php echo $this->Html->link($this->Html->image('logo_whadtv_2.png'), array('controller'=>'videos','action'=>'index'),array('class'=>'png', 'escape'=>false)); ?>
<!-- <a href="./"><?php //echo $this->Html->image("logo_whadtv_2.png", array('class'=>"png")); ?></a>--></div> 
<div id="clam">tu marca everywhere</div>

<!-- # MENÚ GENERAL # -->
<div id="menu">
	<ul>
		<?php $user = $this->Session->read("Auth"); ?>
		<li class="ini txt">Hola, <?php echo $this->Html->link( __($user['User']['username']) , array('controller'=> 'users', 'action'=>'edit'), array('class' => 'usr')); ?><!--<a class="usr" href="users/edit">

		</a>--></li>
		<li class="lgut"><?php echo $this->Html->link(__('Cerrar sesión'), array('controller'=>'users', 'action' => 'logout')); ?></li>
		<li><?php echo $this->Html->link(__('Contactar'), array('controller'=>'users','action'=>'contacto')); ?></li>
	</ul>
</div><!-- /menu -->

<!-- # MENÚ SECCIOS # -->
<?php
	$empresa =  $this->Session->read('Empresa');
	$user = $this->Session->read('Auth');
	//if( $this->request->controller != 'adm'){
	switch ( strtolower($this->request->controller) ) { 
		case 'adm': 
			if(isset($user['User']['nivel']) && $user['User']['nivel'] ==  0 ){
				echo $this->element('header_admin',array('empresa'=>$empresa,'user'=>$user));
			}
			
			break;
		case 'agencia':
			if ($empresa['agencia']['clientes'] > 0 ){
				echo $this->element('header_agencia',array('empresa'=>$empresa,'user'=>$user));	
			}
			
			break;
		default:
			echo $this->element('header_otros',array('empresa'=>$empresa,'user'=>$user));
			
			break;
	}
?>

</div><!-- /wrap -->

</div><!-- /head -->