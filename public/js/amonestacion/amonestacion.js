// $(document).ready(function() {
//     $('input[type=checkbox]').live('click', function(){
//         var parent = $(this).parent().attr('id');
//         $('#'+parent+' input[type=checkbox]').removeAttr('checked');
//         $(this).attr('checked', 'checked');
//     });
// });
function send_info_registro() {
	//alert("/catic/amonestacion/confirmacion?"+request(document.getElementById('info_registro')));
    send_ajax('POST', '../../catic/amonestacion/confirmacion', 'response_registro_persona', request(document.getElementById('info_registro')), null, true);
}

function response_registro_persona(response) {
   alert("Registro Exitoso");

}