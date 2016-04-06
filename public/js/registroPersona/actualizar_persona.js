function enviar_datos(cedula,destino,destino2,destino3,destino4,destino5,destino6,destino7,destino8,destino9,destino10,destino11,destino12,destino13,destino14,destino15,destino16){

        //alert("destino: "+destino+" destino2: "+destino2+" destino3: "+destino3+" destino4: "+destino4+" destino5: "+destino5+" destino6: "+destino6+" destino7: "+destino7+" destino8: "+destino8+" destino9:"+destino9+"Destino 10:"+destino10);
        cedular= document.getElementById(cedula).value;
        destino= document.getElementById(destino).value;
        destino2= document.getElementById(destino2).value;
        destino3= document.getElementById(destino3).value;
        destino4= document.getElementById(destino4).value;
        destino5= document.getElementById(destino5).value;
        destino6= document.getElementById(destino6).value;
        destino7= document.getElementById(destino7).value;
        destino8= document.getElementById(destino8).value;
        destino9= document.getElementById(destino9).value;
        destino10= document.getElementById(destino10).value;
        destino11= document.getElementById(destino11).value;
        destino12= document.getElementById(destino12).value;
        destino13= document.getElementById(destino13).value;
        destino14= document.getElementById(destino14).value;
        destino15= document.getElementById(destino15).value;
        destino16= document.getElementById(destino16).value;

        datos =[{
            "cedula": cedular,
            "primer_nombre": destino,
            "segundo_nombre": destino2,
            "primer_apellido": destino3,
            "segundo_apellido": destino4,
            "sexo": destino5,
            "fecha_nacimiento": destino6,
            "fecha_ingreso": destino7,
            "telefono": destino8,
            "otro_telefono": destino8,
            "correo": destino10,
            "cargo": destino11,
            "coordinacion": destino12,
            "estado": destino13,
            "municipio": destino14,
            "parroquia": destino15,
            "ubicacion": destino16
        }];

        //alert(datos);

            $.ajax({
                type: 'post',
                url: BASE_URL +'personal/actualizarPersona',
                data: {datos},                
                success:function (data){
                    alert(data);          
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });         
       
  
    }