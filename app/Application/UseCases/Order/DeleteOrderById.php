<?php

namespace App\Application\UseCases\Order;

use App\Domain\Repositories\Order\OrderRepositoryInterface;

class DeleteOrderById
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(int $id): bool
    {
        return $this->orderRepository->delete($id);
    }
}
