var jQ=jQuery.noConflict();
jQ(document).ready(function(){
	jQ("tr").click(function (){
		var elem  =jQ(this).find("a");
		window.location.href = jQ(this).find("a").attr('href');
	});
});