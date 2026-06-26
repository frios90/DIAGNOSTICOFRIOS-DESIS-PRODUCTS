<?php

declare(strict_types=1);

require_once '../repositories/CurrencyRepository.php';

class GetListController
{
    private CurrencyRepository $repository;

    public function __construct()
    {
        $this->repository = new CurrencyRepository();
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