<?php

namespace app\middlewares;

use app\helpers\CSRF;

use app\interfaces\MiddlewareInterface;

use core\helpers\Request;
use core\helpers\Response;

class CSRFMiddleware implements MiddlewareInterface {

    public function __invoke(Request $request, Response $response, \Closure $next) : mixed {
        if(!CSRF::valid($request->input('_token'))) {
            return $response->sendStatus(403)->sendFile('403.php', ['message' => "Falha na verificação de CSRF. Requisição anulada. Você está vendo esta mensagem porque este site exige um token CSRF ao enviar formulários.
                Este token é necessário por motivos de segurança, para garantir que o seu navegador não seja invadido por terceiros."
            ]);
        }
        return $next($request, $response);
    }
}
?>