<?php
$routes = [
    ['GET', '/', ['HomeController', 'index']],
    ['GET', '/login', ['LoginController', 'index'], ['auth']],
    ['GET', '/register', ['RegisterController', 'index'], ['auth']],
    ['GET', '/oauth/driver:(google|github)/callback', ['LoginController', 'doLoginWith'], ['auth']],
    ['GET', '/password/recovery/code:\w+', ['PasswordRecoveryController', 'index']],
    ['POST', '/password/update', ['PasswordRecoveryController', 'update'], ['csrf']],
    ['POST', '/password/recovery', ['PasswordRecoveryController', 'sendCode'], ['csrf']],
    ['POST', '/login', ['LoginController', 'doLogin'], ['auth', 'csrf', 'recaptcha']],
    ['POST', '/register', ['RegisterController', 'store'], ['auth', 'csrf', 'recaptcha']],
];
return $routes;
?> 