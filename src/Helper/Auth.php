<?php
    namespace App\Helper;
    use App\Helper\Database;
    use PDO;
    class Auth {
        public static function login(string $nome_usuario, string $senha): bool {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nome_usuario = ?");
            $stmt->execute([$nome_usuario]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                // Carregar filiais permitidas
                $stmt = $pdo->prepare("SELECT filial_id FROM usuario_filial WHERE usuario_id = ?");
                $stmt->execute([$usuario['id']]);
                $filiais = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $_SESSION['filiais'] = $filiais;
                return true;
            }
            return false;
        }
        public static function check(): bool {
            return isset($_SESSION['usuario_id']);
        }
        public static function logout(): void {
            session_unset();
            session_destroy();
        }
        public static function getUsuarioId(): ?int {
            return $_SESSION['usuario_id'] ?? null;
        }
        public static function getFiliais(): array {
            return $_SESSION['filiais'] ?? [];
        }
    }