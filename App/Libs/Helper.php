<?php
class Helper{
    public static function clean($str){
        return htmlentities(strip_tags($str), ENT_QUOTES);
    }

    public static function executeCURL($url, $campos){
        foreach($campos as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($campos));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta = curl_exec($ch);
        curl_close($ch);
        return $respuesta;
    }
}