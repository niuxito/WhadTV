var ip = 'localhost';
$(document).ready(function(){
	$(".draggable").draggable({
		appendTo:"body",
		revert:true,
		helper:"clone"
	});
	
	$("ul#dispositivos li" ).droppable({
		tolerance:'pointer',
		hoverClass: 'soltador',
		drop: function( event, ui) {
			$(this).find("#listasDispositivo").append(
					'<li id='+ui.draggable[0].id+'>'+
						'<input type="checkbox" name="listaActiva" value="Activa" id="'+ui.draggable[0].id+'"/>'+
					+$(ui.draggable[0]).val()+
					'<a href="/GestVideo/ListaDispositivos/delete/'+ui.draggable[0].id+'" class=btndeleteLV>x</a>'+
					'</li>');
			$("#ListaDispositivoIdLista").val(ui.draggable[0].id);
			$("#ListaDispositivoIdDispositivo").val($(this).attr("id"));
			$("#ListaDispositivoIdUsuario").val("1");
			$("#ListaDispositivoIndexForm").submit();
			console.log($(this));
		}
	});
	
	$(".dispositivos.form").hide();
	$("#nuevoDispositivo").click(function(){
		$(".dispositivos.form").dialog();
	});
	
	$('[name="dispositivoMute"]').click(function(){
		var silencio;
		if( $( this ).is( ":checked" ) ){
			silencio = 1;
		}else{
			slencio = 0;
		}
		$.post("/GestVideo/Dispositivos/mute",{"mute":silencio,"id":$( this ).attr( 'id' )});
	});
	
	$('[name="listaActiva"]').click(function(){
		var activa;
		if( $( this ).is( ":checked" ) ){
			activa = 1;
		}else{
			activa = 0;
		}
		$.post("/GestVideo/ListaDispositivos/activa",{"activa":activa,"idLista":$( this ).attr( 'id' )});
	});
	
	$( ".btndeleteLV" ).hide();
	$("#formAddListaDispositivo").hide();
	$( ".btndeleteLV" ).click(function(){
		  if (confirm('Estás seguro de querer eliminar # %s?')) {
			  document.post_4fdb4947a31d2.submit(); 
		  } 
		  event.returnValue = false;
		  return false; 
	});
	$( "ul#dispositivos li" ).hover(
			  function(){
				  $( this ).find( ".btndeleteLV" ).show();
			  },
			  function(){
				  $( this ).find( ".btndeleteLV" ).hide();
			  }
	  );
	
	$( ".push" ).click(function(){
		$.ajax({
			  url: "https://"+ip+"/GestVideo/Dispositivos/"+$(this).attr('op')+"/"+$(this).attr('id'),
			  beforeSend: function ( xhr ) {
			    xhr.overrideMimeType("application/json; charset=x-user-defined");
			  }
			}).done(function ( data ) {
				console.log(data);
			});
				
	});
});


