 var BASE_URL = "http://localhost/catic/"; 
$(document).ready(function () {

   
    var grid_selector = "#consulta_personas_tabla";
    var grid_pager = "#jqGridPager";

    //Se reajusta el tamaño dependiendo la pantalla.
    $(window).on('resize.jqGrid', function () {
        $(grid_selector).jqGrid( 'setGridWidth', $("#caja").width() );
    })
    
    //Se crea la tabla con los parametros establecidos
    $(grid_selector).jqGrid({
        viewrecords:true,
        url: BASE_URL+"personal/personasTabla",
        loadonce: true,
        rowNum:10,
        height:200,
        autowidth:true,
        rowList:[10,20,30],
        datatype:"json",

        colModel: [

            { label: 'id', name: 'id_persona', width: 1,"search":false },
            { label: 'id_persona_empleada', name: 'id_persona_empleada',  width: 1,"search":false },
            { label: 'Cédula', name: 'cedula', width: 20,"search":true },
            { label: 'Nombres', name: 'nombres', width: 20,"search":true },
            { label: 'Apellidos', name: 'apellidos', width: 20,"search":true },
            { label: 'Coordinación', name: 'coordinacion', width: 20,"search":true },
            { label: 'Cargo', name: 'cargo', width: 20,"search":true },
            { label: 'Fecha de ingreso', name: 'fecha_ingreso', width: 20,"search":true },


        ],

        jsonReader: {repeatitems:false, root:"personal"},
        pager: grid_pager,
        multiselect: true,

        //Cuando los datos se cargan se realiza la funcion para ocultar la columna de id_persona
        loadComplete : function() {

            var table = this;
            $(grid_selector).jqGrid("hideCol", "id_persona");
             $(grid_selector).jqGrid("hideCol", "id_persona_empleada");

            //Para asignarle a la tabla estilo de botones bootstrap
            setTimeout(function(){

                updatePagerIcons(table);

            }, 0);

            },
        beforeSelectRow: function(rowid,e){
            jQuery(grid_selector).jqGrid('resetSelection');
            return (true);
        },

        multiboxonly: true

    });


            $(window).on("resize", function () {
    var $grid = $(grid_selector),
        newWidth = $grid.closest(".ui-jqgrid").parent().width();
    $grid.jqGrid("setGridWidth", newWidth, true);
});
    //Funcionamiento del filtro de busqueda para que no distinga mayusculas ni minusculas
    jQuery(grid_selector).jqGrid('filterToolbar',{"stringResult":true});

    //Botones del paginador
    jQuery(grid_selector).jqGrid('navGrid',grid_pager,
    {   
        edit:false,
        editicon: 'ace-icon fa fa-pencil blue',
        add:false,
        addicon: 'ace-icon fa fa-plus-circle purple',
        del: false,
        delicon: 'ace-icon fa fa-trash-o red',
        search: false,
        searchicon : 'ace-icon fa fa-search orange',
        refresh: false,
        refreshicon : 'ace-icon fa fa-refresh green',
        view: false,
        viewicon : 'ace-icon fa fa-search-plus grey',
        position: 'left',
        cloneToTop: true
    },
    {
        //Parametros de los campos de busqueda
        recreateForm: true,

        afterShowSearch: function(e){
            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
            style_search_form(form);
        },

        afterRedraw: function(){

            style_search_filters($(this));

        },
        
        multipleSearch: true,
    },
    {
        //Parametros para el detalle
        recreateForm: true,

        beforeShowForm: function(e){

            var form = $(e[0]);
            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')

        }
    })

    $(grid_selector).navButtonAdd(grid_pager,
    {
        buttonicon: "ace-icon fa fa-search-plus grey",
        title: "Detalles de persona",
        caption: 'Detalles de persona',
        position: "last",
        onClickButton: detalles_persona
    });

    function detalles_persona() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_persona = [];
            var id_persona_empleada = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                id_persona.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_persona'));
                id_persona_empleada.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_persona_empleada'));
            }
        }

    if (id_persona!=undefined && id_persona!=null) {
              pickOpen('prod', 'id_prod',BASE_URL+'personal/update/'+id_persona,90, 96, 85, 1);
              show('prod',500);show('id_aceptar',500);hide('id_buscar',500); 
              llenarEstado(id_persona);

    }else{
        alert('Por favor seleccione una fila');
    }



    }
                function updatePagerIcons(table) {
                    var replacement = 
                    {
                        'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
                        'ui-icon-seek-prev' : 'ace-icon fa fa-angle-left bigger-140',
                        'ui-icon-seek-next' : 'ace-icon fa fa-angle-right bigger-140',
                        'ui-icon-seek-end' : 'ace-icon fa fa-angle-double-right bigger-140'
                    };
                    $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
                        var icon = $(this);
                        var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
                        
                        if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
                    })
                }

    $(grid_selector).navButtonAdd(grid_pager,
    {
        buttonicon: "ace-icon fa fa-print fx-1 green",
        title: "Imprimir detalles persona",
        caption: 'Imprimir detalles de persona',
        position: "last",
        onClickButton: imprimir_detalles
    });

    function imprimir_detalles() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_persona = [];
            var id_persona_empleada = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                id_persona.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_persona'));
                id_persona_empleada.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_persona_empleada'));
            }
        }
    if (id_persona!=undefined && id_persona!=null) {
              window.open(BASE_URL+'pdf/pdfDetallePersona/'+id_persona+'/'+id_persona_empleada);
    }else{
        alert('Por favor seleccione una fila');
    }



    }  

    $(grid_selector).navButtonAdd(grid_pager,
    {
        buttonicon: "ace-icon fa fa-trash-o red",
        title: "Eliminar persona",
        caption: 'Eliminar persona',
        position: "last",
        onClickButton: eliminar_persona
    });

    function eliminar_persona() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_persona = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                var personas = $(grid_selector).jqGrid('getCell', columna_check[i], 'id_persona');
                id_persona.push(personas);
            }
        }

    if (id_persona!=undefined && id_persona!=null) {
              pickOpen('prod', 'id_prod',BASE_URL+'personal/delete/'+id_persona,

        93, 30, 50, 16);show('prod',500);show('id_aceptar',500);hide('id_buscar',500); 
    }else{
        alert('Por favor seleccione una fila');
    }



    }       
});

