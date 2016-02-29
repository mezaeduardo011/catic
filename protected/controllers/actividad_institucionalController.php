<?php 
	class actividad_institucionalController extends Controller{
		
		
		protected $_sidebar_menu;
		private $_actividad;
		
		public function __construct(){
			
			parent::__construct();
			$this->_actividad = $this->loadModel('actividad');
			$this->_persona = $this->loadModel('personal');
						$this->_sidebar_menu =array(
					array(
				'id' => 'insert_new',
				'title' => 'Registrar nueva actividad',
				'link' => BASE_URL . 'actividad_institucional' . DS . 'index'
						),
			 		array(
			 	'id' => 'listar',
			 	'title' => 'Consultar actividades',
			 	'link' => BASE_URL . 'actividad_institucional' . DS . 'consultaDeActividad'
			 			)
					);	

		}
		
		function index(){
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools",
			"Librerias/dataTables.colVis","tables","pickList","Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
			"Librerias/jquery.dataTables","Librerias/bootstrap-timepicker.min","actividades/actividades"));

			$this->_view->setCss(array(
			"datepicker","bootstrap-datepicker","bootstrap-timepicker.min"));			
			$listado = $this->_persona->getPersonal(FALSE,1);
			$this->_view->_listado = $listado;
			$this->_view->render('registro_de_actividad','','',$this->_sidebar_menu);
	
		}

		function insert(){	
					unset($_POST['dynamic-table_length']);
					$check = $this->valCheckbox( $_POST['contador']);
					$contador=$_POST['contador'];	
					unset($_POST['contador']);								
					$checkSeleccionados = $this->ConvertirArraySql($check);
					$arregloValido = $this->ConvertirArray($_POST);
					$actividad=$this->borrarCheckbox($contador,$arregloValido);
					$this->_actividad->insertActividad($actividad,$checkSeleccionados);	
					//$this->_view->render('consultar_actividad');


			}	
	

			function consultaDeActividad(){
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools",
			"Librerias/dataTables.colVis","tables","pickList","Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
			"Librerias/jquery.dataTables","Librerias/bootstrap-timepicker.min","actividades/actividades"));				
				$listado = $this->_actividad->getActividad();
				$this->_view->_listado = $listado;			
				$this->_view->render('consultar_actividad', 'persons', '',$this->_sidebar_menu);
			}



		function detalles($id = false){
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools",
			"Librerias/dataTables.colVis","tables","pickList","Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
			"Librerias/jquery.dataTables","Librerias/bootstrap-timepicker.min","actividades/actividades"));							
				$actividad = $this->_actividad->getDetalles($id);
				$this->_view->_actividad = $actividad;
				$this->_view->render('detalles','','pickList');
		}

	function fin($id= FALSE){		
		
		if(isset($id)&& !empty($id)){	
						$this->_view->setJs(array("pickList"));		
				$datos = $this->_actividad->getActividadUnica($id);
				$this->_view->_datos = $datos;				
				$this->_view->render('finalizar_actividad','','pickList');

			
		}else {
			
			$this->_actividad->finalizarActividad($_POST['id_actividad_institucional']);			
			
		}
	}

}
?>