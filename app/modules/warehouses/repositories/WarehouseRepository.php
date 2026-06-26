<?php
require_once '../../../config/DatabaseConnection.php';

class WarehouseRepository
{
    private $pdo;

    public function __construct()
    {
        $db = DatabaseConnection::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getList()
    {
        $sql = "SELECT id, name FROM warehouses ORDER BY name";
        $stmt = $this->pdo->query($sql);
        return json_encode($stmt->fetchAll());
    }
}
?>