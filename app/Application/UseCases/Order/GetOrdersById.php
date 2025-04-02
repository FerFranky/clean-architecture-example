<?php

namespace App\Application\UseCases\Order;

use App\Domain\Entities\Order\Order;
use App\Domain\Repositories\Order\OrderRepositoryInterface;

class GetOrdersById
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(int $id): Order
    {
        return $this->orderRepository->findById($id);
    }
}
