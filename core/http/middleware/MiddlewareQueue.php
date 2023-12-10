<?php

declare(strict_types=1);

namespace core\http\middleware;

use app\middlewares\AuthMiddleware;
use app\middlewares\CSRFMiddleware;
use app\middlewares\ReCaptchaMiddleware;
use app\routes\Dispatcher;

use core\helpers\Request;
use core\helpers\Response;

final class MiddlewareQueue {

    /** @var array $middlewares */
    private array $middlewares = [];

    /** @var array $handle */
    private readonly array $handle;

    /** @var array $middlewareAliases */
    private array $middlewareAliases = [
        'auth' => AuthMiddleware::class,
        'csrf' => CSRFMiddleware::class,
        'recaptcha' => ReCaptchaMiddleware::class
    ];

    public static function create() : self {
        return new self;
    }

    public function setMiddlewares(array $middlewares) : self {
        $this->middlewares = $middlewares;
        return $this;
    }

    public function setHandle(array $handle) : self {
        $this->handle = $handle;
        return $this;
    }

    public function next(Request $request, Response $response) : mixed {
        if(empty($this->middlewares)) {
            return Dispatcher::dispatch($request, $response, $this->handle);
        }
        $middleware = array_shift($this->middlewares);

        if(!isset($this->middlewareAliases[$middleware])) {
            throw new \RuntimeException("Unable to execute middleware {$middleware}");
        }
        $middleware = new $this->middlewareAliases[$middleware];
        $queue = $this;
        $responseQueue = $middleware($request, $response, function (Request $request, Response $response) use ($queue) : mixed {
            return $queue->next($request, $response);
        });
        if($responseQueue instanceof Response) $responseQueue->send();
        return true;
    }
}
?>