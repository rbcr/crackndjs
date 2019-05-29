<?php
namespace Cracknd;

class Utils{
    public static function debug($enabled = true){
        if($enabled){
            ini_set('display_errors', 1);
            return true;
        } else {
            ini_set('display_errors', 0);
            return false;
        }
    }
}