<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    use App\Core\Router;
    // Start session (controle de login)
    session_start();
    $router = new Router();
    $router->dispatch();
?>