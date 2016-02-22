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
						
			$this->query = "INSERT INTO correspondencia
							( asunto ,  oficina ,   fecha ,  instruccion,tipo , id_status, id_coordinacion)  VALUES 
							( :asunto, :oficina, :fecha ,  :instruccion,:tipo , 19 ,:coordinacion)   ";		
			try {
				$this->_db->beginTransaction();
				$this->_db->prepare($this->query)->execute($correspondencia);
				$this->_db->commit();
			}
			catch (Exception $e){
				$this->_db->rollBack();
				echo "Error :: ".$e->getMessage();
				exit();
			}
			
		}
		
		
		
		
		
		
		
		public function getCorrespondencia(){

		$query = "SELECT ROW_NUMBER() OVER (ORDER BY id_correspondencia) AS numeracion,
				*,referencia as Coordinacion, (select referencia from referencial where id_referencial = 23) as Status 
				FROM correspondencia
				inner join referencial on id_referencial= id_coordinacion
				ORDER BY id_correspondencia DESC";
			
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
				
				return $result;
			
		}

		public function getUnicaPersonal($id){

		$query = "SELECT * FROM personas where id = $id";
			
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
				
				return $result;
			
		}

		
		

		public function updatePerson($persona){
		$this->query = "UPDATE PERSONAS SET 
					cedula 		= :cedula,
					nombre 		= :nombre,
					apellido 	= :apellido,
					sexo 		= :sexo,
					fecha_nacimiento = :fecha_nacimiento,
					telefono 		= :telefono,
					correo 		= :correo
					where id = :id";

				
		
			try {
				$this->_db->beginTransaction();
				$this->_db->prepare($this->query)->execute($persona);
				$this->_db->commit();
			}
			catch (Exception $e){
				$this->_db->rollBack();
				echo "Error :: ".$e->getMessage();
				exit();
			}
			
		}
		


		public function deletePersons($id){
		$this->query = "DELETE  FROM personas where id = $id";

				
		
			try {
				$this->_db->beginTransaction();
				$this->_db->prepare($this->query)->execute();
				$this->_db->commit();
			}
			catch (Exception $e){
				$this->_db->rollBack();
				echo "Error :: ".$e->getMessage();
				exit();
			}
			
		}
		 
	


		public function getCoordinacion(){

		$query = "select id_referencial,referencia from referencial where referencial_id=9 and id_referencial !=9";
			
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
				
				return $result;
			
		}

		








}?>