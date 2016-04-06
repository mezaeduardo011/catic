<?php 

	class vacacionesModel extends Model{
		protected $query;
				public function __construct(){
			parent::__construct();
		}
		
		public function registroVacaciones($vacaciones){
				$this->registroPdo($query=$this->query = "SELECT registrar_vacaciones(:desde,:hasta,:dias_habiles,:fecha_solicitud,:reincorporacion,:id_persona);",$vacaciones);
		}

		public function getVacaciones(){			 				
				return $this->selectPdo($query = "SELECT * FROM vacaciones_registradas");
		}

		
	}
?>

