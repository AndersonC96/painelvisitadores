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
            // Impede username duplicado
            if (Usuario::existeUsername($dados['username'])) {
                $_SESSION['mensagem'] = 'Já existe um usuário com este username!';
                $_SESSION['mensagem_tipo'] = 'is-danger';
                header('Location: /usuarios/create');
                exit;
            }
            Usuario::criar($dados);
            $_SESSION['mensagem'] = 'Usuário cadastrado com sucesso!';
            $_SESSION['mensagem_tipo'] = 'is-success';
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
            // Impede username duplicado na edição
            if (Usuario::existeUsername($dados['username'], $id)) {
                $_SESSION['mensagem'] = 'Já existe outro usuário com este username!';
                $_SESSION['mensagem_tipo'] = 'is-danger';
                header('Location: /usuarios/edit?id=' . $id);
                exit;
            }
            Usuario::atualizar($id, $dados);
            $_SESSION['mensagem'] = 'Usuário atualizado com sucesso!';
            $_SESSION['mensagem_tipo'] = 'is-success';
            header('Location: /usuarios');
            exit;
        }
        public function delete() {
            $id = $_GET['id'] ?? null;
            if ($id) {
                // Não deixa excluir o próprio usuário logado
                if ($id == $_SESSION['usuario_id']) {
                    $_SESSION['mensagem'] = 'Você não pode excluir seu próprio usuário!';
                    $_SESSION['mensagem_tipo'] = 'is-danger';
                } else {
                    \App\Models\Usuario::excluir($id);
                    $_SESSION['mensagem'] = 'Usuário excluído com sucesso!';
                    $_SESSION['mensagem_tipo'] = 'is-success';
                }
            }
            header('Location: /usuarios');
            exit;
        }
    }