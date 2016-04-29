    persona = document.getElementById('persona_empleada_auxiliar');
    sexo = document.getElementById('sexo_empleado');
    cargo = document.getElementById('cargo');
    coordinacion = document.getElementById('coordinacion');
    estado = document.getElementById('estado');
    municipio = document.getElementById('municipio');
    parroquia = document.getElementById('direccion');

    $.ajax({
        type: 'post',
        dataType: 'json',
        url: BASE_URL +'personal/getInfoDatos',
        data: {id_persona: persona.value},
        success: function(json){
            LlenarDatos(json,sexo,cargo,coordinacion,estado,municipio,parroquia);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            alert(textStatus);
        }
    });

    function LlenarDatos(text,destino,destino2,destino3,destino4,destino5,destino6){
        //alert(''+JSON.stringify(text));       
        //alert(text.sexo_referencial);
        seleccionar_sexo(text.sexo);
        llenar_cargo(text.cargo);
        llenar_coordinacion(text.coordinacion);
        llenar_direccion(text.direccion,text.municipio,text.estado);


    }

    function seleccionar_sexo(sexo){
        var checkbox = document.getElementsByName('sexos');
        if(sexo!=null){
            if (sexo==17) {
                checkbox[1].checked = true;
            }
            if(sexo==16){
                checkbox[0].checked = true;
            }
        }                
    }

    function llenar_cargo(cargo){
        $.ajax({
            url: BASE_URL +'personal/SelectCargo', 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(datos) { 
            $('#cargo').empty();
            $('#cargo').append('<option value="">Seleccione un cargo...</option>');
            for (var i=0; i<datos.length; i++) {
                if (datos[i].value==cargo) {
                    $('#cargo').append('<option  selected="selected" value="'+ datos[i].value+'">'+datos[i].option +'</option>');
                }else{
                    $('#cargo').append('<option value="'+ datos[i].value+'">'+datos[i].option +'</option>');
                }

            }   
            $('#cargo').selectpicker('refresh');
        })

        .fail(function() {
            alert("Error cargando el cargo");
        });
    }

    function llenar_coordinacion(coordinacion){
        $.ajax({
            url: BASE_URL +'personal/SelectCoordinaciones', 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { 
            $('#coordnacion').empty();
            $('#coordinacion').append('<option value="">Seleccione una coordinacion...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].value==coordinacion) {
                    $('#coordinacion').append('<option  selected="selected" value="'+ data[i].value+'">'+data[i].option +'</option>');
                }else{
                    $('#coordinacion').append('<option value="'+ data[i].value+'">'+data[i].option +'</option>');
                }

            }   
            $('#coordinacion').selectpicker('refresh');
        })

        .fail(function() {
            alert("Error cargando las coordinaciones");
        });
    
    }    

     function llenar_direccion(parroquia,municipio,estado){
        $.ajax({
            url: BASE_URL +'personal/SelectEstado', 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { 
            $('#estado').empty();
            $('#estado').append('<option value="">Seleccione un estado...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].option==estado) {
                    $('#estado').append('<option  selected="selected" value="'+ data[i].value+'">'+data[i].option +'</option>');
                }else{
                    $('#estado').append('<option value="'+ data[i].value+'">'+data[i].option +'</option>');
                }

            }   
            $('#estado').selectpicker('refresh');
        })

        .fail(function() {
            alert("Error cargando el estado");
        });

        $.ajax({
            url: BASE_URL +'personal/SelectMunicipioGeneral', 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { 
            $('#municipio').empty();
            $('#municipio').append('<option value="">Seleccione un municipio...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].option==municipio) {
                    $('#municipio').append('<option selected="selected" value="'+ data[i].value+'">'+data[i].option +'</option>');
                }else{
                    $('#municipio').append('<option value="'+ data[i].value+'">'+data[i].option +'</option>');
                }

            }   
            $('#municipio').selectpicker('refresh');
        })

        .fail(function() {
            alert("Error cargando el municipio");
        }); 

        $.ajax({
            url: BASE_URL +'personal/SelectParroquiaGeneral', 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { 
            $('#direccion').empty();
            $('#direccion').append('<option value="">Seleccione una parroquia...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].option==parroquia) {
                    $('#direccion').append('<option  selected="selected" value="'+ data[i].value+'">'+data[i].option +'</option>');

                }else{
                    $('#direccion').append('<option value="'+ data[i].value+'">'+data[i].option +'</option>');
                }

            }   
            $('#direccion').selectpicker('refresh');
        })

        .fail(function() {
            alert("Error cargando la parroquia");
        });
    
 }      

