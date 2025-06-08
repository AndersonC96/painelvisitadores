<?php
    namespace App\Controllers;
    use App\Models\Representante;
    class RepresentanteController {
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
            if ($busca !== '') {
                $representantes = Representante::buscarComFiltro($busca);
            } else {
                $representantes = Representante::listar();
            }
            require dirname(__DIR__) . '/views/representantes/index.php';
        }
        public function create() {
            $this->checkAdminComMensagem();
            $filiais = Representante::todasFiliais();
            require dirname(__DIR__) . '/views/representantes/create.php';
        }
        public function store() {
            $this->checkAdminComMensagem();
            $dados = [
                'nome' => $_POST['nome'],
                'filial_id' => $_POST['filial_id'],
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];
            Representante::criar($dados);
            $_SESSION['mensagem'] = 'Representante criado com sucesso!';
            $_SESSION['mensagem_tipo'] = 'is-success';
            header('Location: /representantes');
            exit;
        }
        public function edit() {
            $this->checkAdminComMensagem();
            $id = $_GET['id'] ?? null;
            if (!$id) { header('Location: /representantes'); exit; }
            $representante = Representante::buscarPorId($id);
            $filiais = Representante::todasFiliais();
            require dirname(__DIR__) . '/views/representantes/edit.php';
        }
        public function update() {
            $this->checkAdminComMensagem();
            $id = $_POST['id'];
            $dados = [
                'nome' => $_POST['nome'],
                'filial_id' => $_POST['filial_id'],
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];
            Representante::atualizar($id, $dados);
            $_SESSION['mensagem'] = 'Representante atualizado com sucesso!';
            $_SESSION['mensagem_tipo'] = 'is-success';
            header('Location: /representantes');
            exit;
        }
        public function delete() {
            $this->checkAdminComMensagem();
            $id = $_GET['id'] ?? null;
            if ($id) {
                Representante::excluir($id);
                $_SESSION['mensagem'] = 'Representante excluído com sucesso!';
                $_SESSION['mensagem_tipo'] = 'is-success';
            }
            header('Location: /representantes');
            exit;
        }
    }