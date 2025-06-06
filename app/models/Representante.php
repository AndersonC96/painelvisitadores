<?php
    namespace App\Models;
    use App\Core\Database;
    use PDO;
    class Representante {
        public static function listar() {
            $pdo = Database::getConnection();
            $sql = "SELECT r.*, f.nome as filial_nome FROM representantes r LEFT JOIN filiais f ON r.filial_id = f.id ORDER BY r.nome";
            return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function listarTodos() {
            $pdo = Database::getConnection();
            // $sql = "SELECT id, nome FROM representantes WHERE ativo = 1 ORDER BY nome";
            $sql = "SELECT id, nome FROM representantes ORDER BY nome";
            return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function buscarPorId($id) {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM representantes WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function criar($dados) {
            $pdo = Database::getConnection();
            $sql = "INSERT INTO representantes (nome, filial_id, ativo) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                $dados['nome'],
                $dados['filial_id'],
                $dados['ativo'] ?? 1
            ]);
        }
        public static function atualizar($id, $dados) {
            $pdo = Database::getConnection();
            $sql = "UPDATE representantes SET nome = ?, filial_id = ?, ativo = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                $dados['nome'],
                $dados['filial_id'],
                $dados['ativo'] ?? 1,
                $id
            ]);
        }
        public static function excluir($id) {
            $pdo = Database::getConnection();
            $sql = "DELETE FROM representantes WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$id]);
        }
        public static function todasFiliais() {
            $pdo = Database::getConnection();
            return $pdo->query("SELECT id, nome FROM filiais ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
        }
    }