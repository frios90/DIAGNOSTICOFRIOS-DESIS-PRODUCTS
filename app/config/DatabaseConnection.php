<?php

class DatabaseConnection
{
    private static $instance = null;
    private $pdo;
    private $host = 'localhost'; /** Cambiar a db si se usa con docker */
    private $port = '5432';
    private $database_name = 'diagnostico';
    private $db_username = 'diagnostico_usr';
    private $db_password = '1234';

    private function __construct() {
        try {
            $this->pdo = new PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->database_name};",
                $this->db_username,
                $this->db_password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $error) {
            die("Error en la conexión con la base de datos: " . $error->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>