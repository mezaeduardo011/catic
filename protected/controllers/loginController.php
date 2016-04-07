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

				if ($_POST['user_name']==null || $_POST['user_name']=="" ) {
			 		$this->_view->_error = 'Debe ingresar un usuario.';
				 	$this->_view->render('access', '','login');
				 	exit();
			    }
				if ($_POST['password']==null || $_POST['password']=="" ) {
			 		$this->_view->_error = 'Debe ingresar una contraseña.';
				 	$this->_view->render('access', '','login');
				 	exit();
			    }			    				

				$usuario = $this->_login->getUser($_POST['user_name'], false);

				if ($usuario['contraseña']=="nueva") {
					$this->_login->updatePass($_POST['password'], $usuario[0]);
				}

				$data = $this->_login->getUser($_POST['user_name'], $_POST['password']);
				if ($data==null || $data=="") {
			 		$this->_view->_error = 'El usuario o contraseña no existen.';
				 	$this->_view->render('access', '','login');
				 	exit();
			    }
			    

				Session::set('authenticated', true);
				Session::set('level', $data['perfil_referencial']);
				Session::set('user', $data['nombre'].' '.$data['apellido']);
				Session::set('cedula', $data['cedula']);
				Session::set('perfil', $data['perfil']);	
				
				Session::set('time', time());

				 //switch ($data['perfil_referencial']) {
				//	case 60:						
						$this->_view->redirect('personal');
				//	break;
				// }
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