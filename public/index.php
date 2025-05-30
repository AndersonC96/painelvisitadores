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
    // ---- Proteção das rotas internas ----
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = '/' . trim($uri, '/'); // Deixa no formato '/rota'
    $rotasPublicas = ['/login', '/logout'];
    // Se não está logado e não está numa rota pública, redireciona para /login
    if (
        !isset($_SESSION['usuario_id']) &&
        !in_array($uri, $rotasPublicas)
    ) {
        header('Location: /login');
        exit;
    }
    // Dispara o roteador normalmente
    $router->dispatch();
?>