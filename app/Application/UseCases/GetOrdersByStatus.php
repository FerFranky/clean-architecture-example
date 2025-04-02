<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\OrderRepositoryInterface;

class GetOrdersByStatus
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(string $status): array
    {
        return $this->orderRepository->findByStatus($status);
    }
}
