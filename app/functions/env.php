<?php
if(!function_exists('env')) {
    function env(string $key, $default = '') : mixed {
        $arrayMerged = array_merge(getenv(), $_SERVER, $_ENV);

        $keys = array_keys($arrayMerged);
        $values = array_values($arrayMerged);

        $vars = array_unique(array_combine($keys, $values));

        return ($vars == false || !key_exists($key, $vars)) ? $default : $vars[$key];
    }
}
?>