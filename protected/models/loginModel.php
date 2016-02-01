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
				"SELECT per.nombre,per.apellido,Use.usuario
					FROM
					persona Per
					INNER JOIN usuario Use on Use.id_usuario=Per.id_persona
					WHERE 
						Use.usuario = '$user'
					AND 
						Use.contraseña = '$contraseña'
						"
			);
			
			return $data->fetch();
		}
		
		
		
	}
?>