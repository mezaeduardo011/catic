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

            { label: 'id', name: 'id_persona', key: true, width: 10,"search":false },
             
            { label: '#', name: 'numeracion', key: true, width: 150,"search":false,},            
            { label: 'Nombres', name: 'nombres', width: 800 ,"search":true},
            { label: 'Coordinacion', name: 'coordinacion', width: 800 ,"search":true},
            { label:'Fecha de solicitud', name: 'fecha_solicitud', width: 600,"search":true },
            { label:'Inicio', name: 'desde', width: 600,"search":true },
            { label:'Fin', name: 'hasta', width: 600 ,"search":true},
            { label:'Reincorporacion', name: 'reincorporacion', width: 600,"search":true },
            { label:'Dias hábiles', name: 'dias_correspondientes', width: 600,"search":true },
            { label:'Estatus', name: 'estatus', width: 600,"search":true },
            { label: 'id', name: 'id_vacaciones', key: false, width: 0,"search":false },
            
        ],

        jsonReader: {repeatitems:false, root:"vacaciones"},
        pager: grid_pager,
        multiselect: true,

        //Cuando los datos se cargan se realiza la funcion para ocultar la columna de id_persona
        loadComplete : function() {


            var table = this;
            $(grid_selector).jqGrid("hideCol", "id_persona");
            $(grid_selector).jqGrid("hideCol", "id_vacaciones");

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
        search: false,
        searchicon : 'ace-icon fa fa-search orange',
        refresh: false,
        refreshicon : 'ace-icon fa fa-refresh green',
        view: false,
        viewicon : 'ace-icon fa fa-search-plus grey',
        position: 'left',
        cloneToTop: false
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
//cellattr: function () { return ' title="Here is my tooltip on colCell!"'; }

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

    $(grid_selector).navButtonAdd(grid_pager,
    {
        buttonicon: "ace-icon fa fa-times-circle red",
        title: "Finalizar vacaciones",
        caption: 'Finalizar vacaciones',
        position: "last",
        onClickButton: finalizar_vacaciones
    });

    function finalizar_vacaciones() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_vacaciones = [];
            var estatus = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                id_vacaciones.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_vacaciones'));
                estatus.push($(grid_selector).jqGrid('getCell', columna_check[i], 'estatus'));
            }
        }
        if (id_vacaciones!=undefined && id_vacaciones!=null) {
            if (estatus=="Finalizadas") {
               alert('Estas vacaciones ya fueron finalizadas');
            }
            else if(estatus=="Canceladas"){
               alert('Estas vacaciones fueron canceladas');
            }
            else{ 
                 pickOpen('prod', 'id_prod',BASE_URL+'vacaciones/finVacaciones/'+id_vacaciones+"/TRUE",
                60, 30, 300, 80);show('prod',500);show('id_aceptar',500);hide('id_buscar',500);                     
            }

        }else{
            alert('Seleccione una de las vacaciones registradas');
        }
    } 
    $(grid_selector).navButtonAdd(grid_pager,
    {
        buttonicon: "ace-icon fa fa-times-circle red",
        title: "Cancelar vacaciones",
        caption: 'Cancelar vacaciones',
        position: "last",
        onClickButton: cancelar_vacaciones
    });

    function cancelar_vacaciones() {
        var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
        if(columna_check.length>0){
            var id_vacaciones = [];
            var estatus = [];
            for(var i=0,ids=columna_check.length;i<ids; i++){
                id_vacaciones.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_vacaciones'));
                estatus.push($(grid_selector).jqGrid('getCell', columna_check[i], 'estatus'));
            }
        }
        if (id_vacaciones!=undefined && id_vacaciones!=null) {
            if (estatus=="Finalizadas") {
               alert('Estas vacaciones ya fueron finalizadas');
            }
            else if(estatus=="Canceladas"){
               alert('Estas vacaciones fueron canceladas');
            }
            else{ 
                 pickOpen('prod', 'id_prod',BASE_URL+'vacaciones/cancelarVacaciones/'+id_vacaciones+"/TRUE",
                60, 30, 300, 80);show('prod',500);show('id_aceptar',500);hide('id_buscar',500);                     
            }

        }else{
            alert('Seleccione una de las vacaciones registradas');
        }
    }    
});