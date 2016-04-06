function send_registro_persona() {
}

$("#registrarPersona").click(function() {
 send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona_empleada', request(document.getElementById('divPersona')), null, true);   
});

$("#registrarHijo").click(function() {
 send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_hijo', request(document.getElementById('infoHijos')), null, true);
});
$("#registrarAmbosPadres").click(function() {
    //alert("/catic/personal/insertPerson?" + request(document.getElementById('infoPadreUnico')));
        send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona_padre', request(document.getElementById('infoPadre')), null, true);
        send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona_padre', request(document.getElementById('infoMadre')), null, true);
        $('#tablaInfoPadres').jqGrid('setGridParam', {
            url: BASE_URL + "personal/getPadres",
            datatype: "json"
        }).trigger("reloadGrid");    
});
$("#registrarPadre").click(function() {
    if (request(document.getElementById('infoPadreUnico')) != "") {
        send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona_padre', request(document.getElementById('infoPadreUnico')), null, true);
    };
        $('#tablaInfoPadres').jqGrid('setGridParam', {
            url: BASE_URL + "personal/getPadres",
            datatype: "json"
        }).trigger("reloadGrid");    
});

function send_registro_InfoAdicional() {
    send_ajax('POST','../../catic/personal/Insert_InfoAdicional', 'response_registro_infoAdicional', request(document.getElementById('informacion_adicional')), null, true);
}
function response_registro_persona_empleada(response) {
    hiddenElementos('registrarPersona');send_consulta_info();showElementos('modificarDatos');
    alert("Registro Exitoso");
}
function response_registro_infoAdicional(response) {
    alert("Registro Exitoso");
}
function response_registro_persona_padre(response) {
    showElementos('tablaPadresAdd');hiddenElementos('infoPadres');hiddenElementos('infoExtra');showElementos('AgregarOtroPadre');
   // alert("Registro Exitoso");
}

function response_registro_hijo(response) {
    showElementos('tablaHijos');
    hiddenElementos('infoHijos');
    hiddenElementos('infoExtra');
    showElementos('AgregarOtro');
}

function send_consulta_hijo(id) {
    send_ajax('POST', '../../catic/personal/getHijos', 'response_consulta_hijo', 'Familiar - Hijo', null, true);
}


function response_consulta_hijo(response) {
    //alert(response[0]['nombre']);
    var tbl = document.getElementById('tablaHijosAdd');
    var len = response.length;
    var lastRow, row, nombres, apellidos, sexo, edad;
    if (borrar_datos_tabla('tablaHijosAdd') == true) {
        for (var i = 0; i < len; i++) {
            lastRow = tbl.rows.length;
            row = tbl.insertRow(lastRow);
            nombres = row.insertCell(0);
            apellidos = row.insertCell(1);
            sexo = row.insertCell(2);
            edad = row.insertCell(3);
            nombres.innerHTML = response[i]['nombre'] + response[i]['nombre2'];
            apellidos.innerHTML = response[i]['apellido'] + response[i]['apellido2'];
            sexo.innerHTML = response[i]['sexo'];
            edad.innerHTML = response[i]['edad'];
        }
    };
    return false;
}



function send_consulta_info() {
    send_ajax('POST', '../../catic/personal/getInfoDatos', 'response_consulta_info', 'Familiar - Hijo', null, true);
}


function response_consulta_info(response) {
    var tbl = document.getElementById('infoDatos');
    tbl.style.color = '#ffffff';
    if (borrar_datos_tabla('infoDatos')) {
        var len = response.length;
        var lastRow, row, nombre, apellido;
        lastRow = tbl.rows.length;
        row = tbl.insertRow(lastRow);
        nombre = row.insertCell(0);
        apellido = row.insertCell(1);
        nombre.innerHTML = response[i]['nombre'];
        apellido.innerHTML = response[i]['apellido'];
        showElementos('infoDatosDiv');
    }
    return false;
}


function deleteBodyTablaHijos() {
    alert(document.getElementById("bodyTablaHijos"));
    return true;
}

function borrar_datos_tabla(id_tabla) {
    var tbl = document.getElementById(id_tabla);
    for (var i = 1; i < tbl.rows.length;) {
        tbl.deleteRow(tbl.rows[i].rowIndex);
    }
    return true;
}

$("#registrarHijo").click(function() {
    $.ajax({
        url: BASE_URL + 'personal/getHijos',
        type: 'POST',
        dataType: 'json',
    })

    .done(function(data) {
        //alert(data.length);
        contador = 0;
        for (var i = 0; i < data.length; i++) {
            if (i == 4) {
                alert('Ya tiene registrado el maximo de hijos');
                hiddenElementos('AgregarOtro');
                }
            contador ++;
        }
        //alert(contador);
        if(contador < 5 ){
            alert('registro exitoso');
        }
        $('#tablaInfoHijos').jqGrid('setGridParam', {
            url: BASE_URL + "personal/getHijos",
            datatype: "json"
        }).trigger("reloadGrid");
    })

    .fail(function() {
        alert("Error");
    });
});

jQuery(function($) {
    $.mask.definitions['~'] = '[+-]';
    $('.input-mask-date').mask('99/99/9999');
    $('.input-mask-phone').mask('(9999) 999-9999');
    $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
    $(".input-mask-product").mask("a*-999-a999", {
        placeholder: " ",
        completed: function() {
            alert("You typed the following: " + this.val());
        }
    });

});

$(document).ready(function() {
    $('#fecha_ingreso').datepicker({
        clearBtn: true,
        autoclose: true,
        language: "es",
        daysOfWeekHighlighted: "0,1,2,3,4,5,6",
        todayHighlight: true
    })
    .on('changeDate', function(e) {
        $('#registro_persona').formValidation('revalidateField', 'fecha_ingreso');
    });

    $('#fecha_nacimiento').datepicker({
        clearBtn: true,
        autoclose: true,
        language: "es",
        daysOfWeekHighlighted: "0,1,2,3,4,5,6",
        todayHighlight: true,
        endDate: "1998/12/31"

    })
    .on('changeDate', function(e) {
        $('#registro_persona').formValidation('revalidateField', 'fecha_nacimiento');
    });

    $('#fecha_nacimiento_hijo').datepicker({
        clearBtn: true,
        autoclose: true,
        language: "es",
        daysOfWeekHighlighted: "0,1,2,3,4,5,6",
        todayHighlight: true
    })
    .on('changeDate', function(e) {
        $('#registro_persona').formValidation('revalidateField', 'fecha_nacimiento_hijo');
    });
});