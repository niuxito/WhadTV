$(document).ready(function() {
	montarPanel();
});

function ejecutarConsulta(url, completeFunction) {
	$.jsonp({
		url : url,
		callback : "lazyCallback",
		complete : completeFunction
	});
}

function montarPanel() {
	var estructura = '<div id="logo"><img src="http://www.loteriasyapuestas.es/MODULOS/global/publico/interfaces/web/default//img/web2_0/le_sisuenas.jpg" ></div><div id="msg"></div>'
			+ '<div id="mnu"><ul>'
			+

			'<li><a href="#" onClick="javascript:comprobarEstado()">Actualizar estado</a></li>'
			+ '<li><a href="#" onClick="javascript:comprobarResumen()">Listar Premios</a></li>'
			+ '<div id="num"><label>Número</label>'
			+ '<input name="numero" type="text" maxlength="5">'
			+ '<input type="button" value="Comprobar"  onClick="javascript:comprobarNumero()"/></div>'
			+ '</ul></div>'
			+ '<div id="datos"></div><div id="nota">Nota: Para mostrar los resultados hemos utilizado la API de ElPais.com</div>';
	$("#loterias").append(estructura);
	comprobarEstado();

}

function comprobarEstado() {
	var url = "http://api.elpais.com/ws/LoteriaNinoPremiados?s=1";
	ejecutarConsulta(url, estado);
}

function comprobarResumen(numero) {
	var url = "http://api.elpais.com/ws/LoteriaNinoPremiados?n=resumen";
	ejecutarConsulta(url, resumen);
}

function comprobarNumero() {
	var numero = $("#loterias [name='numero']").val();
	if (numero != "") {
		console.log(numero);
		if (numero.match("^[0-9]")) {
			num = parseInt(numero, 10);
			var url = "http://api.elpais.com/ws/LoteriaNinoPremiados?n=" + num;
			ejecutarConsulta(url, premiado);

		} else {
			$('#loterias #datos').empty();
			$("#loterias #datos").append("Debes introducir un número correcto");
		}
	} else {
		$('#loterias #datos').empty();
		$("#loterias #datos")
				.append(
						"Debes introducir primero el numero de tu décimo en la casilla");
	}

}

function premiado() {
	console.log(busqueda);
	$('#loterias #datos').empty();
	if (busqueda['premio'] == 0) {
		$("#loterias #datos").append(
				"El numero " + busqueda['numero'] + " no ha sido premiado");
	} else {
		$("#loterias #datos").append(
				"El numero " + busqueda['numero'] + " ha sido premiado con "
						+ busqueda['premio'] + " euros al décimo");
	}
}

function estado() {
	console.log(info);
	$("#loterias #msg").empty();
	switch (info['status']) {
	case 0:
		$("#loterias #msg").append("Todavía no ha comenzado el sorteo...");
		break;
	case 1:
		$("#loterias #msg").append(
				"Se está repartiendo suerte. Comprueba tu décimo");
		break;
	case 2, 3:
		$("#loterias #msg").append(
				"El sorteao ha terminado, la lista provisional está completa");
		break;
	case 4:
		$("#loterias #msg").append(
				"Ya están disponibles los resultados oficiales");
	}

}

function inteligible(valor) {
	if (valor == -1) {
		return 'Por salir';
	}
	return valor;
}

function resumen() {
	console.log(premios);
	$('#loterias #datos').empty();
	var estructura;
	if (premios['status'] != 0) {

		estructura = '<div class="titulo premio">Primer Premio</div><div class="numero premio">'
				+ inteligible(premios['premio1'])
				+ '</div>'
				+ '<div class="titulo premio">Segundo Premio</div><div class="numero premio">'
				+ inteligible(premios['premio2']) + '</div>';
		estructura += '<div class="titulo">Extracciones 5 cifras</div>';

		for ( var i = 0; i < 12; i++) {
			estructura += '<div class="numero">'
					+ inteligible(premios['extracciones5cifras'][i]) + '</div>';
		}

		estructura += '<div id="trescifras" class="sub"><div class="titulo">Extracciones 3 cifras</div>';

		for ( var i = 0; i < 14; i++) {
			estructura += '<div class="numero">'
					+ inteligible(premios['extracciones3cifras'][i]) + '</div>';
		}
		estructura += '</div>';

		estructura += '<div id="doscifras" class="sub"><div class="titulo">Extracciones 2 cifras</div>';

		for ( var i = 0; i < 5; i++) {
			estructura += '<div class="numero">'
					+ inteligible(premios['extracciones2cifras'][i]) + '</div>';
		}
		estructura += '</div>';

		estructura += '<div class="titulo">Reintegros</div><div class="numero reintegro">'
				+ inteligible(premios['reintegros'][0])
				+ '</div>'
				+ '<div class="numero reintegro">'
				+ inteligible(premios['reintegros'][1])
				+ '</div><div class="numero reintegro">'
				+ inteligible(premios['reintegros'][2]) + '</div>';
	} else {
		estructura = 'Todavia no hay resultados.';
	}
	$('#loterias #datos').append(estructura);
}
