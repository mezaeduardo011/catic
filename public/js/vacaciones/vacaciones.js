 $('#fecha_solicitud').datepicker({
     clearBtn: true,
     autoclose: true,
     language: "es",
     daysOfWeekHighlighted: "0,1,2,3,4,5,6",
     todayHighlight: true,
	datesDisabled: ['2016/02/24', '2016/02/25']
 });

 $('.input-daterange').datepicker({

     clearBtn: true,
     language: "es",
     daysOfWeekHighlighted: "0,1,2,3,4,5,6",
     autoclose: true,
     todayHighlight: true,
     datesDisabled: ['25/02/2016', '26/02/2016','27/02/2016'],


 });


 $(document).ready(function() {
     var selector = function(dateStr) {
         var d1 = $('#desde').datepicker('getDate');
         var d2 = $('#hasta').datepicker('getDate');
         $('#desde').datepicker("option", "maxDate", d2);            
         $('#hasta').datepicker("option", "minDate", d1); 
         var diff = 1;
         if (d1 && d2) {
             diff = diff + Math.floor((d2.getTime() - d1.getTime()) / 86400000);
         }
         $('#dias_habiles').val(diff);

     }

     $('#desde,#hasta').change(selector)
 });