<?php
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use WoohooLabs\Harmony\Harmony;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;
use WoohooLabs\Harmony\Middleware\FastRouteMiddleware;
use WoohooLabs\Harmony\Middleware\HttpHandlerRunnerMiddleware;

    $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/demo/{nombre}', [\Controllers\DefaultController::class, 'request_demo']);
        $r->addRoute('POST', '/demo', [\Controllers\DefaultController::class, 'request_demo']);

        $r->addRoute('GET', '/deploy/init', [\Controllers\DeployController::class, 'init']);
        $r->addRoute('GET', '/', [\Controllers\DefaultController::class, 'index']);
    });

$harmony = new Harmony(ServerRequestFactory::fromGlobals(), new Response());
$harmony->addMiddleware(new HttpHandlerRunnerMiddleware(new SapiEmitter()))
    ->addMiddleware(new \Middleware\Handler\ExceptionHandlerMiddleware(new Response()))
    ->addMiddleware(new FastRouteMiddleware($dispatcher))
    ->addMiddleware(new DispatcherMiddleware())
    ->run();