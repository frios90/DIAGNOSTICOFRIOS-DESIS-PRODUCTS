<?php

require_once '../../config/dbConnection.php';

/**
 * Función aux. para la creacion del producto desde saveProduct()
 *
 *
 */
function getListWarehousesRepository($pdo, $data)
{
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
?>