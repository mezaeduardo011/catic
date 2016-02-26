<?php
	class Model{
		protected $_db;
		
		public function __construct() {
			$this->_db = new DataBase();
		}
		public function registroPdo($query,$datos){
					try {

						$this->_db->beginTransaction();
						$this->_db->prepare($query)->execute($datos);
						$this->_db->commit();
					}
					catch (Exception $e){
						$this->_db->rollBack();
						echo "Error :: ".$e->getMessage();
						exit();
					}
		}

		public function registroPdoArray($query,$datos){
					try {

						$this->_db->beginTransaction();
						$this->_db->prepare($query)->execute();
						$this->_db->commit();
					}
					catch (Exception $e){
						$this->_db->rollBack();
						echo "Error :: ".$e->getMessage();
						exit();
					}
		}


		public function selectPdo($query){
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
	}
?>