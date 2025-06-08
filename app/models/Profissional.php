<?php
    namespace App\Models;
    use App\Core\Database;
    use PDO;
    class Profissional {
        public static function listar($busca = '', $ordenar = '') {
            $pdo = Database::getConnection();
            $where = ["p.oculto != 1"];
            $params = [];
            if ($busca) {
                $where[] = "(p.nome_profissional LIKE ? OR p.registro LIKE ? OR r.nome LIKE ? OR v.nome LIKE ?)";
                $params[] = "%$busca%";
                $params[] = "%$busca%";
                $params[] = "%$busca%";
                $params[] = "%$busca%";
            }
            $order = "p.nome_profissional ASC";
            switch ($ordenar) {
                case 'nome_asc':   $order = "p.nome_profissional ASC"; break;
                case 'nome_desc':  $order = "p.nome_profissional DESC"; break;
                case 'rep_asc':    $order = "r.nome ASC"; break;
                case 'rep_desc':   $order = "r.nome DESC"; break;
                case 'uf_asc':     $order = "p.estado ASC"; break;
                case 'uf_desc':    $order = "p.estado DESC"; break;
                case 'vend_asc':   $order = "v.nome ASC"; break;
                case 'vend_desc':  $order = "v.nome DESC"; break;
            }
            $sql = "SELECT p.*, r.nome as representante_nome, v.nome as vendedora_nome, f.nome as filial_nome FROM profissionais p LEFT JOIN representantes r ON p.representante_id = r.id LEFT JOIN vendedoras v ON p.vendedora_id = v.id LEFT JOIN filiais f ON p.filial_id = f.id";
            if ($where) {
                $sql .= " WHERE " . implode(' AND ', $where);
            }
            $sql .= " ORDER BY $order";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function buscarPorId($id) {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM profissionais WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function criar($dados) {
            $pdo = Database::getConnection();
            $sql = "INSERT INTO profissionais (tipo, estado, registro, nome_profissional, representante_id, categoria, vendedora_id, filial_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                $dados['tipo'],
                $dados['estado'],
                $dados['registro'],
                $dados['nome_profissional'],
                $dados['representante_id'],
                $dados['categoria'],
                $dados['vendedora_id'],
                $dados['filial_id']
            ]);
        }
        public static function atualizar($id, $dados) {
            $pdo = Database::getConnection();
            $sql = "UPDATE profissionais SET tipo = ?, estado = ?, registro = ?, nome_profissional = ?, representante_id = ?, categoria = ?, vendedora_id = ?, filial_id = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                $dados['tipo'],
                $dados['estado'],
                $dados['registro'],
                $dados['nome_profissional'],
                $dados['representante_id'],
                $dados['categoria'],
                $dados['vendedora_id'],
                $dados['filial_id'],
                $id
            ]);
        }
        public static function ocultar($id) {
            $pdo = Database::getConnection();
            $sql = "UPDATE profissionais SET oculto = 1 WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$id]);
        }
        public static function excluir($id) {
            return self::ocultar($id);
        }
        public static function todosRepresentantes() {
            $pdo = Database::getConnection();
            return $pdo->query("SELECT id, nome FROM representantes ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function todasVendedoras() {
            $pdo = Database::getConnection();
            return $pdo->query("SELECT id, nome FROM vendedoras ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function todasFiliais() {
            $pdo = Database::getConnection();
            return $pdo->query("SELECT id, nome FROM filiais ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
        }
    }