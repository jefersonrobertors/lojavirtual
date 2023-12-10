<?php

namespace core\http\request\rules;

use app\interfaces\FormRequestInterface;

final class State implements FormRequestInterface  {

    private array $stateList = [
        'AC', 
        'AL', 
        'AP', 
        'AM', 
        'BA', 
        'CE', 
        'DF', 
        'ES', 
        'GO', 
        'MA', 
        'MT', 
        'MS', 
        'MG', 
        'PA', 
        'PB', 
        'PR', 
        'PE', 
        'PI', 
        'RJ', 
        'RN', 
        'RO', 
        'RS', 
        'RR', 
        'SC', 
        'SP', 
        'SE', 
        'TO'
    ];

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

    public function validate($value) : bool {
        return isset($this->stateList[$value]);
    }
}
?>