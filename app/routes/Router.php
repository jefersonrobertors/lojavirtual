<?php

declare(strict_types=1);

namespace app\routes;

use core\helpers\Request;
use core\helpers\Response;

use core\http\middleware\MiddlewareQueue;

final class Router {

    /** @var Request $request */
    private readonly Request $request;

    /** @var Response $response */
    private readonly Response $response;

    /** @var array $routes */
    private array $routes;

    /** @var string $uri */
    private readonly string $uri;

    /** @var string $method */
    private readonly string $method;

    private readonly MiddlewareQueue $middlewareQueue;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
        $this->middlewareQueue = MiddlewareQueue::create();
        $this->method = $this->request->getServer()->getCurrentHttpMethod();
        $this->uri = $this->request->getServer()->getCurrentPath();
    }

    /**
     * @param string $httpMethod
     * @param string $pattern
     * @param array $handle
     */
    public function addRoute(string $httpMethod, string $pattern, array $handle, array $middlewares = []) : void {
        $route = new Route($httpMethod, $pattern, $handle);

        if(!empty($middlewares)) {    
            foreach($middlewares as $middleware) {
                $route->addMiddleware($middleware);
            }
        }
        $this->routes[] = $route;
    }

    public function run() : bool {
        $routes = array_filter($this->routes, function (Route $route) : bool {
            return $route->getHttpMethod() === $this->method;
        });
        foreach($routes as $route) {
            if($route instanceof Route) {
                $paramsClass = new Params($route->getPattern());
                $params = $paramsClass->getPathParams();
                $known = $paramsClass->getDiffPathKnown();
                $given = $paramsClass->getDiffPathGiven();

                $match = $route->getPattern() === $this->uri;
 
                if($match == false && count($params) == count($known)) {
                    $count = 0;
                    foreach($known as $key => $value) {
                        $pattern = explode(':', $value);
                        if(!isset($given[$key], $pattern[1])) {
                            continue;
                        }
                        if(preg_match("/^" . $pattern[1] . "$/iu", $given[$key])) {
                            $count++;
                        }
                    }
                    $match = count($given) === $count;
                }
                if($match) {
                    $this->middlewareQueue->setHandle($route->getHandle());
                    $this->middlewareQueue->setMiddlewares($route->getMiddlewares());
                    $this->request->setParams($paramsClass->getParams());
                    try {
                        $this->middlewareQueue->next($this->request, $this->response);
                    }catch(\Exception $e) {
                        echo $e->getMessage();
                    }
                    return true;
                }
            }
        }      
        $this->response->sendStatus(404)->sendFile('404.php')->send();
        return false;
    }
}
?>