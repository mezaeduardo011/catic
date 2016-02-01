<?php
	abstract class Controller extends Complement{
		
		protected $_view;
		
		public function __construct() {
			$this->_view = new View(new Request);
		}
	
		abstract public function index();
	
		protected function loadModel($model) {
			
			$model = $model . 'Model';
			$model_route = ROOT . 'protected' . DS . 'models' . DS . $model . '.php';
						
			if (is_readable($model_route)) {
				
				require_once $model_route;
				$model = new $model;
				return $model;
				
			}else {
				
				throw new Exception('EL ARCHIVO: "'. $model_route .'" NO ENCONTRADO.');
				
			}
		}
		
		protected function getLibrary($carpeta=FALSE,$lib) {
			if ($carpeta!=FALSE) {
			$route = ROOT . 'libs' . DS . $carpeta . DS. $lib . '.php';

			}else{
				$route = ROOT . 'libs' . DS . $lib . '.php';
			}
			if (is_readable($route)) {
				require_once $route;
			}else{
				throw new Exception('Error de libreria');
			}
		}
		
		public static function varDump($ar = array()) {
			echo '<pre>';
				print_r($ar);
			echo '</pre>';
		}
		
		public static function saveDate($date) {
			
			$result = date("Y-m-d", strtotime($date) );
			return $result;
		}
		
		public static function getDate($date) {
			
			$result = date("d-m-Y", strtotime($date) );
			return $result;
		}
		
		/**
		 * Metodo para redimencionar una imagen y subirla al servidor
		 * 
		 * las dimeciones standar para una foto carnet son 240 x 320
		 * y para una cedula 640 x 480
		 * 
		 * @param $file: 	input[type=file]
		 * @param $pre:		pic_, dni_, car_
		 * @param $name:	nombre img
		 * @param $width:	ancho
		 * @param $height:	alto
		 */
		
		
		public static function modelSession() {
			$model = 'sessionModel';
			$model_route = ROOT . 'protected' . DS . 'models' . DS . $model . '.php';
						
			if (is_readable($model_route)) {				
				require_once $model_route;
				$model = new $model;
				return $model;				
			}else {				
				throw new Exception('EL ARCHIVO: "'. $model_route .'" NO ENCONTRADO.');				
			}
		}
		
		
		
		/**
		 * 
		 * @param unknown $title
		 * @param unknown $content
		 * @param unknown success, info, warning or danger
		 * @return string
		 */
		public static function getBoxAlert($content) {
			$messeger = '
				<div class="alert alert-error hide">
					<a class="close" data-dismiss="alert" href="ui_elements.html#"><i class="fa fa-close"></i></a>
						'.$content.'
				</div>';
			return $messeger;
		}
				
	}
?>