<?php

require_once '../../config/dbConnection.php';
require_once './middlewares/storeMiddleware.php';
header('Content-Type: application/json');

/**
 * Función aux. para la creacion del producto desde saveProduct()
 *
 *
 */
function insertProduct($pdo, $data) {
    $sql = "INSERT INTO products (code, name, warehouse_id, branch_id, currency_id, price, description) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['code'],
        $data['name'],
        $data['warehouse'],
        $data['branch'],
        $data['currency'],
        $data['price'],
        $data['description']
    ]);
    return $pdo->lastInsertId();
}

/**
 * Función aux. para la creacion del productMaterial en la tabla pivote desde saveProduct()
 *
 *
 */
function insertProductMaterials($pdo, $product_id, $materials) {
    $sql = "INSERT INTO product_material (product_id, material_id) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    foreach ($materials as $material_id) {
        if (validateMaterialExists($pdo, $material_id)) {
            $stmt->execute([$product_id, $material_id]);
        }
    }
}

/**
 * Función principal para la creacion del producto
 *
 *
 */
function saveProduct($pdo) {
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
}

saveProduct($pdo);
?>