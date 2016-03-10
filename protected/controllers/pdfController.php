<?php 
	class pdfController extends Controller{
				
		public function __construct(){
	
			parent::__construct();
			$this->_pdf = $this->getLibrary('dompdf','dompdf_config.inc');
			$this->_personal = $this->loadModel('personal');
	
		}
		
		function index(){
	
		}

		function pdfDetallePersona($id=false,$id_persona_empleada=false){
			$hijos = $this->_personal->getHijosEmpleado($id_persona_empleada);
			$this->_view->_hijos  = $hijos;
			$persona = $this->_personal->getUnicaPersona($id);
			$this->_view->_persona  = $persona;
			$this->_view->render('pdfDetallePersona', 'personal', 'pdf','');

		}

}?>