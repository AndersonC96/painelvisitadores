<?php
    session_start();
    require_once __DIR__ . '/../vendor/autoload.php';
    use App\Helper\Auth;
    $erro = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome_usuario = $_POST['nome_usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';
        if (Auth::login($nome_usuario, $senha)) {
            header('Location: dashboard.php');
            exit;
        } else {
            $erro = 'Nome de usuário ou senha inválidos.';
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Login - Painel Visitadores</title>
    </head>
    <body>
        <h2>Login</h2>
        <?php if ($erro): ?>
            <p style="color:red;"><?php echo $erro; ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Nome de Usuário:</label>
            <input type="text" name="nome_usuario" required><br>
            <label>Senha:</label>
            <input type="password" name="senha" required><br>
            <button type="submit">Entrar</button>
        </form>
    </body>
</html>