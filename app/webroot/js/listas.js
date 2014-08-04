var ip = 'localhost';
$(document).ready(function(){
	$("#formAddLista").hide();
	$("#addLista").click(function(){
		$("#formAddLista").show();
	});
	
	  $( ".btndeleteL" ).hide();
	  $( ".btndeleteL" ).click(function(){
		  if (confirm('Are you sure you want to delete # %s?')) {
			  document.post_4fdb4947a31d2.submit(); 
		  } 
		  event.returnValue = false;
		  return false; 
	  });

	  $( ".lista" ).hover(
			  function(){
				  $( this ).find( ".btndeleteL" ).show();
			  },
			  function(){
				  $( this ).find( ".btndeleteL" ).hide();
			  }
	  );
	$(".listas li").click(function (){
		$("#listado").empty();
		var lista = $(this).attr('id');
		$("#listado").append("<li lista="+lista+" pos=1 class=dropable>Insertar</li>");
		$.ajax({
			  url: "https://"+ip+"/GestVideo/ListaVideos/videosFromLista?idLista="+$(this).attr('id'),
			  beforeSend: function ( xhr ) {
			    xhr.overrideMimeType("application/json; charset=x-user-defined");
			  }
			}).done(function ( data ) {
			
			$("[name='listaMute']").attr( 'id', lista );
			$("[name='listaMute']").attr('checked', false);
			if( data != "" ){
				if(data['mute'] == 1 ){
					$("[name='listaMute']").attr('checked', true);
				}
				if( ( data['videos']['ListaVideo'] != undefined ) ){
					$.each(data['videos']['ListaVideo'], function ( index, domElem )  {
					  console.log("Sample of data:", domElem);
					  $("#listado").append(
							"<li lista="+lista+" pos="+domElem['posicion']+" id="+domElem['idVideo']+" class=dropable>" +
					  			domElem['idVideo']+
					  			"<a href='/GestVideo/ListaVideos/delete/"+domElem['id']+"' class=btndeleteLV>x</a>" +
					  		"</li>");
				  });
				}
			  $( ".btndeleteLV" ).hide();
			  $( ".btndeleteLV" ).click(function(){
				  if (confirm('Estás seguro de querer eliminar # %s?')) {
					  document.post_4fdb4947a31d2.submit(); 
				  } 
				  event.returnValue = false;
				  return false; 
			  });
			}
			  $( ".dropable" ).hover(
					  function(){
						  $( this ).find( ".btndeleteLV" ).show();
					  },
					  function(){
						  $( this ).find( ".btndeleteLV" ).hide();
					  }
			  );
			  
			  $( "#contlistas").show();
			  cargarDrops();
			});
		
	});
	$('[name="listaMute"]').click(function(){
		var silencio;
		if( $( this ).is( ":checked" ) ){
			silencio = 1;
		}else{
			slencio = 0;
		}
		$.post("/GestVideo/Lista/mute",{"mute":silencio,"id":$( this ).attr( 'id' )});
	});
	
	$('[name="videoMute"]').click(function(){
		var silencio;
		if( $( this ).is( ":checked" ) ){
			silencio = 1;
		}else{
			slencio = 0;
		}
		$.post("/GestVideo/Videos/mute",{"mute":silencio,"id":$( this ).attr( 'id' )});
	});
	
	
	/*$('[name="activa"]').click(function(){
		var activa;
		if( $( this ).is( ":checked" ) ){
			activa = 1;
		}else{
			activa = 0;
		}
		$.post("/GestVideo/ListaVideos/activa",{"activa":activa,"id":$( this ).attr( 'id' )});
	});*/
	
	$( "#contlistas").hide();
	
	
});