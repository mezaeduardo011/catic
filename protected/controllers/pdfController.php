<?php 
	class pdfController extends Controller{
				
		public function __construct(){
	
			parent::__construct();
			$this->_pdf = $this->getLibrary('dompdf','dompdf_config.inc');
			$this->_personal = $this->loadModel('personal');
			$this->_biometrico = $this->loadModel('biometrico');
			$this->_amonestacion = $this->loadModel('amonestacion');
	
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
			$reporte = $this->_personal->getReporte();
			$this->_view->_reporte  = $reporte;
			$inasistencias = $this->_biometrico->getInasistencias();
			//$this->imprimirArreglo($inasistencias[0]['id_persona_empleada']);
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

}?>