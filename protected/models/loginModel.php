<?php
	
	class loginModel extends Model {
		
		protected 	$query;
		
		public function __construct() {
			parent::__construct();
		}
		
		public function __destruct() {
			;
		}
		
		public function getUser($user, $pass=false) {
			if ($pass!=false) {
			$contraseña=md5($pass);	
			$data = $this->_db->query(
				"SELECT  *,P.nombre,P.apellido,P.cedula,ref.referencia as perfil
					FROM usuario U
					INNER JOIN persona as P ON P.id_persona=U.id_persona
					INNER JOIN persona_empleada as Per ON Per.id_persona=P.id_persona
					INNER JOIN referencial as ref ON ref.id_referencial = u.perfil_referencial
					WHERE 
						usuario = "."'".$user."'"."
					AND 
						contraseña = "."'".$contraseña."'".""
			);
			
			return $data->fetch();
			}else{

			$data = $this->_db->query(
				"SELECT  *,P.nombre,P.apellido,P.cedula,ref.referencia as perfil
					FROM usuario U
					INNER JOIN persona as P ON P.id_persona=U.id_persona
					INNER JOIN persona_empleada as Per ON Per.id_persona=P.id_persona
					INNER JOIN referencial as ref ON ref.id_referencial = u.perfil_referencial
					WHERE 
						usuario = "."'".$user."'".""
			);
			
			return $data->fetch();				
			}

		}

		function updatePass($pass,$id_usuario){
			 $contraseña=md5($pass);	
			 $this->query ="UPDATE usuario SET contraseña ='".$contraseña."' WHERE id_usuario = '$id_usuario'";	
		
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
		
		
		
	}
?>