<?php

use app\helpers\Flash;

if(!function_exists('flash')) {
    function flash(string $name) : string {
        return Flash::get($name);
    }
}
?>