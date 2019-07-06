<?php
    function url($direccion = null){
        return URL . $direccion;
    }

    function asset($asset){
        return ASSET_DIRECTORY . $asset;
    }

    function redirect($url){
        header('location:' . URL . $url);
    }

    function root_path($file){
        return URL_ROOT . $file;
    }

    function storage_path($file = null){
        return URL_ROOT . "storage/$file";
    }