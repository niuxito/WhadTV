WebFontConfig = {
    google: { families: [ 'Open Sans::latin','Oswald::latin','Droid+Sans::latin','Roboto::latin',
                'Lato::latin','Open+Sans Condensed::latin','PT+Sans::latin','Droid Serif::latin',
                'Ubuntu::latin','PT+Sans+Narrow::latin','Kite+One::latin','Bigelow+Rules::latin',
                'Prosto+One::latin','Parisienne::latin','Kavoon::latin','New+Rocker::latin','Spirax::latin',
                'Raleway Dots::latin','Smokum::latin','UnifrakturCook::latin','Mrs+Sheppards::latin',
                'Nosifer::latin'] 
    }
};
(function() {
  var wf = document.createElement('script');
  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
  wf.type = 'text/javascript';
  wf.async = 'true';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(wf, s);
})();
function fuentesDropDown(){
  /*
  var fuentes = ['Open Sans',
                'Oswald',
                'Droid Sans',
                'Roboto',
                'Lato',
                'Open Sans Condensed',
                'PT Sans',
                'Droid Serif',
                'Ubuntu',
                'PT Sans Narrow',
                'Kite One',
                'Bigelow Rules',
                'Prosto One',
                'Parisienne',
                'Kavoon',
                'New Rocker',
                'Spirax',
                'Raleway Dots',
                'Smokum',
                'UnifrakturCook',
                'Mrs Sheppards',
                'Nosifer'];
  */
  var fuentes = { 'Open Sans': "Open Sans",
                'Oswald': "Oswald",
                'Droid Sans': "Droid Sans",
                'Roboto': "Roboto",
                'Lato': "Lato",
                'Open Sans Condensed': "Open Sans Condensed",
                'PT Sans': "PT Sans",
                'Droid Serif': "Droid Serif",
                'Ubuntu': "Ubuntu",
                'PT Sans Narrow': "PT Sans Narrow",
                'Kite One': "Kite One",
                'Bigelow Rules': "Bigelow Rules",
                'Prosto One': "Prosto One",
                'Parisienne': "Parisienne",
                'Kavoon': "Kavoon",
                'New Rocker': "New Rocker",
                'Spirax': "Spirax",
                'Raleway Dots': "Raleway Dots",
                'Smokum': "Smokum",
                'UnifrakturCook': "UnifrakturCook",
                'Mrs Sheppards': "Mrs Sheppards",
                'Nosifer': "Nosifer"
                
  };
  /*
  var fuentes = {
    OS: "Open Sans",
    OW: "Oswald"
  }
  */
  var drop = "<select id='idFuentes'>";
  for (var fuente in fuentes) {
    drop += "<option value='" + fuente + "'  >" + fuentes[fuente] + "</option>";
  }
  drop += "</select>";
  //var iDiv = document.createElement('div');
  //iDiv.id = 'fuentes';
  //iDiv.className = 'fuentes';
  //document.getElementsByTagName('body')[0].appendChild(iDiv);
  //document.getElementById('iDiv').innerHTML = drop;
  document.getElementById('opcFont').innerHTML = drop;

  //document.getElementById('container').innerHTML = drop;
}