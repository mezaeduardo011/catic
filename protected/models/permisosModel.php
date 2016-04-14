<?php 

	class permisosModel extends Model{
		
		protected $query;
		
		public function __construct(){
			parent::__construct();
		}
		public function __destruct(){
			;
		}
		public function registroPermisos($permiso){
				$query=$this->query = "SELECT registrar_permiso(:desde,:hasta,:duracion,:dias_horas,:tipo_registro,:id_persona);";
				$this->registroPdo($query,$permiso);
		}


		public function getPermisos($id=false){
					switch(Session::get('perfil')){
						case 'Secretaria':
						case 'Adjunta':
						case 'Director General':
						if (isset($id) && $id!=false) {
								return $result=$this->selectPdo($query = "SELECT * FROM consulta_permisos WHERE id_permisos=".$id."");
							}else{
								return $result=$this->selectPdo($query = "SELECT * FROM consulta_permisos");
							}
						break;
						case 'Director de linea':
						if (isset($id) && $id!=false) {
								return $result=$this->selectPdo($query = "SELECT * FROM consulta_permisos WHERE id_permisos=".$id."
								AND coordinacion ='".Session::get('coordinacion')."'");
							}else{
								return $result=$this->selectPdo($query = "SELECT * FROM consulta_permisos WHERE coordinacion ='".Session::get('coordinacion')."'");
							}						
						break;
					}			
		}

		public function finalizarPermiso($id = FALSE,$finalizar=FALSE){			
			$this->updatePersona($id);
		if($finalizar!=FALSE){
		    return $result=$this->selectPdo($query = "UPDATE permisos SET status=108 WHERE id_permisos = '$id'");
		}else{
			return $result=$this->selectPdo($query = "UPDATE permisos SET status=109 WHERE id_permisos = '$id'");
		}				
		
		}

		public function updatePersona($id_permiso){
				return $result=$this->selectPdo($query = "UPDATE persona_empleada SET status_referencial = 19 WHERE id_persona = (SELECT id_persona FROM permisos WHERE id_permisos = '$id_permiso')");
		}									

}
?>