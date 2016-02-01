<?php 
	class correspondenciaController extends Controller{
		
		
		protected $_sidebar_menu;
		private $_correspondencia;
		
		public function __construct(){
	
			parent::__construct();
			$this->_correspondencia = $this->loadModel('correspondencia');
		//Objeto donde almacenamos todas las funciones de PersonsModel.php

		}
		
		function index(){

			$this->_view->render('correspondencia', 'correspondencia', '',$this->_sidebar_menu);
	
		}

		function registro_correspondencia(){
				$coordinacion = $this->_correspondencia->getCoordinacion();
				$this->_view->_coordinacion = $coordinacion;

			$this->_view->render('registro_correspondencia', 'correspondencia', '',$this->_sidebar_menu);
	
		}


			
			function insert(){
				//Si hay una solicitud via POST
				if ($_SERVER['REQUEST_METHOD']=='POST') {
				$correspondencia = array(
			
					':numero_comunicacion' => $_POST['numero_comunicacion'],
					':asunto' => $_POST['asunto'], 
					':oficina' => $_POST['oficina'],
					':fecha_entregado' => $_POST['fecha_entregado'],
					':fecha_recibido' => $_POST['fecha_recibido'],
					':instruccion' => $_POST['instruccion'],
					':coordinacion' => $_POST['coordinacion']
				);


	//enviamos ala funcion Insert en el modelo de correspondencias el arreglo 
			$this->_correspondencia->insertCorrespondencia($correspondencia);
			/*echo "<script language='javascript'> var r=confirm('Correspondencia registrada. ¿Desea ver la lista de correspondencias?');
								if (r == true) {
					    x = '';
					} else {
					    x = '';
					}

			</script>";
			die();*/

			$this->_view->redirect("correspondencia/listing");
			$this->_view->redirect('correspondencia/listing');
						 // metodo  arreglo
			//$this->_view->redirect('persons/listing');
				}else{ 
					// se muestra la ventana si no es via post.
					$this->_view->render('insert', 'correspondencia', '',$this->_sidebar_menu);
			
				}
			}



			function listing(){

				$listado = $this->_correspondencia->getCorrespondencia();
				$this->_view->_listado = $listado;
				
				$this->_view->render('consulta_correspondencia', 'persons', '',$this->_sidebar_menu);
			}



		
		function update($id = false){
			//Si le damos al boton modificar.
				if ($_SERVER['REQUEST_METHOD']=='POST') {
		//guardamos en un arreglo los valores enviados desde la vista
				//para luego enviarlos a la funcion UpdatePerson
					$persona = array(
							':id' => $_POST['id'] ,
							':cedula' => $_POST['cedula'] ,
							':nombre' => $_POST['nombre'] ,
							':apellido' => $_POST['apellido'] ,
							':sexo' => $_POST['sexo'] ,
							':fecha_nacimiento' => $_POST['fecha_nacimiento'] ,
							':telefono' => $_POST['telefono'],
							':correo' => $_POST['correo'],
							':fecha_ingreso' => $_POST['fecha_ingreso']

						);
											 
					$this->_correspondencia->updatecorrespondencia($persona);	
						 // metodo  arreglo
					$this->_view->redirect('correspondencia/actualizar_persona/'.$persona[':id']);
					//OJO redireccionamos a persona update MAS EL ID de la persona, 
					//para que vea los cambios

				}else{//si no mostramos igual.

		//llamamos a la funcion getPergetUnicaPersona en el modelo la cual
		// le pasamos el id, Guardamos en la variable $person el resultado 
		//de la funcion getUnicaPersona
		//para luego ser enviada a la vista en el objeto _correspondenciaa

					$persona = $this->_correspondencia->getUnicaPersona($id);
					$this->_view->_persona = $persona;
					$this->_view->render('actualizar_persona', 'correspondencia', '',$this->_sidebar_menu);

				}
		}




		function delete($id){

			$this->_correspondencia->deletecorrespondencia($id);
			$this->_view->redirect('correspondencia/listing');

		}
		
		
		
		function select(){
			$this->_view->setJs(array('js/persons'));
			$this->_view->render('select', 'persons', '',$this->_sidebar_menu);

		}
		
		function loadSexo(){

				 	$result = $this->_correspondencia->getSexo();
					$data = array();
					for ($i = 0; $i < count($result); $i++) {
						$data[$i] = array("value"=>$result[$i]['id'],"option"=>$result[$i]['sexo']);
					}
					echo json_encode($data);

		}
		
		

	
	
	
	









}?>