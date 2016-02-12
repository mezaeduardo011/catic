<?php
namespace MPPICurl;

use MPPICurl\MPPICurl;
/**
* Clase cliente de conexiones CuRL
*/
class MPPICurlCliente extends MPPICurl
{
    /**
     * Arreglo con los metodos que usan query-uri en su url
     * @var array
     */
    private $query_url_type = array('get','delete','head','options');

	/**
     * Permite realizar una conexion con el metodo GET
     * @param  String       $url          Cadena con la url de la conexión
     * @param  Array        $data         Arreglo asociativo con los parametros que se desean enviar
     * @param  Callable     $success      Funcion que debe ejecutarse en caso de que la petición sea exitosa
     * @param  Callable     $error        Funcion que debe ejecutarse en caso de error en la petición
     * @param  Callable     $complete     Funcion que debe ejecutarse cuando la petición culmina sin importar si fue exitosa o no
     * @return mixto                      El valor que se desea devolver desdela funcion success o error segun sea el caso
     */
	public function get($url,$data = array(),$success = NULL,$error = NULL,$complete = NULL){

        $this->defineConexion('GET',$url, $data);
        $this->definirOpcionCuRL(CURLOPT_HTTPGET, true);
        return $this->ejecutar($success,$error,$complete);
	}

    /**
     * Permite realizar una conexion con el metodo POST
     * @param  String       $url          Cadena con la url de la conexión
     * @param  Array        $data         Arreglo asociativo con los parametros que se desean enviar
     * @param  Callable     $success      Funcion que debe ejecutarse en caso de que la petición sea exitosa
     * @param  Callable     $error        Funcion que debe ejecutarse en caso de error en la petición
     * @param  Callable     $complete     Funcion que debe ejecutarse cuando la petición culmina sin importar si fue exitosa o no
     * @return mixto                      El valor que se desea devolver desdela funcion success o error segun sea el caso
     */
    public function post($url, $data = array(),$success = NULL,$error = NULL,$complete = NULL)
    {
        if (is_array($data) && empty($data)) {
            $this->eliminarCabecera('Content-Length');
        }

        $this->defineConexion('POST',$url, $data);

        return $this->ejecutar($success,$error,$complete);
    }

    /**
     * Permite realizar una conexion con el metodo PUT
     * @param  String       $url          Cadena con la url de la conexión
     * @param  Array        $data         Arreglo asociativo con los parametros que se desean enviar
     * @param  Callable     $success      Funcion que debe ejecutarse en caso de que la petición sea exitosa
     * @param  Callable     $error        Funcion que debe ejecutarse en caso de error en la petición
     * @param  Callable     $complete     Funcion que debe ejecutarse cuando la petición culmina sin importar si fue exitosa o no
     * @return mixto                      El valor que se desea devolver desdela funcion success o error segun sea el caso
     */
    public function put($url, $data = array(),$success = NULL,$error = NULL,$complete = NULL)
    {

        if(is_null($this->optenerOpcionCuRL(CURLOPT_INFILE))&&is_null($this->optenerOpcionCuRL(CURLOPT_INFILE))){
            $this->definirCabeceras('Content-Length', strlen(http_build_query($data)));
        }

        $this->defineConexion('PUT',$url, $data);

        return $this->ejecutar($success,$error,$complete);
    }

    /**
     * Permite realizar una conexion con el metodo PATCH
     * @param  String       $url          Cadena con la url de la conexión
     * @param  Array        $data         Arreglo asociativo con los parametros que se desean enviar
     * @param  Callable     $success      Funcion que debe ejecutarse en caso de que la petición sea exitosa
     * @param  Callable     $error        Funcion que debe ejecutarse en caso de error en la petición
     * @param  Callable     $complete     Funcion que debe ejecutarse cuando la petición culmina sin importar si fue exitosa o no
     * @return mixto                      El valor que se desea devolver desdela funcion success o error segun sea el caso
     */
    public function patch($url, $data = array(),$success = NULL,$error = NULL,$complete = NULL)
    {
        $this->eliminarCabecera('Content-Length');

        $this->defineConexion('PATCH',$url, $data);
        
        return $this->ejecutar($success,$error,$complete);
    }

