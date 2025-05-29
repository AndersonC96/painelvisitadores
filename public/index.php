<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use App\Helper\Database;
    echo "Painel Visitadores - Conexão com o banco funcionando!<br>";
    $db = Database::getConnection();
    echo "Conectado ao banco de dados com sucesso!";
?>