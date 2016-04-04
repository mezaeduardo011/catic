<?php 
	class administracionController extends Controller{

		private $_administracion;
		private $_personal;
		
		public function __construct(){

			//Hereda el constructor del Controlador Frontal para hacer el llamado a su modelo correspondiente
			parent::__construct();
			$this->_administracion = $this->loadModel('administracion');
			$this->_personal = $this->loadModel('personal');

		}
		

		function index(){
			$this->_view->setJs(array("Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",				
			"administracion/administracion","utilidades","pickList"));
			$this->_view->setCss(array(
			"datepicker"));
			$this->_view->render('administracion');
	
		}
	

		function registrarFechas(){
		$fechas=$this->ConvertirArraySql($_POST);
		$this->_administracion->insertFechas($fechas);

		}

		function usuarios(){
			$this->_view->setJs(array("pickList","Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","administracion/consulta"));
			$this->_view->setCss(array("ui.jqgrid"));
			$this->_view->render('usuarios');
		}


		function getUsuarios(){
			$listado = $this->_administracion->getUsuarios();
			$this->_view->_listado = $listado;
			echo json_encode(array("usuarios"=>$listado));			
		}
		function listarPersonal(){
				
			$this->_view->setJs(array("pickList","Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","administracion/personalCompleto"));
			$this->_view->setCss(array("ui.jqgrid"));
			$listado = $this->_personal->getPersonal();

			$this->_view->_listado = $listado;

			$this->_view->render('personalCompleto','','pickList');
		}
	function agregar($id= FALSE){			

			$this->_administracion->agregarUsuario($id);			
		}			

	}
?>