<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    use App\Core\Router;
    session_start();
    $router = new Router();
    $router->get('/login', 'AuthController@loginForm');
    $router->post('/login', 'AuthController@login');
    $router->get('/logout', 'AuthController@logout');
    $router->get('/', 'DashboardController@index');
    // ---- Proteção das rotas internas ----
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = '/' . trim($uri, '/'); // Deixa no formato '/rota'
    $rotasPublicas = ['/login', '/logout'];
    if (
        !isset($_SESSION['usuario_id']) &&
        !in_array($uri, $rotasPublicas)
    ) {
        header('Location: /login');
        exit;
    }
    $router->dispatch();