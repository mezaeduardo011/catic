 
var BASE_URL = "http://localhost/catic/"; 

 $('#fecha_solicitud').datepicker({
     clearBtn: true,
     autoclose: true,
     language: "es",
     daysOfWeekHighlighted: "0,1,2,3,4,5,6",
     todayHighlight: true,
	datesDisabled: ['2016/02/24', '2016/02/25']
 });

 $('#desde').datepicker({
     clearBtn: true,
     language: "es",
     daysOfWeekHighlighted: "0,1,2,3,4,5,6",
     autoclose: true,
     todayHighlight: true,
     format: "yyyy/mm/dd",
 });


 $(document).ready(function() {
     var selector = function(dateStr) {         
	      		desde = $('#desde').val();
	      		dias = $('#dias_habiles').val();
	     		$.post(
	         		BASE_URL+"vacaciones/CalcularDiasHabiles", 
	     			{ desde: desde, dias: dias},
	     			function(data){
	     		 		$('#hasta').val(data['fechaHasta']);
	     		 		$('#reincorporacion').val(data['fecha_reincorporacion']);
	     			}, 
	     			"json");
     }
     $('#desde,#dias_habiles').change(selector)
 });


