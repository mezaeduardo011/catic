<?php 

class indexController extends Controller{
	
	public function __construct(){

		
		parent::__construct();
		
	}
	
	function  index(){

		//Session::get('authenticated')
		
		$this->_view->render('index');

	
	}
	
	
	
	
}


?>