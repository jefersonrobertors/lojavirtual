<?php

declare(strict_types=1);

namespace app\routes;

use core\helpers\Request;
use core\helpers\Response;

final class Dispatcher {

    public static function dispatch(Request $request, Response $response, array $handle) : void {
        [$controller, $action] = $handle;

        $controlllerNamespace = "app\\controllers\\{$controller}";

        if(!class_exists($controlllerNamespace)) {
            throw new \RuntimeException("Class $controller does not exist.");          
        }

        if(!method_exists($controlllerNamespace, $action)) {
            throw new \RuntimeException("Method $action not found in $controller");      
        }
        $controllerInstance = new $controlllerNamespace();

        $response = call_user_func_array([$controllerInstance, $action], [$request, $response]);

        if(!$response || !$response instanceof Response) {
            throw new \RuntimeException("Response not found in $controller, method $action");
        }
        $response->send();
    }
}
?>