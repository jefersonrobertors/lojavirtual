<?php

namespace app\middlewares;

use app\interfaces\MiddlewareInterface;

use core\helpers\Request;
use core\helpers\Response;

class AuthMiddleware implements MiddlewareInterface {

    public function __invoke(Request $request, Response $response, \Closure $next) : mixed {
        if(auth()->isAuthenticated()) {
            return $response->redirect('/');
        }
        return $next($request, $response);
    }
}
?>