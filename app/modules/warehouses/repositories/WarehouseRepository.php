<?php

declare(strict_types=1);

require_once '../../../config/DatabaseConnection.php';

class WarehouseRepository
{
    private \PDO $pdo;
    private const string TABLE = "warehouses";

    public function __construct()
    {
        $db = DatabaseConnection::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getList(): string
    {
        $sql = "SELECT id, name FROM ". self::TABLE ." ORDER BY name";
        $stmt = $this->pdo->query($sql);
        return json_encode($stmt->fetchAll());
    }

    public function findById($id) : array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ". self::TABLE ." WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
?>