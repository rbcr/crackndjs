<?php
    setlocale(LC_CTYPE, 'es_ES.utf8');
    date_default_timezone_set('America/Mexico_City');

    define('DEBUG', false);
    define('ENVIRONMENT', 'DEV');
    define('ROUTING_ENABLED', true);

    define('URL_PROTOCOL', 'http://');
    define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
    switch (ENVIRONMENT) {
        case 'LOCAL':
            define('URL_SUB_FOLDER', dirname($_SERVER['SCRIPT_NAME']));
            define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER . DIRECTORY_SEPARATOR);
            break;

        case 'DEV':
            define('URL_SUB_FOLDER', dirname($_SERVER['SCRIPT_NAME']));
            define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
            break;

        case 'PROD':
            define('URL_SUB_FOLDER', str_replace('/', '', dirname($_SERVER['SCRIPT_NAME'])));
            define('URL', URL_PROTOCOL . URL_DOMAIN . DIRECTORY_SEPARATOR . URL_SUB_FOLDER);
            break;
    }

    define('ASSET_DIRECTORY', URL . 'public/');

    define('RACKSPACE_UPLOAD_ENABLED', false);
    define('RACKSPACE_USER', '');
    define('RACKSPACE_KEY', '');
    define('RACKSPACE_REGION', '');
    define('RACKSPACE_CONTAINER', '');
    define('RACKSPACE_FOLDER', '');
    define('RACKSPACE_CDN', '');

    define('TINIFY_ENABLE_OPTIMIZATION', false);
    define('TINIFY_API_KEY', '');

    define('SENDGRID_ENABLED', false);
    define('SENDGRID_DEBUG', false);
    define('SENDIGRD_DEBUG_EMAILS', []);
    define('SENDGRID_FROM_EMAIL', '');
    define('SENDGRID_FROM_NAME', '');
    define('SENDGRID_API_KEY', '');

    define('DATABASE_ENABLED', true);
    define('MULTIPLE_DATABASES', false);

    if(DATABASE_ENABLED){
        $connections = [];
        switch (ENVIRONMENT) {
            case 'LOCAL':
            case 'DEV':
                $connections[] = [
                    'name' => 'default',
                    'type' => 'mysql',
                    'host' => 'localhost',
                    'user' => 'root',
                    'password' => 'toor',
                    'db' => 'db_cracknd',
                    'prefix' => null,
                    'dsn' => null
                ];
                break;

            case 'PROD':
                $connections[] = [
                    'name' => 'default',
                    'type' => 'mysql',
                    'host' => 'localhost',
                    'user' => 'user',
                    'password' => 'toor',
                    'db' => 'db_cracknd',
                    'prefix' => null,
                    'dsn' => null
                ];
                break;

            default:
                $connections[] = [
                    'name' => 'default',
                    'type' => 'mysql',
                    'host' => 'localhost',
                    'user' => 'user',
                    'password' => 'toor',
                    'db' => 'db_cracknd',
                    'prefix' => null,
                    'dsn' => null
                ];
                break;
        }
    }

    if(DEBUG){
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }