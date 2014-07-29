function whereToRefreshAgencia(action){
	//var localizacion = window.parent.location.href.split('/')[5];
	console.log(action);
	switch (action){
		case 'videoslista':
			refreshVideosLista();
			break;
		default:
			return;
			break;
	}
}
function refreshVideosLista(){
	var lista = document.getElementById('lista');
	idLista = lista.value
	idEmpresa = lista.options[lista.selectedIndex].attributes.idEmpresa.value;
	//console.log(idLista+" "+idEmpresa);
	loadContenido(idLista,idEmpresa);
	//jQ('#sortable').children('.elm_mov').remove();
}