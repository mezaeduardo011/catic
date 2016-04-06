<?php
	class amonestacionModel extends Model{
		
		//variable protegida donde se guardan los query para la base de datos
		protected $query;
		
		//Construtor Herado de la clase Modelo principal
		public function __construct(){
			parent::__construct();
		}
	
		public function getTipoAmonestacion(){
				$query = "SELECT * from referencial WHERE referencial_id=89";			
				$result=$this->selectPdo($query);
				return $result;			
		}

		public function registroAmonestacion($amonestacion){
				$query=$this->query = "INSERT INTO amonestaciones(tipo_amonestacion_referencial,coordinacion_referencial,fecha,motivo,id_persona)
						                VALUES
						                ( :tipo_amonestacion,:coordinacion,:fecha,:motivo,:id_persona); ";
				$this->registroPdo($query,$amonestacion);
		}

		public function getAmonestaciones(){			 
				$query = "SELECT * FROM total_amonestaciones";
				$result=$this->selectPdo($query);
				return $result;
		}
			
		public function amonestacionPersona($id_persona,$id_amonestacion){				
				return $result=$this->selectPdo($query = "SELECT * FROM amonestacion_persona WHERE id_persona=".$id_persona." AND id_amonestaciones=".$id_amonestacion."");;
		}						

}
?>