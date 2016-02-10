<?php 

	class Complement{
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
					return $data;
				}


				function ConvertirArraySql($arregloPhp){
					return ("{".join(",",$arregloPhp)."}");
				}



				function ConvertirArray($VarPost){
							 $arregloNuevo= array();									
								foreach ($VarPost as $newArrayKey => $valor) {		
										$arregloNuevo[':'.$newArrayKey]=$valor;
								}		 					
							return $arregloNuevo;
						}


				function imprimirArreglo($arreglo){
					echo '<pre>';print_r($arreglo);echo '</pre>';die();								
				}
	}

 ?>