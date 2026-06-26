<?php
require_once '../../config/dbConnection.php';
header('Content-Type: application/json');
/**
 * Con el siguiente switch hago un selección de la data que se necesita
 * obtener de manera incial para los distintos selectores.
 * En un entorno mas detallado al igual que con products, cada uno de estos
 * se trataría como un módulo mas y se crearia su directorio particular para
 * cada item
 *
 *
 */

$action = isset($_GET['action']) ? $_GET['action'] : '';
try {
    switch ($action) {
        case 'getWarehouses':
            $stmt = $pdo->query("SELECT id, name FROM warehouses ORDER BY name");
            echo json_encode($stmt->fetchAll());
            break;

        case 'getBranches':
            $warehouse_id = isset($_GET['warehouse_id']) ? $_GET['warehouse_id'] : 0;
            if ($warehouse_id > 0) {
                $stmt = $pdo->prepare("SELECT id, name FROM branches WHERE warehouse_id = ? ORDER BY name");
                $stmt->execute([$warehouse_id]);
                echo json_encode($stmt->fetchAll());
            } else {
                echo json_encode([]);
            }
            break;

        case 'getCurrencies':
            $stmt = $pdo->query("SELECT id, name, symbol FROM currencies ORDER BY name");
            echo json_encode($stmt->fetchAll());
            break;

        case 'getMaterials':
            $stmt = $pdo->query("SELECT id, name FROM materials ORDER BY name");
            echo json_encode($stmt->fetchAll());
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>