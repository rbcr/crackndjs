<?php
namespace Cracknd;

class Images {
    public static function optimize_image_tinify($origen){
        if(TINIFY_ENABLE_OPTIMIZATION){
            \Tinify\Tinify::setKey(TINIFY_API_KEY);
            \Tinify\fromFile($origen)->toFile($origen);
            return true;
        } else
            return false;
    }
}