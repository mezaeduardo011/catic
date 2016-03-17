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
							( cedula ,  fecha ,   hora ,  id_biometrico)  VALUES 
							(:cedula,:fecha,:hora,:id_biometrico)";
				$this->registroPdo($query,$horario);		
		}


		public function getBiometrico(){			 
				$query = "SELECT * FROM horario_diario_vista";
				$result=$this->selectPdo($query);
				return $result;
		}

}?>