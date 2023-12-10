<?php

declare(strict_types=1);

namespace app\http\request;

use core\helpers\Validator;

use core\http\request\FormRequest;

use core\http\request\rules\Email;
use core\http\request\rules\NotEmpty;

class PasswordRecoveryFormRequest extends FormRequest {

    public function handle() : bool {
        $validator = Validator::create();
        $validator->allOf('email-fp', [
            new NotEmpty('Campo email não pode ser vazio!'),
            new Email('Campo email inválido!'),
        ]);
        return $this->validated($validator);
    } 
}
?>