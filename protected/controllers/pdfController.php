<?php 
	class pdfController extends Controller{
				
		public function __construct(){
	
			parent::__construct();
			$this->_pdf = $this->getLibrary('dompdf','dompdf_config.inc');
			$this->_personal 		= $this->loadModel('personal');
			$this->_biometrico 		= $this->loadModel('biometrico');
			$this->_amonestacion 	= $this->loadModel('amonestacion');	
		}
		
		function index(){
	
		}

		function pdfDetallePersona($id=false,$id_persona_empleada=false){
			$hijos = $this->_personal->getHijosEmpleado($id_persona_empleada);
			$this->_view->_hijos  = $hijos;
			$persona = $this->_personal->getUnicaPersona($id);
			$this->_view->_persona  = $persona;
			$deporte = $this->_personal->getDeportes($id_persona_empleada);
			$this->_view->_deporte = $deporte;
			$this->_view->render('pdfDetallePersona', 'personal', 'pdf','');

		}

		function pdfReporteCompleto(){
			$parametros=explode("-",$_POST['fecha']);
			$reporte = $this->_personal->getReporte($parametros[0]);
			
			$this->_view->_reporte  = $reporte;
			$inasistencias = $this->_biometrico->getInasistencias($parametros[0],$parametros[1]);
			//$this->imprimirArreglo($inasistencias);

			$aux=array();
			for($i=0; $i<count($inasistencias); $i++){
				$aux[$i]=$inasistencias[$i]['id_persona_empleada'];
			}
			$auxiliar = array_count_values($aux);
			$this->_view->_inasistencias = $auxiliar;
			$this->_view->render('pdfReporteCompleto', 'personal', 'pdf','');
		}		

		function pdfAmonestacion($id_persona,$id_amonestacion){
			$datos = $this->_amonestacion->amonestacionPersona($id_persona,$id_amonestacion);
			$this->_view->_datos = $datos;		
			$this->_view->render('pdfAmonestacion', 'amonestacion', 'pdf','');
		}	


		function generar(){
		$this->_view->setJs(array("Librerias/bootstrap-select"));

		$this->_view->setCss(array("bootstrap-select"));	

			$arrayFechas=$this->ArmarArrayFechas('01-04-2016',date('d-m-Y'));

			//$this->imprimirArreglo($arrayFechas);
			$this->_view->_fechas = $arrayFechas;
			$this->_view->render('generar_reporte');
		}		


		function ArmarArrayFechas($fechaInicio, $fechaFin){
			$arrayFechas=array();
			$arrayMes=array();
			$fechaMostrar = $fechaInicio;
			$i=0;
			while(strtotime($fechaMostrar) <= strtotime($fechaFin)) {
			$arrayFechas[$i]['fecha']=date("m-Y", strtotime($fechaMostrar));
			$arrayFechas[$i]['mes']=date("m", strtotime($fechaMostrar));
			$arrayFechas[$i]['año']=date("Y", strtotime($fechaMostrar));
			$fechaMostrar = date("d-m-Y", strtotime($fechaMostrar . " + 1 month"));
			$i++;
			}


			return $arrayFechas;
		}
}?>