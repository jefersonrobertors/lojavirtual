<?php

declare(strict_types=1);

namespace core\http\request\rules;

use app\interfaces\FormRequestInterface;

final class CPF implements FormRequestInterface {

    private string $template = '';

    public function __construct(string $template = '') {
        $this->setTemplate($template);
    }

    public function getTemplate() : string {
        return $this->template;
    }

    public function setTemplate(string $template) : void {
        $this->template = $template;
    }

    public function validate(string $value) : bool {
        $value = preg_replace('/[^0-9]/', '', $value);

        if(strlen($value) !== 11) {
            return false;
        }
        if(preg_match('/(\d)\1{10}/', $value)) {
            return false;
        }
        $sum = 0;

        for($i = 0; $i < 9; $i++) {
            $sum += ($value[$i] * (10 - $i));
        }
        $remainder = $sum % 11;
        $digit = ($remainder < 2) ? 0 : (11 - $remainder);

        if($value[9] != $digit) {
            return false;
        }
        $sum = 0;

        for($i = 0; $i < 10; $i++) {
            $sum += ($value[$i] * (11 - $i));
        }
        $remainder = $sum % 11;
        $digit = ($remainder < 2) ? 0 : (11 - $remainder);

        if($value[10] != $digit) {
            return false;
        }
        return true;
    }
}
?>