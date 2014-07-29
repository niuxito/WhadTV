var ua = "UA-35714992-1";
$(document).ready(function(){
	montarPanel();
});

function montarPanel(){
	var estructura = '<div id="logo"><img src="http://www.loteriasyapuestas.es/MODULOS/global/publico/interfaces/web/default//img/web2_0/le_sisuenas.jpg" ><div id="msg"></div>'+
					'<div id="mnu"><ul>'+
					
					'<li><a href="#" onClick="javascript:comprobarEstado()">Actualizar estado</a></li>'+
					'<li><a href="#" onClick="javascript:comprobarResumen()">Listar Premios</a></li>'+
					'<div id="num"><label>Número</label>'+
						'<input name="numero" type="text" maxlength="5">'+
						'<input type="button" value="Comprobar"  onClick="javascript:comprobarNumero()"/></div>'+
					'</ul></div>'+
					'<div id="datos"></div><div id="nota">Nota: Para mostrar los resultados hemos utilizado la API de ElPais.com</div>';	
	$("#loterias").append(estructura);
	comprobarEstado();
	
}

function comprobarNumero(){
	var numero = $("#loterias [name='numero']").val();
	if(numero != ""){
	console.log(numero);
	if(numero.match("^[0-9]")){
		num = parseInt(numero);
	
		var url = "http://api.elpais.com/ws/LoteriaNavidadPremiados?n="+num;
		
		$.jsonp({
			url: url,
			callback: "lazyCallback",
			complete: function(){
				console.log(busqueda);
				$('#loterias #datos').empty();
				if(busqueda['premio'] == 0){
					$("#loterias #datos").append("El numero "+busqueda['numero']+" no ha sido premiado");
				}else{
					$("#loterias #datos").append("El numero "+busqueda['numero']+" ha sido premiado con "+ busqueda['premio']+" euros al décimo");
				}
			}
		
		});
		}else{
			$('#loterias #datos').empty();
			$("#loterias #datos").append("Debes introducir un número correcto");
		}
	}else{
		$('#loterias #datos').empty();
		$("#loterias #datos").append("Debes introducir primero el numero de tu décimo en la casilla");
	}
	
}
function comprobarEstado( ){
	var url = "http://api.elpais.com/ws/LoteriaNavidadPremiados?s=1";
	
	$.jsonp({
		url: url,
		callback: "lazyCallback",
		complete: function(){
			console.log(info);
			$("#loterias #msg").empty();
			if(info['status'] == 0){
				
				$("#loterias #msg").append("Todavía no ha comenzado el sorteo...");
			}else{
				$("#loterias #msg").append("Se está repartiendo suerte. Comprueba tu décimo");
			}
		}
		
	});	
}

function comprobarResumen( numero){
	var url = "http://api.elpais.com/ws/LoteriaNavidadPremiados?n=resumen";
	
	$.jsonp({
		url: url,
		callback: "lazyCallback",
		complete: function(){
			console.log(premios);
			$('#loterias #datos').empty();
			for(var campo in premios){
				if(premios[campo] == -1){
					premios[campo] = '';
				}
			}
			var estructura = '<table>'+
			'<tr><td>Premio</td><td>Número</td><tr>'+
			'<tr><td>1º</td><td>'+ premios['numero1']+'<td></tr>'+
			'<tr><td>2º</td><td>'+ premios['numero2']+'<td></tr>'+
			'<tr><td>3º</td><td>'+ premios['numero3']+'<td></tr>'+
			'<tr><td>4º</td><td>'+ premios['numero4']+'<td></tr>'+
			'<tr><td>4º</td><td>'+ premios['numero5']+'<td></tr>'+
			'<tr><td>5º</td><td>'+ premios['numero6']+'<td></tr>'+
			'<tr><td>5º</td><td>'+ premios['numero7']+'<td></tr>'+
			'<tr><td>5º</td><td>'+ premios['numero8']+'<td></tr>'+
			'<tr><td>5º</td><td>'+ premios['numero9']+'<td></tr>'+
			'<tr><td>5º</td><td>'+ premios['numero10']+'<td></tr>'+
			'<tr><td>5º</td><td>'+ premios['numero11']+'<td></tr>'+
			'<tr><td>5º</td><td>'+ premios['numero12']+'<td></tr>'+
			'<tr><td>5º</td><td>'+ premios['numero13']+'<td></tr>'+
			'</table>';
			$('#loterias #datos').append(estructura);
		}
		
	});	
}
