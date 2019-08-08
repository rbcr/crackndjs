<?php
    try{
        define('URL_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

        if (file_exists('../vendor/autoload.php'))
            require_once '../vendor/autoload.php';

        if (!file_exists('../config/config.php'))
            throw new Exception("Configuration file not found.");

        $Cracknd = new \Cracknd\App();
        echo $Cracknd->init();
    } catch (\Exception $ex){
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo $ex->getMessage() . "\n\n";
    }