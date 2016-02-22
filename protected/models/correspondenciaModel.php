<?php 

	class correspondenciaModel extends Model{
		
		protected $query;
		
		public function __construct(){
			parent::__construct();
		}
		public function __destruct(){
			;
		}

		public function insertCorrespondencia($correspondencia){
						
			$query=$this->query = "INSERT INTO correspondencia
							( asunto ,  oficina ,   fecha ,  instruccion,tipo , id_status, id_coordinacion)  VALUES 
							( :asunto, :oficina, :fecha ,  :instruccion,:tipo , 19 ,:coordinacion)   ";		

				$this->registroPdo($query,$correspondencia);
			
		}
		
		
		public function getCorrespondencia(){

		$query = "SELECT ROW_NUMBER() OVER (ORDER BY id_correspondencia) AS numeracion,
				*,referencia as Coordinacion, (select referencia from referencial where id_referencial = 23) as Status 
				FROM correspondencia
				inner join referencial on id_referencial= id_coordinacion
				ORDER BY id_correspondencia DESC";
			
				$result=$this->selectPdo($query);
				return $result;
			
		}


		public function getCoordinacion(){

		$query = "select id_referencial,referencia from referencial where referencial_id=9 and id_referencial !=9";
			
				$result=$this->selectPdo($query);
				return $result;
			
		}


}?>