<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\OrderRepositoryInterface;

class GetAllOrders
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(): array
    {
        return $this->orderRepository->findAll();
    }
}
