var jQ = jQuery.noConflict();
// var ip = "192.168.1.3";
// Open sub-win v.2.1.1
function openSubWin(c, w, h, f, t, x) {
	if (!jQ('#subWin').length)
		jQ('body')
				.append(
						'<div id="subWin"><div class="shadow"/><div class="windw">'
								+ '<h2></h2><div class="cls"/><div id="subWInfo"/></div></div>');
	x = "jQ('#subWin').fadeOut('fast'" + ((x) ? ', function(){' + x + '}' : '')
			+ ')';
	jQ('#subWin .shadow, #subWin .cls').click(function() {
		eval(x);
		jQ('#subWInfo').html('');
	});
	if (t)
		jQ('#subWin h2').html(t);
	var g = jQ('#subWInfo');
	if (f != 2)
		g.html((f == 1) ? c : '<iframe src="' + c
				+ '" scrolling="yes" frameborder="0"></iframe>');
	if (f == 1)
		jQ('#subWInfo img').css('visibility', 'hidden').load(function() {
			jQ(this).css('visibility', 'visible');
			g.addClass('opaque');
		});
	else if (f == 2)
		jQ.get(c, function(e) {
			g.html(e);
		});
	openSubWin_size(w, h, 0, ((f) ? 0 : 1));
	jQ('#subWin').fadeIn('fast', function() {
		g.fadeIn('fast');
	});
}
// Resize v.1.1
function openSubWin_size(w, h, m, r) {
	w = parseInt(w);
	h = parseInt(h);
	if (h) {
		h = h + 25;
		h2 = (h > jQ(window).height()) ? jQ(window).height() : h;
		if (h != h2)
			h2 = h2 - 25;
		if (w && r != 1)
			w = (w * h2) / h;
		h = h2;
	}
	if (w) {
		var w2 = (w > jQ(window).width()) ? jQ(window).width() : w;
		if (h && r != 1)
			h = (h * w2) / w;
		w = w2;
	}
	var b = 0, c = {}, g = jQ('#subWInfo'), e = jQ('#subWin .windw');
	w = (w < 200) ? 200 : w;
	h = (h < 100) ? 100 : h;
	if (w || h)
		b = parseInt(e.css("border-left-width"))
				+ parseInt(e.css("padding-left"));
	if (w) {
		c['width'] = w + 'px';
		c['margin-left'] = '-' + ((w / 2) + b) + 'px';
	}
	if (h) {
		c['height'] = h + 'px';
		c['margin-top'] = '-' + ((h / 2) + b) + 'px';
	}
	var r = '#subWInfo';
	s = jQ(r + ((jQ(r + ' iframe').length) ? ' iframe' : ''));
	o = s.css('overflow');
	if (m) {
		s.css('overflow', 'hidden');
		e.animate(c, m, function() {
			s.css('overflow', o);
		});
	} else
		e.css(c);
}
function closeSubWin() {
	jQ('#subWin').fadeOut('fast')
}

jQ(document).ready(function() {
	cargarEventosSonido();
	cargarEventosActivacion();
	cargarEventosPush();
	ocultarMensajes();
	activarBusqueda();
	jQ(".btn.ftr_msg").attr('disabled', 'disabled');
	jQ("#footer .inpt").change(function(){ 
		if( jQ("#footer .inpt").val() != ""){ 
			jQ(".btn.ftr_msg").removeAttr('disabled');
		}else{
			jQ(".btn.ftr_msg").attr('disabled', 'disabled');
		}
	});
	if( typeof demo !== "undefined" ){
		( demo ) ? openSubWin('Reproductors/crear',700,400,2,'Añadir un nuevo reproductor web') : false;
	}

	jQ('.add_content').click(function(){
		jQ.get(directorio+'/videos/addVideo', function(data){
			jQ('.modal-content').html(data);
			jQ('#myModal').modal('show');
		});
	});
});

