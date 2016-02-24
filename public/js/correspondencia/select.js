
$(document).ready(

	function() { 

		var BASE_URL = "http://localhost/catic/"; 
		$.ajax({
			url: BASE_URL +'correspondencia/selectCarpetas', 
			type: 'POST',
			dataType: 'json',		
		})

		.done(function(data) {		
			$('#carpetas').empty();
			$('#carpetas').append('<option value="">Seleccione una carpeta...</option>');
			for (var i=0; i<data.length; i++) {
				$('#carpetas').append('<option value="'+ data[i].value+'">'+data[i].option +'</option>');
			}	
			$('#carpetas').selectpicker('refresh');
		})

		.fail(function() {
			alert("Error cargando las coordinaciones");
		});



});		