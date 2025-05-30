<?php
    namespace App\Core;
    use PDO;
    use PDOException;
    class Database {
        private static $instance = null;
        public static function getConnection() {
            if (self::$instance === null) {
                $config = require dirname(__DIR__, 2) . '/config/config.php';
                $db = $config['db'];
                $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}";
                try {
                    self::$instance = new PDO($dsn, $db['user'], $db['pass']);
                    self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die('Erro de conexão: ' . $e->getMessage());
                }
            }
            return self::$instance;
        }
    }
?>