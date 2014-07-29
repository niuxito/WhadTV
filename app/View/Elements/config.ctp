<script type="text/javascript">
<?php foreach ($config as $linea){?>
	var <?php echo h($linea['Configuracion']['Nombre']);?> = '<?php echo h($linea['Configuracion']['Valor']); ?>';
<?php }?>
</script>