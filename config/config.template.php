<?php
	/**
	 * Configuración de idioma y zona horaria
	 */
	setlocale(LC_CTYPE, 'es');
	date_default_timezone_set('America/Mexico_City');
	/**
	 * Activar modo de depuración
	 */
	define('DEBUG', false);
	/**
	 * Definición del entorno de desarrollo
	 */
	define('ENVIROMENT', 'LOCAL');
	/**
	 * Detección del host y de la URL Absoluta del proyecto
	 */
	define('URL_PROTOCOL', 'http://');
	define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
    switch (ENVIROMENT) {
        case 'LOCAL':
            define('URL_SUB_FOLDER', dirname($_SERVER['SCRIPT_NAME']));
            define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER . DIRECTORY_SEPARATOR);
            define('URL_ROOT', $_SERVER['DOCUMENT_ROOT'] . URL_SUB_FOLDER . DIRECTORY_SEPARATOR);
            break;
        
        case 'DEV':
            define('URL_SUB_FOLDER', dirname($_SERVER['SCRIPT_NAME']));
            define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
            define('URL_ROOT', $_SERVER['DOCUMENT_ROOT'] . URL_SUB_FOLDER);
            break;

        case 'PROD':
            define('URL_SUB_FOLDER', str_replace('/', '', dirname($_SERVER['SCRIPT_NAME'])));
            define('URL', URL_PROTOCOL . URL_DOMAIN . DIRECTORY_SEPARATOR . URL_SUB_FOLDER);
            define('URL_ROOT', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . URL_SUB_FOLDER);
            break;

        default:
            define('URL_SUB_FOLDER', str_replace('//', '/', dirname($_SERVER['SCRIPT_NAME'])));
            define('URL', URL_PROTOCOL . URL_DOMAIN . DIRECTORY_SEPARATOR . URL_SUB_FOLDER . DIRECTORY_SEPARATOR);
            define('URL_ROOT', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . URL_SUB_FOLDER . DIRECTORY_SEPARATOR);
            break;
    }
    /**
	 * Definición de los directorios de archivos, imágenes y asstets.
	 */
    define('ASSET_DIRECTORY', URL.'public/');
    define('APP_MAILS_PATH', URL.'app/mail/');
	/**
	 * Para el caso de estos directorios deben tener activado los permisos de escritura
	 */
	define('IMG_DIRECTORY', URL.'public/img/');
    define('FILES_PATH', URL_ROOT.'app/files/');
    define('FILES_DIRECTORY', URL.'app/files/');
	/**
	 * Definición de la API KEY de Google Maps
	 */
	//define('GOOGLE_MAPS_API_KEY', '');

	/**
	 * Usuario y contraseña de Sendgrid para el envío de correos.
	 * Para esta funcionalidad debe estar definido el paquete Sendgrid (sendgrid/sendgrid-php)
	 * en el archivo composer.json
	 */
    define('SENDGRID_USER', '');
    define('SENDGRID_PASS', '');

	/**
	 * Configuraciones del API de Rackspace, se debe definir Usuario, API KEY, región del contenedor, nombre
	 * y en el caso de ser CDN la URL del mismo.
	 *
	 *Para utilizar esta funcionalidad debe estar definido el paquete PHP Opencloud (rackspace/php-opencloud)
	 * en el archivo composer.json
	 */
    define('RACKSPACE_UPLOAD_ENABLED', false);
    define('RACKSPACE_USER', '');
    define('RACKSPACE_KEY', '');
    define('RACKSPACE_REGION', '');
    define('RACKSPACE_CONTAINER', '');
    define('RACKSPACE_CDN', '');

	/**
	 * Definición de Tinify API KEY para la optimización de imágenes
	 *
	 * Para utilizar esta funcionalidad debe estar definido el paquete Tinify (tinify/tinify)
	 * en el archivo composer.json
	 */
	//define('TINIFY_API_KEY', '');

	/**
	 * Definición del HOST, usuario, contraseña y base de datos para los entornos de desarrollo y producción
	 *
	 * En esta función se utiliza Eloquent en la v5.1 como ORM (illuminate/database) y esta definido por defecto en el archivo composer.json
	 */
	switch (ENVIROMENT) {
	    case 'LOCAL':
        case 'DEV':
				define('DB_TYPE', 'mysql');
				define('DB_HOST', 'localhost');
				define('DB_USER', 'root');
				define('DB_PASS', 'toor');
				define('DB_NAME', '');
			break;

		case 'PROD':
				define('DB_TYPE', 'mysql');
				define('DB_HOST', '');
			    define('DB_USER', '');
			    define('DB_PASS', '');
			    define('DB_NAME', '');
			break;
		
		default:
				define('DB_TYPE', 'mysql');
				define('DB_HOST', 'localhost');
				define('DB_NAME', 'testing');
				define('DB_USER', 'root');
				define('DB_PASS', 'toor');
			break;
	}

	/**
	 * Comentarios adicionales: Se encuentra integrado por defecto el paquete Sentry para la gestión de usuarios y permisos,
	 * definiendo grupos y nivel de acceso a las funciones del sistema.
	 *
	 * Se encuentra definido en el archivo composer.json (cartalyst/sentry) además del paquete password-compat (ircmaxell/password-compat)
	 * En los entornos con versión de PHP 5.3 y 5.4, actualmente ya no es necesario para la versión 5.6 en Cloud Sites
	 */
	/* DEBUG SETTINGS */
	if(DEBUG){
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
	}