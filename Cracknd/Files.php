<?php
namespace Cracknd;

class Files{
    public static function root_path($path){
        return URL_ROOT . $path;
    }

    public static function copy_file($source_file, $destiny_directory = null, $rename = false, $absolute_name = true, $custom_directory = false){
        try{
            $root_directory = URL_ROOT . 'app/files';
            $source_info = pathinfo($source_file);
            if($rename){
                $destiny_directory .= "/$rename." . $source_info['extension'];
            } else
                $destiny_directory .= $source_info['basename'];
            copy("$root_directory/$source_file", "$root_directory/$destiny_directory");
            return ($absolute_name) ? "$root_directory/$destiny_directory" : $destiny_directory;
        } catch (\Exception $exception){
            echo "<strong>Error: </strong> " . $exception->getMessage();
            return false;
        }
    }
}