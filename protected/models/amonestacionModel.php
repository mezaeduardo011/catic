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
				$query=$this->query = "INSERT INTO amonestaciones(tipo_amonestacion_referencial,coordinacion_referencial,fecha, hora,motivo,id_persona,id_amonestador)
						                VALUES
						                ( :tipo_amonestacion,:coordinacion,:fecha,:hora,:motivo,:id_persona,:id_amonestador); ";
				$this->registroPdo($query,$amonestacion);
		}

		public function getAmonestaciones(){			 
					switch(Session::get('perfil')){
						case 'Secretaria':
						case 'Adjunta':
						case 'Director General':
						    return $this->selectPdo($query ="SELECT * FROM total_amonestaciones");
						break;
						case 'Director de linea':
						    return  $this->selectPdo($query = "SELECT * FROM total_amonestaciones WHERE coordinacion ='".Session::get('coordinacion')."'");						
						break;
					}	
								
		}
			
		public function amonestacionPersona($id_persona,$id_amonestacion){				
				return $result=$this->selectPdo($query = "SELECT * FROM amonestacion_persona WHERE id_persona=".$id_persona." AND id_amonestaciones=".$id_amonestacion."");;
		}						

}
?>