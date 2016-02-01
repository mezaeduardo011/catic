<?php
	class Request {
		
		private $_controller;
		private $_method;
		private $_arguments;

		function __construct() {			
			
			if (isset($_GET['url'])) {				
				 
				$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
				
				$url = explode('/', $url);
				
				$url = array_filter($url);
								
				$this->_controller = strtolower( array_shift($url) );
				$this->_method = strtolower( array_shift($url) );
				$this->_arguments = $url;				
			}
						
			if (!$this->_controller) {
				$this->_controller = DEFAULT_CONTROLLER;
			}			
			if (!$this->_method) {
				$this->_method = DEFAULT_METHOD;
			}			
			if (!isset($this->_arguments)) {
				$this->_arguments = array();
			}
		}
				
		public function getController() {
			return $this->_controller;
		}
		public function getMethod() {
			return $this->_method;
		}
		public function getArguments() {
			return $this->_arguments;
		}

			function valCheckbox($contador){
				$count = $contador;							
				$data = array();
					for ($i = 0; $i <= $count; $i++) {
						if(isset($_POST['check'.$i]) && !($_POST['check'.$i]==" ")){
							$data[$i] =  $_POST['check'.$i];
							}
					}
							for ($i=0; $i <= count($data); $i++) { 
						if(isset($data[$i]) && !($data[$i]==" ")){
							}
					}
				//print_r($data);
				return $data;
			}
	}
?>