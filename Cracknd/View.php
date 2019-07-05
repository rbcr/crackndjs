<?php
namespace Cracknd;

class View{
    public static function render($template, $data = []) {
        $templatePathname = root_path("App/Views/$template.php");
        if (!is_file($templatePathname)) {
            echo "View cannot render `$template` because the template does not exist";
        }
        extract($data);
        ob_start();
        include $templatePathname;
        $renderedView = ob_get_clean();
        return $renderedView;
    }
}