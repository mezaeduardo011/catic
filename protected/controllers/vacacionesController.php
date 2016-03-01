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

			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap",
			"Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables"
			,"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
			"moment","pickList","Librerias/jquery.maskedinput","utilidades","vacaciones/vacaciones"));
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
					$this->imprimirArreglo($vacaciones);
					$this->_vacaciones->registroVacaciones($vacaciones,$checkSeleccionados);

		}

		function consulta_vacaciones(){
			$this->_view->setJs(array("pickList","Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","jgrid"));
			$this->_view->setCss(array("ui.jqgrid"));
			$this->_view->render('consulta_vacaciones','','',$this->_sidebar_menu);

		}

		function personal_vacaciones(){
			$listado = $this->_vacaciones->getVacaciones();
			echo json_encode(array("vacaciones"=>$listado)); 
		}

		function leyendo_txt(){
			$file = fopen("/var/www/catic/public/horario_laboral/2016-02-26", "r") or exit("Unable to open file!");
			//Output a line of the file until the end is reached
			while(!feof($file)){

				echo fgets($file). "<br />";

			}

			fclose($file);
		}


		function CalcularDiasHabiles() {
		$fechasBd=$this->_administracion->getFechas();
		$fecha1 = strtotime($_POST['desde']); 
		$diasHabiles = $_POST['dias']; 

		$i=0; $totalDias=0; $data=array();		

			for($i;$i<=$diasHabiles+$totalDias;$i++){ 

				$fechaReincorporacion=strtotime('+'.$i.' day ' . date('Y-m-d',$fecha1)); //fecha reincorp

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

		// function CalcularDiasHabiles() {
		// $fechasBd=$this->_administracion->getFechas();
		// $fecha1 = strtotime($_POST['desde']); 
		// $fecha2 = strtotime($_POST['hasta']); 
		// $i=0; $j=0;$totalDias=0;

		// 	for($fecha1;$fecha1<=$diasHabiles;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){ 
				
		// 		    if((strcmp(date('D',$fecha1),'Sun')!=0) && (strcmp(date('D',$fecha1),'Sat')!=0)){
		// 		    	$i++;	
		// 		    } 
		// 	}


		// 	for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){ 
				
		// 		    if((strcmp(date('D',$fecha1),'Sun')!=0) && (strcmp(date('D',$fecha1),'Sat')!=0)){
		// 		    	$i++;	
		// 		    } 
		// 	}

		//  foreach($fechasBd as $key => $value){

		//     if((strcmp($fecha1,strtotime($fechasBd[$key]['fecha']))==0)){
		//     	$j++;
		//     }
		//  }
		// //$totalJ=$j-1;
		// //$totalDias=$i+$totalJ; 				
		// 	echo json_encode($i);

		// }


	
	}
?>