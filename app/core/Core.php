<?php
    function url($direccion = null){
        return URL.$direccion;
    }

    function asset($asset){
        echo ASSET_DIRECTORY.$asset;
    }

    function redirect($url){
        header('location:'.URL.$url);
    }

    function get_img($image){
        echo IMG_DIRECTORY.$image;
    }

    function get_img_url($image){
        return IMG_DIRECTORY.$image;
    }

    function get_file($filename){
        return FILES_DIRECTORY.$filename;
    }