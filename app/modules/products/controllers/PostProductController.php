<?php

declare(strict_types=1);

require_once '../repositories/ProductRepository.php';
require_once '../middlewares/StoreMiddleware.php';
class PostProductController
{
    private ProductRepository $product_repository;
    private StoreMiddleware $store_moddleware;

    public function __construct()
    {
        $this->product_repository = new ProductRepository();
        $this->store_moddleware = new StoreMiddleware();
    }

    public function handle(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        $validation = $this->store_moddleware->validate($_POST);
        if (!$validation['valid']) {
            echo json_encode(['success' => false, 'message' => $validation['message']]);
            return;
        }

        try {
            $product_id = $this->product_repository->createProduct($_POST);
            $this->product_repository->createProductMaterial($product_id, $validation['materials']);
            echo json_encode(['success' => true, 'message' => 'Producto creado correctamente']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
}

$controller = new PostProductController();
$controller->handle();