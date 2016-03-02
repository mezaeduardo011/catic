<?php 
	class amonestacionController extends Controller{
		private $_amonestacion;
		
		public function __construct(){
			parent::__construct();
			$this->_amonestacion = $this->loadModel('amonestacion');
			$this->_personal = $this->loadModel('personal');
			$this->_sidebar_menu =array(
					array(
				'id' => 'insert_new',
				'title' => 'Asignar amonestacion',
				'link' => BASE_URL . 'amonestacion' . DS . 'index'
						),
			 		array(
			 	'id' => 'listar',
			 	'title' => 'Consultar amonestaciones',
			 	'link' => BASE_URL . 'amonestacion' . DS . 'consulta_amonestaciones'
			 			)
					);			
		}
		
		function index(){
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap",
			"Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables"
			,"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
			"moment","pickList","Librerias/jquery.maskedinput","utilidades","pickList","Librerias/bootstrap-select",
			"selectDireccion","amonestacion/amonestacion"));

			$this->_view->setCss(array("bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone","bootstrap-select"));	

				$listado = $this->_personal->getPersonalDisponible();
				$this->_view->_listado = $listado;
				$this->_view->render('amonestacion','','',$this->_sidebar_menu);
	
		}

		function registro_amonestacion(){
					unset($_POST['dynamic-table_length']);
					$checkSeleccionado = $this->valCheckboxUnico( $_POST['contador'] );
					$contador=$_POST['contador'];	
					unset($_POST['contador']);								
					$arregloValido = $this->ConvertirArray($_POST);
					$amonestacion=$this->borrarCheckbox($contador,$arregloValido);
					$this->_amonestacion->registroAmonestacion($amonestacion,$checkSeleccionado);

		}

		function consulta_amonestaciones(){
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools",
			"Librerias/dataTables.colVis","tables","pickList"));

			$listado = $this->_amonestacion->getAmonestaciones();
			$this->_view->_listado = $listado;
			$this->_view->render('consulta_amonestaciones','','',$this->_sidebar_menu);

		}

		function confirmacionAjax(){

			$data['tipo_amonestacion_confirmacion']=$_POST['tipo_amonestacion'];
			$data['coordinacion_confirmacion']= $_POST['coordinacion'];
			echo json_encode($data);
				//$this->_view->render('confirmacion_amonestacion','','pickList');
				
			
		}

		function confirmacionVista(){

				$this->_view->render('confirmacion_amonestacion','','pickList');
				
			
		}				

		function selectTipoAmonestaciones() {
			
					$result = $this->_amonestacion->getTipoAmonestacion();
					$data = array();

					for ($i = 0; $i < count($result); $i++) {
						$data[$i] = array("value"=>$result[$i]['id_referencial'],"option"=>$result[$i]['referencia']);
					}

					echo json_encode($data);

		}		

		function SelectCoordinaciones(){

					$result = $this->_personal->getCoordinaciones();
					$data = array();

					for ($i = 0; $i < count($result); $i++) {
						$data[$i] = array("value"=>$result[$i]['id_coordinacion'],"option"=>$result[$i]['coordinacion']);
					}

					echo json_encode($data);

		}		

	function asignarAmonestacion($id= FALSE){		
		
		if(isset($id)&& !empty($id)){	
						$this->_view->setJs(array("pickList"));		
				$datos = $this->_amonestacion->getActividadUnica($id);
				$this->_view->_datos = $datos;				
				$this->_view->render('asignar_amonestacion','','pickList');			
		}else {
			
			$this->_amonestacion->finalizarActividad($_POST['id_actividad_institucional']);			
			
		}
	}		
	}
?>