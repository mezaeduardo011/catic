<?php 

	class administracionModel extends Model{
		
		//variable protegida donde se guardan los query para la base de datos
		protected $query;
		
		//Construtor Herado de la clase Modelo principal
		public function __construct(){
			parent::__construct();
		}


		public function insertFechas($fechas){
			$query=$this->query = "INSERT INTO fechas (fechas) VALUES ('$fechas')";
			$this->registroPdoArray($query,$fechas);
		}

		public function getFechas(){
				$query = "SELECT unnest(fechas) as fecha  FROM fechas";
				$result=$this->selectPdo($query);
				return $result;		
		}

		public function getUsuarios(){
				$query = "SELECT * from vista_usuarios";
				$result=$this->selectPdo($query);
				return $result;		
		}	

		public function agregarUsuario($id){
			$query=$this->query = "SELECT registro_usuario('$id')";
			$this->registroPdoArray($query,$id);
		}			

	
	}
?>

