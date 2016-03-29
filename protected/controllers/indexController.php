<?php 

class indexController extends Controller{
	
	public function __construct(){

		
		parent::__construct();
		
	}
	
	function  index(){

			
			$this->_view->setJs(array("jquery.fancybox.pack","jquery.flexslider","custom"));

			$this->_view->setCss(array("flexslider"));		
		$this->_view->render('index');

	
	}
	
	
	
	
}


?>