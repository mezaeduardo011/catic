var BASE_URL = "http://localhost/catic/"; 

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


 $(document).ready(function() {
            $('#fecha').datepicker({
        clearBtn: true,
        autoclose: true,
        language: "es",
        daysOfWeekHighlighted: "0,1,2,3,4,5,6",
        todayHighlight: true
    })
 });


