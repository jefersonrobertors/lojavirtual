<?php

declare(strict_types=1);

namespace core\helpers;

use app\interfaces\FormRequestInterface;

use core\http\request\rules\Email;
use core\http\request\rules\NotEmpty;
use core\http\request\rules\Phone;

final class Validator {

    private array $errors = [], $rules = [];

    private array $fields = [
        'password' => 'senha'
    ];

    public static function create() : self {
        return new self;
    }

    public function allOf(string $field, array $rules) : void {
        foreach($rules as $rule) {
            if(isset($this->rules[$field])) {
                if($this->rules[$field] == $rule) {
                    continue;
                }
            }
            $this->rules[$field][] = $rule;
        }
    }

    public function notEmpty(string $field, string $template = '') : NotEmpty {
        $notEmpty = new NotEmpty();
        $notEmpty->setTemplate($template);
        return $this->rules[$field] = $notEmpty;
    }

    public function phone(string $field, string $template = '') : Phone {
        $phone = new Phone();
        $phone->setTemplate($template);
        return $this->rules[$field] = $phone;
    }

    public function email(string $field, string $template = '') : Email {
        $email = new Email();
        $email->setTemplate($template);
        return $this->rules[$field] = $email;
    }

    private function validate(string $value, string $field, FormRequestInterface $rule) : void {
        if(!$rule->validate($value)) {
            if(!isset($this->errors[$field])) {
                $alias = $this->fields[$field] ?? $field;
                $this->errors[$field] = str_replace('{{name}}', (strlen($alias) <= 3 ? strtoupper($alias) : ucfirst($alias)), $rule->getTemplate());
            }
        }
    }

    public function assert(array $data) : array {
        foreach($this->rules as $field => $rule) {
            if(!isset($data[$field])) {
                continue;
            }
            $value = $data[$field];

            if(is_array($rule)) {
                foreach($rule as $key) {
                   $this->validate($value, $field, $key);
                }
            }else{
                $this->validate($value, $field, $rule);
            }
        }
        return $this->errors;
    }
}
?>