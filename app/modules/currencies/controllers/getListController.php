<?php
require_once '../repositories/CurrencyRepository.php';

header('Content-Type: application/json');

/**
 * AJAX para la obtención del listado de bodegas. Este se obtiene desde el repositio CurrencyRepository
 *
 *
 */
try {
    $currency_repository = new CurrencyRepository();
    echo $currency_repository->getList();
} catch (PDOException $e) {
    echo json_encode(['Error: ' => $e->getMessage()]);
}
?>