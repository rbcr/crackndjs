<?php
    $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/', 'DefaultController@index');
        $r->addRoute('GET', '/example/', 'DefaultController@index');
        $r->addRoute('GET', '/deploy/init', 'DeployController@init');
    });