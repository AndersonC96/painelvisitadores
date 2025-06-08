<?php
    namespace App\Controllers;
    use App\Models\Vendedora;
    use App\Models\Time;
    class VendedoraController {
        private function checkAdminComMensagem() {
            if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
                echo '<div style="max-width:400px;margin:6rem auto 0; background:#181b29e8;padding:2.3rem 1.8rem;border-radius:15px; color:#fff;box-shadow:0 6px 30px #2563eb33; text-align:center;font-size:1.2rem;">
                <strong style="font-size:1.5rem;color:#e45c5c;">Acesso Negado</strong>
                <br><br>
                Você não tem permissão para acessar esta área.<br>
                Redirecionando para Profissionais...
                <br><br>
                <a href="/profissionais" style="color:#2563eb;text-decoration:underline;">Clique aqui se não for redirecionado.</a>
                </div>';
                header("Refresh: 5; URL=/profissionais");
                exit;
            }
        }
        public function index() {
            $this->checkAdminComMensagem();
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
            $this->checkAdminComMensagem();
            $times = Time::listar();
            require dirname(__DIR__) . '/views/vendedoras/create.php';
        }
        public function store() {
            $this->checkAdminComMensagem();
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
            $this->checkAdminComMensagem();
            $id = $_GET['id'] ?? null;
            if (!$id) { header('Location: /vendedoras'); exit; }
            $vendedora = Vendedora::buscarPorId($id);
            $times = Time::listar();
            require dirname(__DIR__) . '/views/vendedoras/edit.php';
        }
        public function update() {
            $this->checkAdminComMensagem();
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
            $this->checkAdminComMensagem();
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