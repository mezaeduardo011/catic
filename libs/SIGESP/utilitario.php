<?php
include_once '/var/www/catic/libs/SIGESP/mppi-curl-php/src/MPPICurl/MPPICurlCabeceras.php';
include_once '/var/www/catic/libs/SIGESP/mppi-curl-php/src/MPPICurl/MPPICurlMensajes.php';
include_once '/var/www/catic/libs/SIGESP/mppi-curl-php/src/MPPICurl/MPPICurlRespuesta.php';
include_once '/var/www/catic/libs/SIGESP/mppi-curl-php/src/MPPICurl/MPPICurl.php';
include_once '/var/www/catic/libs/SIGESP/mppi-curl-php/src/MPPICurl/MPPICurlCliente.php';
/**
 * Esta clase permite listar y verificar la existecia de un modulo dentro de la aplicación frontend.
 */
 class ModulosApp
{
    /** 
     * Metodo que permite listar los modulos registrados dentro de la aplicación frontend.
     * 
     * @return array
     */
    private static function dirToArray()
    {
        $result = array();
        
        $dir = realpath(dirname(__FILE__).'/../apps/frontend/modules');

        $cdir = scandir($dir);
        
        foreach ($cdir as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                {
                    $result[] = $value;
                }
            }
        }
        return $result;
    }
    
    /**
     * Permite verificar si un modulo existe dentro de la aplicación frontend.
     * 
     * @param string $name Cadena de texto con el nombre del modulo a verificar.
     * @return boolean Devuelve TRUE si el modulo existe o FALSE en caso contrario.
     */
    public static function modulo_exits($name)
    {
        return !!in_array($name,self::dirToArray());
    }
}

class ClienteApiSigesp
{
    /**
     *Nombre de usuario dentro del APISIGESP
     * @var string
     */
    private $username;
    
    /**
     * Clave dentro del APISIGESP
     * @var string
     */
    private $password;
    
    /**
     * Protocolo para consumir los servicios del APISIGESP
     * @var string
     */
    private $protocolo;
    
    /**
     * Hostname para el consumo de los servicios del APISIGESP
     * @var string
     */
    private $hostname;
    
    /**
     * Lista de rutas disponibles para el comsumo de los servicios del APISIGESP
     * @var array
     */
    private $paths;
    
    /**
     * Objeto para el uso de cURL
     * @var \MPPICurl\MPPICurlCliente 
     */
    private $curl;

    function __construct()
    {
        $this->username = 'catic';
        $this->password = 'e5b1942042f7c8dd80a3d757bd6eaa8a693cad4b0375926a7909c92b';
        $this->protocolo = 'http';
        $this->hostname = 'pruebaapisigesp.mppi.gob.ve';
        $this->paths = array('datos_empleado' => 'GET /api/1.0/ficha-personal/<cedula>');
        $this->curl = new \MPPICurl\MPPICurlCliente();
        $this->curl->definirBasicAuthentication($this->username, $this->password);
    }
    
    public function getServicio($name,$param = array())
    {
        $response = False;

        if(!!isset($this->paths[$name]))
        {        
        
            list($metodo,$url) = $this->parse_url($name, $param);
        
             $response = call_user_func(
                array($this->curl,$metodo),
                $url,
                $metodo=='GET'?array():$param,
                function($rsp){return $rsp;},
                function($rsp){return $rsp;}
            );
        }
        
        return $response;
    }
    
    private function parse_url($name,$param)
    {
        list($metodo, $serv) = explode(' ',$this->paths[$name]);
            
        foreach ($param as $key => $value)
        {
            $serv = preg_replace("/<$key>/", $value, $serv);
        }
        $serv = explode("<", $serv);

        $serv = substr($serv[0],-1)=="/"?substr($serv[0],0,-1):$serv[0];
            
        return array(strtoupper($metodo),sprintf("%s://%s%s",$this->protocolo, $this->hostname, $serv));
    }
}
