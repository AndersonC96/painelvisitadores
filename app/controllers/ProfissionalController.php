<?php
    namespace App\Controllers;
    use App\Models\Profissional;
    class ProfissionalController {
        private function checkAdmin() {
            if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
                header('Location: /profissionais');
                exit;
            }
        }
        public function index() {
            $busca            = $_GET['busca'] ?? '';
            $ordenar          = $_GET['ordenar'] ?? '';
            $representante_id = $_GET['representante_id'] ?? null;
            $vendedora_id     = $_GET['vendedora_id'] ?? null;
            $filial           = isset($_GET['filial']) ? (int)$_GET['filial'] : null;
            $filiais_usuario  = [];
            if (isset($_SESSION['usuario_id'])) {
                if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'comum') {
                    $filiais_usuario = \App\Models\Usuario::filiaisDoUsuario($_SESSION['usuario_id']);
                }
            }
            $representantes = \App\Models\Profissional::todosRepresentantes();
            $vendedoras    = \App\Models\Profissional::todasVendedoras();
            $profissionais = [];
            if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin') {
                if ($filial) {
                    $filiais_filtrar = [$filial];
                } else {
                    $filiais_filtrar = null;
                }
                $profissionais = \App\Models\Profissional::listar($busca, $ordenar, $filiais_filtrar, $representante_id, $vendedora_id);
            }
            elseif (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'comum') {
                $temFiltro =
                    !empty($busca) ||
                    !empty($representante_id) ||
                    !empty($vendedora_id) ||
                    !empty($filial);
                if (
                    (is_array($filiais_usuario) && count($filiais_usuario) > 1 && $filial && in_array($filial, $filiais_usuario))
                ) {
                    $filiais_filtrar = $filial ? [$filial] : $filiais_usuario;
                } else {
                    $filiais_filtrar = $filiais_usuario;
                }
                if ($temFiltro) {
                    $profissionais = \App\Models\Profissional::listar($busca, $ordenar, $filiais_filtrar, $representante_id, $vendedora_id);
                }
            }
            require dirname(__DIR__) . '/views/profissionais/index.php';
        }
        public function create() {
            $this->checkAdmin();
            $representantes = Profissional::todosRepresentantes();
            $vendedoras = Profissional::todasVendedoras();
            $filiais = Profissional::todasFiliais();
            require dirname(__DIR__) . '/views/profissionais/create.php';
        }
        public function store() {
            $this->checkAdmin();
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
            $this->checkAdmin();
            $id = $_GET['id'] ?? null;
            if (!$id) { header('Location: /profissionais'); exit; }
            $profissional = Profissional::buscarPorId($id);
            $representantes = Profissional::todosRepresentantes();
            $vendedoras = Profissional::todasVendedoras();
            $filiais = Profissional::todasFiliais();
            require dirname(__DIR__) . '/views/profissionais/edit.php';
        }
        public function update() {
            $this->checkAdmin();
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
            $this->checkAdmin();
            $id = $_GET['id'] ?? null;
            if ($id) {
                Profissional::ocultar($id);
                $_SESSION['mensagem'] = 'Profissional removido com sucesso!';
            }
            header('Location: /profissionais');
            exit;
        }
    }