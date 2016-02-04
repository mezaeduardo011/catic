function showElementos(divName){
	hide(divName,0);
		show(divName, 1000);	
}

function hiddenElementos(divName){
	hide(divName,0);
}

function send_registro_persona() {

     //alert("/catic/personal/insertPerson?"+request(document.getElementById('infoPadreUnico')));

     if (request(document.getElementById('divPersona'))!="") {
     	 send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('divPersona')), null,true);
     };
     if (request(document.getElementById('infoHijos'))!="") {
     	 send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('infoHijos')), null,true);
     };    
     if (request(document.getElementById('infoPadre'))!="") {
       send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('infoPadre')), null,true);
     };
     if (request(document.getElementById('infoMadre'))!="") {
       send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('infoMadre')), null,true);
     };     
     if (request(document.getElementById('infoPadreUnico'))!="") {
       send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('infoPadreUnico')), null,true);
     };      
   
}


function response_registro_persona(response) {
    alert("Registro exitoso");

}

function send_consulta_hijo(id) {
     	   send_ajax('POST', '../../catic/personal/getHijos', 'response_consulta_hijo','Familiar - Hijo', null,true);
}


function response_consulta_hijo(response) {
	//alert(response[0]['nombre']);
	 var tbl = document.getElementById('tablaHijosAdd');
	 	 var len= response.length;
		 var lastRow, row, nombre, nombre2, apellido, apellido2, sexo, edad;
		 if (borrar_datos_tabla('tablaHijosAdd')) {
        for (var i = 0; i < len; i++) {
		    lastRow = tbl.rows.length;
            row = tbl.insertRow(lastRow);
         	nombre = row.insertCell(0);
			nombre2 = row.insertCell(1);
			apellido = row.insertCell(2);
			apellido2 = row.insertCell(3);
			sexo = row.insertCell(4);
			edad = row.insertCell(5);
		    nombre.innerHTML = response[i]['nombre'];
		    nombre2.innerHTML = response[i]['nombre2'];
		    apellido.innerHTML = response[i]['apellido'];
		    apellido2.innerHTML = response[i]['apellido2'];
		    sexo.innerHTML = response[i]['sexo'];	 
		    edad.innerHTML = response[i]['edad'];	 
    	}
	};
	 return false;
}



function send_consulta_info(id) {
     	   send_ajax('POST', '../../catic/personal/getInfoDatos', 'response_consulta_info','Familiar - Hijo', null,true);
     	   showElementos('infoDatosDiv');
}


function response_consulta_info(response) {

	 	 var tbl = document.getElementById('infoDatos');

		 if (borrar_datos_tabla('infoDatos')){
	 	 var len= response.length;
		 var lastRow, row, nombre,apellido,espacio;     
	    lastRow = tbl.rows.length;
        row = tbl.insertRow(lastRow);
     	nombre = row.insertCell(0);
     	espacio = row.insertCell(1);
     	apellido = row.insertCell(2);
	    nombre.innerHTML = response[i]['nombre']; 
	    espacio.innerHTML = '&nbsp;&nbsp;&nbsp;'
	    apellido.innerHTML = response[i]['apellido']; 
		}

	 return false;
}


function response_detalle_solicitud(response) {
    var tbl = document.getElementById('tabla_detalle_solicitud');

    if (response == '') {
        if (borrar_tabla_detalle('tabla_detalle_solicitud')) {
            var tr = document.createElement('tr');
            tr.style.align = 'center';
            var cell = document.createElement('td');
            cell.align = 'center';
            cell.width = 'auto';
            cell.setAttribute('colspan', '11');
            var node = document.createTextNode('No se encontro el producto solicitado');
            cell.appendChild(node);
            tr.appendChild(cell);
            tbl.tBodies[0].appendChild(tr);

        }
    } else {

        if (borrar_tabla_detalle('tabla_detalle_solicitud')) {
            var i = 0;
            var lista = response.split('|%');
            for (i = 0; i < lista.length; i++) {
                var campos = lista[i].split('#');
                tbl.tBodies[0].appendChild(addRowDatosSeleccion2(campos));
                 paintTRsClearDark('tabla_detalle_solicitud');
            }

        }
    }
    vista_preliminar();
}



function addRowDatosSeleccion2(row) {
    var tam = new Array();
        tam[0]='25px';
        tam[1]='191px';
        tam[2]='310px';
        tam[3]='325px';
        tam[4]='350px';
        tam[5]='102px';
        tam[6]='102px';
    

    var tr = document.createElement('tr');
   
    tr.style.align = 'center';
    var cell = new Array();
    var node = new Array();
    tr.setAttribute('id',row[0]);
    
    
    var j=0;
    for (var i = 1; i < row.length; i++) {
        cell[j] = document.createElement('td');
        cell[j].align = 'center';
        cell[j].setAttribute('style','min-width: '+tam[j]+'; max-width: '+tam[j]/*+'color: BA3131;'+' color: BA3131'*/);

        
        
            node[j] = document.createTextNode(row[i]);
            cell[j].appendChild(node[j]);
            tr.appendChild(cell[j]);  
            j++;
     
    }
    return tr;
}


function deleteRow(rowIndex) {
 var table = document.getElementById('tablaHijosAdd')
 table.deleteRow(rowIndex);
 return true;
}

function borrar_datos_tabla(id_tabla) {
    var tbl = document.getElementById(id_tabla);
    for (var i = 0; i < tbl.rows.length;) {
        tbl.deleteRow(tbl.rows[i].rowIndex);
    }
    return true;
}

  function letras(e) { // 1
  tecla = (document.all) ? e.keyCode : e.which; // 2
  if (tecla==8) return true; // 3
  if (tecla==9) return true; // 3
  if (tecla==11) return true; // 3
  patron = /[A-Za-zñÑ'áéíóúÁÉÍÓÚàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛÑñäëïöüÄËÏÖÜ\s\t]/; // 4
  
  te = String.fromCharCode(tecla); // 5
  return patron.test(te); // 6
  } 
  function numeros(e) {
  k = (document.all) ? e.keyCode : e.which;
  if (k==8 || k==0) return true;
  patron = /\d/;
  n = String.fromCharCode(k);
  return patron.test(n);
  }    