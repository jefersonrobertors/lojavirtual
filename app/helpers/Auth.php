<?php

declare(strict_types=1);

namespace app\helpers;

use Google\Service\Oauth2\Userinfo;

final class Auth {

    public function doLoginWithGoogle(Userinfo $user) {
        redirect('/');
    }

    public function isAuthenticated() : bool {
        return isset(session()->auth) && !empty(session()->auth);
    }
}
?>