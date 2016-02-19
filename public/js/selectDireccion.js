$(document).ready(

    function() {

        var BASE_URL = "http://localhost/catic/"; //base url en javascript 

        $.ajax({
            url: BASE_URL + 'personal/SelectEstado', //apuntamos a persons/loadSexo
            type: 'POST',
            dataType: 'json',
        })

        .done(function(data) { // si todo funciona
            $('#estado').empty();
            $('#estado').append('<option value="">Seleccione un estado...</option>');
            for (var i = 0; i < data.length; i++) {
                $('#estado').append('<option value="' + data[i].value + '">' + data[i].option + '</option>');
            }
            $('#estado').selectpicker('refresh');
        })

        .fail(function() { //si da error decimos error
            alert("Error cargando los estados");
        });

        var idSelectestado = '#estado';
        var selectDepen3 = $("#municipio");

        $($('#estado')).change(function() {
            $(idSelectestado + ' option:selected').each(function() {
                selected = $(this).val();
                var select = $(selectDepen3);
                select.append('<option value="">Seleccione un municipio...</option>');

                $.post(

                    BASE_URL + "personal/SelectMunicipio", {
                        selected: selected
                    },

                    function(data) {
                        select.empty();
                        select.append('<option value="">Seleccione un municipio...</option>');
                        for (var i = 0; i < data.length; i++) {
                            select.append('<option value="' + data[i].id + '">' + data[i].option + '</option>');
                        }

                        $('#municipio').selectpicker('refresh');
                    },

                    "json");

            });
        });

        var idSelect9 = '#municipio';
        var selectDepen2 = $("#direccion");

        $(selectDepen3).change(function() {

            $(idSelect9 + ' option:selected').each(function() {
                selected = $(this).val();
                var select = $(selectDepen2);

                $.post(
                    BASE_URL + "personal/SelectParroquia", {
                        selected: selected
                    },

                    function(data) {
                        select.empty();
                        select.append('<option value="">Seleccione...</option>');

                        for (var i = 0; i < data.length; i++) {
                            select.append('<option value="' + data[i].id + '">' + data[i].option + '</option>');
                        }

                        $('#direccion').selectpicker('refresh');
                    },

                    "json");
            });
        });

        $.ajax({
            url: BASE_URL + 'personal/SelectCargo', //apuntamos a persons/loadSexo
            type: 'POST',
            dataType: 'json',
        })

        .done(function(data) { // si todo funciona
            $('#cargo').empty();
            $('#cargo').append('<option value="">Seleccione un cargo...</option>');
            for (var i = 0; i < data.length; i++) {
                $('#cargo').append('<option value="' + data[i].value + '">' + data[i].option + '</option>');
            }
            $('#cargo').selectpicker('refresh');
        })

        .fail(function() { //si da error decimos error
            alert("Error cargando los estados");
        });

        $.ajax({
            url: BASE_URL + 'personal/SelectCoordinaciones', //apuntamos a persons/loadSexo
            type: 'POST',
            dataType: 'json',
        })

        .done(function(data) { // si todo funciona
            $('#coordinacion').empty();
            $('#coordinacion').append('<option value="">Seleccione una coordinacion...</option>');
            for (var i = 0; i < data.length; i++) {
                $('#coordinacion').append('<option value="' + data[i].value + '">' + data[i].option + '</option>');
            }
            $('#coordinacion').selectpicker('refresh');
        })

        .fail(function() { //si da error decimos error
            alert("Error cargando las coordinaciones");
        });


    });

