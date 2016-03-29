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
				'link' => BASE_URL . 'correspondencia' . DS . 'agregar_carpeta'
						)
										);
		}
		
		function index(){
			$this->_view->setJs(array("Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","correspondencia/consulta_correspondencia","pickList","correspondencia/correspondencia"));	
			$this->_view->setCss(array("ui.jqgrid"));
				$this->_view->render('consulta_correspondencia','','',$this->_sidebar_menu);	
		}

		function registro_correspondencia(){
				$this->_view->setJs(array("pickList"));
				$correspondencia= $this->ConvertirArray($_POST);
				// $_POST=$_GET;
				// unset($_POST['url']);
				// $this->imprimirArreglo($_POST);
				$this->_correspondencia->insertCorrespondencia($correspondencia);
		}

		function registro(){
					$this->_view->setJs(array("Librerias/bootstrap-select",
												"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
												"pickList","correspondencia/select","correspondencia/correspondencia",
											"Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","utilidades"));

					$this->_view->setCss(array("bootstrap-select",
												"bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone"));
				
				$coordinacion = $this->_correspondencia->getCoordinacion();
				$this->_view->_coordinacion = $coordinacion;
				$this->_view->render('registro_correspondencia','','pickList');	
		}
		function consulta_correspondencia(){
					$listado=$this->_correspondencia->getCorrespondencia();
					echo json_encode(array("correspondencia"=>$listado));					
		}

		function agregar_carpeta(){
				$carpeta= $this->ConvertirArray($_POST);
				$this->_correspondencia->insertCarpeta($carpeta);
		}

		function selectCarpetas() {			
					$result = $this->_correspondencia->getCarpetas();
					$data = array();

					for ($i = 0; $i < count($result); $i++) {
						$data[$i] = array("value"=>$result[$i]['id_carpeta_correspondencia'],"option"=>$result[$i]['carpeta']);
					}
					echo json_encode($data);
		}		


}?>