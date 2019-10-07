<?php
namespace Cracknd;

use FastRoute\Dispatcher;

class Routes{
    private $dispatcher;

    public function __construct(){
        require_once root_path('routes.php');
        $this->dispatcher = $dispatcher;
    }

    public function init(){
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);
        $routeInfo = $this->dispatcher->dispatch($httpMethod, (ENVIRONMENT === 'LOCAL') ? str_replace(URL_SUB_FOLDER, '', $uri) : $uri);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                $response = View::render('404');
                break;

            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $response = 'no allowed';
                break;

            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                list($class, $method) = explode("@", $handler, 2);
                $class = "App\\Controllers\\$class";
                $response = call_user_func_array(array(new $class, $method), $vars);
                break;
        }

        return $response;
    }
}
