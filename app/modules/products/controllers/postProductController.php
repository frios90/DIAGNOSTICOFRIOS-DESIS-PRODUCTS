<?php

require_once '../repositories/ProductRepository.php';
require_once '../middlewares/validateFieldsAndMaterialsMiddleware.php';
require_once '../middlewares/storeMiddleware.php';

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

$product_repository = new ProductRepository();

try {
    $pdo->beginTransaction();
    $product_id = $product_repository->createProduct($_POST);
    $product_repository->createProductMaterial($product_id, $validation['materials']);
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Producto creado correctamente']);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>