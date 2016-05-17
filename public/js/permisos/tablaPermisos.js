$(document).ready(function () {
            var BASE_URL = "http://localhost/catic/"; 
            var grid_selector = "#jqGrid";
            var grid_pager = "#jqGridPager";

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector).jqGrid( 'setGridWidth', $("#caja").width() );
            })
            
            $(grid_selector).jqGrid({
            hoverrows:false,
            "viewrecords":true,
            "jsonReader":{"repeatitems":false,"subgrid":{"repeatitems":false}},
            "gridview":true,
             url: BASE_URL+"permisos/consultar_permisos",
            "loadonce": true,
            "rowNum":10,
            "height":200,
            "autowidth":true,
            "sortname":"OrderID",
            "rowList":[10,30,40],
            "datatype":"json",

                colModel: [
                    { label: '#', name: 'numeracion', key: true, width: 20,"search":false },
                    { label: 'Coordinacion', name: 'coordinacion', width: 150 ,"search":true},
                    { label: 'Nombres', name: 'nombres', width: 120 ,"search":true},
                    { label:'Desde', name: 'desde', width: 50,"search":true },
                    { label:'Hasta', name: 'hasta', width: 50 ,"search":true},
                    { label:'Duracion', name: 'duracion_total', width: 25,"search":true },
                    { label: 'Estatus', name: 'estatus', key: true, width: 40,"search":true },
                     { label: '#', name: 'id_permisos', key: true, width: 1,"search":false },

                ],

                jsonReader: {repeatitems:false, root:"vacaciones"},
                pager: grid_pager,
                multiselect: true,
                loadComplete : function() {

                     $(grid_selector).jqGrid("hideCol", "id_permisos");
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
        buttonicon: "ace-icon fa fa-times-circle red",
        title: "Finalizar permiso o reposo",
        caption: 'Finalizar permiso o reposo',
        position: "last",
        onClickButton: finalizar_actividad
    });

    function finalizar_actividad() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_permisos = [];
            var status_actividad = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                id_permisos.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_permisos'));
                status_actividad.push($(grid_selector).jqGrid('getCell', columna_check[i], 'status_actividad'));
            }
        }
        if (id_permisos!=undefined && id_permisos!=null) {
            if (status_actividad=="Actividada finalizada") {
               alert('Este permiso ya fue finalizado');
            }
            else if(status_actividad=="Cancelada"){
               alert('Este permiso fue cancelado');
            }
            else{ 
                 pickOpen('prod', 'id_prod',BASE_URL+'permisos/finPermiso/'+id_permisos+"/TRUE",
                60, 30, 300, 80);show('prod',500);show('id_aceptar',500);hide('id_buscar',500);                     
            }

        }else{
            alert('Seleccione un permiso o reposo');
        }
    }                 


        });
 