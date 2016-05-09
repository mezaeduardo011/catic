$(document).ready(function () {
            var BASE_URL = "http://localhost/catic/"; 
            var grid_selector = "#consulta_correspondencia";
            var grid_pager = "#jqGridPager";

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector).jqGrid( 'setGridWidth', $("#caja").width() );
            })
            
            $(grid_selector).jqGrid({
                url: BASE_URL+"correspondencia/consulta_correspondencia",
                mtype: "GET",
                styleUI : 'Bootstrap',
                datatype: "json",
                colModel: [
                    { label: 'N°', name: 'numeracion',key: true, width: 20, "search":false},
                    { label: 'Asunto', name: 'asunto',key: true, width: 150 ,"search":true},
                    { label: 'Oficina', name: 'oficina',key: true, width: 150 ,"search":true},
                    { label:'Instrucción', name: 'instruccion',key: true, width: 90 ,"search":true},
                    { label:'Fecha', name: 'fecha',key: true, width: 50 ,"search":true},
                    { label:'Tipo', name: 'tipo',key: true, width: 50 ,"search":true},  
                    { label:'Estatus', name: 'estatus',key: true, width: 50 ,"search":true},                                     
                    { label:'Coordinacion encargada', name: 'coordinacion',key: true, width: 120 ,"search":true},
                    { label:'Carpeta', name: 'carpeta',key: true, width: 60 ,"search":true},
                    { label:'Coordinacion encargada', name: 'id_correspondencia',key: true, width: 1 ,"search":true},

                ],

                jsonReader: {repeatitems:false, root:"correspondencia"},
                viewrecords: true,
                height: 250,
                rowNum: 20,
                rowList:[10,20,30],
                pager: grid_pager,
                multiselect: true,
                loadComplete : function() {
                        $(grid_selector).jqGrid("hideCol", "id_correspondencia");
                        var table = this;
                        setTimeout(function(){
                            updatePagerIcons(table);
                        }, 0);
                    },
                multiboxonly: true,
                autowidth: true,
                loadonce:true

            });
jQuery(grid_selector).jqGrid('filterToolbar',{"stringResult":true});
            $(window).on("resize", function () {
    var $grid = $(grid_selector),
        newWidth = $grid.closest(".ui-jqgrid").parent().width();
    $grid.jqGrid("setGridWidth", newWidth, true);
});

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
        buttonicon: "ace-icon fa fa-search-plus grey",
        title: "Archivar correspondencia",
        caption: 'Archivar correspondencia',
        position: "last",
        onClickButton: archivar
    });

    function archivar() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_correspondencia = [];
             var estatus = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                id_correspondencia.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_correspondencia'));
                estatus.push($(grid_selector).jqGrid('getCell', columna_check[i], 'estatus'));
            }
        }

    if (id_correspondencia!=undefined && id_correspondencia!=null) {
        if(estatus=='Archivada'){
            alert('Esta correspondencia ya esta archivada');
        }else{
              pickOpen('prod', 'id_prod',BASE_URL+'correspondencia/archivar/'+id_correspondencia,

        90, 30, 60, 70);show('prod',500);show('id_aceptar',500);hide('id_buscar',500); 

        llenarEstado(id_correspondencia);            
        }

    }else{
        alert('Por favor seleccione una fila');
    }



    }                


        });
 