<?php

require_once '../../config/dbConnection.php';

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
?>