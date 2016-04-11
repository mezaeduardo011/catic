<?php 
	class biometricoController extends Controller{
		
		
		protected $_sidebar_menu;
		private $_biometrico;
		
		public function __construct(){	
			parent::__construct();
			$this->_biometrico = $this->loadModel('biometrico');
						$this->_sidebar_menu =array(
					array(
				'id' => 'insert_new',
				'title' => 'Agregar nueva carpeta',
				'link' => BASE_URL . 'correspondencia' . DS . 'agregar_carpeta'
						)
										);
		}
		
		function index(){
			$this->_view->setJs(array("pickList","Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","biometrico/consulta_biometrico"));
			$this->_view->setCss(array("ui.jqgrid"));
			$this->_view->render('consulta_biometrico','','',$this->_sidebar_menu);
								
		}

		function leerTxt(){
				$file = file('/home/emeza/Documentos/prueba.txt');
				foreach ($file as $linea)
				{
				$explode = explode("|", $linea);
				$arrayOrdenado[]=$linea;
				} 

				$j=0;
				for($i=0;$i<count($arrayOrdenado)-1;$i++){
					 $nuevoArreglo[$i]=$arrayOrdenado[$i];									
					//$var[$i] = str_replace(" ",",",$nuevoArreglo[$i] );
					 $var[$i]= explode(",", $nuevoArreglo[$i] );
					 if(rtrim($var[$i][5])!="OTIC"){
					 	unset($var[$i]);
					 }else{
						 $arregloValido[$j]=$var[$i];
						  $j++;
					 }
				}	
			 $cont=0;
			 for($i=0;$i<count($arregloValido);$i++){
			 	if(isset($arregloValido[$i][1])){
			 		$cont++;
			 	}
			 }
			return $arregloValido;		
		}

		function guardarHorarioDiario(){

				$datosValidos=$this->leerTxt();
				for($k=0;$k<count($datosValidos);$k++){
					   if($this->_biometrico->getPulsador($datosValidos[$k][0])==null){
							$horario= array(
										':pulsador' => $datosValidos[$k][0],
										':cedula' => number_format(rtrim($datosValidos[$k][7]), 0, '.', '.'),
										':hora' => $datosValidos[$k][1],
							);
							$this->_biometrico->insertHorario($horario);
						}							
				}
		}

		function consulta_biometrico(){
			$listado = $this->_biometrico->getBiometrico();
			echo json_encode(array("biometrico"=>$listado)); 
		}
}?>