var pickControl = null;
var idControl = null;
var tot = null;

/** Componente reutilizable que llama, abre y carga en pantalla 
* una página independiente al documento para una consulta específica.
* Vea también: {@link showBox}, {@link showBoxAux}, {@link closePickList}, {@link pickClose}, {@link closeBox}, 
* {@link selectItemSimple}, {@link chkThis}, {@link selectItemMultiple}, {@link chkThese}, {@link rowOn}, 
* {@link rowOff}, {@link moveBox}, {@link pickSelect} y {@link isIE}.
* @param id string Identificador del elemento que guardará el valor esperado de la consulta.
* @param idCtl string Identificador del elemento que guardará la descripción esperada de la consulta.
* @param url string Ubicación de la página más el nombre y argumentos de busqueda (si los tiene).
* @param ancho integer Ancho que tendrá el elemento DIV en la pantalla.
* @param altura integer Altura que tendrá el elemento DIV en la pantalla.
* @param cleft integer Pocisión izquierda que desea que tenga el elemento DIV en la pantalla.
* @param ctop integer Pocisión superior que desea que tenga el elemento DIV en la pantalla.
* @param scroll string Si coloca 'yes' el DIV será escroleado, de lo contrario, coloque null.*/		
function pickOpen(id, idCtl, url, ancho, altura, cleft, ctop, scroll){
	if (pickControl!=null)
		pickClose();
	pickControl = id;
	idControl = idCtl;
	showBox(pickControl, ancho, altura, url, cleft, ctop, scroll);
}

/** Crea y muestra un DIV que contenga un IFRAME y posicionar el DIV con su contenido.
* Vea también: {@link showBoxAux}, {@link pickOpen}, {@link closePickList}, {@link pickClose}, {@link closeBox}, 
* {@link selectItemSimple}, {@link chkThis}, {@link selectItemMultiple}, {@link chkThese}, {@link rowOn}, 
* {@link rowOff}, {@link moveBox}, {@link pickSelect} y {@link isIE}.
* @param objID string Identificador del elemento que guardará el valor esperado de la consulta.
* @param width integer Ancho que tendrá el elemento DIV en la pantalla.
* @param height integer Altura que tendrá el elemento DIV en la pantalla.
* @param url string Ubicación de la página más el nombre y argumentos de busqueda (si los tiene).
* @param cleft integer Pocisión izquierda que desea que tenga el elemento DIV en la pantalla.
* @param ctop integer Pocisión superior que desea que tenga el elemento DIV en la pantalla.
* @param scroll string Si coloca 'yes' el DIV será escroleado, de lo contrario, coloque null.
* @return false*/		
function showBox(objID, width, height, url, cleft, ctop, scroll){
	//Original author: JTricks.com :: http://www.jtricks.com/ 

	var obj = document.getElementById(objID);
	var newID = objID + "_popup";
	var borderStyle = "lightgrey 4px solid"
	var boxdiv = document.getElementById(newID);                

        if ( cleft != 0 && ctop != 0 )
		show('id_fondo_opaco', 0);//document.getElementById('id_fondo_opaco').style.display='block';//
       
	if (boxdiv != null){
		if (boxdiv.style.display=='none'){
                    
	    		if (url!=null)
				showBoxAux(objID,url);
			moveBox(obj, boxdiv, cleft, ctop);
			//boxdiv.style.display='block';    
			show(newID,'slow', 200); 
			                   
		} 
		else
		hide(newID, 100);//	boxdiv.style.display='none';
		return false;
	}

	boxdiv = document.createElement('div');
        boxdiv.setAttribute('class', 'ventana_modal_catalogo');
	boxdiv.setAttribute('id', newID);
        boxdiv.style.display = 'none';        
        boxdiv.style.position = ( cleft == 0 && ctop == 0 )?'absolute':'fixed';
	boxdiv.style.width = width + '%';
	boxdiv.style.height = height + '%';
	boxdiv.style.border = borderStyle;
       // boxdiv.blur=closePickList();

        //background:transparent;
	boxdiv.style.backgroundColor = '#F7F7F7';
	boxdiv.style.padding = "0px";
	
	var contents = document.createElement('iframe');
        //contents.AllowTransparency='true';
	contents.frameBorder = '0';
	contents.style.width = '100%';
	contents.style.height = '100%';
        if ( cleft != 0 && ctop != 0 ){
            contents.marginHeight = 0;
            contents.marginWidth = 0;
        }
        else{
            contents.marginHeight = 0;
            contents.marginWidth = 0;
        }
	contents.setAttribute('id', objID + "_iframe");
	contents.setAttribute('name', objID + "_iframe");
        if ( cleft == 0 && ctop == 0 )
                contents.setAttribute('onmouseout', 'closePickList()');
	boxdiv.appendChild(contents);
	document.body.appendChild(boxdiv);
        
	if (url!=null)
		showBoxAux(objID,url);
            
	moveBox(obj, boxdiv, cleft, ctop);

	show(newID,300);
	//boxdiv.style.display = 'block';
 	return false;

}	

