

function cargarSortable(){
	jQ("#sortable").sortable({
		revert: true,
		handle : ".alrts",
		placeholder: "elm",
		connectWith: ".draggable",
		stop: function(event, ui){
			//console.log(jQ(ui.item[0]).attr('listaId'));
			if(jQ(ui.item[0]).attr('listaId') != undefined){
				console.log(jQ(ui.item[0]).attr('listaId'));
				whadtv_move_video(
					jQ(ui.item[0]).attr("idVideo"),
					ui.item.index()+1,
					jQ(ui.item[0]).attr('listaId')
				);
			}else{
				whadtv_insert_video(
					jQ(ui.item[0]).attr("idVideo"),
					ui.item.index()+1
				);
			}
		}

	});
}

function cargarDraggable(){
	jQ(".draggable").draggable({
		connectToSortable: "#sortable",
		appendTo:"body",
		revert:"invalid",
		helper:"clone",
		stack: ".elm.move"
	});
	jQ( "#sortable" ).disableSelection();
}

function whadtv_insert_video(a, pos) {
	// jQ('#bx_vid_'+a).fadeOut(300);
	jQ.post(directorio + "/ListaVideos/add", {
			"idVideo" : a,
			"idLista" : jQ('#lista').val(),
			"posicion" : pos
		},
		function(){
			if (typeof controller != 'undefined'){
				if (controller == 'agencia'){
					whereToRefreshAgencia(action);
				}
			}else{
				if (window.parent.location.href.indexOf(jQ('#lista').val()) != -1) {
					window.parent.location = window.parent.location;
				} else {
					window.parent.location = window.parent.location + '/'
					+ jQ('#lista').val();
				}
			}
		}
	);
	// alert("Insertem video "+a+". La forma fàcil és per GET reescrivint el
	// window.parent.location per exemple...");
	// crearVideoBox();
	// closeSubWin();
	/*if (window.parent.location.href.indexOf(jQ('#lista').val()) != -1) {
		window.parent.location = window.parent.location;
	} else {
		window.parent.location = window.parent.location + '/'
				+ jQ('#lista').val();
	}*/
	return false;
}

function whadtv_move_video(a, pos, id) {
	jQ.post(directorio + "/ListaVideos/move", {
			"idVideo" : a,
			"idLista" : jQ('#lista').val(),
			"posicion" : pos,
			"id" : id
		},
		function(){
			if (controller == 'agencia'){
				whereToRefreshAgencia(action);
			}else{
				if (window.parent.location.href.indexOf(jQ('#lista').val()) != -1) {
					window.parent.location = window.parent.location;
				} else {
					window.parent.location = window.parent.location + '/'
					+ jQ('#lista').val();
				}
			}
		}
	);
	console.log(window.parent.location.href);
	console.log(jQ('#lista').val());
	
	return false;
}