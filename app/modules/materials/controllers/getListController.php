<?php
require_once '../repositories/MaterialRepository.php';

header('Content-Type: application/json');

/**
 * AJAX para la obtención del listado de los materiales. Este se obtiene desde el repositio MaterialRepository
 *
 *
 */
try {
    $material_repository = new MaterialRepository();
    echo $material_repository->getList();
} catch (PDOException $e) {
    echo json_encode(['Error: ' => $e->getMessage()]);
}
?>