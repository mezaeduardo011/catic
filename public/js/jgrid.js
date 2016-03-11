$(document).ready(function () {

    var BASE_URL = "http://localhost/catic/"; 
    var grid_selector = "#jqGrid";
    var grid_pager = "#jqGridPager";

    //Se reajusta el tamaño dependiendo la pantalla.
    $(window).on('resize.jqGrid', function () {
        $(grid_selector).jqGrid( 'setGridWidth', $("#caja").width() );
    })
    
    //Se crea la tabla con los parametros establecidos
    $(grid_selector).jqGrid({
        hoverrows:false,
        viewrecords:true,
        gridview:true,
        url: BASE_URL+"vacaciones/personal_vacaciones",
        loadonce: true,
        rowNum:10,
        height:200,
        autowidth:true,
        sortname:"OrderID",
        rowList:[10,30,40],
        datatype:"json",

        colModel: [

            { label: 'id', name: 'id_persona', key: true, width: 1,"search":false },
            { label: '#', name: 'numeracion', key: true, width: 20,"search":false },
            { label: 'Coordinacion', name: 'coordinacion', width: 110 ,"search":true},
            { label: 'Nombres', name: 'nombres', width: 120 ,"search":true},
            { label:'Fecha de solicitud', name: 'fecha_solicitud', width: 110,"search":true },
            { label:'Inicio', name: 'desde', width: 70,"search":true },
            { label:'Fin', name: 'hasta', width: 70 ,"search":true},
            { label:'Reincorporacion', name: 'reincorporacion', width: 100,"search":true },
            { label:'Dias hábiles', name: 'dias_correspondientes', width: 70,"search":true },

        ],

        jsonReader: {repeatitems:false, root:"vacaciones"},
        pager: grid_pager,
        multiselect: true,

        //Cuando los datos se cargan se realiza la funcion para ocultar la columna de id_persona
        loadComplete : function() {

            var table = this;
            $(grid_selector).jqGrid("hideCol", "id_persona");

            //Para asignarle a la tabla estilo de botones bootstrap
            setTimeout(function(){

                updatePagerIcons(table);

            }, 0);

            },

        multiboxonly: true

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
        search: true,
        searchicon : 'ace-icon fa fa-search orange',
        refresh: true,
        refreshicon : 'ace-icon fa fa-refresh green',
        view: true,
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

    // Primer Boton Personalizado para cancelar vacaciones
    $(grid_selector).navButtonAdd(grid_pager,
    {
        buttonicon: "ace-icon fa fa-trash-o red",
        title: "Cancelar Vacaciones",
        caption: '',
        position: "last",
        onClickButton: CancelarVacaciones
    });

    //Botones de Bootstrap
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

    //Se ejecuta cuando se pulsa el boton cancelar vacaciones
    function CancelarVacaciones() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var vacaciones_canceladas = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                var personas = $(grid_selector).jqGrid('getCell', columna_check[i], 'id_persona');
                vacaciones_canceladas.push(personas);
            }
        }

        //alert ("id de la personas: " + vacaciones_canceladas.join(", ") + "; Columna Seleccionadas: " + columna_check.join(", "));

        $("#vacaciones_canceladas").html(vacaciones_canceladas.join(", "));

        $("#dialog-confirm").dialog({
            height:100,
            modal:true,
            buttons:{

                'Cancel': function(){

                    $(this).dialog('close');

                },

                'Confirm': function(){

                    //alert(vacaciones_canceladas);
                    
                    $.ajax({

                        type: "POST",
                        url:  BASE_URL +'vacaciones/cancelar_vacaciones',

                        data: 
                        { 
                            Columna: JSON.stringify(columna_check),
                            id_persona: JSON.stringify(vacaciones_canceladas)
                        },

                        dataType: "json",

                        success: function(msg){
                            alert(JSON.stringify(msg));
                        },

                        error: function(res, status, exeption) {
                            alert(JSON.stringify(res));
                        }

                    });
                }
            },
            show:{
                effect:"blind",
                duration: 300
            },
            hide:{
                effect:"explode",
                duration: 500
            }
        });
    }
});