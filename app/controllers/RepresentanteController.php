<?php
    namespace App\Controllers;
    use App\Models\Representante;
    class RepresentanteController {
        public function index() {
            $representantes = Representante::listar();
            require dirname(__DIR__) . '/views/representantes/index.php';
        }
        public function create() {
            $filiais = Representante::todasFiliais();
            require dirname(__DIR__) . '/views/representantes/create.php';
        }
        public function store() {
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
            $id = $_GET['id'] ?? null;
            if (!$id) { header('Location: /representantes'); exit; }
            $representante = Representante::buscarPorId($id);
            $filiais = Representante::todasFiliais();
            require dirname(__DIR__) . '/views/representantes/edit.php';
        }
        public function update() {
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