<?php
namespace Cracknd;

class Core{
    public function __construct(){
        spl_autoload_register(function ($class) {
            $class = str_replace('\\', '/', $class . '.php');
            if (file_exists(root_path($class)))
                require_once root_path($class);
        });
    }

    public function load_file($file){
        try{
            if(file_exists(root_path($file))){
                require_once root_path($file);
                return true;
            } else
                return false;
        } catch (\Exception $exception){
            return false;
        }
    }

    public function enable_routes($enabled = true){
        try{
            require_once root_path('routes.php');
        } catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }
}