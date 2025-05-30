<?php
    namespace App\Models;
    use App\Core\Database;
    use PDO;
    class Usuario {
        public static function listar() {
            $pdo = Database::getConnection();
            $sql = "SELECT id, nome, username, ativo, criado_em FROM usuarios";
            return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function buscarPorId($id) {
            $pdo = Database::getConnection();
            $sql = "SELECT id, nome, username, ativo FROM usuarios WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function criar($dados) {
            $pdo = Database::getConnection();
            $sql = "INSERT INTO usuarios (nome, username, senha, ativo) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                $dados['nome'],
                $dados['username'],
                password_hash($dados['senha'], PASSWORD_BCRYPT),
                $dados['ativo'] ?? 1
            ]);
        }
        public static function atualizar($id, $dados) {
            $pdo = Database::getConnection();
            $campos = ['nome = ?', 'username = ?'];
            $params = [$dados['nome'], $dados['username']];
            if (!empty($dados['senha'])) {
                $campos[] = 'senha = ?';
                $params[] = password_hash($dados['senha'], PASSWORD_BCRYPT);
            }
            $campos[] = 'ativo = ?';
            $params[] = $dados['ativo'] ?? 1;
            $params[] = $id;
            $sql = "UPDATE usuarios SET " . implode(', ', $campos) . " WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute($params);
        }
        public static function excluir($id) {
            $pdo = Database::getConnection();
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$id]);
        }
        //Verifica se username já existe
        public static function existeUsername($username, $ignorarId = null) {
            $pdo = Database::getConnection();
            $sql = "SELECT id FROM usuarios WHERE username = ?";
            $params = [$username];
            if ($ignorarId) {
                $sql .= " AND id != ?";
                $params[] = $ignorarId;
            }
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
        }
    }