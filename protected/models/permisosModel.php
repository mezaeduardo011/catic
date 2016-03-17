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
		public function getPermisos(){			 
				$query = "SELECT * FROM consulta_permisos";
				$result=$this->selectPdo($query);
				return $result;
		}			

}
?>