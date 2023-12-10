<?php

declare(strict_types=1);

namespace app\controllers;

use app\http\request\RegisterFormRequest;
use core\helpers\Request;
use core\helpers\Response;

class RegisterController extends AbstractController {

    public function index(Request $request, Response $response) : Response {
        return $response->sendStatus(200)->sendFile('register.php', ['title' => 'Inscrever-se']);
    }

    public function store(Request $request, Response $response) : Response {
        if(!RegisterFormRequest::validate($request)) {
            return $response->write('error');
        }
        return $response->write('stored');
    }
}
?>