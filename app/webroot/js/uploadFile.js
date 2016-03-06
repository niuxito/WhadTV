var context;
var canvas;
var fondo;
var texto = "";
var colorTexto;
jQ(document)
		.ready(
				function() {
					var tips = jQ(".tip");
					console.log(tips);
					if(tips.length != 0){
						jQ(".tip").tipTip({maxWidth: '600px'});
					}
					
					jQ(".progress").hide();

					if (typeof stage !== 'undefined') {
    					generarCartel();
					}				

					jQ("#video").show();
					jQ("#imagen").hide();
					//jQ("#cartel").hide();
					jQ("#pest_video").click(function() {
						jQ(".pest li").each(function(){
							jQ(this).removeClass("up");
						});
						jQ("#pest_video").parent().addClass("up");
						jQ("#video").show();
						jQ("#imagen").hide();
					//	jQ("#cartel").hide();
					});
					jQ("#pest_imagen").click(function() {
						jQ(".pest li").each(function(){
							jQ(this).removeClass("up");
						});
						jQ("#pest_imagen").parent().addClass("up");
						jQ("#imagen").show();
						jQ("#video").hide();
					//	jQ("#cartel").hide();
					});
					jQ("#pest_cartel").click(function() {
						if(confirm("¿Desea generar un nuevo Cartel?")) {
							//document.location.href= 'Carteles/index.php';
							document.getElementById('subWin').style.display = 'none';
							window.open(
					  			'Carteles/index',
					  			'_blank'
							);
							
						}
						//jQ('#cartel #generar').removeAttr('disabled');
					});
					jQ(".progress").hide();
					
					
					
					
					$(' form').ajaxForm(
							{	
								target : '#myResultsDiv',
								beforeSubmit : function(formData, jqForm,
										options) {
									
									console.log(jQ(jqForm));
									var descripcion = jQ(jqForm).find('#VideoDescripcion')[0];
									if(jQ(descripcion).val() == ""){
										alert("Debes introducir un nombre para reconocer tu contenido");
										jqForm.preventDefault();

									}
								},
								uploadProgress : function(event, position,
										total, percentComplete) {
									jQ('form [type=submit]').attr('disabled', 'disabled');
									var percentVal = percentComplete + '%';
									if (percentVal != '100%') {
										jQ('.bar').width(percentVal);
										jQ('.percent').html(percentVal);
										jQ('#status').html("Cargando...");
									} else {
										jQ('#status').html("Cargado");
										jQ(".progress").hide();
										closeSubWin();
										//window.location.reload(); 
									}
								},

								 success: function (responseText, statusText,
								 xhr){// window.location.reload(); 
								 },

								 
								complete : function(responseText, statusText,
										xhr) {
									window.location.reload();
									alert("Guardado!!!");
								}

							});

					// jQ('#imagen form, #video form').ajaxForm(
					// 		{	
					// 			target : '#myResultsDiv',
					// 			beforeSubmit : function(formData, jqForm,
					// 					options) {
					// 				console.log(jQ(jqForm));
					// 				jQ('form [type=submit]').attr('disabled', 'disabled');
					// 				var descripcion = jQ(jqForm).find('#VideoDescripcion')[0];
					// 				if(jQ(descripcion).val() == ""){
					// 					alert("Debes introducir un nombre para reconocer tu contenido");
					// 					jqForm.preventDefault();

					// 				}
					// 				jQ(".progress").show();
					// 			},
					// 			uploadProgress : function(event, position,
					// 					total, percentComplete) {
					// 				var percentVal = percentComplete + '%';
					// 				if (percentVal != '100%') {
					// 					jQ('.bar').width(percentVal);
					// 					jQ('.percent').html(percentVal);
					// 					jQ('#status').html("Cargando...");
					// 				} else {
					// 					jQ('#status').html("Cargado");
					// 					jQ(".progress").hide();
					// 					closeSubWin();
					// 				}
					// 			},
								
					// 			success: function (responseText, statusText,
					// 			 xhr){
					// 			 	 //window.location.reload(); 
					// 			},
								 
					// 			complete : function(responseText, statusText,
					// 					xhr) {
					// 				window.location.reload();
									
					// 			}

					// 		});
					
					jQ('form [type=submit]').attr('disabled', 'disabled');

					jQ('.video_input')
							.change(
									function() {
										console
												.log("se ha introducido un video");
										jQ("[name='temporal']").remove();
										jQ("[name='temporal']")
												.attr('name', '');
										var filesToUpload = this.files[0];

										if (filesToUpload != undefined
												&& !filesToUpload.type
														.match(/video.*|shockwave.*/)) {
											alert(" Este archivo no es un video.");
										} else {
											console.log(filesToUpload.size);
											if (filesToUpload.size > max_file_size) {
												console
														.log("El fichero es muy grande");
												alert("Debes subir un fichero de menos de "
														+ max_file_size / 1000000 + "MB");
											} else {
												if ( filesToUpload.type.match('/x-flv.*|shockwave.*/')){
													jQ('form [type=submit]')
															.removeAttr('disabled');
												}else{
													/*var vid = document.createElement("video");
													vid.setAttribute( "name", "temporal" );
													try{
														var reader = new FileReader();  
														reader.onload = function(e) {vid.src = e.target.result;}
														reader.readAsDataURL(filesToUpload);
														vid.addEventListener('loadedmetadata', function() {
															console.log(vid.duration);
															jQ("[name='data[Video][tiempo]']").val(Math.round(vid.duration));
															jQ('form [type=submit]').removeAttr('disabled');
														});		
													}catch(err){
														console.log(err);*/
														jQ('form [type=submit]').removeAttr('disabled');
													//}			
												}
											}
										}
										;
									});


		$('.file-input').change(function() {
						console.log("se ha introducido un video");
						jQ("[name='temporal']").remove();
						jQ("[name='temporal']").attr('name', '');
						var filesToUpload = this.files[0];
							console.log(filesToUpload.size);
							if (filesToUpload.size > max_file_size) {
								console.log("El fichero es muy grande");
								alert("Debes subir un fichero de menos de "
										+ max_file_size / 1000000 + "MB");
							} else {
								if ( filesToUpload.type.match('/x-flv.*|shockwave.*/')){
									jQ('form [type=submit]')
											.removeAttr('disabled');
								}else{
									/*var vid = document.createElement("video");
									vid.setAttribute( "name", "temporal" );
									try{
										var reader = new FileReader();  
										reader.onload = function(e) {vid.src = e.target.result;}
										reader.readAsDataURL(filesToUpload);
										vid.addEventListener('loadedmetadata', function() {
											console.log(vid.duration);
											jQ("[name='data[Video][tiempo]']").val(Math.round(vid.duration));
											jQ('form [type=submit]').removeAttr('disabled');
										});		
									}catch(err){
										console.log(err);*/
										jQ('form [type=submit]').removeAttr('disabled');
									//}			
								}
							}
				
						;
					});

					jQ('.img_input')
							.change(
									function() {
										console
												.log("se ha introducido una imagen");
										jQ("[name='temporal']").remove();
										jQ("[name='temporal']")
												.attr('name', '');
										var filesToUpload = this.files[0];

										if (filesToUpload != undefined
												&& !filesToUpload.type
														.match(/image.*|/)) {
											alert(" Este archivo no es una imagen.");
										} else {
											console.log(filesToUpload.size);
											if (filesToUpload.size > max_file_size) {
												console
														.log("El fichero es muy grande");
												alert("Debes subir un fichero de menos de "
														+ ( max_file_size / 1000000 ) + "MB");
											} else {
												jQ('form [type=submit]')
														.removeAttr('disabled');
											}
										}
										;
									});

							jQ('.cartel_input').change(function(){
								jQ('form [type=submit]').removeAttr('disabled');
							});
					

				});
				//jQ('')




function generarCartel(){
	console.log("Generando cartel...");
	stage.toDataURL({
        mimeType: "image/jpeg",
		quality: 1,
		callback: function(dataUrl){
			console.log(dataUrl);
			jQ("#contenido_cartel").val(dataUrl);
			
			var c = document.getElementById("cartel_canvas");
			var ctxc = c.getContext("2d");
			var image = new Image();
			image.src = dataUrl;
			ctxc.drawImage(image,0,0);
		}
    });
						
}