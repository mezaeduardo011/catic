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
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables"
			,"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min","moment",
			"pickList","Librerias/jquery.maskedinput"));

			$this->_view->setCss(array("bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone"));	
				//Me manda el listado del personal para seleccionar la asignacion de Vacaciones de forma masiva.
				$listado = $this->_personal->getPersonal();

				//Crea el objeto de la clase vista para pintarle los datos
				$this->_view->_listado = $listado;

				//Pinta la vista
				$this->_view->render('registro_vacaciones');
		}



		function index(){
	

				$this->_view->setJs(array(""));
				$this->_view->setCss(array(""));	
				//Se pinta la vista con el metodo render.
				$this->_view->render('vacaciones');
	
		}
	
	}
?>