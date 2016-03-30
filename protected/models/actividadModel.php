<?php 

	class actividadModel extends Model{
		
		protected $query;
		
		public function __construct(){
			parent::__construct();
		}
		public function __destruct(){
			;
		}

		public function insertActividad($actividad,$arrayPsql){
				$query=$this->query = "SELECT registro_actividad(:nombre_actividad,:fecha_actividad,:hora,:ubicacion,'$arrayPsql')";
				$this->registroPdo($query,$actividad);
		}

		public function getActividad(){
				$query = "SELECT * FROM actividades";			
				$result=$this->selectPdo($query);
				return $result;			
		}

		public function getActividadUnica($id){
				$query = "SELECT A.* FROM actividad_institucional A WHERE a.id_actividad_institucional=$id";			
						$result=$this->selectPdo($query);
						return $result;
					
				}			

		public function getDetalles($id = FALSE){

						$query = "SELECT ROW_NUMBER() OVER (ORDER BY P.id_persona) AS numeracion,
								P.nombre,P.nombre2,P.apellido,P.apellido2,P.telefono , B.nombre_actividad, B.ubicacion,ref.referencia as coordinacion
								from persona_x_actividad_institucional A
								INNER JOIN persona P on P.id_persona=A.id_persona
								INNER JOIN actividad_institucional B on B.id_actividad_institucional = A.id_actividad_institucional
								INNER JOIN persona_empleada as per ON per.id_persona=p.id_persona
								INNER JOIN referencial as Ref on ref.id_referencial=per.coordinacion_referencial
								where A.id_actividad_institucional = '$id'";
						$result=$this->selectPdo($query);
						return $result;
					
				}				
		public function finalizarActividad($id = FALSE,$finalizar=FALSE){			
						if($finalizar!=FALSE){
						    return $result=$this->selectPdo($query = "UPDATE actividad_institucional SET status=97 WHERE id_actividad_institucional = '$id'");
						}else{
							return $result=$this->selectPdo($query = "UPDATE actividad_institucional SET status=98 WHERE id_actividad_institucional = '$id'");
						}				
						
				}
}
?>