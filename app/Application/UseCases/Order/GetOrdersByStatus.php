<?php

namespace App\Application\UseCases\Order;

use App\Domain\Repositories\Order\OrderRepositoryInterface;

class GetOrdersByStatus
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(string $status): array
    {
        return $this->orderRepository->findByStatus($status);
    }
}
