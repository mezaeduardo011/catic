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
					$check = $this->valCheckbox( $_POST['contador']);
					$contador=$_POST['contador'];	
					unset($_POST['contador']);	
					$arregloValido = $this->ConvertirArray($_POST);
					$checkSeleccionado = $this->ConvertirArrayCheck($check);
					$vacaciones=$this->borrarCheckbox($contador,$arregloValido);
					//$this->imprimirArreglo($vacaciones);
					$this->_permisos->registroPermisos($vacaciones,$checkSeleccionado);

		}		
}?>