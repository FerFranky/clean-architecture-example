<?php

namespace App\Application\UseCases;

use App\Application\DTOs\OrderDTO;
use App\Domain\Entities\Order;
use App\Domain\Repositories\OrderRepositoryInterface;

class UpdateOrder
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(int $id, OrderDTO $dto): Order
    {
        $order = Order::update($dto->customerName, $dto->totalAmount);
        return $this->orderRepository->update($id, $order);
    }
}
