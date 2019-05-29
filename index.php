<?php
    ini_set('display_errors', 1);
    try{
        define('APP', 'app/');
        define('MODEL', 'app/model');

        if (file_exists('vendor/autoload.php'))
            require 'vendor/autoload.php';

        require 'Cracknd/Core.php';
        $cracknd = new Cracknd\Core();
        $files = ['config/config.php',
                    'config/class_alias.php',
                    APP . 'libs/Helper.php',
                    APP . 'core/Core.php',
                    APP . 'core/Controller.php',
                    APP . 'core/Database.php',
                    APP . 'core/View.php'];
        foreach ($files as $file){
            $cracknd->load_file($file);
        }

        spl_autoload_register(function ($class) {
            $file = MODEL . "/$class.php";
            if (file_exists($file))
                require_once $file;
        });

        $cracknd->enable_routes(true);

    } catch (Exception $ex){
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo $ex->getMessage();
    }