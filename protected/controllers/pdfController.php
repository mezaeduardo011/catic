<?php 
	class pdfController extends Controller{
				
		public function __construct(){
	
			parent::__construct();
			$this->_pdf = $this->getLibrary('dompdf','dompdf_config.inc');
			$this->_personal = $this->loadModel('personal');
	
		}
		
		function index(){
	
		}

		function pdfDetallePersona($id=false){

			$persona = $this->_personal->getUnicaPersona($id);
			//$this->imprimirArreglo($persona);
			$this->_view->_persona  = $persona;

				$this->_view->render('pdfActividadInstitucional', 'personal', 'pdf','');
			// clase  metodo 	  vista    carpeta dentro de views 

		}

}?>