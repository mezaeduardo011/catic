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
     var selector = function(dateStr) {         
	      		desde = $('#tipo_amonestacion').val();
	      		dias = $('#coordinacion').val();
	     		$.post(
	         		BASE_URL+"amonestacion/confirmacionAjax", 
	     			{ tipo_amonestacion: desde, coordinacion: dias},
	     			function(data){
	     				alert(data['tipo_amonestacion_confirmacion']);
	     		 		$('#tipo_amonestacion_confirmacion').val(data['tipo_amonestacion_confirmacion']);
	     		 		$('#reincorporacion_confirmacion').val(data['coordinacion_confirmacion']);
	     			}, 
	     			"json");
     }
     $('#tipo_amonestacion,#coordinacion').change(selector)
 });