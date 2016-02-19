<?php 
	class vacacionesController extends Controller{

		private $_vacaciones;
		private $_personal;
		
		public function __construct(){

			//Hereda el constructor del Controlador Frontal para hacer el llamado a su modelo correspondiente
			parent::__construct();
			$this->_vacaciones = $this->loadModel('vacaciones');
			$this->_personal = $this->loadModel('personal');

		}
		




		function registro_vacaciones(){
					$check = $this->valCheckbox( $_POST['contador']);				
					$arregloPost = $this->ConvertirArraySql($check);
					$this->imprimirArreglo($arregloPost);


		}



		function index(){
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap",
			"Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables"
			,"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
			"moment","pickList","Librerias/jquery.maskedinput","utilidades"));
			$this->_view->setCss(array("bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone"));	
				$listado = $this->_personal->getPersonal();
				$this->_view->_listado = $listado;
				$this->_view->render('registro_vacaciones');
	
		}
	
	}
?>