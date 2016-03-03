<?php 

	class personalModel extends Model{
		
		protected $query;
		
	public function __construct(){
		parent::__construct();
	}

	public function insertPersonModel($persona){
			$query=$this->query = "SELECT registro_persona(:tipo_persona,:nombre,:nombre2,:apellido,:apellido2,:sexos,
			:fecha_nacimiento,:cedula,:fecha_ingreso,:telefono,:correo,:direccion,:ubicacion,:otro_telefono,:cargo,:coordinacion);";
			$this->registroPdo($query,$persona);
	}

	public function InsertInfoAdicional($infoAdicional,$arregloPost){
			$query=$this->query = "SELECT registro_informacion_adicional(:vehiculos,:vivienda,'$arregloPost',:medicina_text);";
			$this->registroPdo($query,$infoAdicional);
	}
	
	public function getPersonal(){	
			$query = "SELECT * FROM personal_completo";
			$result=$this->selectPdo($query);
			return $result;		
	}

	public function getInfoDatosModel(){	
			$query = " SELECT nombre,apellido,id_persona FROM persona ORDER BY id_persona DESC LIMIT 1;";
			$result=$this->selectPdo($query);
			return $result;		
	}

	public function getHijosModel(){	
			$query = "SELECT * FROM hijos_registro";
			$result=$this->selectPdo($query);
			return $result;
		
	}
			
	public function getDireccionEstado(){
			$query = " SELECT DISTINCT E.id_direccion,E.direccion as Estado from direccion E, direccion M, direccion P
			WHERE  E.id_direccion=M.id_padre and M.id_direccion=P.id_padre";			
			$result=$this->selectPdo($query);
			return $result;			
	}

	public function getDireccionMunicipio($id){
			$query = "SELECT Distinct M.id_direccion,M.direccion AS Municipio FROM direccion E, direccion M, direccion P
			WHERE  E.id_direccion=M.id_padre AND M.id_direccion=P.id_padre AND M.id_padre='".$id."' ORDER BY municipio;";			
			$result=$this->selectPdo($query);
			return $result;			
	}

	public function getDireccionParroquia($id=false){
			$query = "SELECT Distinct P.id_direccion,P.direccion as Parroquia,P.id_referencial from direccion E, direccion M, direccion P
			WHERE  E.id_direccion=M.id_padre AND M.id_direccion=P.id_padre AND P.id_padre='".$id."'";			
			$result=$this->selectPdo($query);
			return $result;			
	}


	public function getCoordinaciones(){
			$query = "SELECT id_referencial as id_coordinacion, referencia as coordinacion FROM referencial WHERE referencial_id = 9 AND id_referencial !=9;";			
			$result=$this->selectPdo($query);
			return $result;			
	}		

	public function getCargos(){
			$query = "SELECT C.id_referencial as id_cargo, C.referencia as cargo FROM referencial C  WHERE C.referencial_id=79 and C.id_referencial!=79 ORDER BY id_referencial;";			
			$result=$this->selectPdo($query);
			return $result;			
	}

	public function getPersonalDisponible(){
			$query = "SELECT * FROM personal_disponible";
			$result=$this->selectPdo($query);
			return $result;		
	}

	public function getUnicaPersona($id){
			$query = "SELECT * FROM persona_unica WHERE id_persona = '".$id."'";
				$result=$this->selectPdo($query);
				return $result;
		
	}			
					
}
?>

