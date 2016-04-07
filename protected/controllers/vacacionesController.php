<?php 
	class vacacionesController extends Controller{

		private $_vacaciones;
		private $_administracion;
		
		public function __construct(){
			parent::__construct();
			$this->_vacaciones = $this->loadModel('vacaciones');
			$this->_administracion = $this->loadModel('administracion');
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
			$this->_view->setJs(
				array(
						"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap",
						"Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables"
						,"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
						"moment","pickList","Librerias/jquery.maskedinput","utilidades","vacaciones/vacaciones"
					)
			);

			$this->_view->setCss(
				array(
						"bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3",
						"bootstrap-datepicker3.standalone"
					)
			);

			$listado = $this->_personal->getPersonalDisponible();
			$this->_view->_listado = $listado;
			$this->_view->render('registro_vacaciones','','',$this->_sidebar_menu);
	
		}



		function registro_vacaciones(){

			unset($_POST['dynamic-table_length']);
			unset($_POST['contador']);								
			$vacaciones = $this->ConvertirArray($_POST);
			//$this->imprimirArreglo($vacaciones);
			$this->_vacaciones->registroVacaciones($vacaciones);
			$this->_view->redirect('vacaciones/consulta_vacaciones');

		}

		function consulta_vacaciones(){

			$this->_view->setJs(
				array(
						"pickList","Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","jgrid"
					)
			);

			$this->_view->setCss(
				array(
						"ui.jqgrid"
					)
			);

			$this->_view->render('consulta_vacaciones','','',$this->_sidebar_menu);

		}

		function personal_vacaciones(){

			$listado = $this->_vacaciones->getVacaciones();
			echo json_encode(array("vacaciones"=>$listado)); 

		}


		function CalcularDiasHabiles() {

			$fechasBd=$this->_administracion->getFechas();
			$fecha1 = strtotime($_POST['desde']); 
			$diasHabiles = $_POST['dias']; 
			$i=0; 
			$totalDias=0; 
			$data=array();		

			for($i;$i<=$diasHabiles+$totalDias;$i++){ 

				$fechaReincorporacion=strtotime('+'.$i.' day ' . date('Y-m-d',$fecha1)); 

				$fechaHasta=strtotime('-1 day ' . date('Y-m-d',$fechaReincorporacion)); 

				if((strcmp(date('D',$fechaHasta),'Sun')==0)){
					$fechaHasta=strtotime('-3 day ' . date('Y-m-d',$fechaReincorporacion));
				}

				if((strcmp(date('D',$fechaReincorporacion),'Sun')==0) || (strcmp(date('D',$fechaReincorporacion),'Sat')==0)){
				    $totalDias++;
				} 
					
				foreach($fechasBd as $key => $value){

					if((strcmp(date($fechaReincorporacion),strtotime($fechasBd[$key]['fecha']))==0)){	
				    	$totalDias++;
					}

				}
			}

			$fechaReincorporacionFinal = date("Y/m/d",$fechaReincorporacion);
			$fechaHastaFinal= date("Y/m/d",$fechaHasta);
			$data['fecha_reincorporacion']=	$fechaReincorporacionFinal;	
			$data['fechaHasta']= $fechaHastaFinal;		
			echo json_encode($data);

		}

		function cancelar_vacaciones(){
			$limpieza = array("[","]",'"',);
			$vacaciones_persona = str_replace($limpieza,"",$_POST['id_persona']);
			$cancelada = $this->_vacaciones->cancelar_vacaciones($vacaciones_persona);
			echo json_encode($vacaciones_persona);
		}

	function finVacaciones($id= FALSE){					
		if(isset($id)&& !empty($id)){	
				$this->_view->setJs(array("pickList"));		
				$datos = $this->_vacaciones->getVacaciones($id);
				$this->_view->_datos = $datos;				
				$this->_view->render('finalizar_vacaciones','','pickList');		
		}else {
			$this->_vacaciones->finalizarVacaciones($_POST['id_vacaciones'],TRUE);			
		}
	}

	function cancelarVacaciones($id= FALSE){					
		if(isset($id)&& !empty($id)){	
				$this->_view->setJs(array("pickList"));		
				$datos = $this->_vacaciones->getVacaciones($id);
				$this->_view->_datos = $datos;				
				$this->_view->render('finalizar_vacaciones','','pickList');		
		}else {
			$this->_vacaciones->finalizarVacaciones($_POST['id_vacaciones'],false);			
		}
	}	
	
	}
?>