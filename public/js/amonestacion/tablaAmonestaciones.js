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
             url: BASE_URL+"amonestacion/consulta_amonestaciones",
            "loadonce": true,
            "rowNum":10,
            "height":200,
            "autowidth":true,
            "sortname":"OrderID",
            "rowList":[10,30,40],
            "datatype":"json",

                colModel: [
                    { label: '#', name: 'numeracion', key: true, width: 20,"search":false },
                    { label: 'Coordinacion', name: 'coordinacion', width: 60 ,"search":true},
                    { label: 'Nombres', name: 'nombres', width: 60 ,"search":true},
                    { label:'Tipo de amonestacion', name: 'tipo_amonestacion', width: 60,"search":true },
                    { label:'Motivo', name: 'motivo', width: 50 ,"search":true},
   

                ],

                jsonReader: {repeatitems:false, root:"vacaciones"},
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
                        search: true,
                        searchicon : 'ace-icon fa fa-search orange',
                        refresh: true,
                        refreshicon : 'ace-icon fa fa-refresh green',
                        view: true,
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


        });
 