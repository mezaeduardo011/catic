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
			//print_r($actividad); die();
			$query=$this->query = "SELECT registro_actividad(:nombre_actividad,:fecha_actividad,:hora,:ubicacion,'$arrayPsql')";

			$this->registroPdo($query,$actividad);
		}

		public function getActividad(){
				$query = "SELECT ROW_NUMBER() OVER (ORDER BY A.id_actividad_institucional) AS numeracion,*,R.referencia as status FROM actividad_institucional A
						INNER JOIN referencial R ON R.id_referencial = A.status";			
						$result=$this->selectPdo($query);
						return $result;
					
				}

		public function getActividadUnica($id){
				$query = "SELECT ROW_NUMBER() OVER (ORDER BY A.id_actividad_institucional) AS numeracion,*,R.referencia as status FROM actividad_institucional A
						INNER JOIN persona_x_actividad_institucional B ON A.id_actividad_institucional = B.id_actividad_institucional
						INNER JOIN referencial R ON R.id_referencial = A.status
						WHERE A.id_actividad_institucional='$id'";			
						$result=$this->selectPdo($query);
						return $result;
					
				}			

		public function getDetalles($id = FALSE){

						$query = "SELECT ROW_NUMBER() OVER (ORDER BY P.id_persona) AS numeracion,
								P.nombre,P.nombre2,P.apellido,P.apellido2,P.telefono , B.nombre_actividad, B.ubicacion
								from persona_x_actividad_institucional A
								INNER JOIN persona P on P.id_persona=A.id_persona
								INNER JOIN actividad_institucional B on B.id_actividad_institucional = A.id_actividad_institucional
								where A.id_actividad_institucional = '$id'";
						$result=$this->selectPdo($query);
						return $result;
					
				}				
		public function finalizarActividad($id = FALSE){
						$query = "UPDATE actividad_institucional SET status=97 WHERE id_actividad_institucional = '$id'";
						$result=$this->selectPdo($query);
						return $result;					
				}
}
?>