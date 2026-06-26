<?php
require_once '../../config/dbConnection.php';
header('Content-Type: application/json');

try {
    $warehouse_id = isset($_GET['warehouse_id']) ? $_GET['warehouse_id'] : 0;
    if ($warehouse_id > 0) {
        $stmt = $pdo->prepare("SELECT id, name FROM branches WHERE warehouse_id = ? ORDER BY name");
        $stmt->execute([$warehouse_id]);
        echo json_encode($stmt->fetchAll());
    } else {
        echo json_encode([]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>