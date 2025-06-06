<?php
    namespace App\Models;
    use App\Core\Database;
    use PDO;
    class Time {
        public static function listar() {
            $pdo = Database::getConnection();
            $sql = "SELECT t.*, f.nome as filial_nome FROM times t LEFT JOIN filiais f ON t.filial_id = f.id ORDER BY t.nome";
            return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function buscarPorId($id) {
            $pdo = Database::getConnection();
            $sql = "SELECT t.*, f.nome as filial_nome FROM times t LEFT JOIN filiais f ON t.filial_id = f.id WHERE t.id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function criar($dados) {
            $pdo = Database::getConnection();
            $sql = "INSERT INTO times (nome, filial_id, ativo) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([
                $dados['nome'],
                $dados['filial_id'],
                $dados['ativo'] ?? 1
            ]);
            if ($ok) {
                return $pdo->lastInsertId();
            }
            return false;
        }        
        public static function atualizar($id, $dados) {
            $pdo = Database::getConnection();
            $sql = "UPDATE times SET nome = ?, filial_id = ?, ativo = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([
                $dados['nome'],
                $dados['filial_id'],
                $dados['ativo'] ?? 1,
                $id
            ]);
            if ($ok) {
                self::atualizarRepresentantes($id, $dados['representantes'] ?? []);
            }
            return $ok;
        }
        public static function excluir($id) {
            $pdo = Database::getConnection();
            $pdo->prepare("DELETE FROM times_representantes WHERE time_id = ?")->execute([$id]);
            $sql = "DELETE FROM times WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$id]);
        }
        public static function todasFiliais() {
            $pdo = Database::getConnection();
            return $pdo->query("SELECT id, nome FROM filiais ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function todosRepresentantes() {
            $pdo = Database::getConnection();
            return $pdo->query("SELECT id, nome FROM representantes ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function representantesDoTime($time_id) {
            $pdo = Database::getConnection();
            $sql = "SELECT representante_id FROM times_representantes WHERE time_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$time_id]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        public static function atualizarRepresentantes($time_id, $representantes = []) {
            $pdo = Database::getConnection();
            $pdo->prepare("DELETE FROM times_representantes WHERE time_id = ?")->execute([$time_id]);
            if (is_array($representantes) && count($representantes)) {
                $stmt = $pdo->prepare("INSERT INTO times_representantes (time_id, representante_id) VALUES (?, ?)");
                foreach ($representantes as $rid) {
                    $stmt->execute([$time_id, $rid]);
                }
            }
        }
        public static function vendedorasDoTime($time_id) {
            $pdo = Database::getConnection();
            $sql = "SELECT nome FROM vendedoras WHERE time_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$time_id]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
    }