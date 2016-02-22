<?php 
	class correspondenciaController extends Controller{
		
		
		protected $_sidebar_menu;
		private $_correspondencia;
		
		public function __construct(){
	
			parent::__construct();
			$this->_correspondencia = $this->loadModel('correspondencia');
						$this->_sidebar_menu =array(
					array(
				'id' => 'insert_new',
				'title' => 'Agregar nueva carpeta',
				'link' => BASE_URL . 'personal' . DS . 'index'
						)
										);//cierre del sidebar
		}
		
		function index(){
			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables",
			"pickList"));	
					$correspondenciasRegistradas=$this->_correspondencia->getCorrespondencia();
				$this->_view->_listado = $correspondenciasRegistradas;
				$coordinacion = $this->_correspondencia->getCoordinacion();
				$this->_view->_coordinacion = $coordinacion;
				$this->_view->render('consulta_correspondencia','','',$this->_sidebar_menu);	
		}

		function registro_correspondencia(){
			$this->_view->setJs(array("pickList"));
				$correspondencia= $this->ConvertirArray($_POST);
				//$this->imprimirArreglo($correspondencia);
				$this->_correspondencia->insertCorrespondencia($correspondencia);

		}
		function registro(){
					$this->_view->setJs(array("Librerias/bootstrap-select",
												"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min","pickList"));
					$this->_view->setCss(array("bootstrap-select",
												"bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone"));
				
				$coordinacion = $this->_correspondencia->getCoordinacion();
				$this->_view->_coordinacion = $coordinacion;
				$this->_view->render('registro_correspondencia','','pickList');	
		}
		function consulta_correspondencia(){
				$this->_view->render('consulta_correspondencia');
		}		

}?>