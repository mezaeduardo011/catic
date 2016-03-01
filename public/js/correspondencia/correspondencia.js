function send_consulta_correspondencia() {
    send_ajax('POST', '../../catic/correspondencia/getCorrespondencias', 'response_consulta_hijo', null, null, true);
}


function response_consulta_hijo(response) {
    alert('asdasds');
     //var tbl = document.getElementById('dynamic-table');
    // var len = response.length;
    // var lastRow, row, nombres, apellidos, sexo, edad;
    // if (borrar_datos_tabla('tablaHijosAdd') == true) {
    //     for (var i = 0; i < len; i++) {
    //         lastRow = tbl.rows.length;
    //         row = tbl.insertRow(lastRow);
    //         nombres = row.insertCell(0);
    //         apellidos = row.insertCell(1);
    //         sexo = row.insertCell(2);
    //         edad = row.insertCell(3);
    //         nombres.innerHTML = response[i]['nombre'] + response[i]['nombre2'];
    //         apellidos.innerHTML = response[i]['apellido'] + response[i]['apellido2'];
    //         sexo.innerHTML = response[i]['sexo'];
    //         edad.innerHTML = response[i]['edad'];
    //     }
    // };
    // return false;
}