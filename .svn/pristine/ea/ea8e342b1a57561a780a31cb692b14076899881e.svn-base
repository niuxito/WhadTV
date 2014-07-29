jQ(document)
		.ready(
				function() {
					jQ('form').ajaxForm(
							{
								target : '#myResultsDiv',
								/*beforeSubmit : function(formData, jqForm,
										options) {
									console.log(jQ(jqForm));
									//var descripcion = jQ(jqForm).find('#VideoDescripcion')[0];
									/*if(jQ(descripcion).val() == ""){
										alert("Debes introducir un nombre para reconocer tu contenido");
										jqForm.preventDefault();

									}
									jQ(".progress").show();
								},*/
								/*uploadProgress : function(event, position,
										total, percentComplete) {
									var percentVal = percentComplete + '%';
									if (percentVal != '100%') {
										jQ('.bar').width(percentVal);
										jQ('.percent').html(percentVal);
										jQ('#status').html("Cargando...");
									} else {
										jQ('#status').html("Cargado");
										jQ(".progress").hide();
										closeSubWin();
									}
								},
								*/
								 success: function (responseText, statusText,
								 xhr){ closeSubWin(); },
								 
								complete : function(responseText, statusText,
										xhr) {
									closeSubWin();
								}

							});

				});