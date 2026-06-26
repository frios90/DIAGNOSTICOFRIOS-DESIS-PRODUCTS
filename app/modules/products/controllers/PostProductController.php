<?php

declare(strict_types=1);

require_once '../repositories/ProductRepository.php';
require_once '../middlewares/validateFieldsAndMaterialsMiddleware.php';
require_once '../middlewares/validateFieldsDatabaseMiddleware.php';

class PostProductController
{
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function handle(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        $validation = validateFieldsAndMaterialsMiddleware($_POST);
        if (!$validation['valid']) {
            echo json_encode(['success' => false, 'message' => $validation['message']]);
            return;
        }

        $validation_fields_db = validateFieldsDatabaseMiddleware($_POST);
        if (!$validation_fields_db['valid']) {
            echo json_encode(['success' => false, 'message' => $validation_fields_db['message']]);
            return;
        }

        try {
            $product_id = $this->productRepository->createProduct($_POST);
            $this->productRepository->createProductMaterial($product_id, $validation['materials']);
            echo json_encode(['success' => true, 'message' => 'Producto creado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
}

$controller = new PostProductController();
$controller->handle();