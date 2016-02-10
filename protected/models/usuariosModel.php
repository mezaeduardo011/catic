<?php 

	class usuariosModel extends Model{
		
		//variable protegida donde se guardan los query para la base de datos
		protected $query;
		
		//Construtor Herado de la clase Modelo principal
		public function __construct(){
			parent::__construct();
		}

		//Insercion de la persona nueva
		public function insertPersonModel($persona){

			//Se le pasa el arreglo desde el controlador, se le asignan los valores segun lo que dicta la asociacion
			$this->query = "SELECT registro_persona(:nombre,:nombre2,:apellido,:apellido2,:sexos,
				:fecha_nacimiento,:cedula,:fecha_ingreso,:telefono,:correo,:direccion,:ubicacion,:otro_telefono);";
			
			//Cuando esta construido el query se envia para que empieze la transaccion.
			try {

				$this->_db->beginTransaction();
				$this->_db->prepare($this->query)->execute($persona);

				//Sirve como confirmacion de que se realizaron los cambios con exito o se ejercuto la sentencia
				$this->_db->commit();
			}

			//En caso de error, lo envia en pantalla.
			catch (Exception $e){
				$this->_db->rollBack();
				echo "Error :: ".$e->getMessage();
				exit();
			}
		}


		//Retorna un listado del personal a traves de un select
		public function getUsuarios($id = FALSE,$actividad = FALSE){
			 

				$query = "SELECT ROW_NUMBER() OVER (ORDER BY P.id_persona) AS numeracion,R.referencia as perfil,* from usuario U
							INNER JOIN persona AS P ON P.id_persona= U.id_persona
							INNER JOIN referencial AS R ON R.id_referencial= U.perfil_referencial";


				$auxiliar = $this->_db->query($query);
				try {
				$this->_db->beginTransaction();
				$result= $auxiliar->fetchAll();
				$this->_db->commit();
				}
				catch (Exception $e){
					
					$this->_db-rollBack();
					echo "Error :: ".$e->getMessage();
					exit();
					
				}

				if(empty($result)){

					$result[0] = "No hay Personal Disponible para asignar";
					return $result;

				}else{

					return $result;
				}
			
		}

	
	}
?>

