<?php 

	class actividadModel extends Model{
		
		protected $query;
		
		public function __construct(){
			parent::__construct();
		}
		public function __destruct(){
			;
		}

		public function getPersonal($id = FALSE){

				$query = "SELECT ROW_NUMBER() OVER (ORDER BY id_persona) AS numeracion,*,S.referencia AS sexo from persona P, referencial S
							WHERE p.sexo_referencial= S.id_referencial";

	

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
				
				return $result;
			
		}		



		//Insercion de la persona nueva
		public function insertActividad($actividad,$arrayPsql){

			//Se le pasa el arreglo desde el controlador, se le asignan los valores segun lo que dicta la asociacion
			$this->query = "SELECT registro_actividad(:nombre_actividad,:fecha_actividad,:hora_actividad,:ubicacion,'$arrayPsql')";
			
			//Cuando esta construido el query se envia para que empieze la transaccion.
			try {

				$this->_db->beginTransaction();
				$this->_db->prepare($this->query)->execute($actividad);

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

public function getActividad(){

		$query = "SELECT ROW_NUMBER() OVER (ORDER BY A.id_actividad_institucional) AS numeracion,* FROM actividad_institucional A
					INNER JOIN persona_x_actividad_institucional B ON A.id_actividad_institucional = B.id_persona_x_actividad_institucional
						INNER JOIN persona C ON B.id_persona = C.id_persona";
			
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
				
				return $result;
			
		}	

public function getActividadDetalle($id = FALSE){

				$query = "SELECT ROW_NUMBER() OVER (ORDER BY P.id_persona) AS numeracion,
						P.nombre,P.nombre2,P.apellido,P.apellido2,P.telefono , B.nombre_actividad, B.ubicacion
						from persona_x_actividad_institucional A
						INNER JOIN persona P on P.id_persona=A.id_persona
						INNER JOIN actividad_institucional B on B.id_actividad_institucional = A.id_actividad_institucional
						where A.id_actividad_institucional = '$id'";

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
				
				return $result;
			
		}				

}
?>