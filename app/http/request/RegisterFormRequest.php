<?php

declare(strict_types=1);

namespace app\http\request;

use core\helpers\Validator;

use core\http\request\FormRequest;
use core\http\request\rules\CEP;
use core\http\request\rules\CPF;
use core\http\request\rules\Email;
use core\http\request\rules\MinMax;
use core\http\request\rules\NotEmpty;
use core\http\request\rules\State;

class RegisterFormRequest extends FormRequest {

    public function handle() : bool {
        $validator = Validator::create();

        $validator->notEmpty('fullName', 'Campo obrigatório!');
        $validator->notEmpty('suburb', 'Campo obrigatório!');
        $validator->notEmpty('city', 'Campo obrigatório!');
        $validator->notEmpty('house_number', 'Campo obrigatório!');

        $validator->allOf('email', [
            new NotEmpty('Campo obrigatório!'),
            new Email('E-mail inválido!')
        ]);
        $validator->allOf('cpf', [
            new NotEmpty('Campo obrigatório!'),
            new MinMax(14, 14),
            new CPF('CPF inválido!')
        ]);
        $validator->allOf('password', [
            new NotEmpty('Campo obrigatório!'),
            new MinMax(8, 20)
        ]);
        $validator->allOf('confirm-password', [
            new NotEmpty('Campo obrigatório!'),
            new MinMax(8, 20)
        ]);
        $validator->allOf('cep', [
            new NotEmpty('Campo obrigatório!'),
            new MinMax(9, 9),
            new CEP('CPF inválido!')
        ]);
        $validator->allOf('state', [
            new NotEmpty('Campo obrigatório!'),
            new MinMax(2, 2),
            new State('Estado inválido!')
        ]);      
        return $this->validated($validator);
    }
}
?>