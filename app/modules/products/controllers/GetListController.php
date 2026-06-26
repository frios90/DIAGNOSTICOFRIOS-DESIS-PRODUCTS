<?php

require_once '../repositories/ProductRepository.php';

class GetListController
{
    private ProductRepository $repository;
    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    public function getList(): void
    {
        header('Content-Type: application/json');
        try {
            echo $this->repository->getList();
        } catch (PDOException $e) {
            echo json_encode(['Error: ' => $e->getMessage()]);
        }
    }
}
$ajax = new GetListController();
$ajax->getList();