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
			$listado = $this->_persona->getPersonalDisponible();
			$this->_view->_listado = $listado;
			$this->_view->render('registro_de_actividad','','',$this->_sidebar_menu);
	
		}

		function insert(){	
					unset($_POST['dynamic-table_length']);
					$check = $this->valCheckbox( $_POST['contador']);
					$contador=$_POST['contador'];	
					unset($_POST['contador']);	

					// $dia=strtotime($_POST['fecha_actividad']);
					// $diaSeleccionado= date("N",$dia);
				
					// $fecha = $_POST['fecha_actividad'];
					// $año=substr($fecha, 0, 4);$mes = substr($fecha, 5, 2);
					// $horaRecibida=$_POST['hora'];
					// $hora = substr($horaRecibida, 0, 2);$minutos = substr($horaRecibida, 3, 2);					
					
					// $file=fopen("/etc/crontab","a") or die("Error abriendo el archivo");					  
					//   fputs($file,$minutos." ".$hora."    ".$diaSeleccionado." ".$mes." ".$año);
					//   fputs($file,"\n");
					//   fclose($file);

					// die();

					$checkSeleccionados = $this->ConvertirArraySql($check);
					$arregloValido = $this->ConvertirArray($_POST);
					$actividad=$this->borrarCheckbox($contador,$arregloValido);					
					$this->_actividad->insertActividad($actividad,$checkSeleccionados);	
					$this->_view->redirect('actividad_institucional/consultaDeActividad');
			}	
	

			function consultaDeActividad(){
			$this->_view->setJs(array(
			
			"pickList","Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min","Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","actividades/consulta","Librerias/bootstrap-timepicker.min","actividades/actividades"));		
			$this->_view->setCss(array("ui.jqgrid"));		

				$listado = $this->_actividad->getActividad();
				$this->_view->_listado = $listado;			
				$this->_view->render('consultar_actividad', 'persons', '',$this->_sidebar_menu);
			}



		function detalles($id = false){
			$this->_view->setJs(array("pickList"));							
				$actividad = $this->_actividad->getDetalles($id);
				$this->_view->_actividad = $actividad;
				$this->_view->render('detalles','','pickList');
		}

		function getActividades(){
			$listado = $this->_actividad->getActividad();
			echo json_encode(array("actividades"=>$listado)); 
		}		

	function fin($id= FALSE){				
		if(isset($id)&& !empty($id)){	
				$this->_view->setJs(array("pickList"));		
				$datos = $this->_actividad->getActividadUnica($id);
				$this->_view->_datos = $datos;				
				$this->_view->render('finalizar_actividad','','pickList');		
		}else {
			$this->_actividad->finalizarActividad($_POST['id_actividad_institucional'],TRUE);			
		}
	}

	function cancelar($id= FALSE){				
		if(isset($id)&& !empty($id)){	
				$this->_view->setJs(array("pickList"));		
				$datos = $this->_actividad->getActividadUnica($id);
				$this->_view->_datos = $datos;				
				$this->_view->render('cancelar_actividad','','pickList');		
		}else {
			$this->_actividad->finalizarActividad($_POST['id_actividad_institucional']);			
		}
	}	

}
?>