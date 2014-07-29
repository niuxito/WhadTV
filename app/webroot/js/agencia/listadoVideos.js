jQ(document)
	.ready(
		function() {
			loadEmpresas();
			jQ(".listEmpresas").change(function(){
				/*idReproductor = this.options[this.selectedIndex].attributes.idReproductor.value;
				idListaDispositivo = this.options[this.selectedIndex].attributes.listaDispositivo.value;
				idEmpresa = this.options[this.selectedIndex].attributes.idEmpresa.value;
				modificarAdds(idLista, idEmpresa);
				modificarActualizarDispositivo(this.value);
				datosLista()*/
				datosEmpresa();
				/*if (this.value == 0){
					loadTodoContenido();
				}else{
					loadContenido(this.value,'una');
				}*/
				loadContenido(this.value);
			});
		}
	)
;

function loadEmpresas(){
	jQ.post(
		directorio + "/agencia/cargarEmpresas",
		function(data){
			var datos = JSON.parse(data);
			if (datos.status == false){
				console.log('El agente no tiene Empresas Cliente.');
				return;
			}
			/*var opcion = document.createElement("option");
			document.getElementById("listEmpresas").options.add(opcion);
			jQ(opcion).text("Todas");
			jQ(opcion).val(0);
			jQ(opcion).attr("selected", "selected");
			*/
			for (var i in datos) {
			    var empresa = datos[i];
			    var idEmpresa = empresa['empresa']['idEmpresa'];
			    var nombreEmpresa = empresa['empresa']['Nombre'];
			    var idRelacionAgencia = empresa['empresa']['idRelacionAgencia'];

			    var idEmpresaSelected = jQ('option:selected', jQ("#listEmpresas")).val();
				
				var opcion = document.createElement("option");
		        document.getElementById("listEmpresas").options.add(opcion);
		        jQ(opcion).text(nombreEmpresa);
		        jQ(opcion).val(idEmpresa);
		        if (idEmpresaSelected == undefined){
		        	jQ(opcion).attr("selected", "selected");
		       	 	loadContenido(idEmpresa);
			    }
			}
			datosEmpresa();
			//loadTodoContenido();

		}
	);
}

/*function loadTodoContenido(){
	var listEmpresas = document.getElementById('listEmpresas');
	var cuenta = listEmpresas.options.length;
	if ( cuenta > 1 ){
		jQ('#sortable').children('.elm_mov').remove();
		for (var i = 1; i < listEmpresas.options.length; i++) {
			idEmpresa = listEmpresas.options[i].value;
			loadContenido(idEmpresa,'todo');
		}
	}
}*/

function loadContenido(idEmpresa){//, tipo){
	jQ.post(
		directorio + "/agencia/cargarTodoContenido/"+idEmpresa,
		function(data){
			var datos = JSON.parse(data);
			//if (tipo == 'una'){
				jQ('#sortable').children('.elm_mov').remove();
			//}
			//console.log(datos);
			if (datos.status == false){
				console.log('La empresa no tiene contenido.');
				//if ( tipo == 'una'){
					return;
				//}
			}else{
				datos = datos[1];
				
				for (var i in datos) {
					video = datos[i];
					var estado = video['Video']['estado'];
					var time = video['Video']['time'];
					var mute = video['Video']['mute'];

					var div = document.createElement('div');
					div.className = "elm_mov";
					div.id = video['Video']['idVideo'];
					div.setAttribute('pos',video['listaVideo']['posicion']);
					div.setAttribute('listaId',video['listaVideo']['id']);
					var divcnt = '';
					divcnt += '<div class="elm" >'+
							'<a class="prv" href="#" id="cont'+video['Video']['idVideo']+'" idVideo="'+video['Video']['idVideo']+'"  title="Ver contenido">';
							if( estado == "procesado"){
								divcnt += '<img src="'+video['Video']['fotograma']+'" />'+video['Video']['descripcion'];
					 			if( time != ""){
					 				divcnt += '&nbsp <u>'+time+'</u>';
								}
							}else{
								divcnt += '<img src="'+directorio+'/img/icons/ico_video_process.jpg" />'+video['Video']['descripcion'];
						 		if(time != ""){
						 			divcnt += '&nbsp <u>'+time+'</u>';
						 		}
							}
							divcnt += '</a>'+
							'<div class="ops">';
								if( estado == "procesado"){
									if( mute == 0){
										divcnt += '<a class="btn st_sond" id="'+video['Video']['idVideo']+'" title="Apagar audio"><img src="'+directorio+'/img/px_tr.gif" /></a>';
									}else{
										divcnt += '<a class="btn st_sonf" id="'+video['Video']['idVideo']+'" title="Activar audio"><img src="'+directorio+'/img/px_tr.gif" /></a>';
									}
									divcnt += '<a class="btn st_list" id="list'+video['Video']['idVideo']+'" idVideo="'+video['Video']['idVideo']+'" descVideo="'+video['Video']['descripcion']+'" href="#" title="Listas de reproducción"><img src="'+directorio+'/img/px_tr.gif" /></a>'+
									'<span class="inf">'+video['0']['listas']+'</span>'+
									'<a class="btn st_disp" id="disp'+video['Video']['idVideo']+'" idVideo="'+video['Video']['idVideo']+'" descVideo="'+video['Video']['descripcion']+'" href="#"  title="Dispositivos"><img src="'+directorio+'/img/px_tr.gif" /></a>'+
									'<span class="inf">'+video['0']['dispositivos']+'</span>'+
									'<a class="btn st_delt" id="delt'+video['Video']['idVideo']+'" idVideo="'+video['Video']['idVideo']+'" descVideo="'+video['Video']['descripcion']+'" idLV="'+video['listaVideo']['id']+'" title="Eliminar video"><img src="'+directorio+'/img/px_tr.gif"></a>';
								}else{
			    					divcnt += '<div class="stat">Procesando...</div>';
			    				}
							divcnt += '</div>'+
						'</div>';

					var box_list = jQ(document).find("#sortable");
				    div.innerHTML = divcnt;
					box_list[0].appendChild(div);
					if( estado == "procesado"){
						var contElement = document.getElementById("cont"+video['Video']['idVideo']);
						contElement.onclick = function(){
							var idVideo = jQ(this).attr('idVideo');
							var txt = 'Ver contenido:';
							openSubWin(directorio+'/videos/view/'+idVideo,700,450,2,txt);
						}
						var listElement = document.getElementById("list"+video['Video']['idVideo']);
						listElement.onclick = function(){
							var idVideo = jQ(this).attr('idVideo');
							var descVideo = jQ(this).attr('descVideo');
							var txt = 'Listas de reproducción de: <b>'+descVideo+'<b>';
							openSubWin(directorio+'/Videos/listasxvideo/'+idVideo,700,300,2,txt);
						}
						var dispElement = document.getElementById("disp"+video['Video']['idVideo']);
						dispElement.onclick = function(){
							var idVideo = jQ(this).attr('idVideo');
							var descVideo = jQ(this).attr('descVideo');
							var txt = 'Dispositivos de: <b>'+descVideo+'<b>';
							openSubWin(directorio+'/Videos/dispositivosxvideo/'+idVideo,700,300,2,txt);
						}
						var delElement = document.getElementById("delt"+video['Video']['idVideo']);
						delElement.onclick = function() {
							var descVideo = jQ(this).attr('descVideo');
					    	if (!confirm("¿Desea eliminar el video "+descVideo+" del reproductor realmente?")){
					        	return false;
					        }else{
					        	jQ.post(directorio+'/agencia/deleteVideo/', {idVideo : jQ( this ).attr( 'idVideo' ) }, function(data){
					        		var datos = JSON.parse(data);
					        		if (datos.status == false){
										console.log('Error al eliminar el video.');
									}else{
										jQ("div[id='"+datos.idVideo+"']").remove();
									}
					        	});
					        }
				        }
				    }
				}
			}
			funcionesWhadtvJs();
		}
	);

}

function funcionesWhadtvJs(){
	cargarEventosSonido();
	cargarEventosActivacion();
	cargarEventosPush();
	ocultarMensajes();
}

function datosEmpresa(){
	var listEmpresas = document.getElementById("listEmpresas");
	var index = listEmpresas.selectedIndex;
	var descripcion = listEmpresas.options[listEmpresas.selectedIndex].text;
	var texto = '';
	//if (descripcion == 'Todas'){
	//	texto = 'Todas';
	//}else{
		texto = 'Todo en: '+descripcion;
	//}
	document.getElementById("titleEmpresa").innerHTML = texto;
}