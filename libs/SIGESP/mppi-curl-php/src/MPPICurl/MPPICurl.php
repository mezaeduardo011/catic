<?php

namespace MPPICurl;

use MPPICurl\MPPICurlMensajes as MSG;
use MPPICurl\MPPICurlCabeceras;
use MPPICurl\MPPICurlRespuesta;

/**
* Clase que permite utilizar la libreria CuRL de forma facil
*/
class MPPICurl extends MPPICurlCabeceras
{
	/**
	 * Versión de la clase
	 */
	const VERSION = '1.0';

	/**
	 * Patron utilizado para validar los contenidos JSON
	 */
	const PATRON_JSON = '/^application\/json/i';

	/**
	 * Patron utilizado para validar los contenidos atom/xml
	 */
	const PATRON_ATOM_XML = '/^application\/atom\+xml/i';
	/**
	 * Patron utilizado para validar los contenidos rss/xml
	 */
	const PATRON_RSS_XML  = '/^application\/rss\+xml/i';
	/**
	 * Patron utilizado para validar los contenidos aplication/xml
	 */
	const PATRON_APP_XML  = '/^application\/xml/i';
	/**
	 * Patron utilizado para validar los contenidos text/xml
	 */
	const PATRON_TEXT_XML = '/^text\/xml/i';

	/**
	 * Arreglo con los COOKIES que se desean incluir en el Request
	 * @var array
	 */
    private $cookies = array();
    /**
     * Arreglo con los HEADERS que se desean incluir en el Request
     * @var array
     */
    private $headers = array();
    /**
     * Arreglo con las OPCIONES que se desean incluir en el Request
     * @var array
     */
    private $options = array();

    /**
     * Objeto CuRL
     * @var CuRL
     */
    protected $curl             = NULL;

    /**
     * Respuesta de la ejecucion del objeto CuRL
     * @var String
     */
    private $curl_respuesta     = NULL;

    /**
     * Codigo de Error CuRL
     * @var [type]
     */
    private $curl_error_code    = NULL;

    /**
     * Mensaje de Error CuRL
     * @var [type]
     */
    private $curl_error_message = NULL;

    /**
     * Error Curl
     * @var [type]
     */
	private $curl_error         = NULL;

	/**
	 * Codigo HTTP del status de la respuesta
	 * @var [type]
	 */
	private $http_status_code   = NULL;

	/**
	 * Error HTTP
	 * @var [type]
	 */
	private $http_error         = NULL;

	/**
	 * Error
	 * @var [type]
	 */
	private $error              = NULL;

	/**
	 * Codigo de Error
	 * @var [type]
	 */
	private $error_code         = NULL;

	/**
	 * HTTP mensaje de error
	 * @var [type]
	 */
	private $http_error_message = NULL;

	/**
	 * Cabeceras de la peticion
	 * @var array
	 */
	private $cabeceras_request  = array();

	/**
	 * Cabeceras de la Respuesta
	 * @var array
	 */
	private $cabeceras_response = array();

	/**
	 * Cuerpo de la respuesta de la peticion
	 * @var string
	 */
	private $cuerpo_response    = '';

	function __construct()
	{
		if (!extension_loaded('curl')) {

            throw new \ErrorException(MSG::NO_EXTENCION_CURL);

        }

		$this->curl = curl_init();
		$this->defineUserAgentPorDefecto();
        $this->definirOpcionCuRL(CURLINFO_HEADER_OUT, true);
        $this->definirOpcionCuRL(CURLOPT_HEADER, true);
        $this->definirOpcionCuRL(CURLOPT_RETURNTRANSFER, true);
	}

	/**
	 * Permite definir el User Agent que se utilizara en la conexion
	 * @param  String     $user_agent     Cadena cvon el User Agent
	 * @return MPPICurl
	 */
	public function defineUserAgent($user_agent = '')
    {
        $this->definirOpcionCuRL(CURLOPT_USERAGENT, $user_agent);
        return $this;
    }

    /**
     * Permite definir opociones propias de CuRL
     * @param String                     $option     Cadena con el nombre de la opcion que se desea definir
     * @param String|Boolean|Numeric     $value      Valor que se desea definir
     * @param Boolean                                Devuelve TRUE si la operacion se realizo corectamente o FALSE en caso contrario
     */
	public function definirOpcionCuRL($opcion, $valor)
    {

        $opciones_requeridas = array(
            CURLINFO_HEADER_OUT    => 'CURLINFO_HEADER_OUT',
            CURLOPT_HEADER         => 'CURLOPT_HEADER',
            CURLOPT_RETURNTRANSFER => 'CURLOPT_RETURNTRANSFER',
        );

        if (in_array($opcion, array_keys($opciones_requeridas), true) && !($valor === true)) {
            trigger_error($opciones_requeridas[$opcion] . MSG::OPCION_NECESARIA, E_USER_WARNING);
        }

        $this->options[$opcion] = $valor;

        return curl_setopt($this->curl, $opcion, $valor);
    }

