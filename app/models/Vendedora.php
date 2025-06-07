<?php
    namespace App\Models;
    use App\Core\Database;
    use PDO;
    class Vendedora {
        public static function listar($busca = '') {
            $pdo = Database::getConnection();
            $sql = "SELECT v.*, t.nome as time_nome FROM vendedoras v LEFT JOIN times t ON v.time_id = t.id";
            if ($busca) {
                $sql .= " WHERE v.nome LIKE :busca OR t.nome LIKE :busca";
            }
            $sql .= " ORDER BY v.nome";
            $stmt = $pdo->prepare($sql);
            if ($busca) {
                $stmt->execute([':busca' => '%' . $busca . '%']);
            } else {
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function buscarPorId($id) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM vendedoras WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function criar($dados) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO vendedoras (nome, time_id, ativo) VALUES (?, ?, ?)");
            return $stmt->execute([
                $dados['nome'],
                $dados['time_id'] ?: null,
                $dados['ativo'] ?? 1
            ]);
        }
        public static function atualizar($id, $dados) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("UPDATE vendedoras SET nome = ?, time_id = ?, ativo = ? WHERE id = ?");
            return $stmt->execute([
                $dados['nome'],
                $dados['time_id'] ?: null,
                $dados['ativo'] ?? 1,
                $id
            ]);
        }
        public static function excluir($id) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("DELETE FROM vendedoras WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }