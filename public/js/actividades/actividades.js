                     var mytime = $('#timepicker1')[0];
                     if(mytime.type !== 'time') {//if browser doesn't support "time" input
                        $(mytime).timepicker({
                        minuteStep: 1,
                        showSeconds: true,
                        showMeridian: false
                        })
                     }