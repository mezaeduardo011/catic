/** Pinta (maquilla) las filas (elemento TR) de un elemento TABLE,
* unas claras y otras oscuras de forma intermitente.
* Esta función necesita definada las clases css: losnone y lospare.
* @param idTable (string) Identificador del elemento TABLE que será maquillado.*/
function paintTRsClearDark(idTable) {
        var objTable= document.getElementById(idTable);
    if (objTable.rows.length == 1)
            return false;
    for (rowIndex = 1; rowIndex < objTable.rows.length; rowIndex++) 
            objTable.rows[rowIndex].className=((rowIndex% 2) == 0)?'losnone':'lospare';              
}