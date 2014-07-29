jQ( document ).ready( function(){
	
	//Add nueva linea
	jQ( '#addbtn' ).click( function(){
		jQ.post(
			directorio + "/programacions/add", {
				"idListaDispositivo" : idListaDispositivo
			},
			addElement

		);

	});
	jQ('.btn.back').hide();
	jQ("[type='submit']").hide();
	asignarTriggers();
	




});

function addElement( data ){
	
	//console.log(jQ(data).find('li').attr('id'));
	if(data != null){
		var id= jQ(data).attr('id');
		jQ(".mlist ul").append(data);
		jQ('li#'+id).find('.btn.back').hide();
		jQ('li#'+id).find("[type='submit']").hide();
		reiniciarTriggers();
	}

}

function removeElement( data ){
	console.log( data );
	var datos = JSON.parse(data);
	if( datos.saved == true ){
		console.log("Eliminando : "+datos[ 'id' ] );
		jQ(".mlist li#"+datos[ 'id' ]).remove();
	}

}

function reiniciarTriggers(){
	eliminarTriggers();
	asignarTriggers();
}

function eliminarTriggers(){
	jQ( '.st_delt' ).unbind('click');
	jQ( '.st_stop, .st_play' ).unbind('click');
}
function asignarTriggers(){
	
	
	jQ( '.st_stop, .st_play' ).click( function(){
		jQ(this).parent().parent().find("[type='submit']").show();
		//jQ(this).parent().parent().find(".btn.back").show();
		if(jQ( this ).attr( 'class' ).toString( ).indexOf( "st_stop" ) == -1 ){
			jQ( this ).removeClass( "st_play" ).addClass( "st_stop" );
			jQ( "input[idPrograma='"+this.id+"']" ).val( 1 );
		}else{
			jQ( this ).removeClass( "st_stop" ).addClass( "st_play" );
			jQ( "input[idPrograma='"+this.id+"']" ).val( 0 );
		}

		//if()

	});

	jQ("input, select").change(function(){
		console.log(jQ(this).parent().parent());
		jQ(this).parent().parent().find("[type='submit']").show();
		//jQ(this).parent().parent().parent().find(".btn.back").show();
	})

	jQ( '.st_delt' ).click( function(){
		jQ.post(
			directorio + "/programacions/delete", {
				"id" : this.id
			},
			removeElement

		);

	});
	var form;
	jQ('form').ajaxForm(
							{
		
		beforeSubmit : function(formData, jqForm,
				options) {
			console.log(jQ(jqForm));
			form = jqForm;
			/*var descripcion = jQ(jqForm).find('#VideoDescripcion')[0];
			if(jQ(descripcion).val() == ""){
				alert("Debes introducir un nombre para reconocer tu contenido");
				jqForm.preventDefault();

			}
			jQ(".progress").show();*/
		},
		 success: function (responseText, statusText,
		 xhr){// window.location.reload(); 
		 	console.log("success");
		 	jQ(this).find("[type='submit']").show();
			//jQ(this).parent().find(".btn.back").show();
		 },
		 
		complete : function(responseText, statusText,
				xhr) {
			console.log(form);
			jQ(form).find("[type='submit']").hide();
			jQ(form).parent().find(".btn.back").hide();
			//window.location.reload();
		}

	});

	jQ( '.btn.back' ).click( function(){
		
	});
}