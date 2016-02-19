<?php 
	class actividad_institucionalController extends Controller{
		
		
		protected $_sidebar_menu;
		private $_actividad;
		
		public function __construct(){
			
			parent::__construct();
			$this->_actividad = $this->loadModel('actividad');
			$this->_persona = $this->loadModel('personal');

		}
		
		function index(){

			$listado = $this->_persona->getPersonal(FALSE,1);
			$this->_view->_listado = $listado;
			$this->_view->render('registro_de_actividad');
	
		}

		function insert(){

				if ($_SERVER['REQUEST_METHOD']=='POST') {
					
					$contador= $_POST['contador'];
					$check = $this->valCheckbox($contador);
					$actividad = $this->ConvertirArray($_POST);
					unset($actividad[':contador']);					
					print_r($actividad);die();

					$arregloPost = $this->ConvertirArraySql($check);

				 	$this->_actividad->insertActividad($actividad,$arregloPost);	
					$this->_view->render('actividad_institucional');
	
				}else{ 

					$this->_view->render('insert', 'actividad_institucional');
			
				}

			}	
	

			function consultaDeActividad(){

				$listado = $this->_actividad->getActividad();
				$this->_view->_listado = $listado;
				
				$this->_view->render('consultar_actividad', 'persons', '',$this->_sidebar_menu);
			}


			function personasAsignadas($id = false){
				$listado = $this->_actividad->getActividadDetalle($id);
				$this->_view->_listado = $listado;				
				$this->_view->render('personasAsignadas', '', 'pickList');
			}								
}
?>