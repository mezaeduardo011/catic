    var BASE_URL = "http://localhost/catic/";

    function LimpiarInput(destino)
    {
        destino.value="";   
    }

    //funcion que llena los datos 
    function LlenarDatos(text,destino,destino2,destino3,destino4,destino5,destino6,destino7,destino8,destino9,destino10)
    {
            //alert(''+JSON.stringify(text));
        if(typeof(text.data.nombres) != "undefined"){
            var nombres = text.data.nombres.split(' ');
            var apellidos = text.data.apellidos.split(' ');     
            destino.value = nombres[0];
            if(nombres[1]!=null || nombres[1]!= undefined){
                destino2.value = nombres[1];
            }            
            destino3.value = apellidos[0];

            if(apellidos[1]!=null || apellidos[1]!= undefined){
                destino4.value = apellidos[1];
            } 
            

            destino5.value = text.data.fecha_nacimiento;
            destino6.value = text.data.telefono_celular;
            destino7.value = text.data.fecha_ingreso;
            destino8.value = text.data.correo_electronico;
            destino9.value = text.data.direccion;
            llenar_direccion(text.data.parroquia_direccion,text.data.municipio_direccion,text.data.estado_direccion);
            llenar_cargo(text.data.cargo_original);
            seleccionar_sexo(text.data.genero);

        }else{
            alert("El usuario no esta registrado en el sistema SIGESP");
        }
    }
    
    function obten_datos(cedula,destino,destino2,destino3,destino4,destino5,destino6,destino7,destino8,destino9,destino10)
    {
        //alert("destino: "+destino+" destino2: "+destino2+" destino3: "+destino3+" destino4: "+destino4+" destino5: "+destino5+" destino6: "+destino6+" destino7: "+destino7+" destino8: "+destino8+" destino9:"+destino9+"Destino 10:- .I."+destino10);
        cedular= document.getElementById(cedula);
        destino = document.getElementById(destino);
        destino2 = document.getElementById(destino2);
        destino3 = document.getElementById(destino3);
        destino4 = document.getElementById(destino4);
        destino5 = document.getElementById(destino5);
        destino6 = document.getElementById(destino6);
        destino7 = document.getElementById(destino7);
        destino8 = document.getElementById(destino8);
        destino9 = document.getElementById(destino9);
        destino10 = document.getElementById(destino10);

        LimpiarInput(destino);
        LimpiarInput(destino2);
        LimpiarInput(destino3);
        LimpiarInput(destino4);
        LimpiarInput(destino5);
        LimpiarInput(destino6);
        LimpiarInput(destino7);
        LimpiarInput(destino8);
        LimpiarInput(destino9);


            $.ajax({
                type: 'post',
                dataType: 'json',
                url: BASE_URL +'personal/BuscarCedula',
                data: {cedular: cedular.value},
                success: function(json){

                    LlenarDatos(json,destino,destino2,destino3,destino4,destino5,destino6,destino7,destino8,destino9,destino10);
                        }
            });               
       
  
    }

 function llenar_direccion(parroquia,municipio,estado){

//Ajax para los estados
        $.ajax({
            url: BASE_URL +'personal/SelectEstado', 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { 
            $('#estado').empty();
            $('#estado').append('<option value="">Seleccione un estado...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].option.toUpperCase()==estado) {
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
                if (data[i].option.toUpperCase()==municipio) {
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
//Fin ajax municipios    

        $.ajax({
            url: BASE_URL +'personal/SelectParroquiaGeneral', 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { 
            $('#direccion').empty();
            $('#direccion').append('<option value="">Seleccione una parroquia...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].option.toUpperCase()==parroquia) {
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

 function llenar_cargo(cargo){

//Ajax para los cargos
        $.ajax({
            url: BASE_URL +'personal/SelectCargo', 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { 
            $('#cargo').empty();
            $('#cargo').append('<option value="">Seleccione un cargo...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].option.toUpperCase()==cargo) {
                    $('#cargo').append('<option  selected="selected" value="'+ data[i].value+'">'+data[i].option +'</option>');
                }else{
                    $('#cargo').append('<option value="'+ data[i].value+'">'+data[i].option +'</option>');
                }

            }   
            $('#cargo').selectpicker('refresh');
        })

        .fail(function() {
            alert("Error cargando el cargo");
        });
    
 }    

 function seleccionar_sexo(sexo){
var checkbox = document.getElementsByName('sexos');
            if(sexo!=null){
                if (sexo=='Femenino') {
                    checkbox[1].checked = true;
                }
                if(sexo=='Masculino'){
                     checkbox[0].checked = true;
                }
            }                
 }   