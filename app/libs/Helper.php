<?php
class Helper{
    public static function clean($str){
        return htmlentities(strip_tags($str), ENT_QUOTES);
    }

    public static function to_slug($str){
        $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', ' ' => '-'
        );
        $text2url = strtolower(strtr($str, $table));
        $text2url = preg_replace('#[^0-9a-z\/^.]+#i', " ", $text2url);
        $text2url = str_replace(' ','-',trim($text2url));
        return $text2url;
    }
    
    public static function renderHTMLtoRichtext($descripcion){
        $contenido_html = str_replace('</p>', '</p><br>', $descripcion);
        $contenido_html = str_replace('strong', 'b', $contenido_html);
        $wizard = new PHPExcel_Helper_HTML;
        $richText = $wizard->toRichTextObject(mb_convert_encoding(html_entity_decode($contenido_html), 'HTML-ENTITIES', 'UTF-8'));
        return $richText;
    }
}