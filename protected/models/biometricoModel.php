<?php 

	class biometricoModel extends Model{
		
		protected $query;
		
		public function __construct(){
			parent::__construct();
		}
		public function __destruct(){
			;
		}

		public function insertHorario($horario){						
			$query=$this->query = "INSERT INTO horario_diario ( cedula ,hora,pulsador,registro) VALUES (:cedula,:hora,:pulsador,:registro)";
				$this->registroPdo($query,$horario);		
		}


		public function getBiometrico(){				
				return $result =$this->selectPdo($query = "SELECT * FROM horario_diario_vista");			
		}

		public function getPulsador($pulsador){			 
				return $this->selectPdo($query = "SELECT pulsador FROM horario_diario WHERE pulsador = $pulsador");
		}		

		public function getCedulas(){
			    return $this->selectPdo($query = "SELECT DISTINCT cedula FROM horario_diario");
		}

		public function horariosTotales($cedula){
			    return $this->selectPdo($query = "SELECT registro,hora FROM horario_diario WHERE cedula = '".$cedula."'");
		}

		public function insertHorarioFinal($horarioFinal){
			$this->registroPdo($query = "INSERT INTO horario_final (hora_llegada,hora_salida,hora_salida_almuerzo,hora_llegada_almuerzo,				cedula, fecha) VALUES 
					(:hora_llegada,:hora_salida,:hora_salida_almuerzo,:hora_llegada_almuerzo,:cedula,:fecha )",$horarioFinal);	
		}		

}?>