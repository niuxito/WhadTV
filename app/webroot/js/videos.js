var ip = 'localhost';
$(document).ready(function(){
	$("#formAddVideo").hide();
	$("#formAddListaVideo").hide()
	$(".draggable a").draggable({
		appendTo:"body",
		revert:true,
		helper:"clone"
	});
	cargarDrops();
	$("#addVideo").click(function(){
		$("#formAddVideo").dialog({width:500});
		
	});
	$( "video" ).click( function(){
		//eval(this);
		
		if(this.paused == false){
			this.load();
			this.width = 100
			this.height = 100
		}else{
			this.width = 300;
			this.height = 300;
			this.play();
		}
		
		
	});
	$( "video" ).bind('ended', function(){
		this.width = 100
		this.height = 100
	});
	
	
});
function cargarDrops(){
	$("ul#listado li" ).droppable({
		tolerance:'pointer',
		hoverClass: 'soltador',
		drop: function( event, ui) {
			$("#ListaVideoIdLista").val($(this).attr("lista"));
			$("#ListaVideoIdVideo").val(ui.draggable[0].id);
			$("#ListaVideoPosicion").val($(this).attr("pos"));
			$("#ListaVideoIndexForm").submit();
			console.log($(this).attr('id'));
		}
	});
}