

function send_actualizar_persona() {
            //alert("/catic/personal/insertPerson?"+request(document.getElementById('divPersona')));

            send_ajax('POST', '../../catic/personal/insertPerson', 'response_actualizar_persona',  request(document.getElementById('divPersona')), null,true);
}


function response_actualizar_persona(response) {
    alert("Registro exitoso");
}