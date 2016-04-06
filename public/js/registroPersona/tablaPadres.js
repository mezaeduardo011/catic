$(document).ready(function () {
            var BASE_URL = "http://localhost/catic/"; 
            var grid_selector = "#tablaInfoPadres";
            var grid_pager   = "#tablaInfoPadresDiv";

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector).jqGrid( 'setGridWidth', $("#caja").width() );
            })

            $(grid_selector).jqGrid('GridUnload');

            $(grid_selector).jqGrid({
                url: BASE_URL+"personal/getPadres",
                mtype: "GET",
                styleUI : 'Bootstrap',
                datatype: "json",
                width: 1200,
                colModel: [

                    { label: 'id', name: 'id_persona', width: 1, },
                    { label: 'Nombres', name: 'nombres', width: 200 },
                    { label: 'Apellidos', name: 'apellidos', width: 150 },
                    { label: 'Teléfono', name: 'telefono', width: 150 },

                ],

                jsonReader: {repeatitems:false},
                viewrecords: true,
                height: "auto",
                rowNum: 20,
                rowList:[10,20,30],
                pager: grid_pager,
                multiselect: true,
                loadComplete : function() {
                        var table = this;
                        $(grid_selector).jqGrid("hideCol", "id_persona");
                        setTimeout(function(){
                            updatePagerIcons(table);
                        }, 0);
                    },
                multiboxonly: true,
                //autowidth: true,
                loadonce:false

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
                        cloneToTop: false
                    })

            $(grid_selector).navButtonAdd(grid_pager,{
                id: "eliminar_padre",
                buttonicon: "ace-icon fa fa-trash-o red",
                title: "Eliminar Padre",
                caption: 'Eliminar Padre',
                position: "last",
                onClickButton: eliminar_padre
            });

            function eliminar_padre() {
                var columna_check = $(grid_selector).jqGrid("getGridParam", "selarrrow")
                                
                if(columna_check.length>0){
                    var id_persona = [];
                    for(var i=0,ids=columna_check.length;i<ids; i++){
                        id_persona.push($(grid_selector).jqGrid('getCell', columna_check[i], 'id_persona'));
                    }
                }

                if (id_persona!=undefined && id_persona!=null) {

                    $.ajax({
                        type: 'post',
                        url: BASE_URL +'personal/eliminarPadre',
                        data: {id_persona},                
                        success: function (data){
                            alert(data);
                            $(grid_selector).jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');          
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert(textStatus);
                        }
                    });
                }
            }

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


        });
 