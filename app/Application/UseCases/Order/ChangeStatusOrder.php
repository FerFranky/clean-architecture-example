<?php

namespace App\Application\UseCases\Order;

use App\Application\DTOs\Order\OrderStatusDTO;
use App\Domain\Entities\OrderEntity\Order;
use App\Domain\Repositories\Order\OrderRepositoryInterface;

class ChangeStatusOrder
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function execute(int $id, OrderStatusDTO $dto): Order
    {
        $order = Order::changeStatus($dto->status);
        return $this->orderRepository->changeStatus($id, $order);
    }
}
