function showElementos(divName){
	hide(divName,0);
		show(divName, 1000);	
}

function hiddenElementos(divName){
	hide(divName,500);
}

function send_registro_persona() {
            //alert("/catic/personal/insertPerson?"+request(document.getElementById('divPersona')));

     if (request(document.getElementById('divPersona'))!="") {
     	 send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('divPersona')), null,true);
     };
     if (request(document.getElementById('infoHijos'))!="") {
     	 send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('infoHijos')), null,true);
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
	 return false;
}



