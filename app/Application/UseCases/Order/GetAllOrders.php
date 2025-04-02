<?php

namespace App\Application\UseCases\Order;

use App\Domain\Repositories\Order\OrderRepositoryInterface;

class GetAllOrders
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(): array
    {
        return $this->orderRepository->findAll();
    }
}
