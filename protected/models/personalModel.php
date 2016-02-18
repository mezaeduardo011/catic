<?php 

	class personalModel extends Model{
		
		//variable protegida donde se guardan los query para la base de datos
		protected $query;
		
		//Construtor Herado de la clase Modelo principal
		public function __construct(){
			parent::__construct();
		}

		//Insercion de la persona nueva
		public function insertPersonModel($persona){
				//Se le pasa el arreglo desde el controlador, se le asignan los valores segun lo que dicta la asociacion
			$this->query = "SELECT registro_persona(:tipo_persona,:nombre,:nombre2,:apellido,:apellido2,:sexos,
				:fecha_nacimiento,:cedula,:fecha_ingreso,:telefono,:correo,:direccion,:ubicacion,:otro_telefono);";
			
			//Cuando esta construido el query se envia para que empieze la transaccion.
			try {

				$this->_db->beginTransaction();
				$this->_db->prepare($this->query)->execute($persona);

				//Sirve como confirmacion de que se realizaron los cambios con exito o se ejercuto la sentencia
				$this->_db->commit();
			}

			//En caso de error, lo envia en pantalla.
			catch (Exception $e){
				$this->_db->rollBack();
				echo "Error :: ".$e->getMessage();
				exit();
			}
		}


		//Retorna un listado del personal a traves de un select
		public function getPersonal($id = FALSE,$actividad = FALSE){
			 
			if (is_bool($id)){
				if(is_bool($actividad)){

				$query = "SELECT ROW_NUMBER() OVER (ORDER BY P.id_persona) AS numeracion,
							P.*,S.referencia AS sexo ,E.*
							FROM persona P
							INNER JOIN referencial AS S on S.id_referencial = P.sexo_referencial
							INNER JOIN persona_empleada as E on E.id_persona=P.id_persona
							AND tipo_persona_referencial=76";
				}else{

				$query = "SELECT ROW_NUMBER() OVER (ORDER BY id_persona) AS numeracion,*,S.referencia AS sexo from persona P, referencial S
							WHERE p.sexo_referencial= S.id_referencial AND P.status_referencial != 20";

				}

			}else{

				$query = "SELECT (SELECT date_part('year',age( fecha_nacimiento )) ) as edad,S.referencia AS sexo,*
					FROM persona P, referencial S, persona_empleada P2
					WHERE p.sexo_referencial= S.id_referencial
					AND
					P.id_persona = $id";

			}

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

		public function getInfoDatosModel(){
	
				$query = " SELECT nombre,apellido FROM persona ORDER BY id_persona DESC LIMIT 1;";
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

		//Retorna un listado del personal a traves de un select
		public function getHijosModel(){
	
				$query = "SELECT
							 ROW_NUMBER() OVER (ORDER BY P.id_persona) AS numeracion,
							     (SELECT date_part('year',age( P.fecha_nacimiento )) ) as edad,
								P.* ,S.referencia as sexo
								FROM persona P,familiar F , referencial S
							        WHERE S.id_referencial=P.sexo_referencial
								AND P.tipo_persona_referencial = 65 
								--AND F.id_persona_empleada = 20 
								--AND F.id_persona= P.id_persona;";
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

		public function getUnicaPersona($id){

		$query = "SELECT (SELECT date_part('year',age( fecha_nacimiento )) ) as edad,S.referencia as sexo,
					 E.direccion as Estado, M.direccion as Municipio,P.direccion as Parroquia,* 
					 from persona PER, referencial S, persona_empleada P2, direccion E, direccion M, direccion P
					WHERE pER.sexo_referencial= S.id_referencial
					AND  E.id_direccion=M.id_padre 
					AND M.id_direccion=P.id_padre
					AND P.id_direccion=direccion_referencial
					AND	PER.id_persona = 0";
			
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

		public function updatePersonal($persona){
		$this->query = "UPDATE persona SET 
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
		
		public function deletePersonal($id){
		$this->query = "DELETE  FROM persona where id_persona = $id";
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
		 
		public function getSexo(){

			$query = "SELECT id_referencial,referencia FROM referencial  WHERE referencial_id=15 and id_referencial!=15";
			
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

	   	// public function num_campos(){
	    // 	$res= $this->_db->prepare("SELECT * from persona");
	    // 	$res->execute();
	    // 	$colcount = $res->columnCount();
	    // 	print_r($colcount);
	    // 	die();
    	// }
		
		public function getDireccionEstado(){


			$query = " SELECT DISTINCT E.id_direccion,E.direccion as Estado from direccion E, direccion M, direccion P
				WHERE  E.id_direccion=M.id_padre and M.id_direccion=P.id_padre";
			
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

		public function getDireccionMunicipio($id){

		$query = "SELECT Distinct M.id_direccion,M.direccion AS Municipio FROM direccion E, direccion M, direccion P
				WHERE  E.id_direccion=M.id_padre AND M.id_direccion=P.id_padre AND M.id_padre='".$id."' ORDER BY municipio;";
			
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

		public function getDireccionParroquia($id=false){

		$query = "SELECT Distinct P.id_direccion,P.direccion as Parroquia,P.id_referencial from direccion E, direccion M, direccion P
			WHERE  E.id_direccion=M.id_padre AND M.id_direccion=P.id_padre AND P.id_padre='".$id."'";
			
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


		public function getCoordinaciones(){

		$query = "SELECT * FROM referencial WHERE referencial_id = 9 AND id_referencial !=9;";
			
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

		public function getTallasCamisas(){

		$query = "SELECT id_referencial,referencia FROM referencial  WHERE referencial_id=22 and id_referencial!=23 ORDER BY id_referencial;";
			
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

		public function getTallasPantalon(){

		$query = "SELECT id_referencial,referencia FROM referencial  WHERE referencial_id=31 and id_referencial!=31 ORDER BY id_referencial;";
			
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

		public function getTallasZapatos(){

		$query = "SELECT id_referencial,referencia FROM referencial  WHERE referencial_id=41 and id_referencial!=41 ORDER BY id_referencial;";
			
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