$("#eliminarPersona").click(function() {
 
        $('#consulta_personas_tabla').jqGrid('setGridParam', {
            url: "http://localhost/catic/personal/personasTabla",
            datatype: "json"
        }).trigger("reloadGrid");
        alert('yes');
});


function llenarEstado(id_persona){
        
        var parroquia=" ";  

        $.ajax({
            url: BASE_URL +'personal/llenarEstado/'+id_persona, 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { // si todo funciona

           $.each(data, function(key, value) {
              parroquia.push(key.value);
           });            
             parroquia = data[0];
             municipio = data[1];
             estado    = data[2]; 

        })

        .fail(function() {//si da error decimos error
            alert("Error cargando la parroquia");
        });

        //---------------------------------------  
        $.ajax({
            url: BASE_URL +'personal/SelectEstado', 
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { // si todo funciona
            $('#direccion').empty();
            $('#direccion').append('<option value="">Seleccione un direccion...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].option==parroquia) {
                    alert('hola');
                    $('#direccion').append('<option selected="selected" value="'+ data[i].value+'">'+data[i].option +'</option>');
                }else{
                    $('#direccion').append('<option value="'+ data[i].value+'">'+data[i].option +'</option>');
                }

            }   
            $('#direccion').selectpicker('refresh');
        })

        .fail(function() {//si da error decimos error
            alert("Error cargando la parroquia");
        });
//Ajax para los municipios
        $.ajax({
            url: BASE_URL +'personal/SelectMunicipioGeneral', //apuntamos a persons/loadSexo
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { // si todo funciona
            $('#municipio').empty();
            $('#municipio').append('<option value="">Seleccione un municipio...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].option==municipio) {
                    $('#municipio').append('<option selected="selected" value="'+ data[i].value+'">'+data[i].option +'</option>');
                }else{
                    $('#municipio').append('<option value="'+ data[i].value+'">'+data[i].option +'</option>');
                }

            }   
            $('#municipio').selectpicker('refresh');
        })

        .fail(function() {//si da error decimos error
            alert("Error cargando el municipio");
        }); 
//Fin ajax municipios    

//Ajax para los estados
        $.ajax({
            url: BASE_URL +'personal/SelectEstado', //apuntamos a persons/loadSexo
            type: 'POST',
            dataType: 'json',       
        })

        .done(function(data) { // si todo funciona
            $('#estado').empty();
            $('#estado').append('<option value="">Seleccione un estado...</option>');
            for (var i=0; i<data.length; i++) {
                if (data[i].option==estado) {
                    $('#estado').append('<option selected="selected" value="'+ data[i].value+'">'+data[i].option +'</option>');
                }else{
                    $('#estado').append('<option value="'+ data[i].value+'">'+data[i].option +'</option>');
                }

            }   
            $('#estado').selectpicker('refresh');
        })

        .fail(function() {//si da error decimos error
            alert("Error cargando el estado");
        }); 
}