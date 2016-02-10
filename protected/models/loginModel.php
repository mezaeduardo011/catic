<?php
	
	class loginModel extends Model {
		
		protected 	$query;
		
		public function __construct() {
			parent::__construct();
		}
		
		public function __destruct() {
			;
		}
		
		public function getUser($user, $pass) {
			$contraseña=md5($pass);	
			$data = $this->_db->query(
				"SELECT  *,P.nombre,P.apellido
					FROM usuario U
					INNER JOIN persona as P ON P.id_persona=U.id_persona
					WHERE 
						usuario = "."'".$user."'"."
					AND 
						contraseña = "."'".$contraseña."'".""
			);
			
			return $data->fetch();
		}
		
		
		
	}
?>