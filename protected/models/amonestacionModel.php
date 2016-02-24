<?php
	class amonestacionModel extends Model{
		
		//variable protegida donde se guardan los query para la base de datos
		protected $query;
		
		//Construtor Herado de la clase Modelo principal
		public function __construct(){
			parent::__construct();
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

		public function getTipoAmonestacion(){
				$query = "SELECT * from referencial WHERE referencial_id=89";			
				$result=$this->selectPdo($query);
				return $result;			
		}


		public function registroAmonestacion($amonestacion,$id_persona){
				$query=$this->query = "INSERT INTO amonestaciones(tipo_amonestacion_referencial,coordinacion_referencial,fecha,motivo,id_persona)
						                VALUES
						                ( :tipo_amonestacion,:coordinacion,:fecha,:motivo,'$id_persona'); ";
				$this->registroPdo($query,$amonestacion);
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

}
?>