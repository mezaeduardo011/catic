function showElementos(divName){
	var i = 0;
	hide(divName,0);
		show(divName, 1500);
	
}

function cerrarDivHijos(divName){
	var i = 0;
	hide(divName,0);
	switch(divName){
		case 'infoHijos':
		hide('infoHijos', 1500);
		  break;  
	}
}

function send_registro_persona() {
            //alert("/catic/personal/insertPerson?"+request(document.getElementById('divPersona')));

     if (request(document.getElementById('divPersona'))!="") {
     	 //send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('divPersona')), null,true);
     };
     if (request(document.getElementById('infoHijos'))!="") {
     	 send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('infoHijos')), null,true);
     };     
   
}


function response_registro_persona(response) {
    alert("Registro exitoso");
}

function send_consulta_hijo(id) {
     	   //send_ajax('POST', '../../catic/personal/getHijos', 'response_consulta_hijo','Familiar - Hijo', null,true);
}


function response_consulta_hijo(response) {
	alert(response);
}
