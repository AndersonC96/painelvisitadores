<?php
    namespace App\Helper;
    use PDO;
    use PDOException;
    class Database {
        private static ?PDO $instance = null;
        public static function getConnection(): PDO {
            if (self::$instance === null) {
                $config = require __DIR__ . '/../../config/config.php';
                $db = $config['db'];
                try {
                    self::$instance = new PDO(
                        "mysql:host={$db['host']};dbname={$db['name']};charset=utf8mb4",
                        $db['user'],
                        $db['pass']
                    );
                    self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
                }
            }
            return self::$instance;
        }
    }
?>