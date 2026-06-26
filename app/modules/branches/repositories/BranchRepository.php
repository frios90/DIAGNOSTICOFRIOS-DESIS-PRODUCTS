<?php

declare(strict_types=1);

require_once '../../../config/DatabaseConnection.php';

class BranchRepository
{
    private \PDO $pdo;
    private const string TABLE = "branches";

    public function __construct()
    {
        $db = DatabaseConnection::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getList() : string
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

    public function findByWarehouseId($warehouse_id) : string
    {
        $stmt = $this->pdo->prepare("SELECT id, name FROM ". self::TABLE ." WHERE warehouse_id = ? ORDER BY name");
        $stmt->execute([$warehouse_id]);
        return json_encode($stmt->fetchAll());
    }

    public function findByIdAndWarehouseId($id, $warehouse_id) : array|false
    {
        $stmt = $this->pdo->prepare("SELECT id FROM ". self::TABLE ." WHERE id = ? AND warehouse_id = ?");
        $stmt->execute([$id, $warehouse_id]);
        return $stmt->fetch();
    }
}
?>