    /**
     * Permite obtener un valor definido entre las opciones CuRL
     * @param  String                          $option     Cadena con el nombre de la opcion que se desea obtener
     * @return String|Boolean|Numeric|NULL     $value      Devuelve el Valor definido o NULL en caso de no estar definido
     */
    public function optenerOpcionCuRL($opcion){

        return isset($this->options[$opcion])?$this->options[$opcion]:NULL;

    }

    /**
     * Permite definir un User Agent por defecto
     * @return MPPICurl
     */
	private function defineUserAgentPorDefecto()
    {
        $user_agent = 'mppi-curl-php/'. self::VERSION . ' (+http://git.mppi.gob.ve/janselmi/mppi-curl-php)';
        $user_agent .= ' PHP/' . PHP_VERSION;
        $curl_version = curl_version();
        $user_agent .= ' curl/' . $curl_version['version'];
        $this->defineUserAgent($user_agent);
        return $this;
    }

    /**
     * Permite cerrar el objeto CuRL
     */
    public function cerrar()
    {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }
    }

    /**
     * Permite definir la o las cabeceras que se desean incluir en la conexion
     * @param  array     $cabeceras     Arreglo asociativo de Cabeceras
     * @return MPPICurl
     */
    public function definirCabeceras($cabeceras = array()){

    	if($this->is_array_assoc($cabeceras)){

    		$cabeceras = $this->preparaCabeceras($cabeceras);

    		$this->definirOpcionCuRL(CURLOPT_HTTPHEADER, $cabeceras);

    	}
    	return $this;
    }

    /**
     * Permite eliminar cabeceras de la conexión
     * @param  String     $key     Cadena con el nombre de la cabecera a eliminar
     * @return MPPICurl
     */
    public function eliminarCabecera($key)
    {
        $this->definirCabeceras($key, '');
        unset($this->headers[$key]);
        return $this;
    }

    /**
     * Permite definir el metodo de autenticación basica como metodo de autenticacion
     * @param  String     $usuario     Cadena con el nombre de usuario
     * @param  String     $clave       Cadena con la clave
     * @return MPPICurl
     */
	public function definirBasicAuthentication($usuario = '', $clave = '')
    {
        $this->definirOpcionCuRL(CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $this->definirOpcionCuRL(CURLOPT_USERPWD, "$usuario:$clave");
        return $this;
    }

    /**
     * Permite definir la url Referrer de la conexión
     * @param  string     $referrer     Cadena con la url que se desea asignar como referrer
     * @return MPPICurl
     */
	public function definirReferrer($referrer = '')
    {
        $this->definirOpcionCuRL(CURLOPT_REFERER, $referrer);
        return $this;
    }

    /**
     * Permite definir Cookies que se desean incluir en la conexion
     * @param  String     $key       Cadena con el nombre de la Coohie que se quiere definir
     * @param  String     $value     Cadena con el valor de la cookie
     * @return MPPICurl
     */
    public function definirCookie($key, $value)
    {
        $this->cookies[$key] = $value;
        $this->definirOpcionCuRL(CURLOPT_COOKIE, http_build_query($this->cookies, '', '; '));
        return $this;
    }

    /**
     * Permite importar Cookies desde un archivo 
     * @param  String     $cookie_file     Cadena de texto con la ruta del archivo que se desea importar
     * @return MPPICurl
     */
    public function definirCookieFile($cookie_file)
    {
        $this->definirOpcionCuRL(CURLOPT_COOKIEFILE, $cookie_file);
        return $this;
    }

    /**
     * Permite definir el archivo donde de desean almacenar las Cookies localmente
     * @param  sTRING     $cookie_jar     Cadena de texto con la ruta del archivo donde se desea almacenar las Cookies
     * @return MPPICurl
     */
    public function definirCookieJar($cookie_jar)
    {
        $this->definirOpcionCuRL(CURLOPT_COOKIEJAR, $cookie_jar);
        return $this;
    }

    public function ejecutar($success,$error,$complete){

    	$this->curl_respuesta    = curl_exec($this->curl);

    	$this->carturarErrores();

		$this->procesarRespuesta();

		if ($this->error) {

            if (isset($this->cabeceras_response['Status-Line'])) {

                $this->http_error_message = $this->cabeceras_response['Status-Line'];

            }

        }

        $this->error_message = $this->curl_error ? $this->curl_error_message : $this->http_error_message;

        
        $respuesta           = new MPPICuRLRespuesta(
        							$this->cabeceras_request,
        							$this->cabeceras_response,
        							$this->cuerpo_response,
        							$this->obtenerErrores()
        );

        $ejecución = $this->ejecutarFuncion(!!$this->error?$error:$success, $respuesta);

       	$this->ejecutarFuncion($complete, $respuesta);

        return $ejecución;
    }

    /**
     * Permite ejecutar una funcion,los parametros deben ser pasados inmediatamente despues de la funcion a ejecutar
     * @param  callable     $funcion     Funcion que se desea ejecutar
     */
    private function ejecutarFuncion($funcion)
    {
        if (is_callable($funcion)) {
            $args = func_get_args();
            array_shift($args);
            return call_user_func_array($funcion, $args);
        }
        return NULL;
    }

    /**
     * Permite procesar la respuesta de la peticion y separar las cabeceras del curpo de la respuesta
     */
    private function procesarRespuesta(){

    	$this->cabeceras_request = $this->extraerCabecerasRequest();

        if (!(strpos($this->curl_respuesta, "\r\n\r\n") === false)) {

        	list($cabeceras,$cuerpo) = explode("\r\n\r\n", trim($this->curl_respuesta));

        	if(preg_match('/^HTTP/',$cabeceras)){

        		$this->cabeceras_response = $this->extraerCabecerasResponse($cabeceras);
        	}

        	if(isset($this->cabeceras_response['Content-Type'])){

        		$tipo_contenido = $this->cabeceras_response['Content-Type'];

        		if($this->esJSON($tipo_contenido)){

        			$cuerpo = json_decode($cuerpo, false);

        		}elseif ($this->esXML($tipo_contenido)){

        			$cuerpo = @simplexml_load_string($cuerpo);

        		}
        	}

        	$this->cuerpo_response = $cuerpo;
        }
    }

    /**
     * Permite saber si un tipo de contenido es JSON
     * @param  String     $tipo_contenido     Cadena con el contenido a evaluar
     * @return Boolean                        Devuelve TRUE si el Contenido es JSON o FALSE en caso contrario
     */
    private function esJSON($tipo_contenido){

    	 return preg_match(self::PATRON_JSON, $tipo_contenido);

    }
    /**
     * Permite saber si un tipo de contenido es XML
     * @param  String     $tipo_contenido     Cadena con el contenido a evaluar
     * @return Boolean                        Devuelve TRUE si el Contenido es XML o FALSE en caso contrario
     */

    private function esXML($tipo_contenido){

    	return !!(preg_match(self::PATRON_ATOM_XML, $tipo_contenido)||
			preg_match(self::PATRON_RSS_XML, $tipo_contenido)||
			preg_match(self::PATRON_APP_XML, $tipo_contenido)||
			preg_match(self::PATRON_TEXT_XML, $tipo_contenido)
		);
    }


    /**
     * Permite Obtener Todos los Errores
     * @return array
     */
    public function obtenerErrores(){
    	return array(
        	"error"              => $this->error,
        	"error_code"         => $this->error_code,
        	"http_error"         => $this->http_error,
        	"http_status_code"   => $this->http_status_code,
        	"http_error_message" => $this->http_error_message,
        	"curl_error"         => $this->curl_error,
    		"curl_error_code"    => $this->curl_error_code,
    		"curl_error_message" => $this->curl_error_message
    	);
    }





    /**
     * Permite capturar todos las definiciones de errores
     * @return [type] [description]
     */
    private function carturarErrores(){

    	$this->curl_error_code    = curl_errno($this->curl);
    	$this->curl_error_message = curl_error($this->curl);
        $this->curl_error         = !($this->curl_error_code === 0);
        $this->http_status_code   = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $this->http_error         = in_array(floor($this->http_status_code / 100), array(4, 5));
        $this->error              = $this->curl_error || $this->http_error;
        $this->error_code         = $this->error ? ($this->curl_error ? $this->curl_error_code : $this->http_status_code) : 0;
        $this->http_error_message = '';
        return $this;
    }


    /**
     * Permite validar si un arrays es asociativo
     * @param  Array      $array     Arreglo que se desea evaluar
     * @return boolean               Devuelve TRUE si el arreglo es asociativo o FAÑSE en caso contrario
     */
    private function is_array_assoc($array = array())
    {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }

}


?>