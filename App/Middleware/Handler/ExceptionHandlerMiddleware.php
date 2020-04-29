<?php
namespace Middleware\Handler;

use Cracknd\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;
use WoohooLabs\Harmony\Exception\MethodNotAllowed;
use WoohooLabs\Harmony\Exception\RouteNotFound;

final class ExceptionHandlerMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseInterface
     */
    private $errorResponsePrototype;

    public function __construct(ResponseInterface $errorResponsePrototype)
    {
        $this->errorResponsePrototype = $errorResponsePrototype;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (RouteNotFound $exception) {
            return $this->handleNotFound();
        } catch (MethodNotAllowed $exception) {
            return $this->handleNotAllowed();
        } catch (Throwable $exception) {
            return $this->handleThrowable($exception);
        }
    }

    private function handleNotFound(): ResponseInterface
    {
        $response = $this->errorResponsePrototype->withStatus(404);
        return View::render($response, '404');
    }

    private function handleThrowable(Throwable $exception): ResponseInterface
    {
        $response = $this->errorResponsePrototype->withStatus(500);
        return View::render($response, '500', ['message' => $exception->getCode() . ' - ' . $exception->getMessage()]);
    }

    private function handleNotAllowed(): ResponseInterface
    {
        $response = $this->errorResponsePrototype->withStatus(500);
        return View::to_json($response, false, 'Method not allowed');
    }
}