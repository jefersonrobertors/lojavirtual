<?php

declare(strict_types=1);

namespace core\http\request;

use core\helpers\Request;
use core\helpers\Validator;

abstract class FormRequest {

    protected Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public static function validate(Request $request) : bool {
        return (new static($request))->handle();
    }

    protected function validated(Validator $validator) : bool {
        $errors = $validator->assert($this->request->post->all());

        if(!empty($errors)) {
            $session = session();
            $flashData = isset($session->flash) ? $session->flash : [];

            foreach($errors as $name => $template) {
                if(isset($flashData[$name])) {
                    unset($flashData[$name]);
                }
                $flashData[$name] = $template;
            }
            $session->flash = $flashData;
        }
        return count($errors) == 0;
    }

    abstract public function handle() : bool;
}
?>