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
        public static function buscarComFiltro($busca) {
            $pdo = Database::getConnection();
            $busca = '%' . mb_strtolower(trim($busca), 'UTF-8') . '%';
            $sql = "SELECT r.*, f.nome as filial_nome FROM representantes r LEFT JOIN filiais f ON r.filial_id = f.id WHERE LOWER(r.nome) LIKE :busca OR LOWER(f.nome) LIKE :busca OR (:ativo = 1 AND r.ativo = 1 AND 'ativo' LIKE :busca) OR (:inativo = 1 AND r.ativo = 0 AND 'inativo' LIKE :busca) ORDER BY r.nome";
            $ativo = (stripos($busca, 'ativo') !== false) ? 1 : 0;
            $inativo = (stripos($busca, 'inativo') !== false) ? 1 : 0;
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':busca' => $busca,
                ':ativo' => $ativo,
                ':inativo' => $inativo
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }