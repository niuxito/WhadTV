jQ(document)
	.ready(
		function() {
			var argumentos = this.location.href.split('videosLista/')[1];
			argumentos = argumentos.split(/#(.*)/)[0];
			idLista = argumentos.split('/')[0];
			idListaDispositivo = argumentos.split('/')[1];
			jQ.post(
				directorio + '/agencia/obtenerDatosLista/',{idLista : idLista, idListaDispositivo : idListaDispositivo},
				function(data){
					var datos = JSON.parse(data);
					if (datos.status == false){
						console.log('Error al cargar la Empresa de la lista '+idLista);
						return;
					}
					idEmpresa = datos[0];
					idReproductor = datos[1];
					crearAddLista(idLista, idListaDispositivo, idEmpresa);
					loadListas(idReproductor, idLista, idListaDispositivo ,idEmpresa);
					wtv_cargarAddsAgencia(idLista, idEmpresa);
				}
			);
			jQ(".listListas").change(function(){
				idReproductor = this.options[this.selectedIndex].attributes.idReproductor.value;
				idListaDispositivo = this.options[this.selectedIndex].attributes.listaDispositivo.value;
				idEmpresa = this.options[this.selectedIndex].attributes.idEmpresa.value;
				modificarEditarLista(idReproductor, this.value, idListaDispositivo);
				modificarAdds(idLista, idEmpresa);
				modificarActualizarDispositivo(this.value);
				datosLista()
				loadContenido(this.value, idEmpresa);
			});
		}
	)
;

function modificarEditarLista(idReproductor, idLista, idListaDispositivo){
	var idLista = document.getElementById('lista').value;
	jQ('#editarLista').children('.edit').remove();
	var a = document.createElement('a');
	a.className = 'edit';
	a.href = "../../editarLista/"+idLista+'/'+idListaDispositivo+'/'+idReproductor;
	var acnt = '<img src="'+directorio+'/img/px_tr.gif" />';
	a.innerHTML = acnt;
	var box_disp = jQ(document).find("#editarLista");
    box_disp[0].appendChild(a);
}

function modificarActualizarDispositivo(idLista){
	var idLista = document.getElementById('lista').value;
	jQ('#elm_upd_disp').children('.prv').remove();
	var a = document.createElement('a');
	a.className = 'prv';
	a.href = "#";
	a.id = 'upd_disp';
	var acnt = '<img src="'+directorio+'/img/icons/ico_pantalla_upd.png" /><br><i>Actualizar dispositivos vinculados</i>';
	a.innerHTML = acnt;
	var upd_disp = jQ(document).find("#elm_upd_disp");
    upd_disp[0].appendChild(a);
    var updElement = document.getElementById("upd_disp");
	updElement.onclick = function(){
		var txt = 'Actualizar dispositivos vinculados';
		openSubWin(directorio+'/Reproductors/updatedispositivos/'+idLista,790,425,2,txt);
	}
}

function modificarAdds(idLista, idEmpresa){
	jQ('.bx_cntnt').children().remove();
	wtv_cargarAddsAgencia(idLista, idEmpresa);
}

function crearAddLista(idLista, idListaDispositivo, idEmpresa){
	var a = document.createElement('a');
	a.id = 'addListaBtn';
	a.href = "#";
	a.title = "Crear lista nueva";
	var acnt = '<img src="'+directorio+'/img/px_tr.gif" />';
	a.innerHTML = acnt;
	var addLista = jQ(document).find("#addLista");
	addLista[0].appendChild(a);

	var addElement = document.getElementById('addListaBtn');
	addElement.onclick = function(){
		openSubWin(directorio+'/Agencia/addLista/'+idEmpresa+"/"+idLista+"/"+idListaDispositivo,700,225,2,'Crear una nueva lista');
	}

}

function loadListas(idReproductor, idLista, idListaDispositivo, idEmpresa){
	jQ.post(
		directorio + "/agencia/cargarListas/"+idReproductor,
		function(data){
			var datos = JSON.parse(data);
			if (datos.status == false){
				console.log('Error al cargar las listas.');
				return;
			}
			var index = '';
			for (var i in datos) {
				var lista = datos[i];
			    var idListaAdd = lista['Listum']['idLista'];
			    var nombreListaAdd = lista['Listum']['descripcion'];
			    var idListaSelected = jQ('option:selected', jQ(".listListas")).val();
			    var idListaDispositivo = lista['listaDispositivo']['id'];
				
				var opcion = document.createElement("option");
		        document.getElementById("lista").options.add(opcion);
		    	jQ(opcion).text(nombreListaAdd);
		        jQ(opcion).val(idListaAdd);
				jQ(opcion).attr("listaDispositivo",idListaDispositivo);
				jQ(opcion).attr("idReproductor",idReproductor);
				jQ(opcion).attr("idEmpresa",idEmpresa);
		        if (idListaAdd == idLista){
		        	jQ(opcion).attr("selected", "selected");
		       	 	loadContenido(idLista, idEmpresa);
			    }
			}
			modificarEditarLista(idReproductor, idLista, idListaDispositivo);
			modificarActualizarDispositivo(idLista);
			datosLista();	
		}
	);
}

function loadContenido(idLista, idEmpresa){
	jQ.post(
		directorio + "/agencia/cargarContenido/"+idLista+"/"+idEmpresa,
		function(data){
			var datos = JSON.parse(data);
			jQ('#sortable').children('.elm_mov, .draggable').remove();

			if (datos.status == false){
				console.log('La lista no tiene contenido.');
				return;
			}else{
				datos = datos.videos;
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
							'<a class="prv" href="#" id="cont'+video['listaVideo']['id']+'" idVideo="'+video['Video']['idVideo']+'"  title="Ver contenido">';
							if( estado == "procesado"){
								divcnt += '<img src="'+video['Video']['fotograma']+'" alt/>'+video['Video']['descripcion'];
					 			if( time != ""){
					 				divcnt += '&nbsp <u>'+time+'"</u>';
								}
							}else{
								divcnt += '<img src="'+directorio+'/img/icons/ico_video_process.jpg" />'+video['Video']['descripcion'];
						 		if(time != ""){
						 			divcnt += '&nbsp <u>'+time+'"</u>';
						 		}
							}
							divcnt += '</a>'+
							'<div class="alrts st_mov" title="Mover orden del vídeo"></div>'+
							'<div class="ops">';
								if( estado == "procesado"){
									if( mute == 0){
										divcnt += '<a class="btn st_sond" id="'+video['Video']['idVideo']+'" title="Apagar audio"><img src="'+directorio+'/img/px_tr.gif" /></a>';
									}else{
										divcnt += '<a class="btn st_sonf" id="'+video['Video']['idVideo']+'" title="Activar audio"><img src="'+directorio+'/img/px_tr.gif" /></a>';
									}
									divcnt += '<a class="btn st_list" id="list'+video['listaVideo']['id']+'" idVideo="'+video['Video']['idVideo']+'" descVideo="'+video['Video']['descripcion']+'" href="#" title="Listas de reproducción"><img src="'+directorio+'/img/px_tr.gif" /></a>'+
									'<span class="inf">'+video['0']['listas']+'</span>'+
									'<a class="btn st_disp" id="disp'+video['listaVideo']['id']+'" idVideo="'+video['Video']['idVideo']+'" descVideo="'+video['Video']['descripcion']+'" href="#"  title="Dispositivos"><img src="'+directorio+'/img/px_tr.gif" /></a>'+
									'<span class="inf">'+video['0']['dispositivos']+'</span>'+
									'<a class="btn st_delt" id="delt'+video['listaVideo']['id']+'" descVideo="'+video['Video']['descripcion']+'" idLV="'+video['listaVideo']['id']+'" title="Eliminar video"><img src="'+directorio+'/img/px_tr.gif"></a>';
								}else{
			    					divcnt += '<div class="stat">Procesando...</div>';
			    				}
							divcnt += '</div>'+
						'</div>';

					var box_list = jQ(document).find("#sortable");
				    div.innerHTML = divcnt;
					box_list[0].appendChild(div);
					if( estado == "procesado"){
						var contElement = document.getElementById("cont"+video['listaVideo']['id']);
						contElement.onclick = function(){
							var idVideo = jQ(this).attr('idVideo');
							var txt = 'Ver contenido:';
							openSubWin(directorio+'/videos/view/'+idVideo,700,400,2,txt);
						}
						var listElement = document.getElementById("list"+video['listaVideo']['id']);
						listElement.onclick = function(){
							var idVideo = jQ(this).attr('idVideo');
							var descVideo = jQ(this).attr('descVideo');
							var txt = 'Listas de reproducción de: <b>'+descVideo+'<b>';
							openSubWin(directorio+'/Videos/listasxvideo/'+idVideo,700,300,2,txt);
						}
						var dispElement = document.getElementById("disp"+video['listaVideo']['id']);
						dispElement.onclick = function(){
							var idVideo = jQ(this).attr('idVideo');
							var descVideo = jQ(this).attr('descVideo');
							var txt = 'Dispositivos de: <b>'+descVideo+'<b>';
							openSubWin(directorio+'/Videos/dispositivosxvideo/'+idVideo,700,300,2,txt);
						}
						var delElement = document.getElementById("delt"+video['listaVideo']['id']);
						delElement.onclick = function() {
							var descVideo = jQ(this).attr('descVideo');
					    	if (!confirm("¿Desea eliminar el video "+descVideo+" del reproductor realmente?")){
					        	return false;
					        }else{
					        	jQ.post(directorio+'/agencia/desvincularVideo/', {idLV : jQ( this ).attr( 'idLV' ) }, function(data){
					        		var datos = JSON.parse(data);
					        		if (datos.status == false){
										console.log('Error al eliminar el video.');
									}else{
										jQ("div[listaid='"+datos.idLV+"']").remove();
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

function datosLista(){
	var listListas = document.getElementById("lista");
	var index = listListas.selectedIndex;
	descripcion = listListas.options[listListas.selectedIndex].text;
	document.getElementById("titleLista").innerHTML = 'Todo en: '+ descripcion;
}

function wtv_cargarAddsAgencia (idLista, idEmpresa) {
	jQ('#elm_add_videos').fadeOut(200);

	jQ('#contnt').addClass('box_part_add');
	jQ('#footer').addClass('noSep');

	jQ('#box_add_video .bx_cntnt').html('');
	jQ.get(directorio+'/agencia/cargarTodosVideos/'+idLista+'/'+idEmpresa, function(data){
			jQ('#box_add_video .bx_cntnt').html(data);
			jQ('#box_add_video .bx_cntnt .vlist').find('.elm').addClass('draggable');
			cargarSortable();
			cargarDraggable();
	});
	jQ('#box_add_video').fadeIn(300);
	ftrPst();
}