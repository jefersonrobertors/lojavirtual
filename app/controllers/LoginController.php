<?php

declare(strict_types=1);

namespace app\controllers;

use app\http\request\LoginFormRequest;

use core\helpers\Request;
use core\helpers\Response;

use core\services\oauth2\Driver;

class LoginController extends AbstractController {

    public function index(Request $request, Response $response) : Response {
        return $response->sendStatus(200)->sendFile('login.php', ['title' => 'Entrar']);
    }

    public function doLogin(Request $request, Response $response) : Response {
        if(!LoginFormRequest::validate($request)) {
            return $response->redirect('/login');
        }
        return $response->redirect('/');
    }

    public function doLoginWith(Request $request, Response $response) : Response { 
        $provider = Driver::create()->getDriver($request->getParameter('driver'));
        
        if($provider === null || !$provider->isAuthorized($request)) {
            return $response;
        }
        echo '<pre>';
        var_dump($provider->getEmail());
        echo '</pre>';
        return $response;
    }
}
?>