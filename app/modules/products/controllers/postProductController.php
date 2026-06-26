<?php

require_once '../repositories/ProductRepository.php';
require_once '../middlewares/validateFieldsAndMaterialsMiddleware.php';
require_once '../middlewares/validateFieldsDatabaseMiddleware.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    return;
}


$validation = validateFieldsAndMaterialsMiddleware($_POST);
if (!$validation['valid']) {
    echo json_encode(['success' => false, 'message' => $validation['message']]);
    return;
}

$validation_fields_db = validateFieldsDatabaseMiddleware($_POST);
if (!$validation_fields_db['valid']) {
    echo json_encode(['success' => false, 'message' => $validation_fields_db['message']]);
    return;
}

$product_repository = new ProductRepository();

try {
    $product_id = $product_repository->createProduct($_POST);
    $product_repository->createProductMaterial($product_id, $validation['materials']);
    echo json_encode(['success' => true, 'message' => 'Producto creado correctamente']);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>