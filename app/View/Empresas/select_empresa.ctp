
<!-- # nom empresa i opcions # -->

<div class="box_ops brd_bx st_empr">

<h1>Listado de empresas</h1>

</div>


<!-- # llistat de vídeos # -->

<div class="box_list st_emp">

<div class="mlist grn">

<ul>

<?php
	$i = 0;
	foreach ($empresas as $empresa): ?>


<li><a class="titl" href="panel/<?php echo h($empresa['Empresa']['idEmpresa']); ?>"><?php echo h($empresa['Empresa']['nombre']); ?></a>
<div class="ops">
<ol>
<li><a class="btn st_vido" href="#" title="Número de vídeos"><?php echo $this->Html->image("px_tr.gif"); ?></a><span class="inf"><?php echo $empresa[0]['videos']; ?></span></li>
<li><a class="btn st_list" href="#" title="Listas de reproducción"><?php echo $this->Html->image("px_tr.gif"); ?></a><span class="inf"><?php echo $empresa[0]['listas']; ?></span></li>
<li><a class="btn st_disp" href="#" title="Dispositivos"><?php echo $this->Html->image("px_tr.gif"); ?></a><span class="inf"><?php echo $empresa[0]['dispositivos']; ?></span></li>
</ol>
</div>
</li>


<?php endforeach; ?>
<!--<li class="imp"><a class="titl" href="index_dispositiu.htm">Empresa #2</a>
<div class="ops">
<ol>
<li><a class="btn st_vido" href="index_llista.htm" title="Número de vídeos"><img src="img/px_tr.gif" /></a><span class="inf">10</span></li>
<li><a class="btn st_list" href="index_llista.htm" title="Listas de reproducción"><img src="img/px_tr.gif" /></a><span class="inf">2</span></li>
<li><a class="btn st_disp" href="index_dispositivos.htm" title="Dispositivos"><img src="img/px_tr.gif" /></a><span class="inf">2</span></li>
</ol>
</div>
</li>

<li><a class="titl" href="index_dispositiu.htm">Empresa #3</a>
<div class="ops">
<ol>
<li><a class="btn st_vido" href="index_llista.htm" title="Número de vídeos"><img src="img/px_tr.gif" /></a><span class="inf">35</span></li>
<li><a class="btn st_list" href="index_llista.htm" title="Listas de reproducción"><img src="img/px_tr.gif" /></a><span class="inf">4</span></li>
<li><a class="btn st_disp" href="index_dispositivos.htm" title="Dispositivos"><img src="img/px_tr.gif" /></a><span class="inf">15</span></li>
</ol>
</div>
</li>-->

</ul>

</div><!-- /mlist -->

<!--div class="box_btns"><a class="btn" href="#">Añadir dispositivo</a></div-->

</div><!-- /box_info -->
