<?php
if(!function_exists('base_path')) {
    function base_path() : string {
        return dirname(__FILE__, 3);
    }
}
?>