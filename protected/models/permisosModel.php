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

}
?>