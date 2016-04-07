<?php 

	class vacacionesModel extends Model{

		protected $query;

		public function __construct(){
			parent::__construct();
		}
		
		public function registroVacaciones($vacaciones){

				$this->registroPdo($query=$this->query ="SELECT registrar_vacaciones(:desde,:hasta,:dias_habiles,:fecha_solicitud,:reincorporacion,:id_persona);",$vacaciones);

		}

		public function getVacaciones($id=false){
			if($id==false){
				return $this->selectPdo($query = "SELECT * FROM vacaciones_registradas");
			}else{
				return $this->selectPdo($query = "SELECT * FROM vacaciones_registradas WHERE id_vacaciones=$id");
			}
		}

		public function finalizarVacaciones($id = FALSE,$finalizar=FALSE){		
						$this->updatePersona($id);						  	
						if($finalizar!=FALSE){
						    return $result=$this->selectPdo($query = "UPDATE vacaciones SET status=102 WHERE id_vacaciones = '$id' ;");						    
						}else{
							return $result=$this->selectPdo($query = "UPDATE vacaciones SET status=103 WHERE id_vacaciones = '$id'");
						}				
						
				}


		public function updatePersona($id_vacaciones){
				return $result=$this->selectPdo($query = "UPDATE persona_empleada SET status_referencial = 19 WHERE id_persona = (SELECT id_persona FROM vacaciones WHERE id_vacaciones = '$id_vacaciones')");
		}



		
	}
?>

