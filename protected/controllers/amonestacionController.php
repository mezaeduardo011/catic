<?php 
	class amonestacionController extends Controller{
		private $_amonestacion;
		
		public function __construct(){
			//Heredado del Controlador Frontal. Y se carga el Modelo correspondiente al controlador.
			parent::__construct();
			$this->_amonestacion = $this->loadModel('amonestacion');
		}
		
		function index(){
				$this->_view->render('amonestacion');
		}
	}
?>