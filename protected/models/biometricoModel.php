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
			$query=$this->query = "INSERT INTO horario_diario
							( cedula ,hora,pulsador,registro)  VALUES 
							(:cedula,:hora,:pulsador,:registro)";
				$this->registroPdo($query,$horario);		
		}


		public function getBiometrico(){			 
				$query = "SELECT * FROM horario_diario_vista";
				$result=$this->selectPdo($query);
				return $result;
		}

		public function getPulsador($pulsador){			 
				return $this->selectPdo($query = "SELECT pulsador FROM horario_diario WHERE pulsador = $pulsador");
		}		

}?>