function cargarEventosSonido() {
	jQ(".st_sond, .st_sonf").unbind('click');
	jQ('.box_vid .st_sond').click(function() {
		jQ.post(directorio + "/Videos/mute", {
			"mute" : "1",
			"id" : jQ(this).attr('id')
		});
		jQ(this).attr('class', "btn st_sonf");
		cargarEventosSonido();
	});
	jQ('.box_vid .st_sonf').click(function() {
		jQ.post(directorio + "/Videos/mute", {
			"mute" : "0",
			"id" : jQ(this).attr('id')
		});
		jQ(this).attr('class', "btn st_sond");
		cargarEventosSonido();
	});
	jQ('.box_list .st_sond').click(function() {
		jQ.post(directorio + "/Lista/mute", {
			"mute" : "1",
			"id" : jQ(this).attr('id')
		});
		jQ(this).attr('class', "btn st_sonf");
		cargarEventosSonido();
	});
	jQ('.box_list .st_sonf').click(function() {
		jQ.post(directorio + "/Lista/mute", {
			"mute" : "0",
			"id" : jQ(this).attr('id')
		});
		jQ(this).attr('class', "btn st_sond");
		cargarEventosSonido();
	});
	jQ('.box_disp .st_sond').click(function() {
		jQ.post(directorio + "/Reproductors/mute", {
			"mute" : "1",
			"id" : jQ(this).attr('id')
		});
		jQ(this).attr('class', "btn st_sonf");
		cargarEventosSonido();
	});
	jQ('.box_disp .st_sonf').click(function() {
		jQ.post(directorio + "/Reproductors/mute", {
			"mute" : "0",
			"id" : jQ(this).attr('id')
		});
		jQ(this).attr('class', "btn st_sond");
		cargarEventosSonido();
	});
}

function cargarEventosPush() 
{
	jQ(".push").unbind('click');
	jQ(".push").click(
			function(event) 
			{
				var objeto = jQ(this);
				var url =  host + directorio + "/Reproductors/" + jQ(this).attr('op') + "/" + jQ(this).attr('id');
				( jQ(this).attr('op') == 'sendActualizar' ) 
				? url =  host + directorio + "/actualizacionDispositivos/" + jQ(this).attr('op') + "/" + jQ(this).attr('id')
				: false;
				jQ.ajax(
					{
						url : url
					}).done(function(data) 
					{
						console.log(data);
						if (objeto.attr('op') == 'sendReproducir') {
							objeto.attr('class', 'btn st_stop push');
							objeto.attr('op', 'sendDetener');
						} else if (objeto.attr('op') == 'sendDetener') {
							objeto.attr('class', 'btn st_play push');
							objeto.attr('op', 'sendReproducir');
						}
						// console.log(objeto.attr('op'));

					});


			});
}

function cargarEventosActivacion() {
	jQ(".st_stop, .st_play").unbind('click');
	jQ('.box_list .st_stop').click(function() {
		jQ.post(directorio + "/ListaDispositivos/activa", {
			"activa" : "0",
			"id" : jQ(this).attr('id')
		});
		jQ(this).attr('class', "btn st_play");
		cargarEventosActivacion();
	});
	jQ('.box_list .st_play').click(function() {
		jQ.post(directorio + "/ListaDispositivos/activa", {
			"activa" : "1",
			"id" : jQ(this).attr('id')
		});
		jQ(this).attr('class', "btn st_stop");
		cargarEventosActivacion();
	});

}

/*function whadtv_insert_video(a, pos) {

	// jQ('#bx_vid_'+a).fadeOut(300);
	jQ.post(directorio + "/ListaVideos/add", {
		"idVideo" : a,
		"idLista" : jQ('#lista').val(),
		"posicion" : pos
	});
	// alert("Insertem video "+a+". La forma fàcil és per GET reescrivint el
	// window.parent.location per exemple...");
	// crearVideoBox();
	// closeSubWin();
	window.parent.location = window.parent.location;
	return false;
}

function whadtv_move_video(a, pos, id) {
	jQ.post(directorio + "/ListaVideos/move", {
		"idVideo" : a,
		"idLista" : jQ('#lista').val(),
		"posicion" : pos,
		"id" : id
	});
	console.log(window.parent.location.href);
	console.log(jQ('#lista').val());
	if (window.parent.location.href.indexOf(jQ('#lista').val()) != -1) {
		window.parent.location = window.parent.location;
	} else {
		window.parent.location = window.parent.location + '/'
				+ jQ('#lista').val();
	}
	return false;
}*/


/**
 * Esto se va a cambiar por un popup que desaparece a los x segundos
 */
function ocultarMensajes() {

	setTimeout(function() {
		jQ('.box_info').fadeOut(300);
		jQ('.box_error').fadeOut(300);
			ftrPst();
	}, 2000);

}

/**
 * Activa la función de busqueda en tablas
 */
 function activarBusqueda(){
 	var options = {
    	valueNames: ['selm', 'selm1', 'selm2'],
    	listClass: 'slist'
	};
	//console.log("cargando lista");
	var usersList = ( typeof List !== "undefined" ) ? new List( 'listado', options ) : false;
	//console.log(usersList);
 }
