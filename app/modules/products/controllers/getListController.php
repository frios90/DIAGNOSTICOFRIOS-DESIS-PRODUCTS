<?php
require_once '../repositories/ProductRepository.php';

header('Content-Type: application/json');

/**
 * Ajax para la obtención de los producto creados, con el formato requerido para
 * llegar y cargar desde la tabla en el front
 *
 *
 */
try {
    $repository = new ProductRepository();
    $products = $repository->getList();
    echo $products;
} catch (PDOException $e) {
    echo json_encode(['Error: ' => $e->getMessage()]);
}
?>