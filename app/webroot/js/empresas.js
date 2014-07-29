$( document ).ready( function( ){
	$( "#formAddLogo" ).hide( );
	$( ".logo" ).click( function( ){
		$( "#formAddLogo" ).prepend( $( this ).clone( ) );
		$( "#LogoIdEmpresa").val( this.id );
		$( "#formAddLogo" ).dialog({
			width:600
			
		});
	});
});