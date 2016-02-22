<?php 

	class Complement{
				function valCheckbox($contador){		
						for ($i = 0; $i <= $contador; $i++) {
							if(isset($_POST['check'.$i]) && !($_POST['check'.$i]==" ")){
								$data[$i] =  $_POST['check'.$i];
								}
						}
					return $data;
				}

				function borrarCheckbox($contador,$arreglo){		
						for ($i = 0; $i <= $contador; $i++) {
								unset($arreglo [':check'.$i]);
						}
					return $arreglo;
				}				
				


				function ConvertirArraySql($arregloPhp){
					return ("{".join(",",$arregloPhp)."}");
				}



				function ConvertirArray($VarPost){
							 //$arregloNuevo= array();									
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