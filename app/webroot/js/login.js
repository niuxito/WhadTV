$(document).ready( function (){

	$('#UserLoginForm').ajaxForm(
							{
								 
								complete : function(data, statusText,
										xhr) {
									console.log(data.responseText);
									resultado = JSON.parse(data.responseText);
									console.log(resultado.status);
									if(resultado.status == "ok"){ 
										window.location.reload();
									}else{
										$('.help-inline').text( resultado.status ) ;
										$('.help-inline').removeClass('hide');	
									} 
									
								}

							});
	});