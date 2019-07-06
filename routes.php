<?php
    $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/deploy/init', 'DeployController@init');
        $r->addRoute('GET', '/deploy', 'DeployController@index');
        $r->addRoute('GET', '/sample/cache', 'SampleController@cache');
        $r->addRoute('GET', '/', 'DefaultController@index');
    });