<?php
if(!function_exists('route')) {
    function route(string $route) : string {
        $base = env('BASE_URL');
        
        if(substr($route, 0, 1) == ROUTER_SEPARATOR) {
            $route = substr($route, 1);
        }
        if(substr($base, strlen($base) - 1) == ROUTER_SEPARATOR) {
            $base = substr($base, 0, strlen($base) - 1);
        }
        return $base . ROUTER_SEPARATOR . $route;
    }
}
?>