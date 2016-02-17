    var BASE_URL = "http://localhost/catic/";

    //funcion que limpia los campos
    function LimpiarInput(destino)
    {
        destino.value="";   
    }

    //funcion que llena los datos 
    function LlenarDatos(text,destino,destino2,destino3,destino4,destino5,destino6,destino7,destino8,destino9)
    {

        if(typeof(text.data.nombres) != "undefined"){
            //alert(''+JSON.stringify(text));
            var nombres = text.data.nombres.split(' ');
            var apellidos = text.data.apellidos.split(' ');     
            destino.value = nombres[0];
            destino2.value = nombres[1];
            destino3.value = apellidos[0];
            destino4.value = apellidos[1];
            destino5.value = text.data.fecha_nacimiento;
            destino6.value = text.data.telefono_celular;
            destino7.value = text.data.fecha_ingreso;
            destino8.value = text.data.correo_electronico;
            destino9.value = text.data.direccion;
        }else{
            alert("El usuario no esta registrado en el sistema SIGESP");
        }
    }
    
    //fucion con la cual obtenemos  los datos 
    function obten_datos(cedula,destino,destino2,destino3,destino4,destino5,destino6,destino7,destino8,destino9)
    {
        
        //alert("destino: "+destino+" destino2: "+destino2+" destino3: "+destino3+" destino4: "+destino4+" destino5: "+destino5+" destino6: "+destino6+" destino7: "+destino7+" destino8: "+destino8+" destino9:"+destino9);
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
                    LlenarDatos(json,destino,destino2,destino3,destino4,destino5,destino6,destino7,destino8,destino9);
                        }
            });     
    }