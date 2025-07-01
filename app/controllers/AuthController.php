<?php
    namespace App\Controllers;
    use App\Models\Usuario;
    use App\Models\Auditoria;
    class AuthController {
        public function loginForm() {
            require dirname(__DIR__) . '/views/auth/login.php';
        }
        public function login() {
            $username = $_POST['username'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $erro = null;
            $usuario = Usuario::buscarPorUsername($username);
            Auditoria::registrar(
                $usuario ? $usuario['id'] : null,
                'login_tentativa',
                'usuario',
                null,
                null,
                ['username' => $username, 'ip' => $_SERVER['REMOTE_ADDR']]
            );
            if (!$usuario || !password_verify($senha, $usuario['senha'])) {
                $erro = "Usuário ou senha inválidos.";
                require dirname(__DIR__) . '/views/auth/login.php';
                return;
            }
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = $usuario['tipo']; // 'admin' ou 'comum'
            $_SESSION['ultimo_acao'] = time();
            Auditoria::registrar(
                $usuario['id'],
                'login',
                'usuario',
                null,
                null,
                ['ip' => $_SERVER['REMOTE_ADDR']]
            );
            header("Location: /");
            exit;
        }
        public function logout() {
            if (isset($_SESSION['usuario_id'])) {
                Auditoria::registrar(
                    $_SESSION['usuario_id'],
                    'logout',
                    'usuario',
                    null,
                    null,
                    ['ip' => $_SERVER['REMOTE_ADDR']]
                );
            }
            session_unset();
            session_destroy();
            header("Location: /login");
            exit;
        }
    }