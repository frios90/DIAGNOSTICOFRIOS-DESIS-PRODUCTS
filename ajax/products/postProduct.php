<?php

require_once './middlewares/storeMiddleware.php';
require_once '../../config/dbConnection.php';
require_once '../../repositories/products/insertProductRepository.php';
require_once '../../repositories/products/insertProductMaterialsRepository.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    return;
}

$validation = validateProductData($pdo, $_POST);
if (!$validation['valid']) {
    echo json_encode(['success' => false, 'message' => $validation['message']]);
    return;
}

try {
    $pdo->beginTransaction();
    $product_id = insertProduct($pdo, $_POST);
    insertProductMaterials($pdo, $product_id, $validation['materials']);
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Producto creado correctamente']);
} catch (PDOException $e) {
    $pdo->rollBack();
    if ($e->getCode() == '23505') {
        echo json_encode(['success' => false, 'message' => 'Error: Duplicación de materiales para un mismo producto']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
?>