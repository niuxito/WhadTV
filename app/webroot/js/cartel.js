var canvas = document.getElementById('cartid');
var ctx = canvas.getContext('2d');
var ancho = canvas.width;
var alto = canvas.height;
var imagenCanvas = new Image();
var stage = new Kinetic.Stage({
        container : "cantainer",
        width : ancho,
        height : alto
    });
var layerbackground = new Kinetic.Layer();
var layerimage = new Kinetic.Layer();
var layertext = new Kinetic.Layer();
stage.add(layerbackground);
stage.add(layerimage);
stage.add(layertext);
var con = stage.getContainer();    
var dragSrcEl = null;
var dragSrcElBox = null;
var mouseX;
var mouseY;
var elementoPulsado = false;
var tamañoinicial;

window.onload = function(){
    
    var fondo = new Kinetic.Rect({
        x: 0,
        y: 0,
        width: ancho,
        height: alto,
        fill: 'white',
    });
    layerbackground.add(fondo);
    drawLayers();

    var imagenes = document.getElementsByName("imagebar");
    
    for (var i=0; i<imagenes.length; i++){ 
        var imageid = imagenes[i].id;
        document.getElementById(imageid).addEventListener('dragstart',function(e){
            dragSrcEl = this;
        });

        document.getElementById(imageid).addEventListener('click',function(e){
            dragSrcEl = this;
            var mnuimagen = document.getElementById('idCarousel');
            if (mnuimagen.style.left == '0px'){
                addImage(e,'click');    
            }
        });
    }
    
    var boxes = document.getElementsByName("boxbar");
    for (var i=0; i<boxes.length; i++){ 
        var boxid = boxes[i].id;
        document.getElementById(boxid).addEventListener('click',function(e){
            var mnubox = document.getElementById('idBox');
            if (mnubox.style.left == '0px'){
                if ( this.id == 'boxcolor' ) {
                    addForma(this.style.backgroundColor,true);            
                }else{
                    addForma(rgb2hex(this.style.backgroundColor),false);
                }
            }
        });
    }

    var texts = document.getElementsByName("textbar");
    for (var i=0; i<texts.length; i++){ 
        var textid = texts[i].id;
        document.getElementById(textid).addEventListener('click',function(e){
            var mnutext = document.getElementById('idText');
            if (mnutext.style.left == '0px'){
                var fontFamily = this.style.fontFamily;
                fontFamily = fontFamily.replace(/'/g,"");
                if ( this.id == 'textfont' ) {
                    addTexto('Open Sans',true);            
                }else{
                    addTexto(fontFamily,false);
                }    
            }
        });
    }

    stage.on('mousemove', function(e) {
        mouseX = e.offsetX;
        mouseY = e.offsetY;
    });

    
    jQ("#cantainer").on('click',function(e){
        if ( !elementoPulsado){
            visibilidadMnuopciones('all');
            limpiarTodosGrupos();
            visibilidadMnuEdit('',false);
        }else{
            elementoPulsado = false;
        }
    });

    con.addEventListener('dragover',function(e){
        e.preventDefault(); //@important
    });
    //Inserta imagen al stage.
    con.addEventListener('drop',function(e){
        e.preventDefault();
        addImage(e,'drop');
     });
}

function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function addImage(e,type){
    var idimg = dragSrcEl.id;
    var imagewidth;
    var imageheight;
    var naturalwidth;
    var naturalheight;

    imageObj = new Image();
    imageObj.src = dragSrcEl.alt;
    imageObj.onload = function(){
        
        naturalwidth = imageObj.width;
        naturalheight = imageObj.height;

        var newSize = escalarImagen(ancho, alto, naturalwidth, naturalheight);
        imagewidth = newSize[0];
        imageheight = newSize[1];

        var posx;
        var posy;
        if (type == 'drop'){
            posx = (e.offsetX - imagewidth * 0.25 / 2);
            posy = (e.offsetY - imageheight * 0.25 / 2);
        }else{
            posx = ancho / 2 - (ancho * 0.25 / 2);
            posy = alto / 2 - (alto * 0.25 / 2);
        }
        var nuevoImageGroup = new Kinetic.Group({
            //x: 0,
            //y: 0,
            x: posx,
            y: posy,
            draggable: true,
            opciones: false,
            offset: [ (imagewidth*0.25) / 2 , (imageheight*0.25) / 2],
            mid: {x: (imagewidth*0.25)/2, y: (imageheight*0.25)/2},
            gradoRotacion: 0,
            rotationB: false
        });
        layerimage.add(nuevoImageGroup);
        
        var nuevaImage = new Kinetic.Image({
            x: 0,
            y: 0,
            width: imagewidth * 0.25,
            height: imageheight * 0.25,
            scalewidth: imagewidth,
            scaleheight: imageheight,
            naturalwidth: naturalwidth,
            naturalheight: naturalheight,
            name: 'image',
            draggable: false
        });

        nuevoImageGroup.add(nuevaImage);
        
        comprobarBordes(nuevoImageGroup,'image');

        nuevoImageGroup.on('mousedown touchstart', function() {
            elementoPulsado = true;
            limpiarGrupos(this,'image');
        });
        nuevoImageGroup.on('dragend', function() {
            limpiarGrupos(this,'image');
        });

        //Antiguas funciones usadas: dragmove, dragend, mousedown touchstart, dragstart
        nuevoImageGroup.on('dragmove', function() {
            comprobarBordes(this,'image');
            editarGrupo(this,'dragmove','image');
        });
        nuevoImageGroup.on('click', function() {
            elementoPulsado = true;
            editarGrupo(this,'click','image');
        });
        nuevoImageGroup.on('dblclick', function() {
            editarGrupo(this,'dlbclick','image');
            //rotate(this,90);
        });
       
        nuevaImage.setImage(imageObj);
        drawLayers();
        nuevoImageGroup.fire('click');
        
        visibilidadMnuopciones('all');
    };
}

function escalarImagen(maxWidth, maxHeight, srcWidth, srcHeight) {
    var ratioOrigen = srcWidth / srcHeight;

    var ratio = [maxWidth / srcWidth, maxHeight / srcHeight ];
    /*if( ratio[0] > ratio[1]){
        return [maxWidth * ratioOrigen, maxHeight];
    }else{
        return [maxWidth, maxHeight  / ratioOrigen];
    }*/
    ratio = Math.min(ratio[0], ratio[1]);

    return [srcWidth*ratio, srcHeight*ratio];
}

function comprobarBordes(group,type){
    var lastPosition = group.getPosition();
    var midX = lastPosition.x - group.attrs.offsetX + group.attrs.mid.x;
    var midY = lastPosition.y - group.attrs.offsetY + group.attrs.mid.y;
    
    if (midX < 0){
        group.attrs.x = 0
    }else if (midX > ancho){
        group.attrs.x = ancho;
    }
    if (midY < 0){
        group.attrs.y = 0;
    }else if (midY > alto){
        group.attrs.y = alto;
    }
}

function editarGrupo(group,origen,type){
    switch (origen) {
        case "dragmove":
            if (group.attrs.opciones == false){
                limpiarGrupos(group,type);
                addGrupos(group,type);
                group.attrs.opciones = true;
                visibilidadMnuEdit(type,true);
                visibilidadMnuopciones('all');
            }
            break;
        case "click":
            if (group.attrs.opciones == false){
                limpiarGrupos(group,type);
                addGrupos(group,type);
                group.attrs.opciones = true;
                visibilidadMnuEdit(type,true);
                visibilidadMnuopciones('all');
            }
            break;
        case "dlbclick":
            group.attrs.opciones = false;
            for (var i=0; i<group.children.length; i++){
                if (group.children[i].attrs.name != 'image' && group.children[i].attrs.name != 'text' && group.children[i].attrs.name != 'forma'){
                //Quitar comandos salvo imagen
                    group.children[i].remove();
                    i--;
                }
            }
            visibilidadMnuEdit(type,false);
            break;
    } 
    drawLayers();
}

function addGrupos(group,type){
    //Añadir comandos
    if ( type == 'image' || type == 'forma'){
        var width = group.children[0].attrs.width - 20;
        var height = group.children[0].attrs.height - 20;
        addOpcion(group, 0, 0, "topLeft",type,"delete");
        addOpcion(group, 0, height, "bottomLeft",type,"front");
        addOpcion(group, 20, height, "bottomLeft2",type,"back");
        addOpcion(group, width , 0, "topRight",type,"rotate");
        addOpcion(group, width, height, "bottomRight",type,"resize");
    }else if ( type == 'text' ){
        var width = group.children[0].textWidth;
        var height = group.children[0].textHeight;
        addOpcion(group, 0, 0, "topLeft",type,"delete");
        addOpcion(group, 0, height, "bottomLeft",type,"front");
        addOpcion(group, 20, height, "bottomLeft2",type,"back");
        addOpcion(group, width , 0, "topRight",type,"rotate");
        addOpcion(group, width, height, "bottomRight",type,"resize");
    }
    
    drawLayers();
}
function limpiarGrupos(group,type){
    var idgroup = group._id;
    if ( type == 'image' || type == 'forma') {
        var longimage = layerimage.children.length;
        for (var i=0; i<longimage; i++){
            if (idgroup != layerimage.children[i]._id && layerimage.children[i].attrs.opciones == true){
                var longitudchildren = layerimage.children[i].children.length;
                layerimage.children[i].attrs.opciones = false;
                for (var j=longitudchildren-1; j>-1; j--){
                    if (layerimage.children[i].children[j].attrs.name != 'image' && layerimage.children[i].children[j].attrs.name != 'forma' ){
                        layerimage.children[i].children[j].remove();
                    }
                }
            }
        }
        var longtext = layertext.children.length;
        for (var i=0; i<longtext; i++){
            if (layertext.children[i].attrs.opciones == true){
                var longitudchildren = layertext.children[i].children.length;
                layertext.children[i].attrs.opciones = false;
                for (var j=longitudchildren-1; j>-1; j--){
                    if (layertext.children[i].children[j].attrs.name != 'text' ){
                        layertext.children[i].children[j].remove();
                    }
                }
            }
        }
    }else if ( type == 'text'){
        var longtext = layertext.children.length;
        for (var i=0; i<longtext; i++){
            if (idgroup != layertext.children[i]._id && layertext.children[i].attrs.opciones == true){
                var longitudchildren = layertext.children[i].children.length;
                layertext.children[i].attrs.opciones = false;
                for (var j=longitudchildren-1; j>-1; j--){
                    if (layertext.children[i].children[j].attrs.name != 'text' ){
                        layertext.children[i].children[j].remove();
                    }
                }
            }
        }
        var longimage = layerimage.children.length;
        for (var i=0; i<longimage; i++){
            if (layerimage.children[i].attrs.opciones == true){
                var longitudchildren = layerimage.children[i].children.length;
                layerimage.children[i].attrs.opciones = false;
                for (var j=longitudchildren-1; j>-1; j--){
                    if (layerimage.children[i].children[j].attrs.name != 'image' && layerimage.children[i].children[j].attrs.name != 'forma' ){
                        layerimage.children[i].children[j].remove();
                    }
                }
            }
        }
    }
    drawLayers();
}

function limpiarTodosGrupos(){
    var longitudImagenes = layerimage.children.length;
        for (var i=0; i<longitudImagenes; i++){
            if (layerimage.children[i].attrs.opciones == true){
                var longitudchildren = layerimage.children[i].children.length;
                layerimage.children[i].attrs.opciones = false;
                for (var j=longitudchildren-1; j>-1; j--){
                    if (layerimage.children[i].children[j].attrs.name != 'image' && layerimage.children[i].children[j].attrs.name != 'forma'){
                        layerimage.children[i].children[j].remove();
                    }
                }
            }
        }
    var longitudTextos = layertext.children.length;
    for (var i=0; i<longitudTextos; i++){
        if (layertext.children[i].attrs.opciones == true){
            var longitudchildren = layertext.children[i].children.length;
            layertext.children[i].attrs.opciones = false;
            for (var j=longitudchildren-1; j>-1; j--){
                if (layertext.children[i].children[j].attrs.name != 'text' ){
                    layertext.children[i].children[j].remove();
                }
            }
        }
    }
    drawLayers();
}

function drawLayers(){
    layerbackground.draw();
    layerimage.draw();
    layertext.draw();
}

function consolelayers(){
    console.log(layerimage);
    console.log(layertext);
}

function addTexto(fuenteTexto,predefinido){
    var longitud = layertext.children.length + 1;

    var nuevoTextGroup = new Kinetic.Group({
        x: ancho / 2 - (ancho * 0.25 / 2),
        y: alto / 2 - (alto * 0.25 / 2),
        draggable: true,
        dragOnTop: false,
        opciones: false,
        mid: {}
    });
    
    layertext.add(nuevoTextGroup);

    //var fuente = document.getElementById('idFuentes').value;
    //var color = document.getElementById('cltexto').value;
    var color = '#000000';

    var nuevoText = new Kinetic.Text({
        text: "Texto "+longitud,
        id: "Texto"+longitud,
        x: 0,
        y: 0,
        fontFamily: fuenteTexto,
        fontSize: 20,
        fill: color,
        draggable: false,
        name: "text"
    });
    
    var nuevoSize = nuevoText.getSize();
    nuevoTextGroup.setOffset(nuevoSize.width/2,nuevoSize.height/2);
    nuevoText.attrs.lastWidth = nuevoSize.width;
    nuevoText.attrs.lastHeight = nuevoSize.height;
    nuevoTextGroup.attrs.mid.x = nuevoSize.width / 2;
    nuevoTextGroup.attrs.mid.y = nuevoSize.height / 2;

    nuevoTextGroup.on('mousedown touchstart', function() {
        elementoPulsado = true;
        limpiarGrupos(this,'text');
    });
    nuevoTextGroup.on('dragend', function() {
        limpiarGrupos(this,'text');
    });
    nuevoTextGroup.on('dragmove', function() {
        comprobarBordes(this,'text');       
        editarGrupo(this,'dragmove','text');
        update(this.children[4],'text','add');
        document.getElementById('idFuentes').value = this.children[0].attrs.fontFamily;
        document.getElementById('cltexto').value = this.children[0].attrs.fill;
        document.getElementById('cltexto').style.background = this.children[0].attrs.fill;
        document.getElementById('msgtexto').value = this.children[0].attrs.text;
        drawLayers();
       // comprobarBordes(this,'text');
    });
    nuevoTextGroup.on('click', function() {
        elementoPulsado = true;
        editarGrupo(this,'click','text');
        update(this.children[4],'text','add');
        document.getElementById('idFuentes').value = this.children[0].attrs.fontFamily;
        document.getElementById('cltexto').value = this.children[0].attrs.fill;
        document.getElementById('cltexto').style.background = this.children[0].attrs.fill;
        document.getElementById('msgtexto').value = this.children[0].attrs.text;
        drawLayers();
    });
    nuevoTextGroup.on('dblclick', function() {
        editarGrupo(this,'dlbclick','text');
        /*var newText=window.prompt("Editar texto: ",nuevoText.getText());
        if(newText!=null){
            nuevoText.setText(newText);
            update(this.children[4],'text','edit');
            drawLayers();
        }*/
    });

    nuevoTextGroup.add(nuevoText);

    if ( predefinido == true ){
        editarGrupo(nuevoTextGroup,'click','text');
        document.getElementById('cltexto').value = nuevoTextGroup.children[0].attrs.fill;
        document.getElementById('cltexto').style.background = nuevoTextGroup.children[0].attrs.fill;
        //startColorPicker(document.getElementById("cltexto"),'over','right','bottom');
        document.getElementById('idFuentes').value = nuevoTextGroup.children[0].attrs.fontFamily;
        document.getElementById('msgtexto').value = nuevoTextGroup.children[0].attrs.text;
    }

    nuevoTextGroup.fire('click');
    drawLayers();
    visibilidadMnuopciones('all');
    //startColorPicker(this)
}

function actualizarColoryTexto(){
    for (var i=0; i<layerimage.children.length; i++){
        if (layerimage.children[i].attrs.opciones == true){
            layerimage.children[i].children[0].attrs.fill = document.getElementById('cltexto').value;
            drawLayers();
        }
    }
    for (var i=0; i<layertext.children.length; i++){
        if (layertext.children[i].attrs.opciones == true){
            var fuente = document.getElementById('idFuentes').value;
            layertext.children[i].children[0].attrs.fontFamily = fuente;
            var text = layertext.children[i].children[0];
            text.attrs.text = document.getElementById('msgtexto').value;
            currentSize = text.getSize();

            var nuevoText = new Kinetic.Text({
                text: text.attrs.text,
                id: "TextoPruebaFuente",
                x: 0,
                y: 0,
                fontFamily: fuente,
                fontSize: 20,
                fill: "blue",
                draggable: false,
                name: "text"
            });
            var nuevoSize = nuevoText.getSize();
            nuevoText.destroy();
            text.setSize(nuevoSize.width,nuevoSize.height);
            text.attrs.lastWidth = nuevoSize.width;
            text.attrs.lastHeight = nuevoSize.height;
            update(layertext.children[i].children[4],'text','resize');
            layertext.children[i].children[0].attrs.fill = document.getElementById('cltexto').value;
            drawLayers();
        }
    }
}

function addForma(colorForma,predefinido){
    var nuevaFormaGroup = new Kinetic.Group({
        x: ancho / 2 - (ancho * 0.25 / 2),
        y: alto / 2 - (alto * 0.25 / 2),
        draggable: true,
        opciones: false,
        offset: [ (ancho * 0.25) / 2 , (alto * 0.25) / 2],
        mid: {x: (ancho*0.25)/2, y: (alto*0.25)/2}
    });
    layerimage.add(nuevaFormaGroup);
    
    if ( predefinido == true ){
        colorForma = '#ce5e03';
    }
    //var color = document.getElementById('cltexto').value;
    
    var nuevaForma = new Kinetic.Rect({
        x: 0,
        y: 0,
        width: ancho * 0.25,
        height: alto * 0.25,
        scalewidth: 200,
        scaleheight: 200,
        fill: colorForma,
        //stroke: 'black',
        //strokeWidth: 4,
        name: 'forma',
        draggable: false
      });

    nuevaFormaGroup.add(nuevaForma);
    
    nuevaFormaGroup.on('mousedown touchstart', function() {
        elementoPulsado = true;
        limpiarGrupos(this,'forma');
    });
    nuevaFormaGroup.on('dragend', function() {
        limpiarGrupos(this,'forma');
    });

    nuevaFormaGroup.on('dragmove', function() {
        comprobarBordes(this,'forma');
        editarGrupo(this,'dragmove','forma');
        document.getElementById('cltexto').value = this.children[0].attrs.fill;
        document.getElementById('cltexto').style.background = this.children[0].attrs.fill;
        drawLayers();
    });
    nuevaFormaGroup.on('click', function() {
        elementoPulsado = true;
        editarGrupo(this,'click','forma');
        document.getElementById('cltexto').value = this.children[0].attrs.fill;
        document.getElementById('cltexto').style.background = this.children[0].attrs.fill;
        drawLayers();
    });
    nuevaFormaGroup.on('dblclick', function() {
        editarGrupo(this,'dlbclick','forma');
    });

    if ( predefinido == true ){
        editarGrupo(nuevaFormaGroup,'click','forma');
        document.getElementById('cltexto').value = nuevaFormaGroup.children[0].attrs.fill;
        document.getElementById('cltexto').style.background = nuevaFormaGroup.children[0].attrs.fill;
        startColorPicker(document.getElementById("cltexto"),'over','right','bottom');
    }

    nuevaFormaGroup.fire('click');
    drawLayers();
    visibilidadMnuopciones('all');
}

function update(activeAnchor,type,origen) {
    var group = activeAnchor.getParent();
    var topLeft = group.get(".topLeft")[0];
    var topRight = group.get(".topRight")[0];
    var bottomRight = group.get(".bottomRight")[0];
    var bottomLeft = group.get(".bottomLeft")[0];
    var bottomLeft2 = group.get(".bottomLeft2")[0];
    switch (type){
        case 'image':
            var image = group.get('.image')[0];
            
            //Actualiza posiciones opciones 
            switch (activeAnchor.getName()) {
            case "topLeft":
                topRight.attrs.y = activeAnchor.attrs.y;
                bottomLeft.attrs.x = activeAnchor.attrs.x;
                break;
            case "topRight":
                topLeft.attrs.y = activeAnchor.attrs.y;
                bottomRight.attrs.x = activeAnchor.attrs.x;
                break;
            case "bottomRight":
                bottomLeft.attrs.y = activeAnchor.attrs.y + 20;
                topRight.attrs.x = activeAnchor.attrs.x + 20;
                break;
            case "bottomLeft":
                bottomRight.attrs.y = activeAnchor.attrs.y;
                topLeft.attrs.x = activeAnchor.attrs.x;
                break;
            }
            
            //http://stackoverflow.com/questions/6565703/math-algorithm-fit-image-to-screen-retain-aspect-ratio
            var ws = topRight.attrs.x - topLeft.attrs.x;
            var hs = bottomLeft.attrs.y - topLeft.attrs.y;
            var width = image.getWidth();
            var height = image.getHeight();
            var rs = ws / hs;
            var ri = width / height;
            if (rs > ri) {
                width = width * hs / height;
                image.setSize(width, hs);
            } else {
                height = height * ws / width;
                image.setSize(ws, height);
            }
            
            var imagescalewidth = image.attrs.scalewidth;
            var imagescaleheight = image.attrs.scaleheight;
            if ( width < ( imagescalewidth * 0.2 ) || height < ( imagescaleheight * 0.2 ) ) {
                width = imagescalewidth * 0.2;
                height = imagescaleheight * 0.2;
                image.setSize(width,height);
            }
            group.attrs.mid.x = image.getWidth()/2;
            group.attrs.mid.y = image.getHeight()/2;
            break;
        case 'text':
            var text = group.get('.text')[0];        
            var anchorX = activeAnchor.getX();
            var anchorY = activeAnchor.getY();
            
            //Actualiza posiciones opciones 
            switch (activeAnchor.getName()) {
                case 'topLeft':
                    topRight.setY(anchorY);
                    bottomLeft.setX(anchorX);
                    break;
                case 'topRight':
                    topLeft.setY(anchorY);
                    bottomRight.setX(anchorX);
                    break;
                case 'bottomRight':
                    bottomLeft.setY(anchorY);
                    topRight.setX(anchorX); 
                    break;
                case 'bottomLeft':
                    bottomRight.setY(anchorY);
                    topLeft.setX(anchorX); 
                    break;
            }
            text.setPosition(topLeft.getPosition());
            var newWidth = topRight.getX() - topLeft.getX();
            var newHeight = bottomLeft.getY() - topLeft.getY();
            switch (origen){
                case 'resize':
                    if(newWidth && newHeight ) {
                        currentSize = text.getSize();
                        if ( newWidth < currentSize.width ){
                            topRight.setX(currentSize.width);
                            bottomRight.setX(currentSize.width);
                            newWidth = currentSize.width;
                        }
                        if ( newHeight < currentSize.height ){
                            bottomLeft.setY(currentSize.height);
                            bottomRight.setY(currentSize.height);
                            newHeight = currentSize.height;
                        }
                        text.attrs.lastWidth = newWidth;
                        text.attrs.lastHeight = newHeight;
                        text.setScale(newWidth/currentSize.width, newHeight/currentSize.height);
                    }
                    break;
                case 'edit':
                    currentSize = text.getSize();
                    topRight.setX(text.attrs.lastWidth);
                    bottomRight.setX(text.attrs.lastwidth);
                    bottomLeft.setY(text.attrs.lastHeight);
                    bottomRight.setY(text.attrs.lastHeight);
                    text.setScale(text.attrs.lastWidth/currentSize.width,text.attrs.lastHeight/currentSize.height);
                    break;
                case 'add':
                    topRight.setX(text.attrs.lastWidth);
                    bottomRight.setX(text.attrs.lastWidth);
                    bottomLeft.setY(text.attrs.lastHeight);
                    bottomRight.setY(text.attrs.lastHeight);
                    bottomLeft2.setX(bottomLeft2.attrs.width);
                    bottomLeft2.setY(text.attrs.lastHeight);
                    break;
            }
            group.attrs.mid.x = text.attrs.lastWidth/2;
            group.attrs.mid.y = text.attrs.lastHeight/2;
            break;
        case 'forma':
            var forma = group.get('.forma')[0];
            
            //Actualiza posiciones opciones 
            switch (activeAnchor.getName()) {
            case "topLeft":
                topRight.attrs.y = activeAnchor.attrs.y;
                bottomLeft.attrs.x = activeAnchor.attrs.x;
                break;
            case "topRight":
                topLeft.attrs.y = activeAnchor.attrs.y;
                bottomRight.attrs.x = activeAnchor.attrs.x;
                break;
            case "bottomRight":
                bottomLeft.attrs.y = activeAnchor.attrs.y + 20;
                topRight.attrs.x = activeAnchor.attrs.x + 20;
                break;
            case "bottomLeft":
                bottomRight.attrs.y = activeAnchor.attrs.y;
                topLeft.attrs.x = activeAnchor.attrs.x;
                break;
            }
            
            var width = topRight.attrs.x - topLeft.attrs.x;
            var height = bottomLeft.attrs.y - topLeft.attrs.y;
            if(width && height) {
                forma.setSize(width, height);
            }
            
            var formascalewidth = forma.attrs.scalewidth;
            var formascaleheight = forma.attrs.scaleheight;

            if ( width < ( formascalewidth * 0.2 ) ) {
                width = formascalewidth * 0.2;
                forma.setSize(width,height);
            }
            if ( height < ( formascaleheight * 0.2 ) ) {
                height = formascaleheight * 0.2;
                forma.setSize(width,height);
            }
            group.attrs.mid.x = forma.getWidth()/2;
            group.attrs.mid.y = forma.getHeight()/2;
            break;
    }
}



function addOpcion(group, x, y, name, type, typeOpcion) {
    var stage = group.getStage();
    var layer = group.getLayer();

    var anchor = new Kinetic.Image({
        x: x,
        y: y,
        name: name,
        width: 20,
        height: 20
    });
    imageObj = new Image();
    switch(typeOpcion){
        case "delete":
            imageObj.src = "../app/webroot/img/cartel/delete.png"
            anchor.setImage(imageObj);
            anchor.on('click', function() {
                group.destroy();
                drawLayers();
                //group.setZIndex(5);
            });
            anchor.on('mouseover', function() {
                document.body.style.cursor = 'pointer';
                this.setStrokeWidth(2);
                drawLayers();
            });
            anchor.on('mouseout', function() {
                document.body.style.cursor = 'default';
                this.setStrokeWidth(0);
                drawLayers();
            });
            break;
        case "back":
            imageObj.src = "../app/webroot/img/cartel/toBack.png"
            anchor.setImage(imageObj);
            anchor.on('click', function() {
                group.moveToBottom();
                //group.moveDown();
                drawLayers();
            });
            anchor.on('mouseover', function() {
                document.body.style.cursor = 'pointer';
                this.setStrokeWidth(2);
                drawLayers();
            });
            anchor.on('mouseout', function() {
                document.body.style.cursor = 'default';
                this.setStrokeWidth(0);
                drawLayers();
            });
            break;
        case "front":
            imageObj.src = "../app/webroot/img/cartel/toFront.png"
            anchor.setImage(imageObj);
            anchor.on('click', function() {
                group.moveToTop();
                //group.moveUp();
                drawLayers();
            });
            anchor.on('mouseover', function() {
                document.body.style.cursor = 'pointer';
                this.setStrokeWidth(2);
                drawLayers();
            });
            anchor.on('mouseout', function() {
                document.body.style.cursor = 'default';
                this.setStrokeWidth(0);
                drawLayers();
            });
            break;
        case "edit":
            imageObj.src = "../app/webroot/img/cartel/edit.png"
            anchor.setImage(imageObj);
            anchor.on('click', function() {
                var newText=window.prompt("Editar texto: ",nuevoText.getText());
                if(newText!=null){
                nuevoText.setText(newText);
                update(group.children[4],'text','edit');
                drawLayers();
                }
            });
            anchor.on('mouseover', function() {
                document.body.style.cursor = 'pointer';
                this.setStrokeWidth(2);
                drawLayers();
            });
            anchor.on('mouseout', function() {
                document.body.style.cursor = 'default';
                this.setStrokeWidth(0);
                drawLayers();
            });
            break;
        case "resize":
            imageObj.src = "../app/webroot/img/cartel/resize.png"
            anchor.setImage(imageObj);
            anchor.setDraggable(true);
            anchor.on('dragmove', function() {
                var topLeft = group.get(".topLeft")[0];
                var topRight = group.get(".topRight")[0];
                var bottomRight = group.get(".bottomRight")[0];
                var bottomLeft = group.get(".bottomLeft")[0];
                var bottomLeft2 = group.get(".bottomLeft2")[0];

                comprobarBordes(group,type);
                update(this,type,'resize');

                var absCenterX = Math.abs((topLeft.getAbsolutePosition().x - 10 + bottomRight.getAbsolutePosition().x - 10 ) / 2);
                var absCenterY = Math.abs((topLeft.getAbsolutePosition().y - 10 + bottomRight.getAbsolutePosition().y - 10 ) / 2);
                
                var grupo = group.children[0];
                var tipo = grupo.attrs.name;
                if ( tipo == 'text' ){
                    var offsetX = grupo.attrs.lastWidth / 2;
                    var offsetY = grupo.attrs.lastHeight / 2;
                }else{
                    var offsetX = grupo.getWidth() / 2;
                    var offsetY = grupo.getHeight() / 2;
                }

                if (absCenterX <= 0 || absCenterX >= ancho || 
                    absCenterY <= 0 || absCenterY >= alto ) {
                    group.setOffset( offsetX , offsetY);
                }
                
                if ( type == 'image' ){
                    var image = group.get('.image')[0];
                    var x = image.getX();
                    var y = image.getY();
                    var width = image.getWidth();
                    var height = image.getHeight();
                    topLeft.setX(x);
                    topLeft.setY(y);
                    topRight.setX(x + width - topRight.attrs.width);
                    topRight.setY(y);
                    bottomLeft.setX(x);
                    bottomLeft.setY(y + height - bottomLeft.attrs.height);
                    bottomRight.setX(x + width - bottomRight.attrs.width);
                    bottomRight.setY(y + height - bottomRight.attrs.height);
                    bottomLeft2.setX(x + bottomLeft2.attrs.width);
                    bottomLeft2.setY(y + height - bottomLeft2.attrs.height);
                    group.moveToTop();
                }
                if ( type == 'forma' ){
                    var forma = group.get('.forma')[0];
                    var x = forma.getX();
                    var y = forma.getY();
                    var width = forma.getWidth();
                    var height = forma.getHeight();
                    topLeft.setX(x);
                    topLeft.setY(y);
                    topRight.setX(x + width - topRight.attrs.width);
                    topRight.setY(y);
                    bottomLeft.setX(x);
                    bottomLeft.setY(y + height - bottomLeft.attrs.height);
                    bottomRight.setX(x + width - bottomRight.attrs.width);
                    bottomRight.setY(y + height - bottomRight.attrs.height);
                    bottomLeft2.setX(x + bottomLeft2.attrs.width);
                    bottomLeft2.setY(y + height - bottomLeft2.attrs.height);
                    group.moveToTop();
                }
                if ( type == 'text' ){
                    var text = group.get('.text')[0];
                    var x = text.getX();
                    var y = text.getY();
                    var width = text.attrs.lastWidth;
                    var height = text.attrs.lastHeight;
                    bottomLeft2.setX(x + bottomLeft2.attrs.width);
                    bottomLeft2.setY(y + height );//- bottomLeft2.attrs.height);
                }
                drawLayers();
            });
            anchor.on('mousedown touchstart', function() {
                group.setDraggable(false);
                //this.moveToTop();
                drawLayers();
            });
            anchor.on('dragstart', function(){
                var tipo = group.children[0].attrs.name;
                tamañoinicial = group.children[0].getSize();
                if ( tipo == 'text' ){
                    tamañoinicial.width = group.children[0].attrs.lastWidth;
                    tamañoinicial.height = group.children[0].attrs.lastHeight;
                }
            });
            anchor.on('dragend', function() {
                var tipo = group.children[0].attrs.name;
                if ( tipo == 'text' ){
                    //console.log(group);
                    var tamañofinalwidth = group.children[0].lastWidth;
                    var tamañofinalheight = group.children[0].lastHeight;
                    var distanciaX = ( tamañofinalwidth - tamañoinicial.width ) / 2;
                    var distanciaY = ( tamañofinalheight - tamañoinicial.height ) / 2;
                    var offsetX = group.children[0].attrs.lastWidth / 2;
                    var offsetY = group.children[0].attrs.lastHeight / 2;

                    if (group.attrs.gradoRotacion == 0){
                        var positiongroup = group.getPosition();
                        group.attrs.offsetX = offsetX;
                        group.attrs.offsetY = offsetY;
                        group.setPosition(positiongroup.x + distanciaX , positiongroup.y + distanciaY);
                    }else{
                        var absolposant = group.getAbsolutePosition();
                        group.attrs.offsetX = offsetX;
                        group.attrs.offsetY = offsetY;
                        var absolposnew = group.getAbsolutePosition();
                        var absolposx = absolposnew.x - absolposant.x;
                        var absolposy = absolposnew.y - absolposant.y;
                        group.setPosition(absolposant.x + absolposx , absolposant.y + absolposy);
                    }
                }else{
                    //console.log(group);
                    var tamañofinal = group.children[0].getSize();
                    var distanciaX = ( tamañofinal.width - tamañoinicial.width ) / 2;
                    var distanciaY = ( tamañofinal.height - tamañoinicial.height ) / 2;
                    
                    if (group.attrs.gradoRotacion == 0){
                        var positiongroup = group.getPosition();
                        group.attrs.offsetX = group.children[0].getWidth() / 2;
                        group.attrs.offsetY = group.children[0].getHeight() / 2;
                        group.setPosition(positiongroup.x + distanciaX , positiongroup.y + distanciaY);
                    }else{
                        var absolposant = group.getAbsolutePosition();
                        group.attrs.offsetX = group.children[0].getWidth() / 2;
                        group.attrs.offsetY = group.children[0].getHeight() / 2;
                        var absolposnew = group.getAbsolutePosition();
                        var absolposx = absolposnew.x - absolposant.x;
                        var absolposy = absolposnew.y - absolposant.y;
                        group.setPosition(absolposant.x + absolposx , absolposant.y + absolposy);
                    }
                }
                group.setDraggable(true);
                drawLayers();
            });
            anchor.on('mouseover', function() {
                document.body.style.cursor = 'pointer';
                this.setStrokeWidth(2);
                drawLayers();
            });
            anchor.on('mouseout', function() {
                document.body.style.cursor = 'default';
                this.setStrokeWidth(0);
                drawLayers();
            });
            break;
        case "rotate":
            imageObj.src = "../app/webroot/img/cartel/rotate.png"
            anchor.setImage(imageObj);
            anchor.setDraggable(true);
            anchor.on('dragmove', function (pos){
                var topLeft = group.get('.topLeft')[0];
                var bottomRight = group.get('.bottomRight')[0];
                var topRight = group.get('.topRight')[0];
                var grupo = group.children[0];
                var tipo = grupo.attrs.name;

                if ( tipo == 'text'){
                    var absCenterX = Math.abs((topLeft.getAbsolutePosition().x + 5 + bottomRight.getAbsolutePosition().x + 5 ) / 2);
                    var absCenterY = Math.abs((topLeft.getAbsolutePosition().y + 5 + bottomRight.getAbsolutePosition().y + 5 ) / 2);
                    
                    var relCenterX = Math.abs((topLeft.getX() + bottomRight.getX()) / 2);
                    var relCenterY = Math.abs((topLeft.getY() + bottomRight.getY()) / 2);

                    var radius = distance(relCenterX, relCenterY, grupo.attrs.lastWidth ,0);//- (topRight.attrs.width / 2) , (topRight.attrs.height / 2));
                    
                    var scale = radius / distance(pos.x, pos.y, absCenterX, absCenterY);

                    var realRotation = Math.round(degrees(angle(relCenterX, relCenterY, grupo.attrs.lastWidth ,0)));//- (topRight.attrs.width / 2) , (topRight.attrs.height / 2))));

                    var rotation = Math.round(degrees(angle(absCenterX, absCenterY, pos.x, pos.y)));
                    rotation -= realRotation;
                    
                    group.attrs.gradoRotacion = rotation;
                    group.setRotationDeg(rotation);
                    this.setX(grupo.attrs.lastWidth - this.attrs.width);
                    this.setY(0)
                }else{  

                    var absCenterX = Math.abs((topLeft.getAbsolutePosition().x + 5 + bottomRight.getAbsolutePosition().x + 5 ) / 2);
                    var absCenterY = Math.abs((topLeft.getAbsolutePosition().y + 5 + bottomRight.getAbsolutePosition().y + 5 ) / 2);
                    
                    var relCenterX = Math.abs((topLeft.getX() + bottomRight.getX()) / 2);
                    var relCenterY = Math.abs((topLeft.getY() + bottomRight.getY()) / 2);

                    var radius = distance(relCenterX, relCenterY, grupo.attrs.width ,0);//- (topRight.attrs.width / 2) , (topRight.attrs.height / 2));
                    
                    var scale = radius / distance(pos.x, pos.y, absCenterX, absCenterY);

                    var realRotation = Math.round(degrees(angle(relCenterX, relCenterY, grupo.attrs.width ,0)));//- (topRight.attrs.width / 2) , (topRight.attrs.height / 2))));

                    var rotation = Math.round(degrees(angle(absCenterX, absCenterY, pos.x, pos.y)));
                    rotation -= realRotation;
                    
                    group.attrs.gradoRotacion = rotation;
                    group.setRotationDeg(rotation);
                    this.setX(grupo.attrs.width - this.attrs.width);
                    this.setY(0)
                }
            });
            //Añade Estilo Puntero
            anchor.on('mouseover', function() {
                document.body.style.cursor = 'pointer';
                this.setStrokeWidth(2);
                drawLayers();
            });
            anchor.on('mouseout', function() {
                document.body.style.cursor = 'default';
                this.setStrokeWidth(0);
                drawLayers();
            });
            break;
        case "blanco":
            break;
    }
    group.add(anchor);             
    drawLayers();
}

function radians(degrees) { return degrees * (Math.PI / 180); }
function degrees(radians) { return radians * (180 / Math.PI); }

// Calculate the angle between two points.
function angle(cx, cy, px, py) {
var x = cx - px;
var y = cy - py;
return Math.atan2(-y, -x);
}

// Calculate the distance between two points.
function distance(p1x, p1y, p2x, p2y) {
return Math.sqrt(Math.pow((p2x - p1x), 2) + Math.pow((p2y - p1y), 2));
}

function salvar(){
    limpiarTodosGrupos();
    stage.toDataURL({
        mimeType: "image/jpeg",
        quality: 1,
        callback: function(dataUrl) {
              window.open(dataUrl);
        }
      });
}

function visibilidadMnuprincipal() {
    var mnuprincipal = document.getElementById('mnuprincipal');
    var imagemnuprincipal = document.getElementById('imagenmnuprincipal');
    //var imageBtn = document.getElementById('btnimagenmnuprincipal');
    if (mnuprincipal.style.top == '0px' || mnuprincipal.style.top == '') {
        //imagemnuprincipal.style.top = 140;
        mnuprincipal.style.top = -147;
        document.getElementById('idCarousel').style.left = -205;
        document.getElementById('idBox').style.left = -205;
        document.getElementById('idText').style.left = -205;
        imagemnuprincipal.setAttribute("class", "fabajo");
        //imageBtn.innerHTML = '<img src="images/mnu_fabajo.png">';
    } else {
        //imagemnuprincipal.style.top = 133; 
        mnuprincipal.style.top = 0;
        //imageBtn.innerHTML = '<img src="images/mnu_farriba.png">';
        imagemnuprincipal.setAttribute("class", "farriba");
    } 
}

function visibilidadMnuopciones(type) {
    hideColorPicker();
    var mnuprincipal = document.getElementById('mnuprincipal');
    var imagemnuprincipal = document.getElementById('imagenmnuprincipal');
    var mnuimagen = document.getElementById('idCarousel');
    var mnubox = document.getElementById('idBox');
    var mnutext = document.getElementById('idText');
    switch(type){
        case 'image':
            if (mnuimagen.style.left == '0px' ) {
                mnuimagen.style.left = -205;
            } else {
                mnubox.style.left = -205;
                mnutext.style.left = -205;
                //console.log(mnuprincipal.style.top);
                if (mnuprincipal.style.top != '-147px'){
                    mnuimagen.style.left = 0;
                }
            }
            break;
        case 'box':
            if (mnubox.style.left == '0px' ) {
                mnubox.style.left = -205;
            } else {
                mnuimagen.style.left = -205;
                mnutext.style.left = -205;
                if (mnuprincipal.style.top != '-147px'){
                    mnubox.style.left = 0;
                }
            }
            break;
        case 'text':
            if (mnutext.style.left == '0px' ) {
                mnutext.style.left = -205;
            } else {
                mnuimagen.style.left = -205;
                mnubox.style.left = -205;
                if (mnuprincipal.style.top != '-147px'){
                    mnutext.style.left = 0;
                }
            }
            break;
        case 'all':
            mnuprincipal.style.top = -147;
            imagemnuprincipal.setAttribute("class", "fabajo");
            //imagemnuprincipal.style.top = 140;
            //imagemnuprincipal.innerHTML = '<img src="images/mnu_fabajo.png">';
            mnuimagen.style.left = -205;
            mnubox.style.left = -205;
            mnutext.style.left = -205;
            break;
    }
    
}

function visibilidadMnuEdit(type,valor){
    hideColorPicker();
    var mnuedit = document.getElementById('mnuedit');
    var mnueditfont = document.getElementById('opcFont');
    var mnuedittext = document.getElementById('opcText');
    switch (type) {
        case "image":
            break;
        case "forma":
            mnueditfont.style.display = "none";
            mnuedittext.style.display = "none";
            break;
        case "text":
            mnueditfont.style.display = "block";
            mnuedittext.style.display = "block";
            break;
    }
    
    if (valor == true && type != 'image'){
        document.getElementById('idFuentes').disabled = false;
        mnuedit.style.height = 50;
    }else{
        document.getElementById('idFuentes').disabled = true;
        mnuedit.style.height = 0;
    }

}

function rotate(image,angle){ // 90 or -90
    if(stage.getHeight() <= image.getWidth()){ 
        aspect = image.getWidth() / image.getHeight();
        height = stage.getHeight() / aspect;
        image.setWidth(stage.getHeight());
        image.setHeight(height);
    }
    image.setOffset(image.getWidth()/2,image.getHeight()/2);
    image.setPosition(stage.getWidth()/2,stage.getHeight()/2);
    image.rotateDeg(angle);
    layerimage.draw();
}

jQ(document).ready(function() {

    jQ('#mycarousel').jcarousel({
        // Configuration goes here
        vertical: true,
        //images: 10,
        //size: mycarousel_itemList.length,
        //itemLoadCallback: {onBeforeAnimation: mycarousel_itemLoadCallback}
    });
    jQ.getJSON(directorio+'/Carteles/getMyImages', setup);
    //jQ.getJSON(directorio+'/Carteles/getMyImages', jsonImages_LoadCallback);
    jQ('img[name=imagemenu]').on('dragstart', function(event){
        event.preventDefault();
    });

    jQ('a[name=ocmenu]').on('dragstart', function(event){
        event.preventDefault();
    });



    jQ('#imagenmnuprincipal').click(function(){
        visibilidadMnuprincipal();
    });

    jQ('#menu_image').click(function(){
        visibilidadMnuopciones('image');
    });

    jQ('#menu_box').click(function(){
        visibilidadMnuopciones('box');
    });

    jQ('#menu_text').click(function(){
        visibilidadMnuopciones('text');
    });

    jQ('#cltexto').click(function(){
        if (document.getElementById('mnuedit').style.height != '0px'){
            console.log(this);
            startColorPicker(this,'over','right','bottom');
        }
    });

    jQ('#cltexto').keyup(function(){
        if (document.getElementById('mnuedit').style.height != '0px'){
            maskedHex(this);
        }
    });

    jQ('#msgtexto').change(function(){
        if (document.getElementById('mnuedit').style.height != '0px'){
            actualizarColoryTexto();
        }
    });

    jQ('#idFuentes').change(function(e){
        if (document.getElementById('mnuedit').style.height != '0px'){
            actualizarColoryTexto();
        }
    });

    jQ('#btn_salvar').click(function(){
        //salvar();
        limpiarTodosGrupos();
        openSubWin(directorio+'/carteles/addCartel',700,300,2,'Guardar Cartel:');return false;
    });

    jQ('#btn_cerrar').click(function(){
        if (confirm('¿Estás segur de que deseas cerrar la ventana?')) {
            window.close();
        }
    });
});

var setup = function(data) {
            var html = '';
            jQ('#mycarousel').jcarousel({
                size: data.length,
            });
            jQ.each(data, function(pos, item){
                
                html+= '<li class="jcarousel-item jcarousel-item-vertical jcarousel-item-'+item.pos+' jcarousel-item-'+item.pos+'-vertical" jcarouselindex="'+item.pos+'" style="float: left; list-style: none;"><img src="' + item.url_fotograma + '" width="'+item.width+'" height="'+item.height+'" alt="' + item.url + '" id="image_id'+item.id+'" name="imagebar" ></img></li>';
                console.log(html);
                
            });
            jQ('#mycarousel').html(html);


            // Append items
           

            // Reload carousel
            jQ('#mycarousel')
                .jcarousel('reload');
        };



/**
 * Item html creation helper.
 */
 
function mycarousel_getItemHTML(item)
{
    return '<li class="jcarousel-item jcarousel-item-vertical jcarousel-item-'+item.pos+' jcarousel-item-'+item.pos+'-vertical" jcarouselindex="'+item.pos+'" style="float: left; list-style: none;"><img src="' + item.url + '" width="'+item.width+'" height="'+item.height+'" alt="' + item.url + '" id="image_id'+item.id+'" name="imagebar" /></li>';
};