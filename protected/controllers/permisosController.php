<?php 
	class permisosController extends Controller{
		
		
		protected $_sidebar_menu;
		private $_permisos;
		
		public function __construct(){	
			parent::__construct();
			$this->_permisos = $this->loadModel('permisos');
			$this->_personal = $this->loadModel('personal');
						$this->_sidebar_menu =array(
					array(
				'id' => 'insert_new',
				'title' => 'Registrar permiso',
				'link' => BASE_URL . 'permisos' . DS . 'agregar_carpeta'
						)
						);
		}
		
		function index(){
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables","pickList","Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min","permisos/permisos"
					));
		    
		    $this->_view->setCss(array("bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3"));  	

				$listado = $this->_personal->getPersonalDisponible();
				$this->_view->_listado = $listado;
				$this->_view->render('registro_permiso','','',$this->_sidebar_menu);	
		}

		function registro_permiso(){
					unset($_POST['dynamic-table_length']);
					unset($_POST['contador']);								
					$permiso = $this->ConvertirArray($_POST);
					//$this->imprimirArreglo($permiso);
					$this->_permisos->registroPermisos($permiso);
					$this->_view->redirect('permisos/listar_permisos');
		}	

			function listar_permisos(){
			$this->_view->setJs(array("pickList","Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","permisos/tablaPermisos"));
			$this->_view->setCss(array("ui.jqgrid"));
			$this->_view->render('consulta','','',$this->_sidebar_menu);

		}

		function consultar_permisos(){
			$listado = $this->_permisos->getPermisos();
			echo json_encode(array("vacaciones"=>$listado)); 
		}		

	function finPermiso($id= FALSE){
		if(isset($id)&& !empty($id)){	
				$this->_view->setJs(array("pickList"));		
				$datos = $this->_permisos->getPermisos($id);
				$this->_view->_datos = $datos;				
				$this->_view->render('finalizar_permiso','','pickList');		
		}else {
			$this->_permisos->finalizarPermiso($_POST['id_permiso'],true);			
		}
	}		
}?>