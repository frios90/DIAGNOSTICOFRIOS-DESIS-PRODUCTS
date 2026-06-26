<?php
require_once '../repositories/BranchRepository.php';

header('Content-Type: application/json');

/**
 * AJAX para la obtención del listado de bodegas. Este se obtiene desde el repositio BranchRepository
 *
 *
 */
try {
    $warehouse_id = isset($_GET['warehouse_id']) ? $_GET['warehouse_id'] : 0;
    if ($warehouse_id > 0) {
        $repository = new BranchRepository();
        echo $repository->findByWarehouseId($warehouse_id);
    } else {
        echo json_encode([]);
    }
} catch (PDOException $e) {
    echo json_encode(['Error: ' => $e->getMessage()]);
}
?>