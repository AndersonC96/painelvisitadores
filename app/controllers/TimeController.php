<?php
    namespace App\Controllers;
    use App\Models\Time;
    use App\Models\Representante;
    class TimeController {
        public function index() {
            $times = Time::listar();
            require dirname(__DIR__) . '/views/times/index.php';
        }
        public function create() {
            $filiais = Time::todasFiliais();
            $representantes = Representante::listarTodos();
            $representantes_do_time = [];
            require dirname(__DIR__) . '/views/times/create.php';
        }
        public function store() {
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
            $id = $_GET['id'] ?? null;
            if (!$id) { header('Location: /times'); exit; }
            $time = Time::buscarPorId($id);
            $filiais = Time::todasFiliais();
            $representantes = Representante::listarTodos();
            $representantes_do_time = Time::representantesDoTime($id);
            require dirname(__DIR__) . '/views/times/edit.php';
        }
        public function update() {
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