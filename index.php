<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    /*var_dump($_ENV['DB_USER']);
    exit;*/
    use App\Core\Router;
    session_start();
    $router = new Router();
    $router->get('/login', 'AuthController@loginForm');
    $router->post('/login', 'AuthController@login');
    $router->get('/logout', 'AuthController@logout');
    $router->get('/', 'DashboardController@index');
    $router->get('/usuarios', 'UsuarioController@index');
    $router->get('/usuarios/create', 'UsuarioController@create');
    $router->post('/usuarios/store', 'UsuarioController@store');
    $router->get('/usuarios/edit', 'UsuarioController@edit');
    $router->post('/usuarios/update', 'UsuarioController@update');
    $router->get('/usuarios/delete', 'UsuarioController@delete');
    $router->get('/representantes', 'RepresentanteController@index');
    $router->get('/representantes/create', 'RepresentanteController@create');
    $router->post('/representantes/store', 'RepresentanteController@store');
    $router->get('/representantes/edit', 'RepresentanteController@edit');
    $router->post('/representantes/update', 'RepresentanteController@update');
    $router->get('/representantes/delete', 'RepresentanteController@delete');
    $router->get('/times', 'TimeController@index');
    $router->get('/times/create', 'TimeController@create');
    $router->post('/times/store', 'TimeController@store');
    $router->get('/times/edit', 'TimeController@edit');
    $router->post('/times/update', 'TimeController@update');
    $router->get('/times/delete', 'TimeController@delete');
    $router->get('/vendedoras', 'VendedoraController@index');
    $router->get('/vendedoras/create', 'VendedoraController@create');
    $router->post('/vendedoras/store', 'VendedoraController@store');
    $router->get('/vendedoras/edit', 'VendedoraController@edit');
    $router->post('/vendedoras/update', 'VendedoraController@update');
    $router->get('/vendedoras/delete', 'VendedoraController@delete');
    $router->get('/profissionais', 'ProfissionalController@index');
    $router->get('/profissionais/create', 'ProfissionalController@create');
    $router->post('/profissionais/store', 'ProfissionalController@store');
    $router->get('/profissionais/edit', 'ProfissionalController@edit');
    $router->post('/profissionais/update', 'ProfissionalController@update');
    $router->get('/profissionais/delete', 'ProfissionalController@delete');
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