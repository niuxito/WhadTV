jQ(document)
	.ready(
		function() {
			var idReproductor = this.location.href.split('vistaReproductor/')[1];
			idReproductor = idReproductor.split(/#(.*)/)[0];
			jQ.post(
				directorio + '/agencia/obtenerEmpresaReproductor/',{idReproductor : idReproductor},
				function(data){
					var datos = JSON.parse(data);
					if (datos.status == false){
						console.log('Error al cargar la Empresa del reproductor '+idReproductor);
						return;
					}
					idEmpresa = datos.Reproductor.idEmpresa;
					loadReproductores(idEmpresa,idReproductor);
				}
			);
			jQ(".repEmpresa").change(function(){
					modificarEditarReproductor();
					datosDispositivo(this.value)
					loadListas(this.value);
			});
		}
	)
;

function modificarEditarReproductor(){
	var idReproductor = document.getElementById('repEmpresa').value;
	jQ('#editarReproductor').children('.edit').remove();
	var a = document.createElement('a');
	a.className = 'edit';
	a.href = "../editarReproductor/"+idReproductor;
	var divcnt = '<img src="'+directorio+'/img/px_tr.gif" />';
	a.innerHTML = divcnt;
	var box_disp = jQ(document).find("#editarReproductor");
    box_disp[0].appendChild(a);
}

function loadReproductores(idEmpresa,idReproductor){
	jQ.post(
		directorio + "/agencia/cargarReproductores/"+idEmpresa,
		function(data){
			var datos = JSON.parse(data);
			if (datos.status == false){
				console.log('Error al cargar los reproductores.');
				return;
			}
			var index = '';
			for (var i in datos) {
			    var dispositivo = datos[i];
			    var idDispositivo = dispositivo['Dispositivo']['idDispositivo'];
			    var nombreDispositivo = dispositivo['Dispositivo']['descripcion'];
			    var acepta_terceros = dispositivo['Dispositivo']['acepta_terceros'];
			    var idDispositivoSelected = jQ('option:selected', jQ(".repEmpresa")).val();
				
				var opcion = document.createElement("option");
		        document.getElementById("repEmpresa").options.add(opcion);
		    	jQ(opcion).text(nombreDispositivo);
		        jQ(opcion).val(idDispositivo);
		        jQ(opcion).attr("terceros",acepta_terceros);
		        if (idDispositivo == idReproductor){
		        	jQ(opcion).attr("selected", "selected");
		       	 	loadListas(idDispositivo);
			    }
			}
			modificarEditarReproductor();
			datosDispositivo(idReproductor);
		}
	);
}

function loadListas(idReproductor){
	var tieneListasTerceros = false;
	jQ.post(
		directorio + "/agencia/cargarListas/"+idReproductor,
		function(data){
			var datos = JSON.parse(data);
			jQ('.box_list').children('.elm').remove();
			añadirAddDiv(idReproductor,'basicas');

			var aceptaTerceros = jQ("#repEmpresa option[value='"+idReproductor+"']")[0].attributes.terceros.value;
			if (datos.status == false){
				console.log('El dispositivo no tiene listas asignadas.');
				//return;
				if (aceptaTerceros == 1){
					añadirAddDiv(idReproductor,'terceros');
				}
			}else{
				for (var i in datos){
					if (datos[i]['listaDispositivo']['tipo_relacion'] == 'terceros'){
						tieneListasTerceros = true;
					}
				}
				if (tieneListasTerceros == false && aceptaTerceros == 1){
					añadirAddDiv(idReproductor,'terceros');
				}
				for (var i in datos) {
				    var lista = datos[i];
				    var div = document.createElement('div');
					div.className = "elm";
					div.id = lista['Listum']['idLista'];
					div.setAttribute('idLD',lista['listaDispositivo']['id']);

				    var divcnt = '';
				    
					    if (lista['listaDispositivo']['tipo_relacion'] == 'terceros'){
							divcnt += '<a class="lst ter" ';
						}else{
							divcnt += '<a class="lst" ';
						}
						divcnt +='href="../videosLista/'+lista['Listum']['idLista']+"/"+lista['listaDispositivo']['id']+'"><img src="'+directorio+'/img/px_tr.gif" /><br />'+lista['Listum']['descripcion']+'</a>'+
						'<div class="ops">'
							if( lista['listaDispositivo']['activa'] == 1){
								divcnt += '<a class="btn st_stop" href="#" title="Desactivar lista" id="'+lista['Listum']['idLista']+'" op="sendDetener" ><img src="'+directorio+'/img/px_tr.gif" /></a>';
							}else{
								divcnt += '<a class="btn st_play" href="#" title="Activar lista" id="'+lista['Listum']['idLista']+'" op="sendReproducir" ><img src="'+directorio+'/img/px_tr.gif" /></a>';
							}
							if( lista['Listum']['mute'] == 0){
								divcnt += '<a class="btn st_sond" href="#" id="'+lista['Listum']['idLista']+'" title="Apagar audio" ><img src="'+directorio+'/img/px_tr.gif" /></a>';
							}else{
								divcnt += '<a class="btn st_sonf" href="#" id="'+lista['Listum']['idLista']+'" title="Activar audio" ><img src="'+directorio+'/img/px_tr.gif" /></a>';
							}
	 
							divcnt += '<a class="btn st_vido" href="../videosLista/'+lista['Listum']['idLista']+"/"+lista['listaDispositivo']['id']+'"><img src="'+directorio+'/img/px_tr.gif"></a>'+
							'<span class="inf">'+lista['0']['videos']+'</span>';
							divcnt += '<a class="btn st_timer" id="timer'+lista['listaDispositivo']['id']+'" descList="'+lista['Listum']['descripcion']+'" idList="'+lista['listaDispositivo']['id']+'" title="Programaciones"  ><img src="'+directorio+'/img/px_tr.gif"></a>'+
							'<form method="post">'+
							'<a class="btn st_delt" id="delt'+lista['listaDispositivo']['id']+'" idLD = "'+lista['listaDispositivo']['id']+'" idDisp = "'+lista['listaDispositivo']['idDispositivo'] +'" idList = "'+lista['Listum']['idLista']+'" descList="'+lista['Listum']['descripcion']+'" title="Eliminar lista"><img src="'+directorio+'/img/px_tr.gif"></a>'+
							'</form>'+
						'</div>'+
					'</div>';
					//console.log(lista);
					var box_list = jQ(document).find(".box_list");
				    div.innerHTML = divcnt;
					box_list[0].appendChild(div);

					var timElement = document.getElementById("timer"+lista['listaDispositivo']['id']);
					timElement.onclick = function(){
						var idList = jQ(this).attr('idList');
						var descList = jQ(this).attr('descList');
						var txt = 'Programación de: <b>'+descList+' en '+lista['dispositivo']['descripcion']+'<b>';
						openSubWin(directorio+'/programacions/listarprogramas/'+idList,700,300,2,txt);
					}
					var delElement = document.getElementById("delt"+lista['listaDispositivo']['id']);
					delElement.onclick = function() {
						var descList = jQ(this).attr('descList');
				    	if (!confirm("¿Desea eliminar la lista "+descList+" del reproductor realmente?")){
				        	return false;
				        }else{
				        	jQ.post(directorio+'/agencia/desvincularLista/', {idLD : jQ( this ).attr( 'idLD' )}, function(data){
				        		var datos = JSON.parse(data);
				        		if (datos.status == false){
									console.log('Error al desvincular la lista.');
								}else{
									jQ("div[idld='"+datos.idLD+"']").remove();
								}
				        	});
				        }
			        }		
				}
			}
			funcionesWhadtvJs();
		}
	);

}

function añadirAddDiv(idReproductor,tipo){
	switch (tipo){
		case 'basicas':
			var div = document.createElement('div');
			div.className = "elm add";
			div.id = "basicas";
			var divcnt = '<a class="lbr" title="Añadir lista básica"><img src="'+directorio+'/img/icons/ico_list_g_add2.png">Añadir lista básica</a>';
			var box_list = jQ(document).find(".box_list");
			div.innerHTML = divcnt;
			box_list[0].appendChild(div);
			
			var addbasicas = document.getElementById('basicas');
			addbasicas.onclick = function(){
				var txt = 'Añadir listas básicas al reproductor '+descripcion;
				openSubWin('../asignarLista/'+idReproductor+'/basica',700,300,2,txt);
			}
			break;
		case 'terceros':
			var div = document.createElement('div');
			div.className = "elm add";
			div.id = "terceros";
			var divcnt = '<a class="lbr" title="Añadir lista de terceros"><img src="'+directorio+'/img/icons/ico_list_g_add2.png">Añadir lista de terceros</a>';
			var box_list = jQ(document).find(".box_list");
			div.innerHTML = divcnt;
			box_list[0].appendChild(div);
			
			var addterceros = document.getElementById('terceros');
			addterceros.onclick = function(){
				var txt = 'Añadir lista de terceros al reproductor '+descripcion;
				openSubWin('../asignarLista/'+idReproductor+'/terceros',700,300,2,txt);
			}
			break;	
	}

	/*if (aceptaTerceros == 1 && cuentaTerceros == 0 ){
		jQ('.box_list').children('.elm').not(":first").next().remove();
	}else{
		jQ('.box_list').children('.elm').not(":first").remove();
	}*/
}

function funcionesWhadtvJs(){
	cargarEventosSonido();
	cargarEventosActivacion();
	cargarEventosPush();
	ocultarMensajes();
}

function datosDispositivo(idReproductor){
	var repEmpresa = document.getElementById("repEmpresa");
	var index = repEmpresa.selectedIndex;
	descripcion = repEmpresa.options[repEmpresa.selectedIndex].text;
	document.getElementById("titleRep").innerHTML = 'Todo en: '+ descripcion;
}