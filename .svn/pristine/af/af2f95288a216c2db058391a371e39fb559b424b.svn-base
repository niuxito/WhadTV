var jQ = jQuery.noConflict();
var rutaWebM = directorio + "/videos/videowebm/";
var rutaMp4 = directorio + "/videos/videomp4/";

jQ(document).ready(function() {
	jQ(".cls").click(function() {
		// console.log(lista);
		lista.stop();
		lista.flush();
		jQ(".cls").unbind("click");
		jQ("#subWin").detach();
	});
	getJSON();

});

function getJSON() {
	console.log(jQ("#tipo").val());
	jQ.post(directorio + "/Reproductor/" + jQ("#tipo").val(), {
		"id" : jQ("#id").val()
	}, function(data) {
		var info = jQ.parseJSON(data);
		if (typeof info.caducidad != 'undefined') {
			cargarDispositivo(info);
		} else {
			var mute = false;
			if (info.listas.mute == true) {
				mute = true;
			}
			cargarLista(info.listas, mute);
		}
		montarContexto();
	});

}

function cargarDispositivo(data) {
	console.log('Dispositivo');
	var mute = false;
	if (data.mute == true) {
		mute = true;
	}
	for ( var i = 0; i < data.listas.length; i++) {
		if (data.listas[i].activa == true) {
			var lista = data.listas[i];
			if (lista.mute == true) {
				mute = true;
			}
			cargarLista(lista, mute);
		}
	}
	// for()

}

function cargarLista(data, mute) {
	var tempNom;

	for ( var i = 0; i < data.videos.length; i++) {
		var video = data.videos[i];
		if (mute == true) {
			nombres.push(new Array(rutaWebM + video.idVideo, mute));
		} else {
			nombres.push(new Array(rutaWebM + video.idVideo, video.mute));
		}
	}

	// console.log(tempNom);
}