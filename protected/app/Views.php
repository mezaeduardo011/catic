<?php
	class View {
		
		private $_controller;
		private $_js;
		private $_css;
		
		public function __construct(Request $request) {			
		
			$this->_controller = $request->getController();
			$this->_js = array();
			$this->_css = array();
		}
	
		public function render($view, $menu = FALSE, $layout = FALSE, $sidebar_menu=false) {
			
			$login = array(
				'icon'	=>'fa-sign-out',
				'id'	=>'signout',
				'name'	=> utf8_encode('Cerrar Sesión'),
				'href'	=> BASE_URL . 'login/close'
			);
			
			if(Session::get('level')==60){
			$menu = array(
								array(
					            'id' => 'personal',
					            'title'   => 'Personas',
					            'link'=> BASE_URL . 'personal',
					            'submenu' => array(
						            	array(
										'id' => 'insert_new',
										'title' => 'Registrar persona',
										'link' => BASE_URL . 'personal' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar personal registrado',
									 	'link' => BASE_URL . 'personal' . DS . 'listing'
									 			)				            	
					            )//Fin del submenu									 			
						      ),
						      
						      array(
					            'id' => 'actividad_institucional',
					            'title'   => 'Vacaciones',
					            'link'=> '',
					       	    'submenu' => array(
											array(
										'id' => 'insert_new',
										'title' => 'Registrar vacaciones',
										'link' => BASE_URL . 'vacaciones' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar vacaciones',
									 	'link' => BASE_URL . 'vacaciones' . DS . 'consulta_vacaciones'
									 			)					            	
					            )//Fin del submenu	
						      ),
						      
						      array(
					            'id' => 'actividad_institucional',
					            'title'   => 'Permisos/Reposos',
					            'link'=> '',
					       	    'submenu' => array(
											array(
										'id' => 'insert_new',
										'title' => 'Registrar permiso/reposo',
										'link' => BASE_URL . 'permisos' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar permiso/reposo',
									 	'link' => BASE_URL . 'permisos' . DS . 'listar_permisos'
									 			)					            	
					            )//Fin del submenu	
						      ),
						      
						      array(
					            'id' => 'actividad_institucional',
					            'title'   => 'Amonestaciones',
					            'link'=> '',
					       	    'submenu' => array(
										array(
										'id' => 'insert_new',
										'title' => 'Asignar amonestacion',
										'link' => BASE_URL . 'amonestacion' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar amonestaciones',
									 	'link' => BASE_URL . 'amonestacion' . DS . 'listar_amonestaciones'
									 			)						            	
					            )//Fin del submenu	
						      ),

						      array(
					            'id' => 'actividad_institucional',
					            'title'   => 'Actividades',
					            'link'=> BASE_URL . 'actividad_institucional',
					       	    'submenu' => array(
											array(
										'id' => 'insert_new',
										'title' => 'Registrar nueva actividad',
										'link' => BASE_URL . 'actividad_institucional' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar actividades',
									 	'link' => BASE_URL . 'actividad_institucional' . DS . 'consultaDeActividad'
									 			)					            	
					            )//Fin del submenu	
						      ),array(
					            'id' => 'correspondencia',
					            'title'   => 'Correspondencias',
					            'link'=> BASE_URL . 'correspondencia'
						      ),array(
					            'id' => 'biometrico',
					            'title'   => 'Control de asistencias',
					            'link'=> BASE_URL . 'biometrico'
						      ),array(
					            'id' => 'actividad_institucional',
					            'title'   => 'Usuarios',
					            'link'=> BASE_URL . 'administracion' . DS . 'usuarios'
						      )	      
					  	 );	
				}elseif(Session::get('level')==62){
			$menu = array(
								array(
					            'id' => 'personal',
					            'title'   => 'Personas',
					            'link'=> BASE_URL . 'personal',
					            'submenu' => array(
						            	array(
										'id' => 'insert_new',
										'title' => 'Registrar persona',
										'link' => BASE_URL . 'personal' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar personal registrado',
									 	'link' => BASE_URL . 'personal' . DS . 'listing'
									 			)				            	
					            )//Fin del submenu									 			
						      ),
						      
						      array(
					            'id' => 'actividad_institucional',
					            'title'   => 'Vacaciones',
					            'link'=> '',
					       	    'submenu' => array(
											array(
										'id' => 'insert_new',
										'title' => 'Registrar vacaciones',
										'link' => BASE_URL . 'vacaciones' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar vacaciones',
									 	'link' => BASE_URL . 'vacaciones' . DS . 'consulta_vacaciones'
									 			)					            	
					            )//Fin del submenu	
						      ),
						      
						      array(
					            'id' => 'actividad_institucional',
					            'title'   => 'Permisos/Reposos',
					            'link'=> '',
					       	    'submenu' => array(
											array(
										'id' => 'insert_new',
										'title' => 'Registrar permiso/reposo',
										'link' => BASE_URL . 'permisos' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar permiso/reposo',
									 	'link' => BASE_URL . 'permisos' . DS . 'listar_permisos'
									 			)					            	
					            )//Fin del submenu	
						      ),
						      
						      array(
					            'id' => 'actividad_institucional',
					            'title'   => 'Amonestaciones',
					            'link'=> '',
					       	    'submenu' => array(
										array(
										'id' => 'insert_new',
										'title' => 'Asignar amonestacion',
										'link' => BASE_URL . 'amonestacion' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar amonestaciones',
									 	'link' => BASE_URL . 'amonestacion' . DS . 'listar_amonestaciones'
									 			)						            	
					            )//Fin del submenu	
						      ),

						      array(
					            'id' => 'actividad_institucional',
					            'title'   => 'Actividades',
					            'link'=> BASE_URL . 'actividad_institucional',
					       	    'submenu' => array(
											array(
										'id' => 'insert_new',
										'title' => 'Registrar nueva actividad',
										'link' => BASE_URL . 'actividad_institucional' . DS . 'index'
												),
									 		array(
									 	'id' => 'listar',
									 	'title' => 'Consultar actividades',
									 	'link' => BASE_URL . 'actividad_institucional' . DS . 'consultaDeActividad'
									 			)					            	
					            )//Fin del submenu	
						      ),array(
					            'id' => 'correspondencia',
					            'title'   => 'Correspondencias',
					            'link'=> BASE_URL . 'correspondencia'
						      ),array(
					            'id' => 'biometrico',
					            'title'   => 'Control de asistencias',
					            'link'=> BASE_URL . 'biometrico'
						      ),array(
					            'id' => 'adiministracion',
					            'title'   => 'Usuarios',
					            'link'=> BASE_URL . 'administracion' . DS . 'usuarios'
						      )				      
					  	 );	
					 }

			$js = array();
			$css = array();
			
			if (count($this->_js)) {
				$js = $this->_js;
			}
			
			if (count($this->_css)) {
				$css = $this->_css;
			}
			
			$_view_params = array(					
				'menu' => $menu,
				'sidebar_menu' => $sidebar_menu,

				'js' => $js,
				'css' => $css,
				'login' => $login,
			);

			//print_r($_view_params);die();					
			
			$view_route = ROOT . 'protected' . DS . 'views' . DS . $this->_controller . DS . $view . '.phtml';
			
			if (is_readable($view_route)) {
				
				switch ($layout) {
					
					case 'modal': 
						include_once ROOT . 'protected' . DS . 'views' . DS . 'layout/modal' . DS . 'statements.phtml';
						include_once $view_route;
						include_once ROOT . 'protected' . DS . 'views' . DS . 'layout/modal' . DS . 'footer.phtml';
					break;
							
					case 'login':
						//include_once ROOT . 'protected' . DS . 'views' . DS . 'layout/login' . DS . 'statements.phtml';
						include_once $view_route;
						//include_once ROOT . 'protected' . DS . 'views' . DS . 'layout/login' . DS . 'footer.phtml';
					break;
					
					case 'error': //error view
						include_once ROOT . 'protected' . DS . 'views' . DS . 'layout/error' . DS . 'statements.phtml';
						include_once $view_route;
						include_once ROOT . 'protected' . DS . 'views' . DS . 'layout/error' . DS . 'footer.phtml';
					break;

					case 'index': //error view
						include_once ROOT . 'protected' . DS . 'views' . DS . 'layout/error' . DS . 'statements.phtml';
						include_once $view_route;
						include_once ROOT . 'protected' . DS . 'views' . DS . 'layout/error' . DS . 'footer.phtml';
					break;

					case 'pdf': 
						//include_once ROOT . 'protected' . DS . 'data' . DS . 'layout/modal' . DS . 'statements.phtml';
						include_once $view_route;
						//include_once ROOT . 'protected' . DS . 'data' . DS . 'layout/modal' . DS . 'footer.phtml';
					break;

					case 'pickList': 
						include_once ROOT . 'protected' . DS . 'views' . DS . 'pickList' . DS . 'statements.phtml';
						include_once $view_route;
						include_once ROOT . 'protected' . DS . 'views' . DS . 'pickList' . DS . 'footer.phtml';
					break;
							

					default:
						include_once ROOT . 'protected' . DS . 'views' . DS . 'layout' . DS . 'statements.phtml';
						 //include_once ROOT . 'protected' . DS . 'views' . DS . 'layout' . DS . 'header.phtml';
						 // include_once ROOT . 'protected' . DS . 'views' . DS . 'layout' . DS . 'imagalery.phtml';
						include_once ROOT . 'protected' . DS . 'views' . DS . 'layout' . DS . 'sidebar.phtml';
						 include_once $view_route;
						include_once ROOT . 'protected' . DS . 'views' . DS . 'layout' . DS . 'footer.phtml';
					break;
				}
				
			}else{
				
				throw new Exception('LA VISTA: "'. $view_route .'" NO FUE ENCONTRADA.');
			}				
		}
		
		public function redirect($route = NULL) {
			if ($route) {
				header('location:' . BASE_URL . $route );
				exit();
			}else {
				header('location:' . BASE_URL );
				exit();
			};
		}
		
		public function setJs(array $js) {
			if (is_array($js) && count($js)) {
				for ($i = 0; $i < count($js); $i++) {
					$this->_js[] = JS_PATH . $js[$i] . '.js';
				}
			}else {
				throw new Exception('El archivo: '. $js . ' No fue encontrado');
			}
		}
		
		public function setCss(array $css) {
			if (is_array($css) && count($css)) {
				for ($i = 0; $i < count($css); $i++) {
					$this->_css[] = CSS_PATH . $css[$i] . '.css';
				}
			}else {
				throw new Exception('El archivo: '. $css . ' No fue encontrado');
			}
		}
	}
	
	/*
	 * bucle para el menu y submenu
	 * 
	   <?php 
			if ($_view_params['menu']) {
				for ($i = 0; $i < count($_view_params['menu']); $i++){
					if (isset($_view_params['menu'][$i]['sub'])) {
						echo '<a href="'.$_view_params['menu'][$i]['href'].'">';
						for ($j = 0; $j < count($_view_params['menu'][$i]['sub']); $j++){
							echo '<a href="'.$_view_params['menu'][$i]['sub'][$j]['href'].'"></a>';
						}
					}else{
						echo '<a href="'.$_view_params['menu'][$i]['href'].'"></a>';
					}
				}
        	}
		?>
	 */
	
?>