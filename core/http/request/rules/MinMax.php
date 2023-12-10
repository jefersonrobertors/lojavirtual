<?php

namespace core\http\request\rules;

use app\interfaces\FormRequestInterface;

final class MinMax implements FormRequestInterface {

    private string $template = '';

    public function __construct(private ?int $min = null, private ?int $max = null) { }

    public function getTemplate() : string {
        return $this->template;
    }

    public function setTemplate(string $template) : void {
        $this->template = $template;
    }

    public function validate(string $value) : bool {
        if($this->min == null && $this->max == null) return true;        
        if($this->min === $this->max) {
            $value = strlen($value) == $this->min;
            $template = $value ? "" : "{{name}} precisa ter exatamente {$this->max} caracteres!";
        }else if($this->min !== null && $this->max == null) {
            $value = strlen($value) >= $this->min;
            $template = $value ? "" : "{{name}} precisa ter pelo menos {$this->min} caracteres!";
        }else if($this->min == null && $this->max !== null) {
            $value = strlen($value) <= $this->max;
            $template = $value ? "" : "{{name}} precisa ter no máximo {$this->max} caracteres!";
        }else{
            $value = strlen($value) >= $this->min && strlen($value) <= $this->max;
            $template = $value ? "" : "{{name}} precisa ter entre {$this->min}-{$this->max} caracteres!";
        }
        $this->setTemplate($template);
        return $value;
    }
}
?>