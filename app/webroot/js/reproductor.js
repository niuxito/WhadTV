var el;
var nombres = Array();
var lista;
var ruta = directorio + "videowebm/";

function getNombres() {
	var tempNom = getElementsByClass('elm_mov');
	for ( var i = 1; i < tempNom.length; i++) {
		console.log(ruta);
		nombres.push(ruta + tempNom[i].id);
	}
	// console.log(tempNom);
}
/**
 * Clase ListaVideos que contiene un listado de los videos y cual está
 * reproduciendose
 * 
 * @returns
 */
function ListaVideos() {
	this.actual = null;
	this.videos = Array();
	this.push = addVideo;
	this.start = arrancarReproductor;
	this.next = siguienteVideo;
	this.stop = detenerReproductor;
	this.flush = eliminarLista;
	this.del = deleteVideo;

}
function eliminarLista() {
	for ( var i = 0; i < this.videos.length; i++) {
		this.del(this.videos[i]);
	}
	lista = undefined;

}
function detenerReproductor() {
	if (this.actual != null){
		this.videos[this.actual].pause();
	}
}
function siguienteVideo() {
	if (this.actual == this.videos.length - 1) {
		this.actual = -1;
	}
	this.videos[++this.actual].play();

}
function arrancarReproductor() {
	this.videos[0].play();
	this.actual = 0;
}
function addVideo(video) {
	this.videos.push(video);
	// console.log(this.videos);
	if (this.videos.length == 1) {
		this.start();
	}
}
function deleteVideo(video) {
	video.src = "";
}

/**
 * Final de ListaVideos
 */

window.onload = function(e) {
	getNombres();
	montarContexto();

};

function montarContexto() {
	el = document.getElementsByTagName('canvas')[0];

	lista = new ListaVideos();
	cargarVideo(lista, 0);
}
function cargarVideo(lista, indice) {
	if (nombres.length > indice) {

		var video = this.document.createElement("video");
		video.src = nombres[indice][0];
		if( nombres[indice][1] == true) {
			video.volume = 0.0;
		}else{
			video.volume = 1.0;
		}
		video.onloadeddata = function() {
			console.log("Cargado");

		};

		video.preload = true;
		lista.push(video);
		var context = el.getContext('2d');
		video.addEventListener('play', function() {
			draw(this, context, el.width, el.height);
		}, false);
		video.addEventListener('ended', function() {
			lista.next();
		});
		cargarVideo(lista, ++indice);
	}

}

function draw(v, c, w, h) {
	if (v.paused || v.ended)
		return false;
	c.drawImage(v, 0, 0, w, h);
	setTimeout(draw, 20, v, c, w, h);
}

var x, y;

function getElementsByClass(searchClass, domNode, tagName) {
	if (domNode == null)
		domNode = document;
	if (tagName == null)
		tagName = '*';
	var el = new Array();
	var tags = domNode.getElementsByTagName(tagName);
	var tcl = " " + searchClass + " ";
	for (i = 0, j = 0; i < tags.length; i++) {
		var test = " " + tags[i].className + " ";
		if (test.indexOf(tcl) != -1)
			el[j++] = tags[i];
	}
	return el;
}
