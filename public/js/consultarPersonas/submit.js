function submitEdit(valor){
	alert("asdas"+valor);
    relocateBlank('../solicitud_pendiente/', {'id':valor});    
}

function submitDelete(valor){
    if (confirm('¿Desea Eliminar Este Registro?'))    
        relocate('delete.php', {'id':valor});
}

function upload_archivo_tecnico(valor1,valor2){
    relocate( '../../'+modulos+'/solicitud_upload_archivo_tecnico/', { 'id_solicitud': valor1,
                                                                        'codigo_solicitud':valor2} );   
}


function submitPrint(valor){
    relocateBlank('../../reportes/empresa_registro/', {'id_empresa':valor});    
}
function download_archivo_solicitud(valor1,valor2){
    relocate( '../../'+modulos+'/recaudos_empresa_consulta/', { 'id': valor1,'rif': valor2});   
                                                                  
}

