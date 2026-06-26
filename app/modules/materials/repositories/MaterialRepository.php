<?php
require_once '../../../config/DatabaseConnection.php';

class MaterialRepository
{
    private $pdo;
    private const TABLE = "materials";

    public function __construct()
    {
        $db = DatabaseConnection::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function getList()
    {
        $sql = "SELECT id, name FROM ". self::TABLE ." ORDER BY name";
        $stmt = $this->pdo->query($sql);
        return json_encode($stmt->fetchAll());
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM ". self::TABLE ." WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();;
    }
}
?>