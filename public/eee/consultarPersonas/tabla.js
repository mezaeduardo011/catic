function borrar_tabla(id_tabla) {

    var tbl = document.getElementById(id_tabla);
    
      for (var i = 1; i < tbl.rows.length;) {
          tbl.deleteRow(tbl.rows[i].rowIndex);
      }
    return true;
}


//--------------modal para mostrar los estatus de la solicitud-------

function vista_preliminar(){
    $("#fondo_preliminar").fadeToggle();
    $("#area_preliminar").fadeToggle();
    $("#ventana_preliminar").fadeToggle();    
    $("#tabla_detalle_persona").show(); 
    centrar_ventana();
    


    //-------------------------------------------------------------------------------------------
}


function centrar_ventana(){
    var longitud_ventana =0;
    var longitud_fondo =0;
    var margen_izquierdo =0;
    while(longitud_ventana!=$('#ventana_preliminar').outerWidth()){
        longitud_ventana=$('#ventana_preliminar').outerWidth();
        longitud_fondo=$(window).width();
        margen_izquierdo=(longitud_fondo/2)-(longitud_ventana/2);       
                $('#ventana_preliminar').css({
                    position:'fixed',
                    left: margen_izquierdo
                });
    }
    $('#imagen_cerrar').css({
                    position:'fixed',
                    top : 150,
                    left: margen_izquierdo
                });
}
