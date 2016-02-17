<?php 

	class vacacionesModel extends Model{
		
		//variable protegida donde se guardan los query para la base de datos
		protected $query;
		
		//Construtor Herado de la clase Modelo principal
		public function __construct(){
			parent::__construct();
		}



		//Retorna un listado del personal a traves de un select
		public function getVacaciones($id = FALSE,$actividad = FALSE){
			 

				$query = "SELECT ROW_NUMBER() OVER (ORDER BY P.id_persona) AS numeracion,R.referencia as perfil,* from usuario U
							INNER JOIN persona AS P ON P.id_persona= U.id_persona
							INNER JOIN referencial AS R ON R.id_referencial= U.perfil_referencial";


				$auxiliar = $this->_db->query($query);
				try {
				$this->_db->beginTransaction();
				$result= $auxiliar->fetchAll();
				$this->_db->commit();
				}
				catch (Exception $e){
					
					$this->_db-rollBack();
					echo "Error :: ".$e->getMessage();
					exit();
					
				}

				if(empty($result)){

					$result[0] = "No hay Personal Disponible para asignar";
					return $result;

				}else{

					return $result;
				}
			
		}

	
	}
?>

