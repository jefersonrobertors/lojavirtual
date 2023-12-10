<?php

namespace app\interfaces;

use core\helpers\Request;
use core\helpers\Response;

interface MiddlewareInterface {

    public function __invoke(Request $request, Response $response, \Closure $next) : mixed;
}
?>