<?php 
	class biometricoController extends Controller{
		
		
		protected $_sidebar_menu;
		private $_biometrico;
		
		public function __construct(){	
			parent::__construct();
			$this->_biometrico = $this->loadModel('correspondencia');
						$this->_sidebar_menu =array(
					array(
				'id' => 'insert_new',
				'title' => 'Agregar nueva carpeta',
				'link' => BASE_URL . 'correspondencia' . DS . 'agregar_carpeta'
						)
										);
		}
		
		function index(){
				$file = file('/home/ehidalgo/Documentos/prueba.txt');
				foreach ($file as $linea)
				{
				$explode = explode("|", $linea);
				$arrayOrdenado[]=$linea;
				} 
				$j=0;
				for($i=0;$i<count($arrayOrdenado);$i++){
					 $nuevoArreglo[$i]=$arrayOrdenado[$i];									
					 $var[$i] = str_replace(" ",",",$nuevoArreglo[$i] );
					 $var[$i]= explode(",", $var[$i] );
					 if($var[$i][5]!="OTIC"){
					 	unset($var[$i]);
					 }else{
						 $arregloValido[$j]=$var[$i];
						 $j++;
					 }
				}

				for($k=0;$k<count($arregloValido);$k++){
							$cedula = number_format($arregloValido[$k][1], 0, '.', '.');
							$fechaBiometrico = $arregloValido[$k][0];
							$año=substr($fechaBiometrico, 0, 2);$mes = substr($fechaBiometrico, 2, 2);$dias = substr($fechaBiometrico, 4, 2);
							$horaBiometrico=$arregloValido[$k][4];
						    $hora = substr($horaBiometrico, 0, 2);$minutos = substr($horaBiometrico, 2, 2);

						$horario= array(
									':fecha' => $dias.'/'.$mes.'/'.$año,
									':cedula' => $cedula,
									':hora' => $hora.':'.$minutos,
									':id_biometrico' => $arregloValido[$k][7]
						);					
						print_r($horario);
						echo "<br>";
						//$this->imprimirArreglo($horario);
						//$this->_biometrico->insertHorario($horario);
				}
				//$this->imprimirArreglo($arregloValido);								
		}

}?>