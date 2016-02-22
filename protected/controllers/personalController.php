<?php 
	class personalController extends Controller{

		private $_personal;
		
		public function __construct(){

			parent::__construct();
			$this->_personal = $this->loadModel('personal');
			$this->_pdf = $this->getLibrary('SIGESP','utilitario');

			$this->_sidebar_menu =array(
					array(
				'id' => 'insert_new',
				'title' => 'Nueva Persona',
				'link' => BASE_URL . 'personal' . DS . 'index'
						),
			 		array(
			 	'id' => 'listar',
			 	'title' => 'Listado de  Persona',
			 	'link' => BASE_URL . 'personal' . DS . 'listing'
			 			)
					);		
		}

		/* Funcion Index donde se inicializa todo lo basico que  sera usado por el controlador*/
		
		function index(){
	
			$this->_view->setJs(array(
			"Librerias/formValidation","Librerias/bootstrapValidator.min","validaciones",
			"Librerias/fuelux.wizard","form-wizard",
			"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
			"Librerias/jquery.maskedinput","Librerias/jquery.gritter", 
			"registroPersona/registroPersona",
			"utilidades","Librerias/bootstrap-select","SIGESP","selectDireccion"));

			$this->_view->setCss(array(
			"datepicker","bootstrapValidator.min","bootstrap-select","jquery.gritter","bootstrap-datepicker",
			"bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone"));

			$listado = $this->_personal->getHijosModel();
			$this->_view->_listado = $listado;
			$this->_view->render('personal','','',$this->_sidebar_menu);
	
		}

		/*API del sistema SIGESP para cargar datos de personas ya registradas*/

		public function BuscarCedula(){

		  	 //18019742
		     $cedula= $_POST['cedular'];
		     $cedula=str_replace('.','', $cedula); 
		     $cliente = new ClienteApiSigesp();

		     $resp = $cliente->getServicio('datos_empleado',array('cedula'=> $cedula));

		     $data = !!$resp->errores['error']?$resp->cuerpo_response:$resp->cuerpo_response->data;

		     echo json_encode(array("data" => $data));
		}

		/*Inserciones o Actualizaciones*/

		function insertPerson(){

				//$_POST=$_GET;
				unset($_POST['url']);
				unset($_POST['estado']);
				unset($_POST['municipio']);
				$persona= $this->ConvertirArray($_POST);
				//$this->imprimirArreglo($persona);
				$prueba=$this->_personal->insertPersonModel($persona);
				print_r($prueba);die();
		}

		function Insert_InfoAdicional(){
			//$_POST=$_GET;
			unset($_POST['url']);
			unset($_POST['medicina']);
			$postRecibido= $this->ConvertirArray($_POST);

			if($_POST['deporte']=='on'){
					unset($postRecibido[':deporte']);
					$check = $this->valCheckbox(6);
					$arregloPost = $this->ConvertirArraySql($check);
					$infoAdicional=$this->borrarCheckbox(6,$postRecibido);
					$this->_personal->InsertInfoAdicional($infoAdicional,$arregloPost);

			}else{
					unset($postRecibido[':deporte']);
					$this->_personal->InsertInfoAdicional($postRecibido,'{0}');		
			}	

		}

		/*Consultas*/	

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
			"Librerias/jquery.dataTables","Librerias/jquery.dataTables.bootstrap","Librerias/dataTables.tableTools",
			"Librerias/dataTables.colVis","tables","pickList"));

			$listado = $this->_personal->getPersonal();
			$this->_view->_listado = $listado;
			$this->_view->render('consulta_personal','','',$this->_sidebar_menu);

		}

		function update($id = false){
			
			//Si le damos al boton modificar.
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				
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

				$this->_personal->updatePersonal($persona);	
				$this->_view->redirect('personal/actualizar_persona/'.$persona[':id']);

				}else{	
				$this->_view->setJs(array(
				"Librerias/formValidation","Librerias/bootstrapValidator.min","validaciones",
				"Librerias/fuelux.wizard","actualizarPersona/form-wizard_actualizar",
				"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
				"Librerias/jquery.maskedinput",
				"registroPersona/registroPersona",
				"utilidades","Librerias/bootstrap-select","SIGESP","selectDireccion","pickList"));

				$this->_view->setCss(array("datepicker","bootstrapValidator.min","bootstrap-select","jquery.gritter",
											"bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone"));		

																
				$persona = $this->_personal->getUnicaPersona($id);
				$this->_view->_persona = $persona;
				$this->_view->render('actualizar_persona','','pickList');
				
				}

		}

		function delete($id){

			$this->_personal->deletePersonal($id);
			$this->_view->redirect('personal/listing');

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