<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\OrderRepositoryInterface;

class DeleteOrderById
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(int $id): bool
    {
        return $this->orderRepository->delete($id);
    }
}
