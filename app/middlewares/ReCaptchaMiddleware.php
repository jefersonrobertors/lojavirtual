<?php

namespace app\middlewares;

use app\interfaces\MiddlewareInterface;

use core\helpers\Request;
use core\helpers\Response;

use ReCaptcha\ReCaptcha;

class ReCaptchaMiddleware implements MiddlewareInterface {

    public function __invoke(Request $request, Response $response, \Closure $next) : mixed {
        $recaptcha = new ReCaptcha(env('GOOGLE_RECAPTCHA_SECRET_KEY'));
        $result = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($request->post->get('g-recaptcha-response'));

        if(!$result->isSuccess()) {
            return $response->sendStatus(403)->sendFile('403.php', ['message' => "Desculpe, houve uma falha na verificação do reCAPTCHA. A sua requisição foi cancelada. 
                Esta mensagem é exibida porque este site requer um token reCAPTCHA ao enviar formulários. Essa medida de segurança é necessária para proteger o seu navegador contra invasões de terceiros e garantir a segurança dos seus dados."
            ]);
        }
        return $next($request, $response);
    }
}
?>