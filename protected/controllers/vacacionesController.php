<?php 
	class vacacionesController extends Controller{

		private $_vacaciones;
		private $_personal;
		
		public function __construct(){
			parent::__construct();
			$this->_vacaciones = $this->loadModel('vacaciones');
			$this->_personal = $this->loadModel('personal');

			$this->_sidebar_menu =array(
					array(
				'id' => 'insert_new',
				'title' => 'Asignar vacaciones',
				'link' => BASE_URL . 'vacaciones' . DS . 'index'
						),
			 		array(
			 	'id' => 'listar',
			 	'title' => 'Consultar vacaciones asignadas',
			 	'link' => BASE_URL . 'vacaciones' . DS . 'consulta_vacaciones'
			 			)
					);			

		}
		
		function index(){
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap",
			"Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables"
			,"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
			"moment","pickList","Librerias/jquery.maskedinput","utilidades"));
			$this->_view->setCss(array("bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone"));	

				$listado = $this->_vacaciones->getPersonalDisponible();
				$this->_view->_listado = $listado;
				$this->_view->render('registro_vacaciones','','',$this->_sidebar_menu);
	
		}



		function registro_vacaciones(){
					unset($_POST['dynamic-table_length']);
					$check = $this->valCheckbox( $_POST['contador']);
					$contador=$_POST['contador'];	
					unset($_POST['contador']);								
					$checkSeleccionados = $this->ConvertirArraySql($check);
					$arregloValido = $this->ConvertirArray($_POST);
					$vacaciones=$this->borrarCheckbox($contador,$arregloValido);
					//$this->imprimirArreglo($vacaciones);
					$this->_vacaciones->registroVacaciones($vacaciones,$checkSeleccionados);

		}

		function consulta_vacaciones(){
			$this->_view->setJs(array("pickList","Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","jgrid"));
			$this->_view->setCss(array("ui.jqgrid"));
			$this->_view->render('consulta_vacaciones','','',$this->_sidebar_menu);

		}

		function personal_vacaciones(){
			$listado = $this->_vacaciones->getVacaciones();
			echo json_encode($listado); 
		}

		function leyendo_txt(){
			$file = fopen("/var/www/catic/public/horario_laboral/2016-02-26", "r") or exit("Unable to open file!");
			//Output a line of the file until the end is reached
			while(!feof($file)){

				echo fgets($file). "<br />";

			}

			fclose($file);
		}




	
	}
?>