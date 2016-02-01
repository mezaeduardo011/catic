<?php 
	class pdfController extends Controller{
				
		public function __construct(){
	
			parent::__construct();
			$this->_pdf = $this->getLibrary('fpdf','fpdf');
			$this->_personal = $this->loadModel('personal');
	
		}
		
		function index(){
	
		}

		function pdfActividadInstitucional(){

				$listado = $this->_personal->getPersonal();
				$this->_view->_listado = $listado;				
				$this->_view->render('pdfActividadInstitucional', 'personal', 'pdf','');
			// clase  metodo 	  vista    carpeta dentro de views 

		}

}?>