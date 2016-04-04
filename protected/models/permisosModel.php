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
				$query=$this->query = "SELECT registrar_permiso(:desde,:hasta,:dias,:horas,:tipo_registro,:id_persona);";
				$this->registroPdo($query,$permiso);
		}

		public function getPermisos($id=false){
			if (isset($id) && $id!=false) {
				return $result=$this->selectPdo($query = "SELECT * FROM consulta_permisos WHERE id_permisos=".$id."");
			}else{
				return $result=$this->selectPdo($query = "SELECT * FROM consulta_permisos");
			}
		}

		public function finalizarPermiso($id = FALSE,$finalizar=FALSE){			
		if($finalizar!=FALSE){
		    return $result=$this->selectPdo($query = "UPDATE permisos SET status=102 WHERE id_permisos = '$id'");
		}else{
			return $result=$this->selectPdo($query = "UPDATE permisos SET status=103 WHERE id_permisos = '$id'");
		}				
		
				}							

}
?>