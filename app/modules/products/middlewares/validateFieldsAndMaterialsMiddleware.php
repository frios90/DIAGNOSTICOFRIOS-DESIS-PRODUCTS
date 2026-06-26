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
 * Validación principal que junta las otras funcionalidades
 *
 *
 */
function validateFieldsAndMaterialsMiddleware($post_data)
{
    $required_fields = ['code', 'name', 'warehouse', 'branch', 'currency', 'price', 'description'];
    $validation = validateRequiredFields($post_data, $required_fields);
    if (!$validation['valid']) return $validation;

    $validation = validateMaterials($post_data['materials'] ?? null);
    if (!$validation['valid']) return $validation;

    return ['valid' => true, 'materials' => $validation['materials']];
}
?>
