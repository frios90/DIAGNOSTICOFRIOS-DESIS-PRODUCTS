<?php
require_once '../repositories/ProductRepository.php';
require_once '../../warehouses/repositories/WarehouseRepository.php';
require_once '../../currencies/repositories/CurrencyRepository.php';
require_once '../../materials/repositories/MaterialRepository.php';
require_once '../../branches/repositories/BranchRepository.php';

/**
 * validación para que no se permita un codigo de producto repetido
 *
 *
 */
function validateUniqueCode($code) {
    $repository = new ProductRepository();
    $existing = $repository->findByCode($code);
    if ($existing) return ['valid' => false,'message' => 'Ya existe un producto con el código ' . $code];
    return ['valid' => true];
}

/**
 * Validación para que no pase bodegas que no exiten
 *
 *
 */
function validateWarehouseExists($warehouse_id) {
    $repository = new WarehouseRepository();
    $existing = $repository->findById($warehouse_id);
    if (!$existing) return ['valid' => false,'message' => 'La Bodega seleccionada no existe'];
    return ['valid' => true];
}

/**
 * Validación para que no pase sucursales que no exiten
 *
 *
 */
function validateBranchBelongsToWarehouse($id, $warehouse_id)
{
    $repository = new BranchRepository();
    $existing = $repository->findByIdAndWarehouseId($id, $warehouse_id);
    if (!$existing) return ['valid' => false,'message' => 'La sucursal seleccionada no pertenece a la Bodega Seleccionada'];
    return ['valid' => true];
}

/**
 * Validación para que no pase un tipo de moneda que no exiten
 *
 *
 */
function validateCurrencyExists($id)
{
    $repository = new CurrencyRepository();
    $existing = $repository->findById($id);
    if (!$existing) return ['valid' => false,'message' => 'El tipo de moneda seleccionado no existe'];
    return ['valid' => true];
}


/**
 * Validación principal que junta las otras funcionalidades
 *
 *
 */
function validateFieldsDatabaseMiddleware($post_data)
{
    $validation = validateUniqueCode($post_data['code']);
    if (!$validation['valid']) return $validation;

    $validation = validateWarehouseExists($post_data['warehouse']);
    if (!$validation['valid']) return $validation;

    $validation = validateBranchBelongsToWarehouse($post_data['branch'], $post_data['warehouse']);
    if (!$validation['valid']) return $validation;

    $validation = validateCurrencyExists($post_data['currency']);
    if (!$validation['valid']) return $validation;

    return ['valid' => true];
}
?>
