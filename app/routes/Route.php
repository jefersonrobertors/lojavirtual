<?php

declare(strict_types=1);

namespace app\routes;

final class Route {

    private array $middlewares = [];

    public function __construct(private readonly string $httpMethod, private readonly string $pattern, private readonly string|array $handle) { }

    public function getHttpMethod() : string {
        return $this->httpMethod;
    }

    public function getPattern() : string {
        return $this->pattern;
    }

    public function getHandle() : string|array {
        return $this->handle;
    }

    public function addMiddleware(string $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function hasMiddleware() : bool {
        return !empty($this->middlewares);
    }

    public function getMiddlewares() : array {
        return $this->middlewares;
    }
}
?>