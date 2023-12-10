<?php

use core\helpers\Redirect;

if(!function_exists('redirect')) {
    function redirect(string $to, $message = '', $type = 'info') : Redirect {
        if(substr($to, 0, 1) !== ROUTER_SEPARATOR) {
            $to = ROUTER_SEPARATOR . $to;
        }
        $navigate = new Redirect($to);
        
        if(!empty($message) && !empty($type)) {
            $navigate->redirect($to)->$type(substr($to, 1), $message);
        }
        $navigate->send();
        return $navigate;
    }
}
?>