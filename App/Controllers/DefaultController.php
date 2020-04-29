<?php
namespace Controllers;

use Cracknd\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DefaultController{
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface{
        return View::to_json($response, true, 'Hello world ;)');
    }

    public function request_demo(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface{
        $nombre = ($request->getMethod() === 'POST') ? $request->getParsedBody()['nombre'] : $request->getAttribute('nombre');
        return View::render($response, 'demo', compact('nombre'));
    }
}