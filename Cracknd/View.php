<?php
namespace Cracknd;

use Psr\Http\Message\ResponseInterface;

class View{
    public static function render(ResponseInterface $response, $template, $data = [], $debug = false) : ResponseInterface {
        $templatePathname = root_path("App/Views/$template.php");
        if (!is_file($templatePathname)) {
            echo "View cannot render `$template` because the template does not exist";
        }
        extract($data);
        ob_start();
        if($debug)
            var_dump($data);
        include $templatePathname;
        $renderedView = ob_get_clean();
        $response->getBody()->write($renderedView);
        return $response;
    }

    public static function to_json(ResponseInterface $response, $status, $message = null, $data = []) : ResponseInterface {
        $responseArray = ['status' => $status, 'code' => $response->getStatusCode(), 'message' => $message, 'data' => $data];
        $response->getBody()->write(json_encode($responseArray));
        return $response;
    }
}