function send_correspondencia() {
    alert("/catic/correspondencia/registro_correspondencia?" + request(document.getElementById('correspondencia')));
    if (request(document.getElementById('correspondencia')) != "") {
        send_ajax('POST', '../../catic/correspondencia/registro_correspondencia', 'response_registro_correspondencia', request(document.getElementById('correspondencia')), null, true);
    };
}


function response_registro_correspondencia(response) {
    

}
 



