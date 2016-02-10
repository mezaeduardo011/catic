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

    function format(input)
{
var num = input.value.replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
input.value = num;
}
  
else{ alert('Solo se permiten numeros');
input.value = input.value.replace(/[^\d\.]*/g,'');
}
}   