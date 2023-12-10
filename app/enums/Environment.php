<?php

namespace app\enums;

enum Environment {

    case Development;
    case Production;

    public function getEnvironment() : bool {
        return match($this) {
            Environment::Development => env('ENV') === 'development',
            Environment::Production => env('ENV') === 'production'
        };
    }
}
?>