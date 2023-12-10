<?php

declare(strict_types=1);

namespace app\controllers;

use app\database\repositories\PasswordRecoveryRepository;
use app\helpers\Random;
use app\http\request\PasswordRecoveryFormRequest;

use core\helpers\Request;
use core\helpers\Response;

class PasswordRecoveryController extends AbstractController {

    public function index(Request $request, Response $response) : Response {
        $code = $request->getParameter('code');
        $entity = PasswordRecoveryRepository::create()->fetchByField('token', $code);

        if($entity === null) {
            return $response->sendStatus(404)->sendFile('404.php');
        }
        return $response->sendStatus(200)->sendFile('password.php', ['title' => 'Redefinir senha', 'code' => $code]);
    }

    public function update(Request $request, Response $response) : Response {
        return $response;
    }

    public function sendCode(Request $request, Response $response) : Response {
        if(!PasswordRecoveryFormRequest::validate($request)) {
            return $response->redirect('/login');
        }
        $email = $request->getParameter('email-pwd');
        $token = Random::generateToken($email);

        PasswordRecoveryRepository::create()->insert([
            'token' => $token,
            'email' => $email,
        ]);      
        $route = route("password/recovery/$token");

        if(!sendmail($email, 'no-reply', $route)) {
            return $response;
        }
        return $response->redirect('/login');
    }
}
?>