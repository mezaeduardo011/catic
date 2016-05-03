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
				'title' => 'Registrar persona',
				'link' => BASE_URL . 'personal' . DS . 'index'
						),
			 		array(
			 	'id' => 'listar',
			 	'title' => 'Consultar personal registrado',
			 	'link' => BASE_URL . 'personal' . DS . 'listing'
			 			),array(
				'id' => 'insert_new',
				'title' => 'Asignar vacaciones',
				'link' => BASE_URL . 'vacaciones' . DS . 'index'
						),
			 		array(
			 	'id' => 'listar',
			 	'title' => 'Consultar vacaciones',
			 	'link' => BASE_URL . 'vacaciones' . DS . 'consulta_vacaciones'
			 			),array(
				'id' => 'insert_new',
				'title' => 'Registrar permiso',
				'link' => BASE_URL . 'permisos' . DS . 'agregar_carpeta'
						),array(
				'id' => 'insert_new',
				'title' => 'Asignar amonestacion',
				'link' => BASE_URL . 'amonestacion' . DS . 'index'
						),
			 		array(
			 	'id' => 'listar',
			 	'title' => 'Consultar amonestaciones',
			 	'link' => BASE_URL . 'amonestacion' . DS . 'consulta_amonestaciones'
			 			)
					);		
		}

		/* Funcion Index donde se inicializa todo lo basico que  sera usado por el controlador*/
		
		function index(){
			
			$this->_view->setJs(array(
			"Librerias/formValidation","Librerias/bootstrapValidator.min",
			"Librerias/fuelux.wizard","form-wizard",
			"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
			"Librerias/jquery.maskedinput","Librerias/jquery.gritter", 
			"registroPersona/registroPersona",
			"utilidades","Librerias/bootstrap-select","SIGESP","selectDireccion",
			"Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","registroPersona/tablaHijos","registroPersona/tablaPadres","registroPersona/actualizar_persona"));

			$this->_view->setCss(array(
			"datepicker","bootstrapValidator.min","bootstrap-select","jquery.gritter","bootstrap-datepicker",
			"bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone",
			"ui.jqgrid"));

			$listado = $this->_personal->getHijosModel();
			$this->_view->_listado = $listado;

			$this->_view->render('personal','','',$this->_sidebar_menu);
	
		}

		/*API del sistema SIGESP para cargar datos de personas ya registradas*/

		public function BuscarCedula(){
			$cedula= $_POST['cedular'];

			$parroquia = $this->_personal->getDireccionParroquia(false,false);

				$parroquiaData = array();
						
	for ($i = 0; $i < count($parroquia); $i++) {
		$parroquiaData[$i] = array("parroquia"=>$parroquia[$i]["parroquia"],"municipio"=>$parroquia[$i]["municipio"],"estado"=>$parroquia[$i]["estado"]);
	}
		  	 //18019742 
		     $cedula=str_replace('.','', $cedula); 
		     $cliente = new ClienteApiSigesp();
		     $resp = $cliente->getServicio('datos_empleado',array('cedula'=> $cedula));
		     $data = !!$resp->errores['error']?$resp->cuerpo_response:$resp->cuerpo_response->data;
		     echo json_encode(array("data" => $data,"direccion"=>$parroquiaData));
		}

		function confirmarCedula(){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$listado = $this->_personal->getPersonal($_POST['cedula']);
				if($listado!=null && $listado !=" "){
					$data=1;
					echo json_encode($data);
				}
			}
					

		}

		function insertPerson(){
				//$_POST=$_GET;
				unset($_POST['url']);
				unset($_POST['estado']);
				unset($_POST['municipio']);
				$persona= $this->ConvertirArray($_POST);
				if(isset($persona[':fecha_nacimiento_hijo'])){
					$persona[':fecha_nacimiento']=$persona[':fecha_nacimiento_hijo'];
					unset($persona[':fecha_nacimiento_hijo']);
				}

				//$this->imprimirArreglo($persona);
				$this->_personal->insertPersonModel($persona);
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

	public function actualizarPersona(){
		$datos = $_POST;
		unset($datos['datos'][0]['estado']);
		unset($datos['datos'][0]['municipio']);


		$personal = 

			array(
					'id_empleado' => $datos['datos'][0]['id_persona'],
					'cedula' => $datos['datos'][0]['cedula'],		
					'nombre1' => $datos['datos'][0]['primer_nombre'],
					'nombre2' => $datos['datos'][0]['segundo_nombre'],
					'apellido1' => $datos['datos'][0]['primer_apellido'],
					'apellido2' => $datos['datos'][0]['segundo_apellido'],
					'sexo' => $datos['datos'][0]['sexo'],
					'fecha_nacimiento' => $datos['datos'][0]['fecha_nacimiento'],
					'fecha_ingreso' => $datos['datos'][0]['fecha_ingreso'],	
					'telefono' => $datos['datos'][0]['telefono'],
					'otro_telefono' => $datos['datos'][0]['otro_telefono'],
					'correo' => $datos['datos'][0]['correo'],
					'cargo' => $datos['datos'][0]['cargo'],		
					'coordinacion' => $datos['datos'][0]['coordinacion'],
					'parroquia' => $datos['datos'][0]['parroquia'],
					'ubicacion' => $datos['datos'][0]['ubicacion'],
					//'tipo_persona' => $datos['datos'][0]['tipo_persona']
			);

		$personal = $this->ConvertirArray($personal);
		$response= $this->_personal->actualizarEmpleado($personal);
		print_r($response);
	}

		function getInfoDatos(){
			$id = $_POST['id_persona'];
			$datosPersona = $this->_personal->getInfoDatosModel($id);
			if(isset($datosPersona[0]['sexo_referencial'])){
				$datos_personal = array (
					'sexo' => $datosPersona[0]['sexo_referencial'],
					'direccion' => $datosPersona[0]['parroquia'],			
					'coordinacion' => $datosPersona[0]['coordinacion_referencial'],
					'cargo' => $datosPersona[0]['cargo'],
					'estado' => $datosPersona[0]['estado'],
					'municipio' => $datosPersona[0]['municipio']
				);
			}
			$this->_view->_datosPersona = $datosPersona;
			if(isset($datos_personal)){
				echo json_encode($datos_personal);
			}else{
				print_r($datosPersona);
			}

		}

		function getHijos($id = false){
			if ($id == false){
			$result = $this->_personal->getInfoDatosModel();
			$listado = $this->_personal->getHijosModel($result[0]['id_persona_empleada']);
			}else{
			$listado = $this->_personal->getHijosModel($id);
			}
			echo json_encode($listado);
		}

		function getPadres(){		
			$listado = $this->_personal->getPadresModel();
			echo json_encode($listado);
		}

		function listing(){
			$this->_view->setJs(array("pickList","Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src","registroPersona/consulta",
			"utilidades","Librerias/bootstrap-select"));
			$this->_view->setCss(array("ui.jqgrid"));

			$this->_view->render('consulta_personal','','',$this->_sidebar_menu);

		}


		function personasTabla(){

			$listado = $this->_personal->getPersonal();
			$this->_view->_listado = $listado;
			echo json_encode(array("personal"=>$listado)); 

		}

		function update($id = false){
			
			if ($_SERVER['REQUEST_METHOD']=='POST') {
		
				}else{	
				$this->_view->setJs(array(
				"Librerias/formValidation","Librerias/bootstrapValidator.min","validaciones",
				"Librerias/jqGrid/i18n/grid.locale-es","Librerias/jqGrid/jquery.jqGrid.src",
				"Librerias/fuelux.wizard","actualizarPersona/form-wizard_actualizar",
				"Librerias/bootstrap-datepicker","Librerias/locales/bootstrap-datepicker.es.min",
				"registroPersona/registroPersona",
				"utilidades","Librerias/bootstrap-select","SIGESP","selectDireccion","pickList",
				"registroPersona/actualiza_y_llena","registroPersona/hijoActualizar",
				"registroPersona/actualizar_persona"));

				$this->_view->setCss(array("datepicker","bootstrapValidator.min","bootstrap-select","jquery.gritter",
											"bootstrap-datepicker","bootstrap-datepicker.standalone","bootstrap-datepicker3","bootstrap-datepicker3.standalone","ui.jqgrid"));	
							
				$persona = $this->_personal->getUnicaPersona($id);
				$hijos = $this->_personal->getHijosModel($persona[0]['id_persona_empleada']);
				$padres = $this->_personal->getPadresModel($persona[0]['id_persona_empleada']);
				//$this->imprimirArreglo($padres);
				$this->_view->_persona = $persona;
				$this->_view->_hijos = $hijos;
				$this->_view->_hijos = $padres;
				//print_r($persona);die();
				$this->_view->render('actualizar_persona','','pickList');
				
				}
		}

		function llenarEstado($id_persona){
			$persona = $this->_personal->getUnicaPersona($id_persona);
			$data=array();
			$data[0]=$persona[0]['parroquia'];
			$data[1]=$persona[0]['municipio'];
			$data[2]=$persona[0]['estado'];
				echo json_encode($data);
		}

		function delete($id=false){ 
					if(isset($_POST['cedula'])&& !empty($_POST['cedula'])){
						print_r($_POST['id']);
						$this->_personal->deletePersona($_POST['id']);
						$this->_view->redirect('personal/listing');
					}else{
			$this->_view->setJs(array("pickList","Librerias/jqGrid/jquery.jqGrid.src","registroPersona/consulta"));						
						$persona = $this->_personal->getUnicaPersona($id);
						$this->_view->_persona = $persona;
						$this->_view->render('eliminar_persona', '','pickList',$this->_sidebar_menu);						
					}

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

		function SelectMunicipioGeneral() {

				$result = $this->_personal->getDireccionMunicipio(false);
				$data = array();
						
				for ($i = 0; $i < count($result); $i++) {
					$data[$i] = array("value"=>$result[$i]["id_direccion"],"option"=>$result[$i]["municipio"]);
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
		

		function SelectParroquiaGeneral() {

				$result = $this->_personal->getDireccionParroquia();
				$data = array();
						
				for ($i = 0; $i < count($result); $i++) {
					$data[$i] = array("value"=>$result[$i]["id_direccion"],"option"=>$result[$i]["parroquia"]);
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