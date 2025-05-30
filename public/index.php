<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    use App\Core\Router;
    // Start session (controle de login)
    session_start();
    $router = new Router();
    // Rotas de autenticação
    $router->get('/login', 'AuthController@loginForm');
    $router->post('/login', 'AuthController@login');
    $router->get('/logout', 'AuthController@logout');
    // Demais rotas
    $router->get('/', 'DashboardController@index');
    $router->dispatch();
?>