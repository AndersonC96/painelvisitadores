<?php
    namespace App\Controllers;
    use App\Models\Usuario;   
    class UsuarioController {
        public function index() {
            $usuarios = Usuario::listar();
            require dirname(__DIR__) . '/views/usuarios/index.php';
        }
        public function create() {
            require dirname(__DIR__) . '/views/usuarios/create.php';
        }
        public function store() {
            $dados = [
                'nome' => $_POST['nome'],
                'username' => $_POST['username'],
                'senha' => $_POST['senha'],
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];
            Usuario::criar($dados);
            header('Location: /usuarios');
            exit;
        }
        public function edit() {
            $id = $_GET['id'] ?? null;
            if (!$id) { header('Location: /usuarios'); exit; }
            $usuario = Usuario::buscarPorId($id);
            require dirname(__DIR__) . '/views/usuarios/edit.php';
        }
        public function update() {
            $id = $_POST['id'];
            $dados = [
                'nome' => $_POST['nome'],
                'username' => $_POST['username'],
                'senha' => $_POST['senha'] ?? '',
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];
            Usuario::atualizar($id, $dados);
            header('Location: /usuarios');
            exit;
        }
        public function delete() {
            $id = $_GET['id'] ?? null;
            if ($id) {
                Usuario::excluir($id);
            }
            header('Location: /usuarios');
            exit;
        }
    }