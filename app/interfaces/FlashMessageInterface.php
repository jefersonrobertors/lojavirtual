<?php

namespace app\interfaces;

interface FlashMessageInterface {

    public function danger(string $name, string $message) : void;
    public function warning(string $name, string $message) : void;
    public function info(string $name, string $message) : void;
    public function success(string $name, string $message) : void;
}
?>