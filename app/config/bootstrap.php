<?php

use app\enums\Environment;
use app\helpers\Session;

use app\routes\Router;
use core\helpers\Container;
use core\helpers\Request;
use core\helpers\Response;

use function DI\autowire;

date_default_timezone_set('America/Sao_Paulo');

if(Environment::Production->getEnvironment()) {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
}else{
    set_error_handler('var_dump');
}

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();

$GLOBALS['session'] = Session::create();

include_once('config.php');

$definitions = [
    Request::class => Request::create(),
    Response::class => Response::create(),
    Router::class => autowire(Router::class),
];
$container = Container::create()->build($definitions);
$router = $container->get(Router::class);

include_once('routes.php');

foreach($routes as $key => $data) {
    $router->addRoute(...$data);
}
try {
    $router->run();
}catch (\Exception $e) {
    echo $e->getMessage();
}
?>