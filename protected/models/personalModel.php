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

	public function actualizarEmpleado($persona){
		$query=$this->query = "SELECT update_persona(:0,:cedula,:nombre1,:nombre2,:apellido1,:apellido2,:sexo,:fecha_nacimiento,:fecha_ingreso,:telefono,:otro_telefono,:correo,:cargo,:coordinacion,:parroquia,:ubicacion);";
		return $this->registroPdo($query,$persona);
	}
		
	public function getPersonal($cedula=false){
					switch(Session::get('perfil')){
						case 'Secretaria':
						case 'Adjunta':
						case 'Director General':
							if($cedula==true){
								return $this->selectPdo($query="SELECT * FROM personal_completo WHERE cedula='".$cedula."'
								AND id_persona != ".Session::get("id_persona")."");
							}else{
								return $this->selectPdo($query="SELECT * FROM personal_completo WHERE id_persona != ".Session::get("id_persona")."");
							}	
						break;
						case 'Director de linea':
							if($cedula==true){
								return $this->selectPdo($query="SELECT * FROM personal_completo WHERE cedula='".$cedula."'
								AND coordinacion ='".Session::get('coordinacion')."' AND id_persona != ".Session::get("id_persona")."");
							}else{
								return $this->selectPdo($query="SELECT * FROM personal_completo WHERE coordinacion ='".Session::get('coordinacion')."' AND id_persona != ".Session::get("id_persona")."");
							}
						break;
					}		
		
	}

	public function getInfoDatosModel(){				
			return $this->selectPdo($query=" SELECT nombre,apellido,id_persona FROM persona ORDER BY id_persona DESC LIMIT 1;");
	}

	public function getHijosModel(){				
			return $this->selectPdo($query = "SELECT * FROM hijos_registro");	
	}

	public function getPadresModel(){				
			return $this->selectPdo($query = "SELECT * FROM padres_registro");	
	}
			
	public function getDireccionEstado(){
			$query = " SELECT DISTINCT E.id_direccion,E.direccion as Estado from direccion E, direccion M, direccion P
			WHERE  E.id_direccion=M.id_padre and M.id_direccion=P.id_padre";			
			return $this->selectPdo($query);
	}

	public function getDireccionMunicipio($id){
			if($id==true){
			$query = "SELECT Distinct M.id_direccion,M.direccion AS Municipio FROM direccion E, direccion M, direccion P
			WHERE  E.id_direccion=M.id_padre AND M.id_direccion=P.id_padre AND M.id_padre='".$id."' ORDER BY municipio;";				
		}else{
			$query = "SELECT Distinct M.id_direccion,M.direccion AS Municipio FROM direccion E, direccion M, direccion P
			WHERE  E.id_direccion=M.id_padre AND M.id_direccion=P.id_padre  ORDER BY municipio;"			;
		}

			return $this->selectPdo($query);	
	}

	public function getDireccionParroquia($id=false,$cedula=false){
			if($cedula==true){
			$query = "SELECT * FROM parroquias_x_cedula	WHERE cedula='".$cedula."'";					
			}elseif($id==true){
			$query = "SELECT Distinct P.id_direccion,P.direccion as Parroquia,P.id_referencial from direccion E, direccion M, direccion P
			WHERE  E.id_direccion=M.id_padre AND M.id_direccion=P.id_padre AND P.id_padre='".$id."'";					
			}else{
			$query = "SELECT Parr.* from parroquias Parr";					
			}
			return $this->selectPdo($query);	
	}


	public function getCoordinaciones(){
			$query = "SELECT id_referencial as id_coordinacion, referencia as coordinacion FROM referencial WHERE referencial_id = 9 AND id_referencial !=9;";
			return $this->selectPdo($query);	
	}		

	public function getCargos(){
			$query = "SELECT C.id_referencial as id_cargo, C.referencia as cargo FROM referencial C  WHERE C.referencial_id=79 and C.id_referencial!=79 ORDER BY id_referencial;";			
			return $this->selectPdo($query);
	}

	public function getPersonalDisponible(){
					switch(Session::get('perfil')){
						case 'Secretaria':
						case 'Adjunta':
						case 'Director General':
							return $this->selectPdo($query = "SELECT * FROM personal_disponible WHERE id_persona != ".Session::get("id_persona")."");
						break;
						case 'Director de linea':
							return $this->selectPdo($query = "SELECT * FROM personal_disponible WHERE coordinacion ='".Session::get('coordinacion')."' AND id_persona != ".Session::get("id_persona")."");
						break;
					}		
			
	}

	public function getUnicaPersona($id){
			return $this->selectPdo($query = "SELECT * FROM persona_unica WHERE id_persona = '".$id."'");
	}			

	public function getHijosEmpleado($id){
			return $this->selectPdo($query = "SELECT H.* FROM hijos_empleados H INNER JOIN familiar f ON f.id_persona_empleada='".$id."'");
	}

	public function getDeportes($id){
			return $this->selectPdo($query = "SELECT * FROM info_adicional WHERE id_persona_empleada='".$id."'");
	}	

	public function deletePersona($id){
			return $this->selectPdo($query = "UPDATE persona_empleada SET status_referencial= 99 where id_persona='".$id."'");	
	}

	public function getReporte($mes){
			return $this->selectPdo($query = "SELECT  * from reporte WHERE extract(MONTH from fecha_asistencia) = ".$mes." ");
	}				
}
?>

