$(document)
		.ready(
				function() {
					var tips = jQ(".tip");
					console.log(tips);
					if(tips.length != 0){
						jQ(".tip").tipTip({maxWidth: '1000px'});
					}

					jQ(".asignarLista").click(function(){
	      					var tipoLista = jQ('option:selected', jQ(".tipoLista")).val();
	      					var idLista = jQ(this).attr('idLista');
							var idDispositivo = jQ(this).attr('idDispositivo');
							console.log(idLista);
							if (confirm('¿Deseas asignar esta lista al dispositivo?')) {
								jQ.post(
									directorio + "/adm/asignarListaDispositivo", {
										"idLista" : idLista,
										"idDispositivo" : idDispositivo,
										"tipoLista" : tipoLista
									},
									function(data){
										window.location.reload();
										//console.log(data);
									}
								);
				  			}
					});
				}
		);