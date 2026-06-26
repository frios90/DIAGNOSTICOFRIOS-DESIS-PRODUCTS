<?php

declare(strict_types=1);

require_once '../repositories/ProductRepository.php';
require_once '../../warehouses/repositories/WarehouseRepository.php';
require_once '../../currencies/repositories/CurrencyRepository.php';
require_once '../../materials/repositories/MaterialRepository.php';
require_once '../../branches/repositories/BranchRepository.php';

class StoreMiddleware
{
    private array $required_fields = ['code', 'name', 'warehouse', 'branch', 'currency', 'price', 'description'];
    private ProductRepository $productRepository;
    private WarehouseRepository $warehouseRepository;
    private BranchRepository $branchRepository;
    private CurrencyRepository $currencyRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->warehouseRepository = new WarehouseRepository();
        $this->branchRepository = new BranchRepository();
        $this->currencyRepository = new CurrencyRepository();
    }

    public function validate(array $data): array
    {
        $validation = $this->validateRequired($data);
        if (!$validation['valid']) return $validation;

        $validation = $this->validateUniqueCode($data['code']);
        if (!$validation['valid']) return $validation;

        $validation = $this->validateWarehouseExists((int)$data['warehouse']);
        if (!$validation['valid']) return $validation;

        $validation = $this->validateBranchBelongsToWarehouse((int)$data['branch'], (int)$data['warehouse']);
        if (!$validation['valid']) return $validation;

        $validation = $this->validateCurrencyExists((int)$data['currency']);
        if (!$validation['valid']) return $validation;

        $validation = $this->validateMaterials($data['materials'] ?? null);
        if (!$validation['valid']) return $validation;

        return ['valid' => true, 'materials' => $validation['materials']];
    }

    private function validateRequired(array $data): array
    {
        foreach ($this->required_fields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') return ['valid' => false, 'message' => "Campo $field es requerido"];
        }
        return ['valid' => true];
    }

    private function validateMaterials($materials): array
    {
        if (!isset($materials) || !is_array($materials)) return ['valid' => false, 'message' => 'Seleccione al menos dos materiales'];
        $clean_materials = array_unique(array_filter($materials));
        if (count($clean_materials) < 2) return ['valid' => false, 'message' => 'Debe seleccionar al menos dos materiales para el producto'];
        return ['valid' => true, 'materials' => $clean_materials];
    }

    private function validateUniqueCode(string $code): array
    {
        $existing = $this->productRepository->findByCode($code);
        if ($existing) return ['valid' => false, 'message' => 'El código del producto ya está registrado'];
        return ['valid' => true];
    }

    private function validateWarehouseExists(int $warehouse_id): array
    {
        $existing = $this->warehouseRepository->findById($warehouse_id);
        if (!$existing) return ['valid' => false, 'message' => 'La Bodega seleccionada no existe'];
        return ['valid' => true];
    }

    private function validateBranchBelongsToWarehouse(int $branch_id, int $warehouse_id): array
    {
        $existing = $this->branchRepository->findByIdAndWarehouseId($branch_id, $warehouse_id);
        if (!$existing) return ['valid' => false, 'message' => 'La sucursal seleccionada no pertenece a la Bodega Seleccionada'];
        return ['valid' => true];
    }

    private function validateCurrencyExists(int $currency_id): array
    {
        $existing = $this->currencyRepository->findById($currency_id);
        if (!$existing) return ['valid' => false, 'message' => 'El tipo de moneda seleccionado no existe'];
        return ['valid' => true];
    }
}