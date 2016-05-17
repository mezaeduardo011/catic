 $(document).ready(function () {
            var aux; 
            var BASE_URL = "http://localhost/catic/"; 
            var grid_selector2 = "#tablaInfoHijos";
            var paginador    = "#tablaInfoHijosDiv";
            var persona = "/"+document.getElementById('persona_empleada').value;
            

            //resize to fit page size
            $(window).on('resize.jqGrid', function () {
                $(grid_selector2).jqGrid( 'setGridWidth', $("#caja").width() );
            })
            
            $(grid_selector2).jqGrid({
                url: BASE_URL+"personal/getHijos"+persona,
                mtype: "GET",
                styleUI : 'Bootstrap',
                datatype: "json",
                colModel: [

                    { label: 'id', name: 'id_persona', width: 1},
                    { label: 'Nombre', name: 'nombre', width: 200 },
                    { label: 'Apellido', name: 'apellido', width: 150 },
                    { label: 'Sexo', name: 'sexo', width: 150 },
                    { label: 'Edad', name: 'edad', width: 150 },   
                    { label: 'Fecha de nacimiento', name: 'fecha_nacimiento', width: 200 }

                ],

                jsonReader: {repeatitems:false},
                viewrecords: true,
                height: "auto",
                rowNum: 20,
                rowList:[10,20,30],
                pager: paginador,
                multiselect: true,
                loadComplete : function() {
                        var table = this;
                        $(grid_selector2).jqGrid("hideCol", "id_persona");
                        setTimeout(function(){
                            updatePagerIcons(table);
                        }, 0);
                    },
                multiboxonly: true,
                autowidth: true,
                loadonce:true

            });

            jQuery(grid_selector2).jqGrid('navGrid',paginador,
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
                        cloneToTop: false
                    }
            )

            $(grid_selector2).navButtonAdd(paginador,{
                id: "eliminarHijo",
                buttonicon: "ace-icon fa fa-trash-o red",
                title: "Eliminar Hijo",
                caption: 'Eliminar Hijo',
                position: "last",
                onClickButton: eliminar_hijo
            });

            function eliminar_hijo() {
                var columna_check = $(grid_selector2).jqGrid("getGridParam", "selarrrow")
                                
                if(columna_check.length>0){
                    var id_persona = [];
                    for(var i=0,ids=columna_check.length;i<ids; i++){
                        id_persona.push($(grid_selector2).jqGrid('getCell', columna_check[i], 'id_persona'));
                    }
                }

                if (id_persona!=undefined && id_persona!=null) {

                    $.ajax({
                        type: 'post',
                        url: BASE_URL +'personal/eliminarHijo',
                        data: {id_persona},                
                        success: function (data){
                            alert(data);
                            $(grid_selector2).jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');          
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