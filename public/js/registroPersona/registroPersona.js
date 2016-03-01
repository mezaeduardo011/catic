function send_registro_persona(tipo_persona) {

    var tipo = tipo_persona;

    //alert("/catic/personal/insertPerson?"+request(document.getElementById('divPersona')));
    if (request(document.getElementById('divPersona')) != "" && tipo ='empleada') {
        alert("funciona");
        send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona', request(document.getElementById('divPersona')), null, true);
    };

    if (request(document.getElementById('infoHijos')) != "" && tipo='hijo') {
         send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona', request(document.getElementById('infoHijos')), null, true);
     };
    
    if (request(document.getElementById('infoPadre')) != "" && request(document.getElementById('infoMadre')) != "" && tipo='padre') {
        send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona', request(document.getElementById('infoPadre')), null, true);
    };

    if (request(document.getElementById('infoPadreUnico')) != "" && tipo='padre') {
         send_ajax('POST', '../../catic/personal/insertPerson', 'response_registro_persona', request(document.getElementById('infoPadreUnico')), null, true);
    };
}

function send_registro_InfoAdicional() {
    send_ajax('POST', '../../catic/personal/Insert_InfoAdicional', 'response_registro_persona', request(document.getElementById('informacion_adicional')), null, true);
}

function response_registro_persona(response) {
    //alert("Registro Exitoso");
}

function response_registro_hijo(response) {
    //alert("Registro de hijo exitoso");
    showElementos('tablaHijos');hiddenElementos('infoHijos');hiddenElementos('infoExtra');showElementos('AgregarOtro');
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



function send_consulta_info(id) {
    send_ajax('POST', '../../catic/personal/getInfoDatos', 'response_consulta_info', 'Familiar - Hijo', null, true);
    showElementos('infoDatosDiv');
}


function response_consulta_info(response) {
    var tbl = document.getElementById('infoDatos');
        tbl.style.color = '#ffffff';
    if (borrar_datos_tabla('infoDatos')) {
        var len = response.length;
        var lastRow, row, nombre, apellido, espacio;
        lastRow = tbl.rows.length;
        row = tbl.insertRow(lastRow);
        nombre = row.insertCell(0);
        espacio = row.insertCell(1);
        apellido = row.insertCell(2);
        nombre.innerHTML = response[i]['nombre'];
        espacio.innerHTML = '&nbsp;&nbsp;&nbsp;'
        apellido.innerHTML = response[i]['apellido'];
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

    for (var i = 0; i < data.length; i++) {
        if (data[i]['numeracion'] == 5) {
            alert('Ya tiene registrado el maximo de hijos');
            hiddenElementos('AgregarOtro');
        }
    }
    alert($data);
})

.fail(function() {
    alert("Error");
});
});