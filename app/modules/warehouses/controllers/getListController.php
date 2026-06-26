<?php
require_once '../repositories/WarehouseRepository.php';

header('Content-Type: application/json');

/**
 * AJAX para la obtención del listado de bodegas. Este se obtiene desde el repositio WarehouseRepository
 *
 *
 */
try {
    $warehouse_repository = new WarehouseRepository();
    echo $warehouse_repository->getList();
} catch (PDOException $e) {
    echo json_encode(['Error: ' => $e->getMessage()]);
}
?>