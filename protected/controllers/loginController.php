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
		
						
				if (!$data) {
					$this->_view->_error = Controller::getBoxAlert(
							'Usuario no Existente O Contrase&ntilde;a Incorrecta'
					);
					$this->_view->render('access', '','login');
					exit();
				}
			    

				Session::set('authenticated', true);
				Session::set('level', $data['perfil']);
			
				
				Session::set('time', time());
				
				switch ($data['perfil']) {
					case 'Admin':
						Session::set('user', 'Sr(a). '.$data['nombre1'].', '.$data['apellido1']);
						$this->_view->redirect('index');
					break;
					
					default:
						Session::set('user', $data['nombres'].', '.$data['apellidos']);
						$this->_view->redirect();
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