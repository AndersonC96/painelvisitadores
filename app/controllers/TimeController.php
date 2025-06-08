<?php
    namespace App\Controllers;
    use App\Models\Time;
    use App\Models\Representante;
    class TimeController {
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
            $times = Time::listar();
            require dirname(__DIR__) . '/views/times/index.php';
        }
        public function create() {
            $this->checkAdminComMensagem();
            $filiais = Time::todasFiliais();
            $representantes = Representante::listarTodos();
            $representantes_do_time = [];
            require dirname(__DIR__) . '/views/times/create.php';
        }
        public function store() {
            $this->checkAdminComMensagem();
            $dados = [
                'nome' => $_POST['nome'],
                'filial_id' => $_POST['filial_id'],
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];
            $time_id = Time::criar($dados);
            $representantes = $_POST['representantes'] ?? [];
            if ($time_id) {
                Time::atualizarRepresentantes($time_id, $representantes);
                $_SESSION['mensagem'] = 'Time criado com sucesso!';
                $_SESSION['mensagem_tipo'] = 'is-success';
            } else {
                $_SESSION['mensagem'] = 'Erro ao criar o time!';
                $_SESSION['mensagem_tipo'] = 'is-danger';
            }
            header('Location: /times');
            exit;
        }
        public function edit() {
            $this->checkAdminComMensagem();
            $id = $_GET['id'] ?? null;
            if (!$id) { header('Location: /times'); exit; }
            $time = Time::buscarPorId($id);
            $filiais = Time::todasFiliais();
            $representantes = Representante::listarTodos();
            $representantes_do_time = Time::representantesDoTime($id);
            require dirname(__DIR__) . '/views/times/edit.php';
        }
        public function update() {
            $this->checkAdminComMensagem();
            $id = $_POST['id'];
            $dados = [
                'nome' => $_POST['nome'],
                'filial_id' => $_POST['filial_id'],
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];
            Time::atualizar($id, $dados);
            $representantes = $_POST['representantes'] ?? [];
            Time::atualizarRepresentantes($id, $representantes);
            $_SESSION['mensagem'] = 'Time atualizado com sucesso!';
            $_SESSION['mensagem_tipo'] = 'is-success';
            header('Location: /times');
            exit;
        }
        public function delete() {
            $this->checkAdminComMensagem();
            $id = $_GET['id'] ?? null;
            if ($id) {
                Time::excluir($id);
                $_SESSION['mensagem'] = 'Time excluído com sucesso!';
                $_SESSION['mensagem_tipo'] = 'is-success';
            }
            header('Location: /times');
            exit;
        }
    }