    /**
     * Permite realizar una conexion con el metodo DELETE
     * @param  String       $url          Cadena con la url de la conexión
     * @param  Array        $data         Arreglo asociativo con los parametros que se desean enviar
     * @param  Callable     $success      Funcion que debe ejecutarse en caso de que la petición sea exitosa
     * @param  Callable     $error        Funcion que debe ejecutarse en caso de error en la petición
     * @param  Callable     $complete     Funcion que debe ejecutarse cuando la petición culmina sin importar si fue exitosa o no
     * @return mixto                      El valor que se desea devolver desdela funcion success o error segun sea el caso
     */
    public function delete($url, $data = array(),$success = NULL,$error = NULL,$complete = NULL)
    {

        $this->eliminarCabecera('Content-Length');

        $this->defineConexion('DELETE',$url, $data);
        
        return $this->ejecutar($success,$error,$complete);

    }

    /**
     * Permite realizar una conexion con el metodo HEAD
     * @param  String       $url          Cadena con la url de la conexión
     * @param  Array        $data         Arreglo asociativo con los parametros que se desean enviar
     * @param  Callable     $success      Funcion que debe ejecutarse en caso de que la petición sea exitosa
     * @param  Callable     $error        Funcion que debe ejecutarse en caso de error en la petición
     * @param  Callable     $complete     Funcion que debe ejecutarse cuando la petición culmina sin importar si fue exitosa o no
     * @return mixto                      El valor que se desea devolver desdela funcion success o error segun sea el caso
     */
    public function head($url, $data = array(),$success = NULL,$error = NULL,$complete = NULL)
    {
        
        $this->definirOpcionCuRL(CURLOPT_NOBODY, true);

        $this->defineConexion('HEAD',$url, $data);
        
        return $this->ejecutar($success,$error,$complete);

    }

    /**
     * Permite realizar una conexion con el metodo OPTIONS
     * @param  String       $url          Cadena con la url de la conexión
     * @param  Array        $data         Arreglo asociativo con los parametros que se desean enviar
     * @param  Callable     $success      Funcion que debe ejecutarse en caso de que la petición sea exitosa
     * @param  Callable     $error        Funcion que debe ejecutarse en caso de error en la petición
     * @param  Callable     $complete     Funcion que debe ejecutarse cuando la petición culmina sin importar si fue exitosa o no
     * @return mixto                      El valor que se desea devolver desdela funcion success o error segun sea el caso
     */
    public function options($url, $data = array())
    {

        $this->eliminarCabecera('Content-Length');

        $this->defineConexion('DELETE',$url, $data);
        
        return $this->ejecutar($success,$error,$complete);

    }


    private function defineConexion($tipo,$url,$data=array()){

        $this->definirOpcionCuRL(CURLOPT_URL, $this->prepararURL($tipo,$url,$data));
        $this->definirOpcionCuRL(CURLOPT_CUSTOMREQUEST,$tipo);

        if(!in_array($tipo, $this->query_url_type)){

            $this->definirOpcionCuRL(CURLOPT_POST, true);
            $this->definirOpcionCuRL(CURLOPT_POSTFIELDS, $this->preparaPostData($data));
        }
    }

	private function prepararURL($tipo,$url, $data)
    {

        $query_data = in_array($tipo, $this->query_url_type)&&!empty($data)?'?'.http_build_query($data):'';

        return "$url$query_data";
    }

    private function  preparaPostData($data){

        $datos_binarios = 0;
        foreach ($data as $key => $value) {

            $data[$key] = is_array($value)&&empty($value)?'':$value;

            if($this->esArchivo($value)&&class_exists('CURLFile')){

                $data[$key] = new \CURLFile(preg_replace('/^@/', '', $value));

                $datos_binarios+=1;

            }

        }

        return $datos_binarios==0?http_build_query($data):$data;
    }

    private function esArchivo($valor = ''){

        return !!file_exists(preg_replace('/^@/', '', $valor));
    }
}
?>