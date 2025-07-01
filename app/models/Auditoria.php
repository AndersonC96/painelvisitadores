<?php
    namespace App\Models;
    use App\Core\Database;
    use PDO;   
    class Auditoria {
        public static function registrar($usuario_id, $acao, $entidade, $entidade_id = null, $dados_antes = null, $dados_depois = null) {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'N/A';
            $pdo = Database::getConnection();
            $sql = "INSERT INTO auditoria (usuario_id, acao, entidade, entidade_id, dados_antes, dados_depois, ip) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $ip = $_SERVER['REMOTE_ADDR'] ?? null;
            $stmt->execute([
                $usuario_id,
                $acao,
                $entidade,
                $entidade_id,
                $dados_antes ? json_encode($dados_antes) : null,
                $dados_depois ? json_encode($dados_depois) : null,
                $ip
            ]);
        }
    }