/** Auxiliar de {@link showBox}.
* Vea también: {@link pickOpen}, {@link closePickList}, {@link pickClose}, {@link closeBox}, 
* {@link selectItemSimple}, {@link chkThis}, {@link selectItemMultiple}, {@link chkThese}, {@link rowOn}, 
* {@link rowOff}, {@link moveBox}, {@link pickSelect} y {@link isIE}.
* @param objID string Identificador del elemento que guardará el valor esperado de la consulta.
* @param url string Ubicación de la página más el nombre y argumentos de busqueda (si los tiene).*/
function showBoxAux(objID,url){
	var f = window.frames[objID + "_iframe"];
	f.document.open();
	f.document.write("<center>");
	f.document.write("<br><br>");
	f.document.write("<img src='../catic/public/img/search.png'>");
	f.document.write("<span style='padding-left:10px;font-family:Arial;font-size:9pt;font-weight:bold'>Por favor espere...</span>");
	f.document.write("</center>");
	f.document.close();
	f.location = url;
}

/** Implementa la función {@link pickClose}
* Vea también: {@link pickOpen}, {@link showBox}, {@link showBoxAux}, {@link closePickList}, {@link closeBox}, 
* {@link selectItemSimple}, {@link chkThis}, {@link selectItemMultiple}, {@link chkThese}, 
* {@link rowOn}, {@link rowOff}, {@link moveBox}, {@link pickSelect} y {@link isIE}.*/
function closePickList(){
	parent.pickClose();
}

/** Cierra una ventana pickList.
* Vea también: {@link closePickList},  {@link pickOpen}, {@link showBox}, {@link showBoxAux}, {@link closePickList},
* {@link closeBox}, {@link selectItemSimple}, {@link chkThis}, {@link selectItemMultiple}, {@link chkThese}, 
* {@link rowOn}, {@link rowOff}, {@link moveBox}, {@link pickSelect} y {@link isIE}.*/
function pickClose(){
	closeBox(pickControl);
	idControl = null;
	pickControl = null;       
        hide('id_fondo_opaco','slow', 600);// document.getElementById('id_fondo_opaco').style.display='none';
}

/** Esconde un DIV que contenga un IFRAME y posicionar el DIV con su contenido.
* Vea también: {@link showBox}, {@link closePickList},  {@link pickOpen}, {@link showBoxAux}, {@link closePickList},
* {@link selectItemSimple}, {@link chkThis}, {@link selectItemMultiple}, {@link chkThese}, {@link rowOn}, 
* {@link rowOff}, {@link moveBox}, {@link pickSelect} y {@link isIE}.*/
function closeBox(objID){//Esconde un DIV + IFRAME abierto con la funcion showBox();
	var obj = document.getElementById(objID);
	if (!obj.readonly)
		obj.focus();		
        hide(objID + "_popup", 400);//document.getElementById(objID + "_popup").style.display = "none";
}

/** Selecciona un Item de la consulta del pickList.
* Vea también: {@link pickOpen}, {@link showBox}, {@link showBoxAux}, {@link closePickList}, {@link closePickList},
* {@link closeBox}, {@link chkThis}, {@link selectItemMultiple}, {@link chkThese}, {@link rowOn}, 
* {@link rowOff}, {@link moveBox}, {@link pickSelect} y {@link isIE}.*/
function selectItemSimple(id,objInput){
	var descripcion = document.getElementById(id);
	parent.pickSelect(id, descripcion.innerHTML, chkThis(id));
	closePickList();	
}

/** Auxiliar de {@link selectItemSimple}.
* Vea también: {@link pickOpen}, {@link showBox}, {@link showBoxAux}, {@link closePickList}, {@link closePickList},
* {@link closeBox}, {@link selectItemMultiple}, {@link chkThese}, {@link rowOn}, {@link rowOff}, {@link moveBox}, 
* {@link pickSelect} y {@link isIE}.*/
function chkThis(aidi){
	document.getElementById("abc").value=aidi;
	return document.getElementById("abc").value;
}

/** Selecciona multiples Items de la consulta del pickList.
* Vea también: {@link pickOpen}, {@link showBox}, {@link showBoxAux}, {@link closePickList}, {@link closePickList},
* {@link closeBox}, {@link chkThis}, {@link selectItemSimple}, {@link chkThese}, {@link rowOn}, 
* {@link rowOff}, {@link moveBox}, {@link pickSelect} y {@link isIE}.*/
function selectItemMultiple(id,objInput){
	var descripcion = document.getElementById(id);
	parent.pickSelect(id, descripcion.innerHTML, chkThese(objInput, id));
}

/** Auxiliar de {@link selectItemMultiple}.
* Vea también: {@link pickOpen}, {@link showBox}, {@link showBoxAux}, {@link closePickList}, {@link closePickList},
* {@link closeBox}, {@link selectItemMultiple}, {@link chkThis}, {@link rowOn}, {@link rowOff}, {@link moveBox}, 
* {@link pickSelect} y {@link isIE}.*/
function chkThese(obj, aidi){
	if (obj.checked==true)
		document.getElementById("abc").value+=aidi+';';
	else if(obj.checked==false)
		document.getElementById("abc").value=document.getElementById("abc").value.replace(aidi+';',"");
	return document.getElementById("abc").value;
}

/** Posiciona un DIV en un lugar deseado o justo debajo de un control de formulario, alineado a la izquierda.
* Vea también: {@link showBoxAux}, {@link showBoxAux}, {@link pickOpen}, {@link closePickList}, 
* {@link pickClose}, {@link closeBox}, {@link selectItemSimple}, {@link chkThis}, {@link selectItemMultiple}, 
* {@link chkThese}, {@link rowOn}, {@link rowOff}, {@link moveBox}, {@link pickSelect} y {@link isIE}.
* @param element object Elemento que representa al control.
* @param box object Elemento que representa al DIV.
* @param cleft integer Pocisión izquierda que desea que tenga el elemento DIV en la pantalla.
* @param ctop integer Pocisión superior que desea que tenga el elemento DIV en la pantalla.*/	
function moveBox(element, box, cleft, ctop){//NOTE:	Original author: JTricks.com :: http://www.jtricks.com/

	var offset = 3;
	if (isIE())
		offset = -13;

	var obj = element;

        if (cleft==0 && ctop==0){
            while (obj.offsetParent) {
                cleft += obj.offsetLeft;
	    	ctop += obj.offsetTop;
	    	obj = obj.offsetParent;
            }
        }

	box.style.left = cleft + 'px';
	ctop += element.offsetHeight + offset;
	
	if (document.body.currentStyle && document.body.currentStyle['marginTop']){
		ctop += parseInt(
	      	document.body.currentStyle['marginTop']);
	}

	box.style.top = ctop + 'px';

}

/** Selecciona de la consulta del pickList.
* Vea también: {@link pickOpen}, {@link showBox}, {@link showBoxAux}, {@link closePickList}, {@link closePickList},
* {@link closeBox}, {@link chkThis}, {@link selectItemSimple}, {@link chkThese}, {@link selectItemSimple}, 
* {@link rowOn}, {@link rowOff}, {@link moveBox} y {@link isIE}.
* @param id string Valor identificativo que se guardará en el elemento esperado de la consulta.
* @param description string Valor descriptivo que se guardará en el elemento esperado de la consulta.*/
function pickSelect(id, description){
	document.getElementById(idControl).value = id;
	document.getElementById(pickControl).value = description;
}

/**Retorna TRUE si el navegador es Internet Explorer.
* Vea también: {@link pickOpen}, {@link showBox}, {@link showBoxAux}, {@link closePickList}, {@link pickClose}, 
* {@link closeBox}, {@link selectItemSimple}, {@link chkThis}, {@link selectItemMultiple}, {@link chkThese}, 
* {@link rowOn}, {@link rowOff}, {@link moveBox} y {@link pickSelect}.
* @return TRUE si el navegador es Internet Explorer de lo contrario retorna FALSE.*/
function isIE(){ 
	return (navigator.appName.indexOf("Explorer")>0)?true:false;
}

var currStyle="";
function rowOn(obj) {
	currStyle = obj.className;
	obj.className="hilite";
}
function rowOff(obj) {
	obj.className=currStyle
}
/*function pickOpen2(num,id, idCtl, url, ancho, altura){	
	if (pickControl!=null)
		pickClose();			
	pickControl = id;
	idControl = idCtl;
	tot = num;	
	showBox(pickControl, ancho, altura, url);
}*/

//    * firstChild: primer hijo
//    * lastChild: último hijo
//    * childNodes: array de los hijos del nodo
//    * parentNode: nodo padre
//    * nextSibling: siguiente hijo
//    * prevSibling: hijo anterior



function show(idObj, effectType, time){//effectType can be:'blind','bounce','clip','drop','explode','fold','highlight','puff','pulsate','scale','shake','size' ó 'slide'
    if (effectType=='slow' || IsNumeric(effectType))//The function 'IsNumeric' are in FDSoil/js/numero.js
        $( "#"+idObj ).fadeIn(effectType);     
    else{
        var options = {};// most effect types need no options passed by default
        if (effectType=='scale')
            options = { percent: 0 };        
        else if (effectType=='size')
            options = { to: { width: 200, height: 60 }};        
        $( "#"+idObj ).show( effectType, options, time); 
    }
}

function hide(idObj, effectType, time){//effectType can be:'blind','bounce','clip','drop','explode','fold','highlight','puff','pulsate','scale','shake','size' ó 'slide'
    if (effectType=='slow' || IsNumeric(effectType))//The function 'IsNumeric' are in FDSoil/js/numero.js
        $( "#"+idObj ).fadeOut(effectType);     
    else{
        var options = {};// most effect types need no options passed by default
        if (effectType=='scale')
            options = { percent: 0 };        
        else if (effectType=='size')
            options = { to: { width: 200, height: 60 }};        
        $( "#"+idObj ).hide( effectType, options, time); 
    }
}

function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
