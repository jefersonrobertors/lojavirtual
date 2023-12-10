<?php

declare(strict_types=1);

namespace app\http\request;

use core\helpers\Validator;

use core\http\request\FormRequest;

use core\http\request\rules\Email;
use core\http\request\rules\MinMax;
use core\http\request\rules\NotEmpty;

class LoginFormRequest extends FormRequest {

    public function handle() : bool {
        $validator = Validator::create();
        $validator->allOf('email', [
            new NotEmpty('Campo obrigatório!'),
            new Email('E-mail inválido!')
        ]);
        $validator->allOf('password', [
            new NotEmpty('Campo obrigatório!'),
            new MinMax(8, 20)
        ]);
        return $this->validated($validator);
    }
}
?>