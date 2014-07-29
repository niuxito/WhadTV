jQ(document)
	.ready(
		function() {
			loadEmpresas();
			jQ(".empAgencia").change(function(){
				 loadReproductores(this.value);	 
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
			var index = '';
			for (var i in datos) {
			    var empresa = datos[i];
			    var idEmpresa = empresa['empresa']['idEmpresa'];
			    var nombreEmpresa = empresa['empresa']['Nombre'];
			    var idRelacionAgencia = empresa['empresa']['idRelacionAgencia'];

			    var idEmpresaSelected = jQ('option:selected', jQ(".empAgencia")).val();
				
				var opcion = document.createElement("option");
		        document.getElementById("empAgencia").options.add(opcion);
		        //jQ(".empAgencia").add(opcion);
		        jQ(opcion).text(nombreEmpresa);
		        jQ(opcion).val(idEmpresa);
		        if (idEmpresaSelected == undefined){
		        	jQ(opcion).attr("selected", "selected");
		       	 	loadReproductores(idEmpresa);
			    }
			}
		}
	);
}

function loadReproductores(idEmpresa){
	jQ.post(
		directorio + "/agencia/cargarReproductores/"+idEmpresa,
		function(data){
			var datos = JSON.parse(data);
			jQ('.box_disp').children('.elm').not(":first").remove();
			
			if (datos.status == false){
				console.log('La Empresa Cliente no tiene reproductores asignados.');
				//return;
			}else{
				for (var i in datos) {
				    var dispositivo = datos[i];
					var crrdt = new Date();
				    var div = document.createElement('div');
				    var divcnt = '';
				    
					if (Date.parse(dispositivo['Dispositivo']['caducidad']) <= Date.parse(crrdt)) {
						div.className = "elm red";
						div.id = dispositivo['Dispositivo']['idDispositivo'];
					}else{
						div.className = "elm";
						div.id = dispositivo['Dispositivo']['idDispositivo'];
					}
					divcnt += '<a class="dsp" href="vistaReproductor/'+dispositivo['Dispositivo']['idDispositivo']+'"><img src="'+directorio+'/img/px_tr.gif" /><br />'+dispositivo['Dispositivo']['descripcion']+'</a>'+
						'<div class="alrts">'+
							'<a class="btn st_rfsh push" href="#" title="Sincronizar vídeos" id="'+dispositivo['Dispositivo']['idDispositivo']+'" op="sendActualizar"><img src="'+directorio+'/img/px_tr.gif" /></a>'+
						'</div>'+
						'<div class="ops">'
							if( dispositivo['Dispositivo']['play'] == 1){
								divcnt += '<a class="btn st_stop push" href="#" title="Apagar dispositiu" id="'+dispositivo['Dispositivo']['idDispositivo']+'" op="sendDetener" ><img src="'+directorio+'/img/px_tr.gif" /></a>';
							}else{
								divcnt += '<a class="btn st_play push" href="#" title="Activar dispositiu" id="'+dispositivo['Dispositivo']['idDispositivo']+'" op="sendReproducir" ><img src="'+directorio+'/img/px_tr.gif" /></a>';
							}
							if( dispositivo['Dispositivo']['mute'] == 0){
								divcnt += '<a class="btn st_sond" href="#" id="'+dispositivo['Dispositivo']['idDispositivo']+'" title="Apagar audio" ><img src="'+directorio+'/img/px_tr.gif" /></a>';
							}else{
								divcnt += '<a class="btn st_sonf" href="#" id="'+dispositivo['Dispositivo']['idDispositivo']+'" title="Activar audio" ><img src="'+directorio+'/img/px_tr.gif" /></a>';
							}
							divcnt += '<a class="btn st_list" href="vistaReproductor/'+dispositivo['Dispositivo']['idDispositivo']+'"><img src="'+directorio+'/img/px_tr.gif"></a>'+
							'<span class="inf">'+dispositivo['0']['listas']+'</span>'+
							'<form method="post">'+
							'<a class="btn st_delt" id="delt'+dispositivo['Dispositivo']['idDispositivo']+'" idDisp = "'+dispositivo['Dispositivo']['idDispositivo']+'" descDisp="'+dispositivo['Dispositivo']['descripcion']+'" title="Eliminar reproductor"><img src="'+directorio+'/img/px_tr.gif"></a>'+
							'</form>'+
						'</div>'+
					'</div>';
							
					
					var box_disp = jQ(document).find(".box_disp");
				    div.innerHTML = divcnt;
				    box_disp[0].appendChild(div);

				    var delElement = document.getElementById('delt'+dispositivo['Dispositivo']['idDispositivo']);
					delElement.onclick = function() {
						var descDisp = jQ(this).attr('descDisp');
				    	if (!confirm("¿Desea eliminar de su lista el reproductor "+descDisp+" realmente?")){
				        	return false;
				        }else{
				        	jQ.post('deleteReproductor', {idDispositivo : jQ( this ).attr( 'idDisp' )}, function(data){
				        		var datos = JSON.parse(data);
				        		if (datos.status == false){
									console.log('Error al eliminar el reproductor.');
								}else{
									jQ("#"+datos.idDispositivo).remove();	
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

function funcionesWhadtvJs(){
	cargarEventosSonido();
	cargarEventosActivacion();
	cargarEventosPush();
	ocultarMensajes();
}