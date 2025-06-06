<?php
    namespace App\Models;
    use App\Core\Database;
    use PDO;
    class Usuario {
        public static function buscarPorId($id) {
            $pdo = Database::getConnection();
            $sql = "SELECT id, nome, username, ativo, tipo FROM usuarios WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function criar($dados) {
            $pdo = Database::getConnection();
            $sql = "INSERT INTO usuarios (nome, username, senha, ativo, tipo) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $ok = $stmt->execute([
                $dados['nome'],
                $dados['username'],
                password_hash($dados['senha'], PASSWORD_BCRYPT),
                $dados['ativo'] ?? 1,
                $dados['tipo'] ?? 'comum'
            ]);
            if ($ok) {
                $id = $pdo->lastInsertId();
                self::atualizarFiliais($id, $dados['filiais'] ?? []);
            }
            return $ok;
        }
        public static function atualizar($id, $dados) {
            $pdo = Database::getConnection();
            $campos = ['nome = ?', 'username = ?', 'tipo = ?'];
            $params = [
                $dados['nome'],
                $dados['username'],
                $dados['tipo'] ?? 'comum'
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
            $ok = $stmt->execute($params);
            if ($ok) {
                self::atualizarFiliais($id, $dados['filiais'] ?? []);
            }
            return $ok;
        }
        public static function excluir($id) {
            $pdo = Database::getConnection();
            // Remove também vínculos com filiais
            $pdo->prepare("DELETE FROM usuarios_filiais WHERE usuario_id = ?")->execute([$id]);
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
            $sql = "SELECT id, nome, username, ativo, tipo, criado_em FROM usuarios $where ORDER BY id DESC LIMIT $porPagina OFFSET $offset";
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
        public static function buscarPorUsername($username) {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM usuarios WHERE username = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function filiaisDoUsuario($usuario_id) {
            $pdo = Database::getConnection();
            $sql = "SELECT filial_id FROM usuarios_filiais WHERE usuario_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        public static function atualizarFiliais($usuario_id, $filiais = []) {
            $pdo = Database::getConnection();
            $pdo->prepare("DELETE FROM usuarios_filiais WHERE usuario_id = ?")->execute([$usuario_id]);
            if (is_array($filiais) && count($filiais)) {
                $stmt = $pdo->prepare("INSERT INTO usuarios_filiais (usuario_id, filial_id) VALUES (?, ?)");
                foreach ($filiais as $filial) {
                    $stmt->execute([$usuario_id, $filial]);
                }
            }
        }
    }