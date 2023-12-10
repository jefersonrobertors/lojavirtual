<?php

use core\helpers\Server;

if(!function_exists('build_query_string')) {
    function build_query_string(string $key, string|int $value) : string {
        $server = Server::create();

        $url = env('BASE_URL');
        $query_string = $server->getQueryString();
        $path = $server->getCurrentPath();
    
        $params = [];

        if(!empty($query_string)) {
            foreach(explode('&', $query_string) as $param) {
                $param_key = substr($param, 0, strpos($param, '='));
                $param_value = urldecode(substr($param, strpos($param, '=') + 1));
                $params[$param_key] = urlencode($param_value);
            }
        }        
        if(isset($params[$key])) {
            unset($params[$key]);
        }
        $query = '';
        if(!empty($params)) {
            foreach($params as $param_key => $param_value) {
                $query .= $param_key .  '=' . $param_value . '&';
            }
        }
        return $url . $path . '?' . $query . $key . '=' . urlencode($value);
    }
}
?>