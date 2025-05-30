<?php
    namespace App\Models;
    use App\Core\Database;
    use PDO;
    class Usuario {
        public static function buscarPorUsername($username) {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM usuarios WHERE username = :username AND ativo = 1 LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['username' => $username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }