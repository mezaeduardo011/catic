<?php 
	class personalController extends Controller{

		private $_personal;
		
		public function __construct(){

			//Hereda el constructor del Controlador Frontal para hacer el llamado a su modelo correspondiente
			parent::__construct();
			$this->_personal = $this->loadModel('personal');
			$this->_pdf = $this->getLibrary('SIGESP','utilitario');
		}
		
		function index(){
	

				$this->_view->setJs(array(
				"Librerias/formValidation","Librerias/bootstrapValidator.min","validaciones",
				"Librerias/fuelux.wizard","form-wizard",
				"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
				"Librerias/jquery.maskedinput",
				"registroPersona/registroPersona",
				// "utilidades","Librerias/bootstrap-select",
				// "Librerias/jquery.gritter",
				// "persons"));
				"utilidades","Librerias/bootstrap-select","SIGESP","selectDireccion"));

				$this->_view->setCss(array("datepicker","bootstrapValidator.min","bootstrap-select","jquery.gritter",
											"bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone"));				
				$listado = $this->_personal->getHijosModel();
				$this->_view->_listado = $listado;
				//Se pinta la vista con el metodo render.
				$this->_view->render('personal');
	
		}


		function insertPerson(){

				//$_POST=$_GET;
				unset($_POST['url']);
				unset($_POST['estado']);
				unset($_POST['municipio']);
				$persona= $this->ConvertirArray($_POST);
				//$this->imprimirArreglo($persona);
				$this->_personal->insertPersonModel($persona);
	
			}	

		function getInfoDatos(){
		
			$datosPersona = $this->_personal->getInfoDatosModel();
			$this->_view->_datosPersona = $datosPersona;

			echo json_encode($datosPersona);


		}


		function getHijos(){
		
			$listado = $this->_personal->getHijosModel();
			$this->_view->_listado = $listado;

			echo json_encode($listado);


		}

		function listing(){

			$this->_view->setJs(array(
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools","Librerias/dataTables.colVis","tables",
			"pickList"));

			$listado = $this->_personal->getPersonal();
			//$this->imprimirArreglo($listado);
			$this->_view->_listado = $listado;

			$this->_view->render('consulta_personal');
		}

		function update($id = false){
			
			//Si le damos al boton modificar.
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				
				/*Guardamos en un arreglo los valores enviados desde la vista
				para luego enviarlos a la funcion UpdatePersonal*/

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

				//Se envia el arreglo con los datos organizados en un asociativo						 
				$this->_personal->updatePersonal($persona);	

				//Me redirecciona a la pagina de la persona en especifico con los cambios realizadosl.
				$this->_view->redirect('personal/actualizar_persona/'.$persona[':id']);
				//OJO redireccionamos a persona update MAS EL ID de la persona,para que vea los cambios

				}else{
							$this->_view->setJs(array("utilidades"));	
				//Se muestra la pagina de la persona con sus datos prederterminados sin cambios
				$persona = $this->_personal->getUnicaPersona($id);

				//Se crea el objeto para la clase vista
				$this->_view->_persona = $persona;

				//Se pinta la vista
				$this->_view->render('actualizar_persona','','pickList');
				
				}
		}

		function delete($id){

			//Recibe el id de la persona y lo manda al metodo correspondiente
			$this->_personal->deletePersonal($id);

			//Nos redirecciona al listado del personal nuevamente
			$this->_view->redirect('personal/listing');

		}

		function loadSexo(){

			$result = $this->_personal->getSexo();

			$data = array();

			for ($i = 0; $i < count($result); $i++) {

				$data[$i] = array("value"=>$result[$i]['id_referencial'],"option"=>$result[$i]['referencia']);
			}

			echo json_encode($data);

		}

		  public function BuscarCedula(){
		  	  //18019742
		      $cedula= $_POST['cedular'];
		      $cedula=str_replace('.','', $cedula); 
		      $cliente = new ClienteApiSigesp();

		      $resp = $cliente->getServicio('datos_empleado',array('cedula'=> $cedula));

		      $data = !!$resp->errores['error']?$resp->cuerpo_response:$resp->cuerpo_response->data;

		      //print_r($data); die();

		      echo json_encode(array("data" => $data));

		      /*$formatjson = json_decode($jsondata,true);

		      //print_r($formatjson); die();

		      list($nombres1, $nombres2) = explode(" ",$formatjson['nombres']);
		      list($apellido1, $apellido2) = explode(" ",$formatjson['apellidos']);

		      $info = array($formatjson['correo_electronico'],$formatjson['direccion'],$formatjson['fecha_ingreso'],$formatjson['fecha_nacimiento'],$formatjson['telefono_celular']);

		      list($correo_electronico,$ubicacion,$fecha_ingreso,$fecha_nacimiento,$telefono) = $info;

		   	  $datos_personas = array($nombres1,$nombres2,$apellido1,$apellido2,$fecha_nacimiento,$telefono,$fecha_ingreso,$correo_electronico,$ubicacion);

		   	  print_r("hola");*/

		  }

		function SelectEstado() {
			
					$result = $this->_personal->getDireccionEstado();
					$data = array();

					for ($i = 0; $i < count($result); $i++) {
						$data[$i] = array("value"=>$result[$i]['id_direccion'],"option"=>$result[$i]['estado']);
					}
					echo json_encode($data);
		}

		function SelectMunicipio() {
			if (isset($_POST["selected"])) {
				$result = $this->_personal->getDireccionMunicipio($_POST["selected"]);
				$data = array();
						
				for ($i = 0; $i < count($result); $i++) {
					$data[$i] = array("id"=>$result[$i]["id_direccion"],"option"=>$result[$i]["municipio"]);
				}
			 }
						
			echo json_encode($data);
		}

		function SelectParroquia() {
			if (isset($_POST["selected"])) {
				$result = $this->_personal->getDireccionParroquia($_POST["selected"]);
				$data = array();
						
				for ($i = 0; $i < count($result); $i++) {
					$data[$i] = array("id"=>$result[$i]["id_direccion"],"option"=>$result[$i]["parroquia"]);
				}
			 }
						
			echo json_encode($data);
		}
		
		function SelectCargo(){			
					$result = $this->_personal->getCargos();
					$data = array();

					for ($i = 0; $i < count($result); $i++) {
						$data[$i] = array("value"=>$result[$i]['id_cargo'],"option"=>$result[$i]['cargo']);
					}
					echo json_encode($data);
		}

		function SelectCoordinaciones(){

					$result = $this->_personal->getCoordinaciones();
					$data = array();

					for ($i = 0; $i < count($result); $i++) {
						$data[$i] = array("value"=>$result[$i]['id_coordinacion'],"option"=>$result[$i]['coordinacion']);
					}
					echo json_encode($data);

		}

	}
?>