<?php
    namespace App\Models;
    use App\Core\Database;
    use PDO;
    class Usuario {
        public static function buscarPorId($id) {
            $pdo = Database::getConnection();
            $sql = "SELECT id, nome, username, ativo, tipo, filial FROM usuarios WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function criar($dados) {
            $pdo = Database::getConnection();
            $sql = "INSERT INTO usuarios (nome, username, senha, ativo, tipo, filial) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                $dados['nome'],
                $dados['username'],
                password_hash($dados['senha'], PASSWORD_BCRYPT),
                $dados['ativo'] ?? 1,
                $dados['tipo'] ?? 'comum',
                $dados['filial'] ?? 'SP'
            ]);
        }
        public static function atualizar($id, $dados) {
            $pdo = Database::getConnection();
            $campos = ['nome = ?', 'username = ?', 'tipo = ?', 'filial = ?'];
            $params = [
                $dados['nome'],
                $dados['username'],
                $dados['tipo'] ?? 'comum',
                $dados['filial'] ?? 'SP'
            ];
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
        public static function listar($pagina = 1, $porPagina = 10, $busca = '') {
            $pdo = Database::getConnection();
            $offset = ($pagina - 1) * $porPagina;
            $where = '';
            $params = [];
            if ($busca) {
                $where = "WHERE nome LIKE ? OR username LIKE ?";
                $params[] = '%' . $busca . '%';
                $params[] = '%' . $busca . '%';
            }
            $sql = "SELECT id, nome, username, ativo, tipo, filial, criado_em FROM usuarios $where ORDER BY id DESC LIMIT $porPagina OFFSET $offset";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function total($busca = '') {
            $pdo = Database::getConnection();
            $where = '';
            $params = [];
            if ($busca) {
                $where = "WHERE nome LIKE ? OR username LIKE ?";
                $params[] = '%' . $busca . '%';
                $params[] = '%' . $busca . '%';
            }
            $sql = "SELECT COUNT(*) FROM usuarios $where";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchColumn();
        }
    }