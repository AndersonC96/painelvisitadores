<?php
    namespace App\Controllers;
    use App\Models\Vendedora;
    use App\Models\Time;
    class VendedoraController {
        public function index() {
            $busca = $_GET['busca'] ?? '';
            $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
            $porPagina = 10;
            $todas = Vendedora::listar($busca);
            $total = count($todas);
            $totalPaginas = max(1, ceil($total / $porPagina));
            $offset = ($pagina - 1) * $porPagina;
            $vendedoras = array_slice($todas, $offset, $porPagina);
            require dirname(__DIR__) . '/views/vendedoras/index.php';
        }
        public function create() {
            $times = Time::listar();
            require dirname(__DIR__) . '/views/vendedoras/create.php';
        }
        public function store() {
            $dados = [
                'nome' => $_POST['nome'],
                'time_id' => $_POST['time_id'] ?? null,
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];
            Vendedora::criar($dados);
            $_SESSION['mensagem'] = 'Vendedora cadastrada com sucesso!';
            $_SESSION['mensagem_tipo'] = 'is-success';
            header('Location: /vendedoras');
            exit;
        }
        public function edit() {
            $id = $_GET['id'] ?? null;
            if (!$id) { header('Location: /vendedoras'); exit; }
            $vendedora = Vendedora::buscarPorId($id);
            $times = Time::listar();
            require dirname(__DIR__) . '/views/vendedoras/edit.php';
        }
        public function update() {
            $id = $_POST['id'];
            $dados = [
                'nome' => $_POST['nome'],
                'time_id' => $_POST['time_id'] ?? null,
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];
            Vendedora::atualizar($id, $dados);
            $_SESSION['mensagem'] = 'Vendedora atualizada com sucesso!';
            $_SESSION['mensagem_tipo'] = 'is-success';
            header('Location: /vendedoras');
            exit;
        }
        public function delete() {
            $id = $_GET['id'] ?? null;
            if ($id) {
                Vendedora::excluir($id);
                $_SESSION['mensagem'] = 'Vendedora excluída com sucesso!';
                $_SESSION['mensagem_tipo'] = 'is-success';
            }
            header('Location: /vendedoras');
            exit;
        }
        public static function listar() {
            $pdo = Database::getConnection();
            $sql = "SELECT v.*, t.nome as time_nome  FROM vendedoras v LEFT JOIN times t ON v.time_id = t.id  ORDER BY v.id DESC";
            return $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        }
    }