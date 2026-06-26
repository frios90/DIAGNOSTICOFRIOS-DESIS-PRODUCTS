<?php
require_once '../../config/dbConnection.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT id, name FROM materials ORDER BY name");
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>