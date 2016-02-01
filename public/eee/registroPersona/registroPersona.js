function crearDivHijos(divName,NumDiv){
	var i = 0;
	hide(divName,0);
		show('infoHijos', 0);
		 
	
}

function cerrarDivHijos(divName,NumDiv){
	var i = 0;
		hide('infoHijos', 0);
		
}



function send_registro_persona() {
            //alert("/catic/personal/insertPerson?"+request(document.getElementById('divPersona')));

            send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona',  request(document.getElementById('divPersona')), null,true);
}


function response_registro_persona(response) {
    alert("Registro exitoso");
}


function search_municipio(id_estado) {
            //alert("/catic/personal/selectMun?"+'id_estado='+id_estado);
            send_ajax('POST', '../../catic/personal/index', 'response_search_municipio',  'id_estado='+id_estado, null,true);
}


function response_search_municipio(response) {
    alert("Registro exitoso");
}

