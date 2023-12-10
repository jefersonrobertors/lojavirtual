<?php

use app\helpers\Session;

if(!function_exists('session')) {
    function session() : Session {
        $session = $GLOBALS['session'] ?? null;
                
        if(!$session instanceof Session) {
            $session = Session::create();
        }
        return $session;
    }
}
?>