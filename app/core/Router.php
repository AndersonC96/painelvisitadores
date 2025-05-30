<?php
    namespace App\Core;
    class Router {
        public function dispatch() {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri = trim($uri, '/');
            if ($uri === '') {
                $controllerName = 'DashboardController';
                $action = 'index';
            } else {
                $parts = explode('/', $uri);
                $controllerName = ucfirst($parts[0]) . 'Controller';
                $action = $parts[1] ?? 'index';
            }
            $controllerClass = "App\\Controllers\\$controllerName";
            if (class_exists($controllerClass) && method_exists($controllerClass, $action)) {
                $controller = new $controllerClass();
                call_user_func([$controller, $action]);
            } else {
                http_response_code(404);
                echo "Página não encontrada";
            }
        }
    }
?>