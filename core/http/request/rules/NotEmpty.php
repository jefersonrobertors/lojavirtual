<?php

declare(strict_types=1);

namespace core\http\request\rules;

use app\interfaces\FormRequestInterface;

class NotEmpty implements FormRequestInterface {

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
        return !empty($value);
    }
}
?>