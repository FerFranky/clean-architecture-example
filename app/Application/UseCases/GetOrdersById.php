<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepositoryInterface;

class GetOrdersById
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(int $id): Order
    {
        return $this->orderRepository->findById($id);
    }
}
