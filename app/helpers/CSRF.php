<?php

declare(strict_types=1);

namespace app\helpers;

final class CSRF {

    public static function valid(?string $token = null) : bool {
        return is_null($token) ? true : (session()->_token == $token ? true : false);
    }

    public static function create() : string {
        session()->_token = $sessid = Random::generateToken();
        return '<input type=\'hidden\' name=\'_token\' value=\'' . $sessid . '\' />';
    }
}
?>