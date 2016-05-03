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
							( asunto ,  oficina ,   fecha ,  instruccion,tipo , estatus, id_coordinacion,id_carpeta_correspondencia)  VALUES 
							(:asunto,:oficina,:fecha,:instruccion,:tipo , :estatus ,:coordinacion,:carpetas)";
				$this->registroPdo($query,$correspondencia);		
		}
		
		public function insertCarpeta($carpeta){					
			$query=$this->query = " ";		
				$this->registroPdo($query,$correspondencia);			
		}

		public function getCorrespondencia($id=false){
			if (isset($id) && $id!=false) {
		$query = "SELECT ROW_NUMBER() OVER (ORDER BY id_correspondencia) AS numeracion,
				*,referencia as Coordinacion, (select referencia from referencial where id_referencial = 23) as Status 
				FROM correspondencia
				inner join referencial on id_referencial= id_coordinacion
				WHERE id_correspondencia =".$id."
				ORDER BY id_correspondencia DESC";

				$result=$this->selectPdo($query);
				return $result;			
			}else{
		$query = "SELECT ROW_NUMBER() OVER (ORDER BY id_correspondencia) AS numeracion,
					*,cor.referencia as Coordinacion,  refi.referencia  as Status 
					FROM correspondencia as C
					inner join referencial AS cor on cor.id_referencial= id_coordinacion
					inner join referencial as refi on refi.id_referencial = C.estatus
					ORDER BY id_correspondencia DESC";

				$result=$this->selectPdo($query);
				return $result;			
			}
		
		}


		public function getCoordinacion(){
				$query = "select id_referencial,referencia from referencial where referencial_id=9 and id_referencial !=9";			
				$result=$this->selectPdo($query);
				return $result;			
		}

		public function getCarpetas(){
				$query = "select * from carpetas_correspondencia";			
				$result=$this->selectPdo($query);
				return $result;			
		}

		public function arvhivarModel($id){			
					    return $result=$this->selectPdo($query = "UPDATE correspondencia SET estatus=110 WHERE id_correspondencia = $id");
				}

}?>