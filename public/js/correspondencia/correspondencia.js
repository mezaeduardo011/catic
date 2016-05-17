function send_correspondencia() {
    alert("/catic/correspondencia/registro_correspondencia?" + request(document.getElementById('correspondencia')));
    if (request(document.getElementById('correspondencia')) != "") {
        send_ajax('POST', '../../catic/correspondencia/registro_correspondencia', 'response_registro_correspondencia', request(document.getElementById('correspondencia')), null, true);
    };
}

$("#registroCorrespondencia").click(function() {
        hiddenElementos('tabla_consulta');
        showElementos('tabla_consulta');
        $('#consulta_correspondencia').jqGrid('setGridParam', {
            url: BASE_URL + "correspondencia/consulta_correspondencia",
            datatype: "json"
        }).trigger("reloadGrid");
});