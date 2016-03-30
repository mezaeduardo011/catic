$(document).ready(function () {
            var BASE_URL = "http://localhost/catic/"; 
            var grid_selector = "#actividades";
            var grid_pager = "#pagerActividades";

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector).jqGrid( 'setGridWidth', $("#caja").width() );
            })
            
            $(grid_selector).jqGrid({
            hoverrows:false,
            "viewrecords":true,
            "jsonReader":{"repeatitems":false,"subgrid":{"repeatitems":false}},
            "gridview":true,
             url: BASE_URL+"actividad_institucional/getActividades",
            "loadonce": true,
            "rowNum":10,
            "height":200,
            "autowidth":true,
            "sortname":"OrderID",
            "rowList":[10,30,40],
            "datatype":"json",

                colModel: [

                    { label: '#', name: 'numeracion', key: true, width: 20,"search":false },
                    { label: 'Nombre de la actividad', name: 'nombre_actividad', width: 150 ,"search":true},
                    { label: 'Fecha', name: 'fecha_actividad', width: 120 ,"search":true},
                    { label: 'Hora', name: 'hora_actividad', width: 120 ,"search":true},
                    { label: 'Ubicación', name: 'ubicacion', width: 120 ,"search":true},
                    { label: 'Estatus', name: 'status_actividad', width: 120 ,"search":true},
                    { label: 'id', name: 'id_actividad_institucional', key: true, width: 1,"search":false },
                ],

                jsonReader: {repeatitems:false, root:"actividades"},
                pager: grid_pager,
                multiselect: true,
                loadComplete : function() {
                        var table = this;
                        setTimeout(function(){
                            updatePagerIcons(table);
                        }, 0);
                    },
                multiboxonly: true

            });


            jQuery(grid_selector).jqGrid('filterToolbar',{"stringResult":true});
            jQuery(grid_selector).jqGrid('navGrid',grid_pager,
                    {   //navbar options
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
                    },
                    {
                        //search form
                        recreateForm: true,
                        afterShowSearch: function(e){
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                            style_search_form(form);
                        },
                        afterRedraw: function(){
                            style_search_filters($(this));
                        }
                        ,
                        multipleSearch: true,
                        /**
                        multipleGroup:true,
                        showQuery: true
                        */
                    },
                    {
                        //view record form
                        recreateForm: true,
                        beforeShowForm: function(e){
                            var form = $(e[0]);
                            form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
                        }
                    })

            //replace icons with FontAwesome icons like above
                function updatePagerIcons(table) {
                    var replacement = 
                    {
                        'ui-icon-seek-first' : 'ace-icon fa fa-angle-double-left bigger-140',
                        'ui-icon-seek-prev'  : 'ace-icon fa fa-angle-left bigger-140',
                        'ui-icon-seek-next'  : 'ace-icon fa fa-angle-right bigger-140',
                        'ui-icon-seek-end'   : 'ace-icon fa fa-angle-double-right bigger-140'
                    };
                    $('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function(){
                        var icon = $(this);
                        var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
                        
                        if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
                    })
                }
    $(grid_selector).navButtonAdd(grid_pager,
    {
        buttonicon: "ace-icon fa fa-search-plus grey",
        title: "Personal asignado",
        caption: 'Ver personal asignado',
        position: "last",
        onClickButton: detalles
    });

    function detalles() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_actividad_institucional = [];
            var status_actividad = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                id_actividad_institucional.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_actividad_institucional'));
                status_actividad.push($(grid_selector).jqGrid('getCell', columna_check[i], 'status_actividad'));
            }
        }
        if (id_actividad_institucional!=undefined && id_actividad_institucional!=null) {
                 pickOpen('prod', 'id_prod',BASE_URL+'actividad_institucional/detalles/'+id_actividad_institucional,
                60, 45, 300, 80);show('prod',500);show('id_aceptar',500);hide('id_buscar',500);
        }else{
            alert('Seleccione una actividad');
        }
    }
    $(grid_selector).navButtonAdd(grid_pager,
    {
        buttonicon: "ace-icon fa fa-times-circle red",
        title: "Finalizar actividad",
        caption: 'Finalizar actividad',
        position: "last",
        onClickButton: finalizar_actividad
    });

    function finalizar_actividad() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_actividad_institucional = [];
            var status_actividad = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                id_actividad_institucional.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_actividad_institucional'));
                status_actividad.push($(grid_selector).jqGrid('getCell', columna_check[i], 'status_actividad'));
            }
        }
        if (id_actividad_institucional!=undefined && id_actividad_institucional!=null) {
            if (status_actividad=="Actividada finalizada") {
               alert('Esta actividad ya fue finalizada');
            }
            else if(status_actividad=="Cancelada"){
               alert('Esta actividad fue cancelada');
            }
            else{ 
                 pickOpen('prod', 'id_prod',BASE_URL+'actividad_institucional/fin/'+id_actividad_institucional+"/TRUE",
                60, 30, 300, 80);show('prod',500);show('id_aceptar',500);hide('id_buscar',500);                     
            }

        }else{
            alert('Seleccione una actividad');
        }
    } 

    $(grid_selector).navButtonAdd(grid_pager,
    {
        buttonicon: "ace-icon fa fa-times-circle red",
        title: "Cancelar actividad",
        caption: 'Cancelar actividad',
        position: "last",
        onClickButton: cancelar_actividad
    });

    function cancelar_actividad() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_actividad_institucional = [];
            var status_actividad = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                id_actividad_institucional.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_actividad_institucional'));
                status_actividad.push($(grid_selector).jqGrid('getCell', columna_check[i], 'status_actividad'));
            }
        }
        if (id_actividad_institucional!=undefined && id_actividad_institucional!=null) {
            if (status_actividad=="Actividada finalizada") {
               alert('Esta actividad ya fue finalizada');
            }
            else if(status_actividad=="Cancelada"){
               alert('Esta actividad ya fue cancelada');
            }else{
                 pickOpen('prod', 'id_prod',BASE_URL+'actividad_institucional/cancelar/'+id_actividad_institucional,
                60, 30, 300, 80);show('prod',500);show('id_aceptar',500);hide('id_buscar',500);                     
            }

        }else{
            alert('Seleccione una actividad');
        }
    }                          


        });
 