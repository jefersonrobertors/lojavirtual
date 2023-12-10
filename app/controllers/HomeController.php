<?php

declare(strict_types=1);

namespace app\controllers;

use core\helpers\Request;
use core\helpers\Response;

class HomeController extends AbstractController {

    public function index(Request $request, Response $response) : Response {
        return $response->sendStatus(200)->sendFile('home.php', ['title' => 'Home']);
    }
}
?>