<?php 

	class permisosModel extends Model{
		
		protected $query;
		
		public function __construct(){
			parent::__construct();
		}
		public function __destruct(){
			;
		}
		public function registroPermisos($vacaciones,$check){
				$arreglo=array_merge($vacaciones,$check);
				$query=$this->query = "SELECT registrar_permiso(:desde,:hasta,:duracion,:tipo_rango,:tipo_registro,:checks);";
				$this->registroPdo($query,$arreglo);
		}	

}
?>