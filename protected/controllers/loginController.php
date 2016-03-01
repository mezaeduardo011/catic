	<?php
	class loginController extends Controller {
		private $_login;
		public function __construct() {
			parent::__construct();
			$this->_login = $this->loadModel('login');
			$this->_sidebar_menu = false;
		}
		
		function index() {
				$this->_view->render('access', '','login');
		}
		
		public function signIn() {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				$data = $this->_login->getUser($_POST['user_name'], $_POST['password']);
						
				// if ($data==null || $data=="") {
				// 	$this->_view->_error = 'Usuario o contraseña no existen';
				// 	$this->_view->render('access', '','login');
				// 	exit();
				// }
			    

				Session::set('authenticated', true);
				Session::set('level', $data['perfil_referencial']);
				Session::set('user', $data['nombre'].', '.$data['apellido']);	
				
				Session::set('time', time());

				 switch ($data['perfil_referencial']) {
					case 60:						
						$this->_view->redirect('personal');
					break;
				 }
			}else {
		
				$this->_view->render('access', '','login');
			}
		}
			
		public function close($param) {
			Session::destroy();
			$this->_view->redirect('login');
		}


	
	}
?>