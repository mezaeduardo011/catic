<?php
// define — Define una constante con nombre.
// Se utiliza para crear una constante
// la cual es global, para luego ser utilizada en cualquier parte de la aplicacion.
//Por esto es que mas adelante se notara la utilizacion de la constante BASE_URL.

	define('DEFAULT_CONTROLLER', 'index');
	define('DEFAULT_METHOD', 'index');
	
	define('BASE_URL', 'http://localhost/catic/');
	define('PUBLIC_URL', BASE_URL . 'public/');
	define('CSS_PATH', PUBLIC_URL. 'css'.DS);
	define('JS_PATH', PUBLIC_URL.'js'.DS);
	define('FONTS_PATH', PUBLIC_URL.'fonts'.DS);
	define('IMG_PATH', PUBLIC_URL.'img'.DS);
	define('UPLOAD_IMG_PATH', PUBLIC_URL.'img'.DS.'partners'.DS);
	define('SIZE_PAPER', 'LEGAL');
	define('SHEET_ORIENTATION', 'P');
	define('LANGUAJE_PDF', 'en');
	define('CHARSET_PDF', 'utf-8');
	define('APP_NAME', 'nombre de la app');
	define('APP_LOGO', '');
	define('APP_OTHER', '');
	define('SESSION_TIME', 20);	
	define("DB_HOST", "localhost"); 
	define("DB_USER", "postgres"); 
	define("DB_PASS", "123456");
	define("DB_NAME", "tesis");
