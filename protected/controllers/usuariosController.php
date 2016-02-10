<?php 
	class usuariosController extends Controller{

		private $_usuario;
		private $_personal;
		
		public function __construct(){

			//Hereda el constructor del Controlador Frontal para hacer el llamado a su modelo correspondiente
			parent::__construct();
			$this->_usuario = $this->loadModel('usuarios');
			$this->_personal = $this->loadModel('personal');

		}
		

		function index(){
	

				$this->_view->setJs(array(
				"Librerias/formValidation","Librerias/bootstrapValidator.min","validaciones",
				"Librerias/fuelux.wizard","form-wizard",
				"Librerias/bootstrap-datepicker",
				"Librerias/jquery.maskedinput",
				"registroPersona/registroPersona"));

				//Se pinta la vista con el metodo render.
				$this->_view->render('administracion');
	
		}
	

		function usuarios(){

			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables",
			"pickList"));

			$listado = $this->_usuario->getUsuarios();

			$this->_view->_listado = $listado;

			$this->_view->render('usuarios');
		}

		function listarPersonal(){
				
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables",
			"pickList"));

			$listado = $this->_personal->getPersonal();

			$this->_view->_listado = $listado;

			$this->_view->render('personalCompleto','','pickList');
		}
	}
?>