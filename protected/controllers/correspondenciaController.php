<?php 
	class correspondenciaController extends Controller{
		
		
		protected $_sidebar_menu;
		private $_correspondencia;
		
		public function __construct(){
	
			parent::__construct();
			$this->_correspondencia = $this->loadModel('correspondencia');
		//Objeto donde almacenamos todas las funciones de PersonsModel.php

		}
		
		function index(){
					$this->_view->setJs(array("Librerias/bootstrap-select",
												"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min"));
					$this->_view->setCss(array("bootstrap-select",
												"bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone"));
				$coordinacion = $this->_correspondencia->getCoordinacion();
				$this->_view->_coordinacion = $coordinacion;
				$this->_view->render('registro_correspondencia');	
		}

		function registro_correspondencia(){

	
		}

}?>