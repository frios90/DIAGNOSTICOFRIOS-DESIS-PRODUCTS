<?php

/**
 * Validación server-side para que todos los campos esten completos
 *
 *
 */
function validateRequiredFields($post_data)
{
    $required_fields = ['code', 'name', 'warehouse', 'branch', 'currency', 'price', 'description'];
    foreach ($required_fields as $field) {
        if (!isset($post_data[$field]) || trim($post_data[$field]) === '') return ['valid' => false, 'message' => "Campo $field es requerido"];
    }
    return ['valid' => true];
}

/**
 * Validación para seleccionar minimo 2 materiales
 *
 *
 */
function validateMaterials($materials)
{
    if (!isset($materials) || !is_array($materials)) return ['valid' => false, 'message' => 'Seleccione al menos dos materiales'];
    $clean_materials = array_unique(array_filter($materials));
    if (count($clean_materials) < 2) return ['valid' => false, 'message' => 'Seleccione al menos dos materiales diferentes'];
    return [ 'valid' => true, 'materials' => $clean_materials];
}

/**
 * validación para que no se permita un codigo de producto repetido
 *
 *
 */
function validateUniqueCode($pdo, $code) {
    $stmt = $pdo->prepare("SELECT id FROM products WHERE code = ?");
    $stmt->execute([$code]);
    if ($stmt->fetch()) return ['valid' => false,'message' => 'Ya existe un producto con el código ' . $code];
    return ['valid' => true];
}

/**
 * Validación para que no pase bodegas que no exiten
 *
 *
 */
function validateWarehouseExists($pdo, $warehouse_id) {
    $stmt = $pdo->prepare("SELECT id FROM warehouses WHERE id = ?");
    $stmt->execute([$warehouse_id]);
    if (!$stmt->fetch()) return ['valid' => false, 'message' => 'La Bodega seleccionada no existe'];
    return ['valid' => true];
}

/**
 * Validación para que no pase sucursales que no exiten
 *
 *
 */
function validateBranchBelongsToWarehouse($pdo, $branch_id, $warehouse_id) {
    $stmt = $pdo->prepare("SELECT id FROM branches WHERE id = ? AND warehouse_id = ?");
    $stmt->execute([$branch_id, $warehouse_id]);
    if (!$stmt->fetch()) return ['valid' => false, 'message' => 'La sucursal seleccionada no pertenece a la Bodega Seleccionada'];
    return ['valid' => true];
}

/**
 * Validación para que no pase un tipo de moneda que no exiten
 *
 *
 */
function validateCurrencyExists($pdo, $currency_id)
{
    $stmt = $pdo->prepare("SELECT id FROM currencies WHERE id = ?");
    $stmt->execute([$currency_id]);
    if (!$stmt->fetch()) return ['valid' => false, 'message' => 'El tipo de moneda seleccionado no existe'];
    return ['valid' => true];
}

/**
 * Validación para que no pase un material que no exiten
 *
 *
 */
function validateMaterialExists($pdo, $material_id)
{
    $stmt = $pdo->prepare("SELECT id FROM materials WHERE id = ?");
    $stmt->execute([$material_id]);
    return $stmt->fetch() !== false;
}

/**
 * Validación principal que junta las otras funcionalidades
 *
 *
 */
function validateProductData($pdo, $post_data)
{
    $required_fields = ['code', 'name', 'warehouse', 'branch', 'currency', 'price', 'description'];
    $validation = validateRequiredFields($post_data, $required_fields);
    if (!$validation['valid']) return $validation;

    $validation = validateMaterials($post_data['materials'] ?? null);
    if (!$validation['valid']) return $validation;
    $materials = $validation['materials'];

    $validation = validateUniqueCode($pdo, $post_data['code']);
    if (!$validation['valid']) return $validation;

    $validation = validateWarehouseExists($pdo, $post_data['warehouse']);
    if (!$validation['valid']) return $validation;

    $validation = validateBranchBelongsToWarehouse($pdo, $post_data['branch'], $post_data['warehouse']);
    if (!$validation['valid']) return $validation;

    $validation = validateCurrencyExists($pdo, $post_data['currency']);
    if (!$validation['valid']) return $validation;

    return ['valid' => true, 'materials' => $materials];
}
?>
