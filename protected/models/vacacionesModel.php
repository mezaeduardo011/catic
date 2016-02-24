<?php 

	class vacacionesModel extends Model{
		protected $query;
				public function __construct(){
			parent::__construct();
		}
		
		public function registroVacaciones($vacaciones,$personas){
				$query=$this->query = "SELECT registrar_vacaciones(:desde,:hasta,:dias_habiles,:fecha_solicitud,:reincorporacion,'$personas');";
				$this->registroPdo($query,$vacaciones);
		}

		public function getVacaciones(){			 
				$query = "SELECT ROW_NUMBER() OVER (ORDER BY PV.id_personas_x_vacaciones) AS numeracion,R.referencia as coordinacion,P.*,V.* 
							FROM personas_x_vacaciones PV
								INNER JOIN vacaciones as V on V.id_vacaciones=PV.id_vacaciones
								INNER JOIN persona as P on P.id_persona=PV.id_persona
								INNER JOIN persona_empleada as PR on PR.id_persona=PV.id_persona
								INNER JOIN referencial as R on R.id_referencial=PR.coordinacion_referencial";
				$result=$this->selectPdo($query);
				return $result;
		}

		public function getPersonalDisponible(){			 

				$query = "SELECT ROW_NUMBER() OVER (ORDER BY P.id_persona) AS numeracion,P.*,S.referencia AS sexo ,E.*
							FROM persona P
							INNER JOIN referencial AS S on S.id_referencial = P.sexo_referencial
							INNER JOIN persona_empleada as E on E.id_persona=P.id_persona
							WHERE tipo_persona_referencial=76
							AND status_referencial != 88";

				$result=$this->selectPdo($query);
				return $result;
		
		}			
	}
?>

