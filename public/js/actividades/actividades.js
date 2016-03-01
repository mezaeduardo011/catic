                     var mytime = $('#hora')[0];
                     if(mytime.type !== 'time') {//if browser doesn't support "time" input
                        $(mytime).timepicker({
                        minuteStep: 1,
                        showSeconds: true,
                        showMeridian: false
                        })
                     }

$('#fecha_actividad').datepicker({
    clearBtn: true,
    autoclose: true,
    language: "es",
    daysOfWeekHighlighted: "0,1,2,3,4,5,6",
    todayHighlight: true,
});                     