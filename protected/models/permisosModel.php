<?php 

	class permisosModel extends Model{
		
		protected $query;
		
		public function __construct(){
			parent::__construct();
		}
		public function __destruct(){
			;
		}

		public function getPersonalDisponible(){			 

				$query = "SELECT ROW_NUMBER() OVER (ORDER BY P.id_persona) AS numeracion,P.*,S.referencia AS sexo ,E.*
							FROM persona P
							INNER JOIN referencial AS S on S.id_referencial = P.sexo_referencial
							INNER JOIN persona_empleada as E on E.id_persona=P.id_persona
							WHERE tipo_persona_referencial=76
							AND status_referencial != 88";

				$result=$this->selectPdo($query);
				return $result;
		
		}		
	

}
?>