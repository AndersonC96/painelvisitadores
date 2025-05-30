<?php
    namespace App\Core;
    class Router {
        private $routes = [
            'GET' => [],
            'POST' => [],
        ];
        // Registrar rota GET
        public function get($path, $handler) {
            $this->routes['GET'][$this->normalize($path)] = $handler;
        }
        // Registrar rota POST
        public function post($path, $handler) {
            $this->routes['POST'][$this->normalize($path)] = $handler;
        }
        // Normaliza a URL removendo barras extras
        private function normalize($path) {
            return '/' . trim($path, '/');
        }
        public function dispatch() {
            $method = $_SERVER['REQUEST_METHOD'];
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri = $this->normalize($uri);
            // Tenta encontrar rota registrada
            if (isset($this->routes[$method][$uri])) {
                [$controller, $action] = explode('@', $this->routes[$method][$uri]);
                $controllerClass = "App\\Controllers\\$controller";
                if (class_exists($controllerClass) && method_exists($controllerClass, $action)) {
                    $instance = new $controllerClass();
                    return call_user_func([$instance, $action]);
                }
            }
            // Roteamento "automático" para outras rotas não registradas
            $parts = explode('/', trim($uri, '/'));
            $controllerName = ucfirst($parts[0] ?? 'dashboard') . 'Controller';
            $action = $parts[1] ?? 'index';
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