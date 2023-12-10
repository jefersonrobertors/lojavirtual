<?php

namespace app\interfaces;

interface FormRequestInterface {

    public function getTemplate() : string;

    public function setTemplate(string $template) : void;

    public function validate(string $value) : bool;
}
?>