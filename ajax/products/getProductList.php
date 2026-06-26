<?php
require_once '../../config/dbConnection.php';
header('Content-Type: application/json');

/**
 * Ajax para la obtención de los producto creados, con el formato requerido para
 * llegar y cargar desde la tabla en el front
 *
 *
 */
try {
    $sql = "
        SELECT
            p.id,
            p.code,
            p.name,
            p.price,
            p.description,
            p.created_at,
            w.name as warehouse,
            b.name as branch,
            c.name as currency,
            c.symbol as currency_symbol,
            COALESCE(string_agg(m.name, ', ' ORDER BY m.name), 'No materials') as materials
        FROM products p
        LEFT JOIN warehouses w ON p.warehouse_id = w.id
        LEFT JOIN branches b ON p.branch_id = b.id
        LEFT JOIN currencies c ON p.currency_id = c.id
        LEFT JOIN product_material pm ON p.id = pm.product_id
        LEFT JOIN materials m ON pm.material_id = m.id
        GROUP BY
            p.id,
            p.code,
            p.name,
            p.price,
            p.description,
            p.created_at,
            w.name,
            b.name,
            c.name,
            c.symbol
        ORDER BY p.created_at DESC
    ";
    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>