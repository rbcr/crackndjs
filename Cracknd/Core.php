<?php
namespace Cracknd;

class Core{
    public function __construct(){
        spl_autoload_register(function ($class) {
            $class = str_replace('\\', '/', $class . '.php');
            if (file_exists($class))
                require_once $class;
        });
    }

    public function load_file($file){
        try{
            if(file_exists($file)){
                require_once $file;
                return true;
            } else
                return false;
        } catch (\Exception $exception){
            return false;
        }
    }

    public function enable_routes($enabled = true){
        try{
            require 'routes.php';
        } catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }
}