<?php
    namespace App\Controllers;
    use App\Models\Usuario;
    class AuthController {
        public function loginForm() {
            require dirname(__DIR__) . '/views/auth/login.php';
        }
        public function login() {
            $username = $_POST['username'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $erro = null;
            $usuario = Usuario::buscarPorUsername($username);
            if (!$usuario || !password_verify($senha, $usuario['senha'])) {
                $erro = "Usuário ou senha inválidos.";
                require dirname(__DIR__) . '/views/auth/login.php';
                return;
            }
            // --- Tipo de sessão ---
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = $usuario['tipo']; // 'admin' ou 'comum'
            $_SESSION['ultimo_acao'] = time();
            // ------------------------------------------------
            header("Location: /");
            exit;
        }
        public function logout() {
            session_unset();
            session_destroy();
            header("Location: /login");
            exit;
        }
    }