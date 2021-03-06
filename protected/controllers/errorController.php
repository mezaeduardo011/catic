<?php
	class errorController extends Controller {
		
		public function __construct() {
			parent::__construct();
			
			$this->_sidebar_menu =array(
			
					array(
							'id' =>'Volver',
							'title'=> 'Regresar',
							'link' => BASE_URL . 'persons' . DS . 'index'
		
		
					)
			);
		}
		
		public function index() {
			$this->_view->render('access', 'error');	
		}
		

		public function acessNull() {
			$this->_view->render('access', 'error');	
		}

		public function access($code) {
			
			$this->_view->type_layout = 'error';
			$this->_view->errorNum = $code;
			$this->_view->message = $this->_getError($code);
			$this->_view->render('access', 'error', $this->_sidebar_menu);
		}
		
		private function _getError($code = null) {
			
			if ($code) {
				if (is_int($code)) {
					$code = $code;
				}
			}else {
				$code = 'default';
			}
			
			$error['default'] = 'Mensaje de Error por defecto';
			$error['5050'] = 'Acceso restringido';
			$error['8080'] = 'Tiempo de sesión agotado';
			
			if (array_key_exists($code, $error)) {
				return $error[$code];
			}else {
				return $error['default'];
			}
		}
		
	}
?>