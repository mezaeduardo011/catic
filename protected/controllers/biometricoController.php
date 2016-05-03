<?php 
	class biometricoController extends Controller{
		
		
		protected $_sidebar_menu;
		private $_biometrico;
		
		public function __construct(){	
			parent::__construct();
			$this->_biometrico = $this->loadModel('biometrico');
			$this->_personas = $this->loadModel('personal');
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

		function actualizarAsistencia(){
				// if($this->_biometrico->getBiometrico()[0]['fecha']!=date('d-m-Y')){				
						//$this->imprimirArreglo($this->_biometrico->getBiometrico());
						$this->guardarHorarioDiario();
						$this->guardarHorarioFinal();
						$horario = $this->_biometrico->getBiometrico();
						$personas = $this->_personas->getPersonal();
						$fecha = $horario[0]['fecha'];			
						$aux=array();
						$k=0;

						for($i=0; $i<count($horario); $i++){
							for($j=0; $j<count($personas); $j++){
									if($personas[$j]['cedula']==$horario[$i]['cedula']){
										$aux[$k] = $j;
										$k++;
									}
							}	
						}

						for($i=0; $i<count($aux);$i++){				
							unset($personas[$aux[$i]]);
						}
						
						for($j=0; $j<count(array_keys($personas)); $j++){					
							$this->_biometrico->insertInasistencia($personas[array_keys($personas)[$j]]['id_persona_empleada'],$fecha);
						}
						$this->_view->redirect('biometrico/index');
			// }elseif($this->_biometrico->getBiometrico()[0]['fecha']==date('d-m-Y')){

			// 			$this->_view->_error = 'La Asistencia Ya Esta Actualizada A La Fecha Actual.';
			// 			$this->_view->redirect('biometrico/index');

			// 			 // echo "<script language='JavaScript'>"; 
			// 			 // 	echo "alert('La Asistencia Ya Esta Actualizada A La Fecha Actual');"; 
			// 			 // echo "</script>";
			// }else{
			// 			 echo "Error";				
			// }
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
			//$this->imprimirArreglo($arregloValido);	
		}

		function guardarHorarioDiario(){

				$datosValidos=$this->leerTxt();				
				for($k=0;$k<count($datosValidos);$k++){
					   if($this->_biometrico->getPulsador($datosValidos[$k][0])==null){
							$horario= array(
										':registro' => $datosValidos[$k][2],
										':pulsador' => $datosValidos[$k][0],
										':cedula' => number_format(rtrim($datosValidos[$k][7]), 0, '.', '.'),
										':hora' => $datosValidos[$k][1],
							);

							$this->_biometrico->insertHorario($horario);
						}							
				}
		}


		function guardarHorarioFinal(){

			$cedulas = $this->_biometrico->getCedulas();			
			
			for($i = 0; $i< count($cedulas); $i++){

					$horasEntrada=array();
					$horasSalidas=array();
					$horasSalidaAlmuerzo=array();
					$horasLlegadasAlmuerzo=array();
					$horaSalidaAlmuerzo=array();				
					$k=0;$l=0;$h=0;$m=0;

					$horarioTotal = $this->_biometrico->horariosTotales($cedulas[$i]['cedula']);
								

						for($j = 0; $j<count($horarioTotal); $j++){

							if($horarioTotal[$j]['registro']=='P01-ENTRADA-OTIC'){

								$horasEntrada[$k] = $horarioTotal[$j]['hora'];
								
									if($horasEntrada[$k] >= '11:45:00' && $horasEntrada[$k]<= '12:30:00'){

											$horasSalidaAlmuerzo[$h]=$horasEntrada[$k];
											$h++;
									}

								$k++;
							}elseif($horarioTotal[$j]['registro']=='P01-SALIDA-OTIC'){

								$horasSalidas[$l] = $horarioTotal[$j]['hora'];							

									if($horasSalidas[$l] >= '13:00:00' && $horasSalidas[$l]<= '13:30:00'){
											$horasLlegadasAlmuerzo[$m]=$horasSalidas[$l];
											$m++;
									}

								$l++;														
							}

						}

								if(count($horasEntrada)>0){
									$horaEntrada = min($horasEntrada); 
								}
								if(count($horasSalidas)>0){
									$horaSalida = max($horasSalidas);
								}
								
								if(count($horasSalidaAlmuerzo)>0 ){
									$horaSalidaAlmuerzo = min($horasSalidaAlmuerzo); 
								}				
								if(count($horasLlegadasAlmuerzo)>0){
									$horaLLegadaAlmuerzo = max($horasLlegadasAlmuerzo);
								}
								if($horasSalidaAlmuerzo==null){
									$horaSalidaAlmuerzo="Sin registro";
								}
								if($horasLlegadasAlmuerzo==null){
									$horaLLegadaAlmuerzo="Sin registro";
								}
								if($horaEntrada==null){
									$horaEntrada="Sin registro";
								}
								if($horaSalida==null){
									$horaSalida="Sin registro";
								}									


								
								$horarioFinal= array(
											':hora_llegada' => $horaEntrada,
											':hora_salida' => $horaSalida,
											':hora_salida_almuerzo' => $horaSalidaAlmuerzo,
											':hora_llegada_almuerzo' => $horaLLegadaAlmuerzo,
											':cedula' => $cedulas[$i]['cedula'],
											':fecha' =>  date('d-m-Y'),
								);


				//$this->imprimirArreglo($horaLLegadaAlmuerzo);
				$this->_biometrico->insertHorarioFinal($horarioFinal);			

			}

		}


		function consulta_biometrico(){
			$listado = $this->_biometrico->getBiometrico();
			echo json_encode(array("biometrico"=>$listado)); 
		}
}?>