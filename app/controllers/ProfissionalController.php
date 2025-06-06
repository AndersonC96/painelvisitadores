<?php
    namespace App\Controllers;
    use App\Models\Profissional;
    class ProfissionalController {
        /*public function index() {
            $profissionais = Profissional::listar();
            require dirname(__DIR__) . '/views/profissionais/index.php';
        }*/
        public function index() {
            $busca   = $_GET['busca'] ?? '';
            $ordenar = $_GET['ordenar'] ?? '';
            $profissionais = Profissional::listar($busca, $ordenar);
            require dirname(__DIR__) . '/views/profissionais/index.php';
        }        
        public function create() {
            $representantes = Profissional::todosRepresentantes();
            $vendedoras = Profissional::todasVendedoras();
            $filiais = Profissional::todasFiliais();
            require dirname(__DIR__) . '/views/profissionais/create.php';
        }
        public function store() {
            $dados = [
                'tipo' => $_POST['tipo'],
                'estado' => $_POST['estado'],
                'registro' => $_POST['registro'],
                'nome_profissional' => $_POST['nome_profissional'],
                'representante_id' => $_POST['representante_id'],
                'categoria' => $_POST['categoria'],
                'vendedora_id' => $_POST['vendedora_id'],
                'filial_id' => $_POST['filial_id']
            ];
            Profissional::criar($dados);
            $_SESSION['mensagem'] = 'Profissional cadastrado com sucesso!';
            $_SESSION['mensagem_tipo'] = 'is-success';
            header('Location: /profissionais');
            exit;
        }
        public function edit() {
            $id = $_GET['id'] ?? null;
            if (!$id) { header('Location: /profissionais'); exit; }
            $profissional = Profissional::buscarPorId($id);
            $representantes = Profissional::todosRepresentantes();
            $vendedoras = Profissional::todasVendedoras();
            $filiais = Profissional::todasFiliais();
            require dirname(__DIR__) . '/views/profissionais/edit.php';
        }
        public function update() {
            $id = $_POST['id'];
            $dados = [
                'tipo' => $_POST['tipo'],
                'estado' => $_POST['estado'],
                'registro' => $_POST['registro'],
                'nome_profissional' => $_POST['nome_profissional'],
                'representante_id' => $_POST['representante_id'],
                'categoria' => $_POST['categoria'],
                'vendedora_id' => $_POST['vendedora_id'],
                'filial_id' => $_POST['filial_id']
            ];
            Profissional::atualizar($id, $dados);
            $_SESSION['mensagem'] = 'Profissional atualizado com sucesso!';
            $_SESSION['mensagem_tipo'] = 'is-success';
            header('Location: /profissionais');
            exit;
        }
        public function delete() {
            $id = $_GET['id'] ?? null;
            if ($id) {
                Profissional::excluir($id);
                $_SESSION['mensagem'] = 'Profissional excluído com sucesso!';
                $_SESSION['mensagem_tipo'] = 'is-success';
            }
            header('Location: /profissionais');
            exit;
        }
    }