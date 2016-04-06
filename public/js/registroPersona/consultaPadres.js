$(document).ready(function () {
            var BASE_URL = "http://localhost/catic/"; 
            var grid_selector = "#tablaInfoPadres";
            var grid_pager    = "#tablaInfoPadresDiv";

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector).jqGrid( 'setGridWidth', $("#caja").width() );
            })
            
            $(grid_selector).jqGrid({
                url: BASE_URL+"personal/getPadres",
                mtype: "GET",
                styleUI : 'Bootstrap',
                datatype: "json",
                colModel: [
                    { label: 'id', name: 'id_persona', width: 1},
                    { label: 'Nombres', name: 'nombres', key: true, width: 200 },
                    { label: 'Apellidos', name: 'apellidos', width: 150 },
                    { label: 'Teléfono', name: 'telefono', width: 200 }


                ],

                jsonReader: {repeatitems:false, root:"vacaciones"},
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
                autowidth: true,
                loadonce:true

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

            $(grid_selector).navButtonAdd(grid_pager,{
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
                            url: BASE_URL +'personal/eliminarHijo',
                            data: {id_persona},                
                            success:function (data){
                                alert(data);          
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
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
 