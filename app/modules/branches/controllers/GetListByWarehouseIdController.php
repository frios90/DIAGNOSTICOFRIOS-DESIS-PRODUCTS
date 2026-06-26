<?php

require_once '../repositories/BranchRepository.php';

class GetListByWarehouseIdController
{
    private BranchRepository $repository;
    public function __construct()
    {
        $this->repository = new BranchRepository();
    }

    public function getBranches(): void
    {
        header('Content-Type: application/json');
        try {
            $warehouse_id = isset($_GET['warehouse_id']) ? (int)$_GET['warehouse_id'] : 0;
            if ($warehouse_id > 0) {
                echo $this->repository->findByWarehouseId($warehouse_id);
            } else {
                echo json_encode([]);
            }
        } catch (PDOException $e) {
            echo json_encode(['Error: ' => $e->getMessage()]);
        }
    }
}

$ajax = new GetListByWarehouseIdController();
$ajax->getBranches();